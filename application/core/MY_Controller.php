<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    

    public $data = array();

	private $private_data = [];



    public function __construct() {

        parent::__construct();

        $this->data['site_settings'] = $this->getSiteSettings();

        $this->data['page']          = $this->uri->segment(1);



		$this->private_data['email_config'] = Array(

			'protocol'   =>'smtp',

			'smtp_host'  =>'ssl://mail.herosolutions.com.pk',

			'smtp_port'  => 465,

			'smtp_user'  => trim($this->data['site_settings']->site_noreply_email),

			'smtp_pass'  => 'B2sBcS^##C1z',

			'mailtype'   => 'html',

			'charset'   => 'utf-8',

			'starttls'  => true

		 );



		$this->private_data['email_from'] = trim($this->data['site_settings']->site_noreply_email);

        $this->private_data['admin_email'] = trim($this->data['site_settings']->site_email); 



        $this->private_data['JWT_PRIVATE_KEY'] = 'wefitwork_____jwt_private_key';

        $this->private_data['JWT_ALGO_METHOD'] = 'HS256';

    }







    function getActiveMem(){

        $row = $this->master->getRow('members', array('mem_id' => $this->session->mem_id));

        return $row;

    }



    function getSiteSettings(){

        return $this->master->getRow("siteadmin", array('site_id' => '1'));

    }



    # RECAPTCHA

    public function verifyRECAPTCHA($token){ 

        $response = json_decode(file_get_contents(

            "https://www.google.com/recaptcha/api/siteverify?secret=" . RECAPTCHA_SITE_SECRET_KEY . "&response=" . $token . "&remoteip=" . $_SERVER['REMOTE_ADDR']

        ));

        // if ((boolean) $response->success && (float) $response->score > 0.5)

        if ($response->success)

            return TRUE;

        return TRUE;

    }



    # JWT

    public function jwt(){

        return new JWT();

    }



    public function createAuthToken($member, $ip){

        $jwt = $this->jwt();

        // mid = mem_id

        // msl = member ip from where he made request

        // mte = token expire time

        $payload = [

            'mid'    => doEncode($member->mem_id), 

            // 'msl'    => doEncode($ip),   

            'mte'    => strtotime(date('Y-m-d h:i:s', strtotime('+1 day'))) 

        ];



        $token = $jwt->encode($payload, $this->private_data['JWT_PRIVATE_KEY'], $this->private_data['JWT_ALGO_METHOD']);

        $this->master->save('members', ['mem_auth_token'=> $token], 'mem_id', $member->mem_id);

        return $token;

    }



    public function jwtDecode($token){

        $jwt = $this->jwt();

        return $jwt->decode($token, $this->private_data['JWT_PRIVATE_KEY'], $this->private_data['JWT_ALGO_METHOD']);

    }



    public function verifyAuthToken($authToken, $ip){

        // mid = mem_id

        // msl = member ip from where he made request

        // mte = token expire time

        $jwt = $this->jwt();

        $this->load->model('Member_model','member');



        $res['error'] = 0;

        $res['message'] = '';

        $res['errorType'] = '';



        try {

            $payload = $this->jwtDecode($authToken);

            # MEMBER

            $member = $this->member->getMember(doDecode($payload->mid));

            if(empty($member->mem_auth_token) || $member->mem_auth_token === null){

                $res['error']   = 1;

                $res['errorType'] = 'not_logged_in';

                $res['message'] = 'Member is not logged in.';

                return $res;

                exit;

            }



            # SAVED TOKEN WHEN IT WAS CREATED

            $savePayload = $this->jwtDecode($member->mem_auth_token);

            $timestamp = strtotime(date('Y-m-d h:i:s'));

            $expire  = $savePayload->mte;



            if($timestamp > $expire){

                $res['error']   = 1;

                $res['errorType'] = 'expired';

                $res['message'] = 'Token has been expired.';

                return $res;

                exit;

            }       



            // if($ip != doDecode($savePayload->msl))

            // {

            //     $res['error']     = 1;

            //     $res['errorType'] = 'invalid_ip';

            //     $res['message']   = 'You are not authenticated for this action.';

            //     return $res;

            //     exit;

            // }

            

            $res['mem_id'] = $member->mem_id;

            return $res;

            exit;

        }catch (exception $e) {

            $res['error'] = 1;

            $res['errorType'] = 'invalid_token';

            $res['message'] = 'Invalid token';

            return $res;

            exit;

        }

    }



    # EMAILS

    function send_maintenance_purchased($mem_data){
		$emailto  = $mem_data['email'];
        $subject  = $this->data['site_settings']->site_name." - Maintenance Cover Purchased";
        $this->data['mem_data'] = $mem_data;
        // pr($mem_data);
        $msg_body = $this->load->view('includes/send_maintenance_purchased_email', $this->data, TRUE);
        // pr($msg_body);
		$this->send_email($msg_body, $emailto, $subject);
    }

    function send_maintenance_purchased_admin($mem_data){
		$emailto  = $this->private_data['admin_email'];
        $subject  = $this->data['site_settings']->site_name." - Maintenance Cover Purchased";
        $this->data['mem_data'] = $mem_data;
        // pr($mem_data);
        $msg_body = $this->load->view('includes/send_maintenance_purchased_email_admin', $this->data, TRUE);
        // pr($msg_body);
		$this->send_email($msg_body, $emailto, $subject);
    }

    function send_signup_code($mem_data){
		$emailto  = $mem_data['email'];
        $subject  = $this->data['site_settings']->site_name." - Email Verification";
        $this->data['mem_data'] = $mem_data;
        $msg_body = $this->load->view('includes/email_verify_code', $this->data, TRUE);
        // pr($msg_body);
		$this->send_email($msg_body, $emailto, $subject);

    }



    function send_verification_confirmation($mem_data){

		$emailto  = $mem_data['email'];

        $subject  = $this->data['site_settings']->site_name." - Signup Successful";

        $this->data['mem_data'] = $mem_data;

        $msg_body = $this->load->view('includes/email_signup_success', $this->data, TRUE);

		$this->send_email($msg_body, $emailto, $subject);

    }



    function send_password_reset_link($mem_data){

		$emailto  = $mem_data['email'];

        $subject  = $this->data['site_settings']->site_name." - Password Reset";

        $this->data['mem_data'] = $mem_data;

        $msg_body = $this->load->view('includes/email_password_reset_link', $this->data, TRUE);

        // pr($msg_body);

		$this->send_email($msg_body, $emailto, $subject);

    }



    function send_password_reset_successful($mem_data){

		$emailto  = $mem_data['email'];

        $subject  = $this->data['site_settings']->site_name." - Password Reset Successful";

        $this->data['mem_data'] = $mem_data;

        $msg_body = $this->load->view('includes/email_password_reset_success', $this->data, TRUE);

		$this->send_email($msg_body, $emailto, $subject);

    }



    function send_password_change_successful($mem_data){

		$emailto  = $mem_data['email'];

        $subject  = $this->data['site_settings']->site_name." - Password Changed";

        $this->data['mem_data'] = $mem_data;

        $msg_body = $this->load->view('includes/email_password_changed_success', $this->data, TRUE);

		$this->send_email($msg_body, $emailto, $subject);

    }



    function send_query_successful($mem_data){

		$emailto  = $mem_data['email'];

        $subject  = $this->data['site_settings']->site_name." - Query Sent";

        $this->data['mem_data'] = $mem_data;

        $msg_body = $this->load->view('includes/send_query_successful', $this->data, TRUE);

		$this->send_email($msg_body, $emailto, $subject);

    } 



    function send_query_recieved_admin($mem_data){

		$emailto  = $this->private_data['admin_email'];

        $subject  = $this->data['site_settings']->site_name." - Query Received";

        $this->data['mem_data'] = $mem_data;

        $msg_body = $this->load->view('includes/send_query_recieved_admin', $this->data, TRUE);

		$this->send_email($msg_body, $emailto, $subject);

    }



    private function send_email($msg_body, $emailto, $subject){

        $this->load->library('email');

        $this->email->initialize($this->private_data['email_config']);

        $this->email->set_mailtype("html");

        // $this->email->set_newline("\r\n");

        $this->email->from($this->private_data['email_from'], $this->data['site_settings']->site_name);

        $this->email->to($emailto);

        $this->email->subject($subject);     

        $this->data['email_body']=$msg_body;

        $this->data['email_subject']=$subject;



        $message = $this->load->view('includes/email_template_base', $this->data, TRUE);

        $this->email->message($message);

        if($this->email->send()){

            return true;

        }

        else{

            return true;

            // $error=$this->email->print_debugger();

            // print_r($this->email->print_debugger());die;

            // return $error;

        }

    }

}



class Admin_Controller extends CI_Controller{



    protected $data = array();

    public function __construct(){

        parent::__construct();

        $this->data['adminsite_setting'] = $this->getAdmineSettings();

    }



    public function isLogged(){

        if ($this->session->loged_in < 1) {

            $this->session->set_userdata('admin_redirect_url', currentURL());

            redirect(ADMIN . '/login', 'refresh');

            exit;

        }

    }



    public function logged(){

        if ($this->session->loged_in > 0) {

            redirect(ADMIN , 'refresh');

            exit;

        }

    }



    function getAdmineSettings(){

        return $this->master->getRow("siteadmin", array('site_id' => '1'));

    }

}



?>



