<?php
class Auth extends MY_Controller{

    public function __construct(){
        parent::__construct();
        header('Content-Type: application/json');
        $this->load->model('Member_model', 'member');
        $this->load->library('Sendinblue', 'sendinblue');
        $this->load->library('my_paystack_lib');
    }

    function sign_up(){

        if($this->input->post()){
            $res = [];
            $res['status'] = 0;
            $res['validationErrors'] = '';
            $this->form_validation->set_rules('fullname', 'Full Name', 'trim|required|min_length[2]', ['min_length' => 'Full Name should contains atleast 2 letters.']);
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_is_email_exists', ['valid_email' => 'Please enter a valid email.','is_email_exists' => 'This email is already in use.']);
            $this->form_validation->set_rules('phone', 'Phone', 'trim|required');    
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]', ['min_length' => 'Password should be atleast 6 characters long.']);
            if ($this->form_validation->run() === FALSE) {
                $res['validationErrors'] = validation_errors();
            }else{
                $post = html_escape($this->input->post());
                // $response = $this->verifyRECAPTCHA($post['recaptcha_token']);
                $response = true;
                // pr($post);
                if($response){
					$six_digit_random_number = random_int(100000, 999999);
					$expire_time = date('Y-m-d H:i:s', strtotime('+12 hours'));
					$mem = null;
					$mem_id = null;
					$mem = $this->member->getNonVerifiedUser(trim($post['email']));

					if($mem){
						$mem_id = $mem->mem_id;
					}

					$save_data = [
						'mem_type'  => $post['mem_type'],
						'mem_fname' => ucfirst($post['fullname']),
						'mem_email' => $post['email'],
						'mem_phone' => $post['phone'],
						'mem_pswd'  => md5($post['password']),
						'mem_verification_code'  => $six_digit_random_number,
						'mem_code_expire'  => $expire_time,
						'mem_status'        => 1,
						'mem_last_login'    => date('Y-m-d h:i:s'),
                        'mem_professionl_profile' => 0,
					];
                    // pr($save_data);
					$mem_id = $this->member->save($save_data, $mem_id);
                    $row = $this->member->getMember($mem_id);
                    // pr($mem_id);
					$mem_data = array('name' => ucfirst($post['fullname']), "email" => $post['email'], "code" => $six_digit_random_number);
					$this->send_signup_code($mem_data);
					$res['email'] = trim($post['email']);

					if($mem_id){
                            $result = $this->my_paystack_lib->create_customer($row->mem_email, $row->mem_fname);
                            $customer_data = json_decode($result);
                        // pr($customer_data);
                            if($customer_data->data->customer_code !== '' || $customer_data->data->customer_code){
                                $this->member->update(['mem_paystack_customer_code' => $customer_data->data->customer_code], array('mem_id' => $mem_id));
                                $res['customer_code'] = $customer_data->data->customer_code;
                            }else{
                                $res['customer_creation'] = false;
                            }
                        
                        // $res['authToken'] = $this->createAuthToken($row, $this->input->ip_address());
                        $res['mem_type'] = $row->mem_type;
                        $res['mem_professionl_profile'] = $row->mem_professionl_profile;
						$res['status'] = 1;
					}
                }else{
					http_response_code(400);
					$tokenResponse['status'] = 0;
					$tokenResponse['error'] = 'invalid_request';
					echo json_encode($tokenResponse);
					exit; 
				}
            }
            echo json_encode($res);
            exit;
        }
    }

    function verify_email(){
        // pr($this->input->post());
        if($this->input->post()){
            $res = [];
            $res['status'] = 0;
            $res['validationErrors'] = '';
            $this->form_validation->set_rules('code', 'Code', 'trim|required', 
                [
                    'required' => ' Verification code required.'
                ]);
            if ($this->form_validation->run() === FALSE) {
                $res['validationErrors'] = validation_errors();
            }else{
                $post = html_escape($this->input->post());
                $code = trim($post['code']);
                $email = trim($post['email']);
                $mem = $this->master->getRow('members', ['mem_verification_code'=> $code, 'mem_email'=> $email, 'mem_verified'=> 0]);
                if(countlength((array)$mem) > 0){
                    $current_time = strtotime(date('Y-m-d H:i:s'));
                    $expire_time = strtotime($mem->mem_code_expire);
                    if($current_time > $expire_time){
                        $res['validationErrors'] = '<p>Verification code has expired. Please click Resend Email to get a new code</p>';
                        $res['status'] = 0; 
                    }else{
                        
                        $save_data = [
                            'mem_verification_code' => NULL,
                            'mem_verified' => 1,
                            'mem_last_login'    => date('Y-m-d h:i:s'),
                            
                        ];
                        $mem_id = $this->member->save($save_data, $mem->mem_id, 'mem_id');
                        // $this->sendinblue->create_contact($mem);
                        // $mem_data = array('name' => $mem->mem_fname . ' ' . $mem->mem_lname, "email" => $mem->mem_email);
                        // $this->send_verification_confirmation($mem_data);
                        $res['authToken'] =  $this->createAuthToken($mem, $this->input->ip_address());
                        $res['mem_type']  = $mem->mem_type;
                        $res['mem_professionl_profile'] = $mem->mem_professionl_profile;
                        if($mem_id){
                            $res['status'] = 1;
                        }
                    }
                }else{
                    $res['validationErrors'] = '<p>Invalid or expired verification code.</p>';
                    $res['status'] = 0;
                } 
            }
            echo json_encode($res);
            exit;
        }
    }

    function resend_email(){
        if($this->input->post()){
            $res = [];
            $res['status'] = 0;
            $res['validationErrors'] = '';
            // pr($this->input->post());
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', ['valid_email' => 'Please enter a valid email.']);
            
            if ($this->form_validation->run() === FALSE) {
                $res['validationErrors'] = validation_errors();
            }else{
                $post = html_escape($this->input->post());

					$six_digit_random_number = random_int(100000, 999999);
					$expire_time = date('Y-m-d H:i:s', strtotime('+12 hours'));
					$mem = null;
					$mem_id = null;
					$mem = $this->member->getNonVerifiedUser(trim($post['email']));

					if($mem)
					{
						$mem_id = $mem->mem_id;
					}else{
                        $res['status']=0;
                        $res['msg']='Email not found';
                        echo json_encode($res);
                        exit;
                    }
					$save_data = [
						'mem_verification_code'  => $six_digit_random_number,
						'mem_code_expire'  => $expire_time,
					];

					$mem_id = $this->member->save($save_data, $mem_id);
					$mem_data = array('name' => ucfirst($mem->mem_fname) . ' ' . ucfirst($mem->mem_lname), "email" => $mem->mem_email, "code" => $six_digit_random_number);
					
                    $this->send_signup_code($mem_data);

					$res['email'] = trim($post['email']);
					if($mem_id)
					{
						$res['status'] = 1;
                        $res['msg'] = 'Verification Code Re sent successfully. Please check your email for verification code.';
					}
               
            }
            echo json_encode($res);
            exit;
        }
    }


    function sign_in(){
        if($this->input->post()){
            $res = [];
            $res['status'] = 0;
            $res['validationErrors'] = '';
            $res['msg'] = '';
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');
            if ($this->form_validation->run() === FALSE) {
                $res['validationErrors'] = validation_errors();
            }else{
                $data = $this->input->post();
                // $checkEmailExist = $this->member->authenticateEmail($data['email']);

                // if(countlength((array)$checkEmailExist)){
                    $row = $this->member->authenticate($data['email'], $data['password']);
                    
                    if (countlength((array)$row) > 0) {
                        if ($row->mem_status == 0) {
                            $res['status'] = 0;
                            $res['validationErrors'] = '<p>Your account has been deactivated by the admin.</p>';
                        }else{
                            $this->member->save(['mem_first_time_login' => 'no'], $row->mem_id);
                            $this->member->update_last_login($row->mem_id, $remember_token);

                            $res['authToken'] = $this->createAuthToken($row, $this->input->ip_address());
                            $res['mem_type']  = $row->mem_type;
                            $res['mem_professionl_profile'] = $row->mem_professionl_profile;
                            $res['memData'] = $this->member->getMemData($mem_id);
                            $res['status'] = 1;
                        }
                    } else {
                        $res['status'] = 0;
                        $res['validationErrors'] = '<p>Incorrect email or password.</p>';
                    }
                // }else{
                //     $res['status'] = 0;
                //     $res['validationErrors'] = '<p>Account does not exist.</p>';
                // }
            }
            echo json_encode($res);
            exit;
        }
    }

    function forgot_password(){

        if($this->input->post()){
            $res = [];
            $res['status'] = 0;
            $res['validationErrors'] = '';
            $res['msg'] = '';
            $res['notExist'] = 0;

            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

            if ($this->form_validation->run() === FALSE) {
                $res['validationErrors'] = validation_errors();
            } else {
                $post    = $this->input->post();
                if ($mem = $this->member->forgotEmailExists($post['email'])) {
                    $rando = doEncode(randCode(rand(15, 20)));
                    $this->master->save('members', array('mem_code' => $rando), 'mem_id', $mem->mem_id);

                    $reset_link = $this->data['site_settings']->site_domain.'/change-password/' . $rando;
                    $mem_data = array('name' => $mem->mem_fname, "email" => $mem->mem_email, "link" => $reset_link);
                    $this->send_password_reset_link($mem_data);

                    $res['status'] = 1;
                } else {
                    $res['status'] = 0;
                    $res['notExist'] = 1;
                }
            }
            echo json_encode($res);
            exit;
        }
    }

    function reset_password(){

        if($this->input->post()){
            $res = [];
            $res['status'] = 0;
            $res['validationErrors'] = '';
            $res['msg'] = '';
            $res['notExist'] = 0;
            // pr($this->input->post());        

            $mem_id = '';
            if ($row = $this->member->getMemCode($this->input->post('token'))) {
                $mem_id = $row->mem_id;
            } else {
                $res['notExist'] = 1;
                echo json_encode($res);
                exit;
            }

            $this->form_validation->set_rules('password', 'New Password', 'required|min_length[8]|callback_is_password_strong', ['is_password_strong' => 'Password should contain at least one upper case letter, one lower case letter, one number and one special character.']);
            $this->form_validation->set_rules('c_password', 'Confirm Password', 'required|matches[password]', ['matches' => 'Confirm password must be the as the password.']);

            if ($this->form_validation->run() === FALSE) {
                $res['validationErrors'] = validation_errors();
            } else {
                $post = html_escape($this->input->post());
                $this->member->save(array('mem_pswd' => md5($post['password'])), $mem_id);
                $this->member->save(array('mem_code' => ''), $mem_id);
                $mem_data = array('name' => $row->mem_fname, "email" => $row->mem_email);
                $this->send_password_reset_successful($mem_data);
                $res['status'] = 1;
            }
            echo json_encode($res);
            exit;
        }
    }

    function create_new_password(){
      
        if($this->input->post()){
            $res = [];
            $res['status'] = 0;
            $res['validationErrors'] = '';
  
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', 
                [
                    'valid_email' => 'Please enter a valid email.',                  
                ]);
            $this->form_validation->set_rules('password', 'New Password', 'required|min_length[8]|callback_is_password_strong', ['is_password_strong' => 'Password should contain at least one upper case letter, one lower case letter, one number and one special character.']);
            $this->form_validation->set_rules('c_password', 'Confirm Password', 'required|matches[password]', ['matches' => 'Confirm password must be the as the password.']);          
              
            if ($this->form_validation->run() === FALSE) {
                $res['validationErrors'] = validation_errors();
            }else{
                $post = html_escape($this->input->post());             
                $response = true;
                // pr($post);
                if($response){
					$six_digit_random_number = random_int(100000, 999999);
					$expire_time = date('Y-m-d H:i:s', strtotime('+12 hours'));
					$mem = null;
					$mem_id = null;
					$mem = $this->member->getNonVerifiedUser(trim($post['email']));
                    // pr($mem);
					if($mem){
						$mem_id = $mem->mem_id;
					}                 

					$save_data = [
						'mem_pswd'  => md5($post['password']),
						'mem_verification_code'  => $six_digit_random_number,
						'mem_code_expire'  => $expire_time,
						'mem_status'        => 1,
						'mem_last_login'    => date('Y-m-d h:i:s')
					];
                    // pr($save_data);
					$mem_id = $this->master->save('members', $save_data, 'mem_id', $mem_id);
                    // pr($mem_id);
					$mem_data = array('name' => ucfirst($mem->mem_fname) . ' ' . ucfirst($mem->mem_lname), "email" => $post['email'], "code" => $six_digit_random_number);
                    $this->send_signup_code($mem_data);
					$res['email'] = trim($post['email']);
					if($mem_id){
						$res['status'] = 1;
					}
                }else{
					http_response_code(400);
					$tokenResponse['status'] = 0;
					$tokenResponse['error'] = 'invalid_request';
					echo json_encode($tokenResponse);
					exit; 
				}
            }
            echo json_encode($res);
            exit;
        }
    }
    
    ### callback functions

    public function is_password_strong($password){
        $whiteListedSpecial = "\$\@\#\^\|\!\~\=\+\-\_\.";
        if (preg_match('#[0-9]#', $password) && preg_match('#[a-zA-Z]#', $password) && preg_match('/[' . $whiteListedSpecial . ']/', $password)) {
            return TRUE;
        }
        return FALSE;
    } 

    public function is_email_exists($email){
        $email = $this->master->getRow('members', ['mem_email'=> $email]);
		if(empty($email)){
			return TRUE;	
		}
		return FALSE;
    }

    



}

