<?php

class User extends MY_Controller
{

    private $mem_id = '';
    public function __construct()
    {
        parent::__construct();

        header('Content-Type: application/json');
        $this->load->model('Member_model', 'member');
        $this->load->model('Chat_model', 'chat');

        $this->load->model('Pages_model', 'page');
        $this->load->library('twilio_lib');

        $tokenResponse = $this->verifyAuthToken($this->input->post('token'), $this->input->ip_address());
        if ($tokenResponse['error'] === 1) {
            http_response_code(400);
            echo json_encode($tokenResponse);
            exit;
        } else {
            $this->mem_id = $tokenResponse['mem_id'];
        }

        // pr($this->data['site_settings']);
        $this->api_output['site_settings'] = (Object)[
            'site_name' => $this->data['site_settings']->site_name,
            'site_email' => $this->data['site_settings']->site_email,
            'site_general_email' => $this->data['site_settings']->site_general_email,
            'site_logo' => $this->data['site_settings']->site_logo,
            'site_footer_logo' => $this->data['site_settings']->site_footer_logo,
            'site_icon' => $this->data['site_settings']->site_icon,
            'site_phone' => $this->data['site_settings']->site_phone,

            ];
    }

    function buyer_dashboard()
    {

        if ($this->input->post()) {
            $post = $this->input->post();
            $mem_id = $this->mem_id;
            $memData = $this->member->getMemData($mem_id);
            $this->api_output['page_title'] = 'Dashboard - ' . $this->data['site_settings']->site_name;
            $this->api_output['member'] = $memData;
       

            $sent = $this->master->getRows('sent_sms', array('from_mem_id' => $mem_id));

            $this->api_output['sent_sms'] = [];
            foreach ($sent as $key => $val) {
                $this->api_output['sent_sms'][] = [
                    'id' => $val->id,
                    'to_mem_id' => $val->to_mem_id,
                    'to_mem_name' => get_mem_name($val->to_mem_id),
                    'to_mem_dp' => get_mem_image($val->to_mem_id),
                    'date' => format_date($val->created_date, 'M d, Y'),
                    'workscope_id' => $val->work_scope_id,
                    'service' => get_pro_mem_service_name($val->to_mem_id),
                    'to_mem_address' => get_pro_mem_address($val->to_mem_id),
                ];
                
            }  
            $wishlists = $this->master->getRows('wishlist', array('mem_id' => $mem_id, 'status' => 1));

            $this->api_output['wishlist_count'] = intval(countlength($wishlists));
            $this->api_output['contract_converged_count'] = intval(countlength($sent));
            $this->api_output['message_count'] = intval(0);

            $this->api_output['notifications'] = $this->master->getRows('notifications', array('receiver_mem_id' => $mem_id, 'read_status' => 0, 'receiver' => 'buyer' ), '', '', 'DESC');
            $this->api_output['notifications_count'] = countlength($this->api_output['notifications']);


            http_response_code(200);
            echo json_encode($this->api_output);
            exit;
        } else {
            http_response_code(404);
            exit;
        }
    }

    function buyer_bookings()
    {

        if ($this->input->post()) {
            $post = $this->input->post();
            $mem_id = $this->mem_id;
            $memData = $this->member->getMemData($mem_id);
            $this->api_output['page_title'] = 'Bookings - ' . $this->data['site_settings']->site_name;
            $this->api_output['member'] = $memData;
            

            $sent = $this->master->getRows('sent_sms', array('from_mem_id' => $mem_id));
            $this->api_output['sent_sms'] = [];
            foreach ($sent as $key => $val) {
                $this->api_output['sent_sms'][] = [
                    'id' => $val->id,
                    'to_mem_id' => $val->to_mem_id,
                    'to_mem_name' => get_mem_name($val->to_mem_id),
                    'to_mem_dp' => get_mem_image($val->to_mem_id),
                    'date' => format_date($val->created_date, 'M d, Y'),
                    'workscope_id' => $val->work_scope_id,
                    'service' => get_pro_mem_service_name($val->to_mem_id),
                    'to_mem_address' => get_pro_mem_address($val->to_mem_id),
                ];
                
            }  

            http_response_code(200);
            echo json_encode($this->api_output);
            exit;
        } else {
            http_response_code(404);
            exit;
        }
    }




    function booking_details($id)
    {
        $id = intval($id);
        
        if ($this->input->post()) {
            if(!empty($id) && !empty($row = $this->master->getRow('sent_sms', array('id' => $id)))){
                $post = $this->input->post();
                $mem_id = $this->mem_id;
                $memData = $this->member->getMemData($mem_id);
                $this->api_output['member'] = $memData;
                $this->api_output['page_title'] = 'Booking Detail - ' . $this->data['site_settings']->site_name;
                $this->api_output['row_data'] = [
                    'id' => $row->id,
                    'to_mem_id' => $row->to_mem_id,
                    'to_mem_name' => get_mem_name($row->to_mem_id),
                    'to_mem_dp' => get_mem_image($row->to_mem_id),
                    'date' => format_date($row->created_date, 'M d, Y'),
                    'workscope_id' => $row->work_scope_id,
                    'service' => get_pro_mem_service_name($row->to_mem_id),
                    'to_mem_address' => get_pro_mem_address($row->to_mem_id),
                    'pro_contacted' => $row->pro_contacted,
                    'pro_hierd' => $row->pro_hierd,
                ];
                $this->api_output['pro_mem_data'] = $this->member->getMemData($row->to_mem_id);
                $this->api_output['pro_mem_profile'] = $this->master->getRow('professional_profile', array('mem_id' => $row->to_mem_id));
                $this->api_output['workscope'] = $this->master->getRow('work_scopes', array('id' => $row->work_scope_id));

            }else{
                http_response_code(404);
            exit; 
            }

            http_response_code(200);
            echo json_encode($this->api_output);
            exit;
        } else {
            http_response_code(404);
            exit;
        }
    }

    function buyer_notifications()
    {

        if ($this->input->post()) {
            $post = $this->input->post();
            $mem_id = $this->mem_id;
            $memData = $this->member->getMemData($mem_id);
            $this->api_output['page_title'] = 'Notifications - ' . $this->data['site_settings']->site_name;
            $this->api_output['member'] = $memData;
             
            $notifis = $this->master->getRows('notifications', array('receiver_mem_id' => $mem_id, 'receiver' => 'buyer' ), '', '', 'DESC');
            $this->api_output['notifications'] = null;
            foreach($notifis as $notif){
                $this->api_output['notifications'][] = [
                    'sender_pic' => get_mem_image($notif->sender_mem_id),
                    'txt' => $notif->txt,
                    'receiver_mem_id' => $notif->receiver_mem_id,
                    'read_status' => $notif->read_status,
                    'created_at' => $notif->created_at,
                    'sender' => $notif->sender,
                    'receiver' => $notif->receiver,
                    'type' => $notif->type,
                ];
            } 
            
            $this->api_output['notifications_count'] = countlength($this->api_output['notifications']);


            // pr($this->api_output['received_sms']);
            http_response_code(200);
            echo json_encode($this->api_output);
            exit;
        } else {
            http_response_code(404);
            exit;
        }
    }

    function review_page_data($pro_id)
    {
        $pro_id = intval($pro_id);
        
        if ($this->input->post()) {
            if(!empty($pro_id) && !empty($pro_mem = $this->member->getMemData($pro_id))){
                $post = $this->input->post();
                $mem_id = $this->mem_id;
                $memData = $this->member->getMemData($mem_id);
                $this->api_output['member'] = $memData;
                $this->api_output['page_title'] = 'Leave Review - ' . $this->data['site_settings']->site_name;

                $this->api_output['pro_mem_profile'] = $this->master->getRow('professional_profile', array('mem_id' => $pro_id));
                $selected_sub_services = $this->master->getRows('selected_sub_services', ['mem_id' => $pro_id, 'mem_profile_id' => $this->api_output['pro_mem_profile']->id]);

            $this->api_output['pro_mem_sub_services'] = [];
            foreach ($selected_sub_services as $sub) {
                $this->api_output['pro_mem_sub_services'][] = get_sub_service_title($sub->sub_service_id);
            }

                $this->api_output['pro_mem_data'] = [
                    'mem_id' => $pro_mem->mem_id,
                            'mem_type' => $pro_mem->mem_type,
                            'mem_fname' => $pro_mem->mem_fname,
                            'mem_lname' => $pro_mem->mem_lname,
                            'mem_display_name' => $pro_mem->mem_display_name,
                            'mem_email' => $pro_mem->mem_email,
                            'mem_phone' => $pro_mem->mem_phone,
                            'mem_image' => $pro_mem->mem_image,
                            'mem_address' => $pro_mem->mem_address,
                            'mem_verified' => $pro_mem->mem_verified,
                            'mem_status' => $pro_mem->mem_status,
                            'mem_professionl_profile' => $pro_mem->mem_professionl_profile,
                            'mem_specialization' => $pro_mem->mem_specialization,
                            'mem_phone_verified' => $pro_mem->mem_phone_verified,
                            'distance' => $pro_mem->distance,
                            'service_title' => get_service_title($this->api_output['pro_mem_profile']->service_id),
                            'sub_services' => $this->api_output['pro_mem_sub_services'],
                            'business_name' => $this->api_output['pro_mem_profile']->business_name,
                            'business_phone' => $this->api_output['pro_mem_profile']->business_phone,
                ];

            }else{
                http_response_code(404);
            exit; 
            }

            http_response_code(200);
            echo json_encode($this->api_output);
            exit;
        } else {
            http_response_code(404);
            exit;
        }
    }

    function update_booking_statuses($id)
    {
        $id = intval($id);
        if ($this->input->post()) {
            $res = [];
            $res['status'] = 0;
          
                $post = html_escape($this->input->post());
                // pr($post);
                $mem_id = $this->mem_id;
                $save_data = [
                    'pro_contacted' => $post['pro_contacted'],
                    'pro_hierd' => $post['pro_hierd'],
                ];

                
                $sid = $this->master->update('sent_sms', $save_data, array('from_mem_id' => $mem_id, 'id' => $id));

                if ($sid) {  

                    $sms_row = $this->master->getRow('sent_sms', array('id' => $id));
                    $pro_profile = $this->master->getRow('professional_profile', array('mem_id' => $sms_row->to_mem_id));
                // pr($pro_profile);
                    if($save_data['pro_hierd'] == 'yes'){
                        $this->master->update('professional_profile', ['completed_projects' => $pro_profile->completed_projects + 1], array('id' => $pro_profile->id, 'mem_id' => $pro_profile->mem_id));
                    }
                    $res['status'] = 1;
                }else{
                    $res['status'] = 0;

                }
            
            echo json_encode($res);
            exit;
        }
    }

    function save_review()
    {
        // pr($this->input->post());
        // pr($_FILES);
        if ($this->input->post()) {
            $res = [];
            $res['status'] = 0;
            $res['validationErrors'] = '';
            $this->form_validation->set_rules('reliability_timekeeping', 'Reliability & timekeeping', 'trim|required');
            $this->form_validation->set_rules('quality_workmanship', 'Quality of workmanship', 'trim|required');
            $this->form_validation->set_rules('tidiness', 'Tidiness', 'trim|required');
            $this->form_validation->set_rules('courtesy', 'Courtesy ', 'trim|required');
            $this->form_validation->set_rules('workscope', 'Work Scope ', 'trim|required');
            $this->form_validation->set_rules('rating', 'Star Rating ', 'trim|required');
            $this->form_validation->set_rules('review', 'Your Review ', 'trim|required');
            $this->form_validation->set_rules('recomended', 'Would you recommend this tradesperson? ', 'trim|required');

            if ($this->form_validation->run() === FALSE) {
                $res['validationErrors'] = validation_errors();
            } else {
                $post = html_escape($this->input->post());
                $mem_id = $this->mem_id;
                $save_data = [
                    'review_from_mem_id' => $mem_id,
                    'pro_mem_id' => intval($post['pro_mem_id']),
                    'reliability_timekeeping' => $post['reliability_timekeeping'], 
                    'quality_workmanship' => $post['quality_workmanship'], 
                    'tidiness' => $post['tidiness'], 
                    'courtesy' => $post['courtesy'], 
                    'workscope' => $post['workscope'], 
                    'rating' => $post['rating'], 
                    'review' => $post['review'], 
                    'recomended' => $post['recomended'],
                    'status' => 1,
                    'created_date' => date('Y-m-d h:i:s'),
                     
                ];

                $id = $this->master->save('reviews', $save_data);

                if ($id > 0) {  
                    if(!empty($_FILES['proof_images'])){
                        
                        foreach ($_FILES['proof_images']['name'] as $key => $file_name) {
                            // pr($file_name);
                            $_FILES['image_file']['name'] = $file_name;
                            $_FILES['image_file']['type'] = $_FILES['proof_images']['type'][$key];
                            $_FILES['image_file']['tmp_name'] = $_FILES['proof_images']['tmp_name'][$key];
                            $_FILES['image_file']['error'] = $_FILES['proof_images']['error'][$key];
                            $_FILES['image_file']['size'] = $_FILES['proof_images']['size'][$key];
                            if ($_FILES['image_file']['name'] != '') {
                                // pr($_FILES['image_file']);
                                $image = upload_file(UPLOAD_PATH . "work_proof/", 'image_file', 'image');
                                // pr($image);     
                                if (!empty($image['file_name'])) {
                                    $this->master->save('work_proof_images', array('mem_id' => $mem_id, 'image' => $image['file_name'], 'review_id' => $id));
                                } else {
                                    setMsg('error', 'Please upload a valid images file >> ' . strip_tags($image['error']));
                                }
                            }
                        }
                    }    
                    
                    $notify_arr = [
                        'sender_mem_id' => $mem_id,
                        'receiver_mem_id' => intval($post['pro_mem_id']),
                        'txt' => get_mem_name($mem_id). ' Leave a review for you',
                        'read_status' => 0,
                        'created_at' => date('Y-m-d h:i:s'),
                        'sender' => 'buyer',
                        'receiver' => 'professional',
                        'type' => 'review',
                    ];

                    $this->master->save('notifications', $notify_arr);
                    $res['status'] = 1;
                    
                }
            }
            echo json_encode($res);
            exit;
        }
    }

    function add_remove_to_wishlist()
    {
        if ($this->input->post()) {
            $res = [];
            $res['status'] = 0;
            $res['validationErrors'] = '';
            $this->form_validation->set_rules('pro_mem_id', 'Professional', 'trim|required');

            if ($this->form_validation->run() === FALSE) {
                $res['validationErrors'] = validation_errors();
            } else {
                $post = html_escape($this->input->post());
                $mem_id = $this->mem_id;
                $save_data = [
                    'mem_id' => $mem_id,
                    'pro_mem_id' => intval($post['pro_mem_id']),
                    'status' => 1,
                    'created_date' => date('Y-m-d h:i:s'),
                     
                ];

                $wishlist=$this->master->getRow("wishlist",array('mem_id' => $mem_id, 'pro_mem_id' => intval($post['pro_mem_id'])));
                if(!empty($wishlist)){
                    $this->master->delete('wishlist' , 'id', $wishlist->id);
                    $res['status'] = 1;
                    $res['removed']=true;
                    				
                }else{
                    $id = $this->master->save('wishlist', $save_data);

                    if ($id > 0) {  
                        $res['status'] = 1;
                        $res['added']=true;

                    }
                    else{
                        $res['status'] = 0;
    
                    }
                }

                
            }
            echo json_encode($res);
            exit;
        }
    }

    function buyer_wishlist()
    {

        if ($this->input->post()) {
            $post = $this->input->post();
            $mem_id = $this->mem_id;
            $memData = $this->member->getMemData($mem_id);
            $this->api_output['page_title'] = 'Wishlist - ' . $this->data['site_settings']->site_name;
            $this->api_output['member'] = $memData;
            $wishlists = $this->master->getRows('wishlist', array('mem_id' => $mem_id, 'status' => 1), '' ,'' ,'DESC');
            // pr($wishlists);

            $this->api_output['wishlist'] = null;

            foreach($wishlists as $wish){
                $pro_mem = $this->member->getMemData($wish->pro_mem_id);
                $pro_profile = $this->master->getRow('professional_profile', array('mem_id' => $wish->pro_mem_id));

                $this->api_output['wishlist'][] = [
                            'mem_id' => $pro_mem->mem_id,
                            'mem_type' => $pro_mem->mem_type,
                            'mem_fname' => $pro_mem->mem_fname,
                            'mem_email' => $pro_mem->mem_email,
                            'mem_phone' => $pro_mem->mem_phone,
                            'mem_image' => $pro_mem->mem_image,
                            'mem_address' => $pro_mem->mem_address,
                            'mem_verified' => $pro_mem->mem_verified,
                            'mem_status' => $pro_mem->mem_status,
                            'mem_professionl_profile' => $pro_mem->mem_professionl_profile,
                            'mem_specialization' => $pro_profile->specialization,
                            'mem_phone_verified' => $pro_mem->mem_phone_verified,
                            'distance' => $pro_mem->distance,
                            'service_title' => get_service_title($pro_profile->service_id),
                            'sub_services' => $this->api_output['pro_mem_sub_services'],
                            'business_name' => $pro_profile->business_name,
                            'business_phone' => $pro_profile->business_phone,
                            'completed_projects' => intval($pro_profile->completed_projects),
                            'reviews_counts' => intval(get_count_pro_mem_reviews($pro_mem->mem_id)),
                    'avg_rating' => floatval(get_count_pro_mem_avg_rating($pro_mem->mem_id)),
                    
                            
                ];

            }



            http_response_code(200);
            echo json_encode($this->api_output);
            exit;
        } else {
            http_response_code(404);
            exit;
        }
    }


    function buyer_profile_settings()
    {
        if ($this->input->post()) {
            $post = $this->input->post();
            $mem_id = $this->mem_id;
            $this->api_output['page_title'] = 'Manage Account - ' . $this->data['site_settings']->site_name;

            $this->api_output['member'] = $this->member->getMemData($mem_id);

            http_response_code(200);
            echo json_encode($this->api_output);
            exit;
        } else {
            http_response_code(404);
            exit;
        }
    }

    function save_buyer_profile_settings()
    {

        if ($this->input->post()) {
            $res = [];
            $res['status'] = 0;
            $res['validationErrors'] = '';
            $this->form_validation->set_rules('fname', 'Name', 'trim|required|min_length[2]|max_length[20]', ['min_length' => 'Name should contains atleast 2 letters.', 'max_length' => 'Name should not be greater than 20 letters.']);
            $this->form_validation->set_rules('display_name', 'Dispaly Name', 'trim|required|alpha|min_length[2]|max_length[20]', ['alpha' => 'Dispaly Name should contains only letters and avoid space.', 'min_length' => 'Dispaly Name should contains atleast 2 letters.', 'max_length' => 'Dispaly Name should not be greater than 20 letters.']);
            $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
            $this->form_validation->set_rules('address', 'Address', 'trim|required');

            if ($this->form_validation->run() === FALSE) {
                $res['validationErrors'] = validation_errors();
            } else {
                $post = html_escape($this->input->post());
                $mem_id = $this->mem_id;
                $save_data = [
                    'mem_fname' => ucfirst($post['fname']),
                    'mem_display_name' => ucfirst($post['display_name']),
                    'mem_phone' => $post['phone'],
                    'mem_address' => $post['address']
                ];
                if (isset($_FILES["profile"]["name"]) && $_FILES["profile"]["name"] != "") {
                    $image = upload_file(UPLOAD_PATH . 'members', 'profile');
                    // generate_thumb(UPLOAD_PATH.'members/',UPLOAD_PATH.'members/',$image['file_name'],100,'thumb_');
                    // pr($image);
                    $save_data['mem_image'] = $image['file_name'];
                }
                $mem_id = $this->member->save($save_data, $mem_id);
                if ($mem_id) {
                    $res['status'] = 1;
                }
            }
            echo json_encode($res);
            exit;
        }
    }

    function save_maintenance_cover_payment()
    {
        // pr($this->input->post());
        if ($this->input->post()) {
            $res = [];
            $res['status'] = 0;
            $res['validationErrors'] = '';
            $this->form_validation->set_rules('fullname', 'Service ', 'trim|required');
            $this->form_validation->set_rules('email', 'Business Name', 'trim|required');
            $this->form_validation->set_rules('phone', 'Business Address', 'trim|required');
            $this->form_validation->set_rules('house_type', 'Business Type', 'trim|required');
            $this->form_validation->set_rules('address', 'Employes ', 'trim|required');
            $this->form_validation->set_rules('txn_reference', 'Looking For', 'trim|required');
            $this->form_validation->set_rules('plan_code', 'Location', 'required');
            


            if ($this->form_validation->run() === FALSE) {
                $res['validationErrors'] = validation_errors();
            } else {
                $post = html_escape($this->input->post());
                // pr($post);
                $mem_id = $this->mem_id;
                $mem_data = $this->member->getMember($mem_id);
                $save_data = [
                    'mem_id' => $mem_id,
                    'maintenance_cover_id' => intval($post['maintenance_cover_id']),
                    'fullname' => $post['fullname'], 
                    'email' => $post['email'], 
                    'phone' => $post['phone'], 
                    'house_type' => $post['house_type'], 
                    'address' => $post['address'], 
                    'trxn_reference' => $post['txn_reference'], 
                    'plan_code' => $post['plan_code'], 
                    'created_date' => date('Y-m-d h:i:s'),
                    'status' => 1

                ];
                // pr($save_data);

                $id = $this->master->save('purchased_maint_covers', $save_data);
                // pr($id);

                
                
                if ($id > 0) {
                    $mem_data = [
                        'email' => $post['email'],
                        'name' => $post['fullname'],
                        'address' => $post['address'],
                        'maintenance_cover' => $this->master->getRow('maintenance_covers', array('id' => intval($post['maintenance_cover_id']))),
                    ];
                    
                    $this->send_maintenance_purchased($mem_data);
                    $this->send_maintenance_purchased_admin($mem_data);

                    $res['status'] = 1;
                } else {
                    $res['status'] = 0;
                    $res['validationErrors'] = "Technical Issue";
                }
            }
            echo json_encode($res);
            exit;
        }
    }

    function buyer_maintenance_requests()
    {

        if ($this->input->post()) {
            $post = $this->input->post();
            $mem_id = $this->mem_id;
            $memData = $this->member->getMemData($mem_id);
            $this->api_output['page_title'] = 'Maintenance Requests - ' . $this->data['site_settings']->site_name;
            $this->api_output['member'] = $memData;          
            
            $purchased_mc = $this->master->getRows('purchased_maint_covers', array('mem_id' => $mem_id));
            if(empty($purchased_mc)){
                $this->api_output['mc_purchased_status'] = false;
                $this->api_output['mc_requests'] = (Object)[];
            }else{
                $this->api_output['mc_purchased_status'] = true;

                $requests = $this->master->getRows('mcover_requests', array('mem_id' => $mem_id), '', '', 'DESC');
                
                    // pr($requests);
                    $this->api_output['mc_requests'] = array();
                    foreach($requests as $req){
                        $this->api_output['mc_requests'][] = (Object)[
                            'id' => $req->id,
                            'mem_id' => $req->mem_id,
                            'maintenance_cover_id' => get_maintenance_cover_service_title($req->maintenance_cover_id),
                            'service_title' => get_maintenance_cover_service_title($req->maintenance_cover_id),
                            'address' => $req->address,
                            'sub_cat_id' => get_mc_sub_service_title($req->sub_cat_id),
                            'request_title' => $req->request_title,
                            'detail' => $req->detail,
                            'status' => $req->status,
                            'created_date' => $req->created_date,
                        ];
                    }           

            }

            http_response_code(200);
            echo json_encode($this->api_output);
            exit;
        } else {
            http_response_code(404);
            exit;
        }
    }

    function add_request_page()
    {

        if ($this->input->post()) {
            $post = $this->input->post();
            $mem_id = $this->mem_id;
            $memData = $this->member->getMemData($mem_id);
            $this->api_output['page_title'] = 'New Request - ' . $this->data['site_settings']->site_name;
            $this->api_output['member'] = $memData;          
            
            $purchased_mc = $this->master->getRows('purchased_maint_covers', array('mem_id' => $mem_id));
            
            foreach($purchased_mc as $p)


            if(empty($purchased_mc)){
                
                $this->api_output['maintenance_services'] = (Object)[];
            }else{
                $this->api_output['maintenance_services'] = [];
                foreach($purchased_mc as $p_mc) {
                    
                    $this->api_output['maintenance_services'][] = (Object)[

                        'id' => intval($p_mc->id), 
                        'mem_id' => intval($p_mc->mem_id), 
                        'maintenance_cover_id' => intval($p_mc->maintenance_cover_id), 
                        'plan_code' => $p_mc->plan_code, 
                        'fullname' => $p_mc->fullname, 
                        'email' => $p_mc->email, 
                        'phone' => $p_mc->phone, 
                        'house_type' => $p_mc->house_type, 
                        'address' => $p_mc->address, 
                        'trxn_reference' => $p_mc->trxn_reference, 
                        'status' => $p_mc->status, 
                        'created_date' => $p_mc->created_date, 
                        'service_title' => get_maintenance_cover_service_title($p_mc->maintenance_cover_id),
                        
                    ];

                }           

            }

            http_response_code(200);
            echo json_encode($this->api_output);
            exit;
        } else {
            http_response_code(404);
            exit;
        }
    }

    function add_maintenance_cover_request(){
        // pr($this->input->post());
        if ($this->input->post()) {
            $res = [];
            $res['status'] = 0;
            $res['validationErrors'] = '';
            
            $this->form_validation->set_rules('request_title', 'Request Title', 'trim|required');
            $this->form_validation->set_rules('purchase_id', 'Service ', 'required');
            $this->form_validation->set_rules('sub_cat_id', 'Sub Service', 'required');
            $this->form_validation->set_rules('detail', 'Detail', 'trim|required');
           

            if ($this->form_validation->run() === FALSE) {
                $res['validationErrors'] = validation_errors();
            } else {
                $post = html_escape($this->input->post());
                $mem_id = $this->mem_id;

                $purchased_mc = $this->master->getRow("purchased_maint_covers", array('id' => intval($post['purchase_id'])));

                $save_data = [
                    'mem_id' => $mem_id,
                    'request_title' => $post['request_title'],
                    'maintenance_cover_id' => intval($purchased_mc->maintenance_cover_id),
                    'sub_cat_id' => intval($post['sub_cat_id']),
                    'detail' => $post['detail'], 
                    'address' => $purchased_mc->address,
                    'status' => 'pending',
                    'created_date' => date('Y-m-d h:i:s')
                ];

                // pr($save_data);
                
                $id = $this->master->save('mcover_requests', $save_data);

                if ($id > 0) {
                    if(!empty($_FILES['request_images'])){
                        
                        foreach ($_FILES['request_images']['name'] as $key => $file_name) {
                            // pr($file_name);
                            $_FILES['image_file']['name'] = $file_name;
                            $_FILES['image_file']['type'] = $_FILES['request_images']['type'][$key];
                            $_FILES['image_file']['tmp_name'] = $_FILES['request_images']['tmp_name'][$key];
                            $_FILES['image_file']['error'] = $_FILES['request_images']['error'][$key];
                            $_FILES['image_file']['size'] = $_FILES['request_images']['size'][$key];
                            if ($_FILES['image_file']['name'] != '') {
                                // pr($_FILES['image_file']);
                                $image = upload_file(UPLOAD_PATH . "members/mc_request_images/", 'image_file', 'image');
                                // pr($image);     
                                if (!empty($image['file_name'])) {
                                    $this->master->save('mc_req_images', array('request_id' => $id, 'image' => $image['file_name']));
                                } else {
                                    setMsg('error', 'Please upload a valid images file >> ' . strip_tags($image['error']));
                                }
                            }
                        }
                    }
                   
                    $res['status'] = 1;
                }else{
                    $res['status'] = 0;
                }
            }
            echo json_encode($res);
            exit;
        }
    }

    function delete_maintenance_cover_request(){
        // pr($this->input->post());
        if ($this->input->post()) {
            $res = [];
            $res['status'] = 0;
            $res['validationErrors'] = '';
            
            $this->form_validation->set_rules('request_id', 'Request Id', 'required');          

            if ($this->form_validation->run() === FALSE) {
                $res['validationErrors'] = validation_errors();
            } else {
                $post = html_escape($this->input->post());
                $mem_id = $this->mem_id;

                $del = $this->master->delete_where('mcover_requests', array('id' => intval($post['request_id'])));
                // pr($save_data);
                if($del) {
                    $this->master->delete_where('mc_req_images', array('request_id' => intval($post['request_id'])));
                    $res['status'] = true;

                    $purchased_mc = $this->master->getRows('purchased_maint_covers', array('mem_id' => $mem_id));
                    if(empty($purchased_mc)){
                        
                        $this->api_output['mc_requests'] = (Object)[];
                    }else{
                        
        
                        $requests = $this->master->getRows('mcover_requests', array('mem_id' => $mem_id), '', '', 'DESC');
                        
                            // pr($requests);
                            $this->api_output['mc_requests'] = array();
                            foreach($requests as $req){
                                $this->api_output['mc_requests'][] = (Object)[
                                    'id' => $req->id,
                                    'mem_id' => $req->mem_id,
                                    'maintenance_cover_id' => get_maintenance_cover_service_title($req->maintenance_cover_id),
                                    'service_title' => get_maintenance_cover_service_title($req->maintenance_cover_id),
                                    'address' => $req->address,
                                    'sub_cat_id' => get_mc_sub_service_title($req->sub_cat_id),
                                    'request_title' => $req->request_title,
                                    'detail' => $req->detail,
                                    'status' => $req->status,
                                    'created_date' => $req->created_date,
                                ];
                            }           
        
                    }

                }else{
                    $res['status'] = false;
                }
            }
            echo json_encode($res);
            exit;
        }
    }

    function buyer_maintenance_request_detail()
    {
        $request_id = intval($this->input->post('request_id'));
        if ($this->input->post() && !empty($request_id) && !empty($request = $this->master->getRow('mcover_requests', array('id' =>$request_id)))) {
            $post = $this->input->post();
            $mem_id = $this->mem_id;
            $memData = $this->member->getMemData($mem_id);
            $this->api_output['page_title'] = 'Maintenance Requests - ' . $this->data['site_settings']->site_name;
            $this->api_output['member'] = $memData; 
            $this->api_output['requestData'] = (Object)[
                'id' => $request->id,
                'mem_id' => $request->mem_id,
                'maintenance_cover_id' => $request->maintenance_cover_id,
                'sub_cat_id' => $request->sub_cat_id,
                'request_title' => $request->request_title,
                'detail' => $request->detail,
                'address' => $request->address,
                'status' => $request->status,
                'created_date' => $request->created_date,

                'service_title' => get_maintenance_cover_service_title($request->maintenance_cover_id),
                'sub_service' => get_mc_sub_service_title($request->sub_cat_id),
                
            ];
            
            $this->api_output['requestImages'] = $this->master->getRows('mc_req_images', array('request_id' => $request->id));
            


            http_response_code(200);
            echo json_encode($this->api_output);
            exit;
        } else {
            http_response_code(404);
            exit;
        }
    }


    function change_password()
    {

        if ($this->input->post()) {
            $res = [];
            $res['status'] = 0;
            $res['validationErrors'] = '';
            $this->form_validation->set_rules('pass', 'Current Password', 'required');
            $this->form_validation->set_rules('new_pass', 'New Password', 'required');
            $this->form_validation->set_rules('confirm_pass', 'Confirm Password', 'required|matches[new_pass]');
            if ($this->form_validation->run() === FALSE) {
                $res['validationErrors'] = validation_errors();
            } else {
                $post = html_escape($this->input->post());
                // pr($post);
                $mem_id = $this->mem_id;
                $row = $this->member->oldPswdCheck($mem_id, $post['pass']);
                if (countlength((array)$row) > 0) {
                    $ary = array('mem_pswd' => doEncode($post['new_pass']));
                    $is_saved = $this->member->save($ary, $mem_id);
                    if ($is_saved) {
                        $mem_data = array('name' => $row->mem_fname, "email" => $row->mem_email);
                        $this->send_password_change_successful($mem_data);
                        // pr($mem_data);
                    }
                    $res['status'] = 1;
                } else {
                    $res['status'] = 0;
                    $res['validationErrors'] = '<p>Wrong current password.</p>';
                }
            }
            exit(json_encode($res));
        }
    }

    function professional_dashboard()
    {

        if ($this->input->post()) {
            $post = $this->input->post();
            $mem_id = $this->mem_id;
            $memData = $this->member->getMemData($mem_id);
            $this->api_output['page_title'] = 'Dashboard - ' . $this->data['site_settings']->site_name;
            $this->api_output['member'] = $memData;
            $this->api_output['pro_profile'] = $this->master->getRow('professional_profile', array('mem_id' => $mem_id));

            $received = $this->master->getRows('sent_sms', array('to_mem_id' => $mem_id));
            $this->api_output['received_sms'] = [];
            foreach ($received as $key => $val) {
                $this->api_output['received_sms'][] = [
                    'from_mem_id' => $val->from_mem_id,
                    'from_mem_name' => get_mem_name($val->from_mem_id),
                    'from_mem_dp' => get_mem_image($val->from_mem_id),
                    'date' => format_date($val->created_date, 'M d, Y'),
                    'workscope_id' => $val->work_scope_id,
                    'from_mem_address' => get_mem_address($val->from_mem_id),
                ];
                
            }                
            $this->api_output['notifications'] = $this->master->getRows('notifications', array('receiver_mem_id' => $mem_id, 'read_status' => 0, 'receiver' => 'professional' ), '', '', 'DESC');
            $this->api_output['notifications_count'] = countlength($this->api_output['notifications']);

            $this->api_output['contract_converged_count'] = intval(countlength($received));
            $this->api_output['message_count'] = intval(0);
            $this->api_output['impressions'] = intval(0);



            // pr($this->api_output['received_sms']);
            http_response_code(200);
            echo json_encode($this->api_output);
            exit;
        } else {
            http_response_code(404);
            exit;
        }
    }

    function professional_notifications()
    {

        if ($this->input->post()) {
            $post = $this->input->post();
            $mem_id = $this->mem_id;
            $memData = $this->member->getMemData($mem_id);
            $this->api_output['page_title'] = 'Notifications - ' . $this->data['site_settings']->site_name;
            $this->api_output['member'] = $memData;
            $this->api_output['pro_profile'] = $this->master->getRow('professional_profile', array('mem_id' => $mem_id));
             
            $notifis = $this->master->getRows('notifications', array('receiver_mem_id' => $mem_id, 'receiver' => 'professional' ), '', '', 'DESC');
            $this->api_output['notifications'] = null;
            foreach($notifis as $notif){
                $this->api_output['notifications'][] = [
                    'sender_pic' => get_mem_image($notif->sender_mem_id),
                    'txt' => $notif->txt,
                    'receiver_mem_id' => $notif->receiver_mem_id,
                    'read_status' => $notif->read_status,
                    'created_at' => $notif->created_at,
                    'sender' => $notif->sender,
                    'receiver' => $notif->receiver,
                    'type' => $notif->type,
                ];
            } 
            
            $this->api_output['notifications_count'] = countlength($this->api_output['notifications']);


            // pr($this->api_output['received_sms']);
            http_response_code(200);
            echo json_encode($this->api_output);
            exit;
        } else {
            http_response_code(404);
            exit;
        }
    }

    function create_professional_profile()
    {
        if ($this->input->post()) {
            $res = [];
            $res['status'] = 0;
            $res['validationErrors'] = '';
            $this->form_validation->set_rules('service_id', 'Service ', 'trim|required');
            $this->form_validation->set_rules('business_name', 'Business Name', 'trim|required');
            $this->form_validation->set_rules('business_address', 'Business Address', 'trim|required');
            $this->form_validation->set_rules('business_type', 'Business Type', 'trim|required');
            $this->form_validation->set_rules('no_of_employes', 'Employes ', 'trim|required');
            $this->form_validation->set_rules('looking_for', 'Looking For', 'trim|required');
            $this->form_validation->set_rules('latitude', 'Location', 'required');
            $this->form_validation->set_rules('longitude', 'Location', 'required');
            


            if ($this->form_validation->run() === FALSE) {
                $res['validationErrors'] = validation_errors();
            } else {
                $post = html_escape($this->input->post());
                // pr($post);
                $mem_id = $this->mem_id;
                $mem_data = $this->member->getMember($mem_id);
                $save_data = [
                    'mem_id' => $mem_id,
                    'service_id' => $post['service_id'],
                    'business_name' => $post['business_name'],
                    'business_address' => $post['business_address'],
                    'business_type' => $post['business_type'],
                    'no_of_employes' => $post['no_of_employes'],
                    'looking_for' => $post['looking_for'],
                    'card_holder_name' => $post['card_holder_name'],
                    'latitude' => $post['latitude'],
                    'longitude' => $post['longitude'],
                    'payment_email' => $post['payment_email'],
                    // 'plan_code' => $post['plan_code'],
                    // 'txn_reference' => $post['txn_reference'],
                    'created_date' => date('Y-m-d h:i:s'),

                ];

                $profile_row = $this->master->getRow('professional_profile', array('mem_id' => $mem_id));
                if(!empty($profile_row)){
                    $id = $this->master->save('professional_profile', $save_data, 'id', $profile_row->id);
                }else{
                    $id = $this->master->save('professional_profile', $save_data);

                }

                // pr($id);

                // $id = $this->master->save('professional_profile', $save_data);
                if ($id > 0) {

                    if(!empty($post['sub_services'])){
                        $this->master->delete_where('selected_sub_services', array('mem_profile_id' => $id, 'mem_id' => $mem_id));
                        foreach($post['sub_services'] as $key=>$val){
                            $this->master->save('selected_sub_services', ['mem_profile_id' => $id, 'mem_id' => $mem_id, 'service_id' => $post['service_id'], 'sub_service_id' => $val]);
                        }
                    }

                    $this->member->update(['paystack_transaction_ref' => $post['txn_reference'], 'mem_type' => 'professional', 'mem_professionl_profile' => 1, 'mem_address' => $post['business_address'], 'mem_latitude' => $post['latitude'], 'mem_longitude' => $post['longitude']], array('mem_id' => $mem_id));
                    
                    $mem_updated = $this->member->getMember($mem_id);
                    $res['mem_type'] = $mem_updated->mem_type;
                    $res['mem_professionl_profile'] = $mem_updated->mem_professionl_profile;

                    $res['Verified'] = $mem_updated->mem_verified;
                    $res['status'] = 1;
                } else {
                    $res['status'] = 0;
                    $res['validationErrors'] = "Technical Issue";
                }
            }
            echo json_encode($res);
            exit;
        }
    }

    function professional_profile_settings()
    {
        if ($this->input->post()) {
            $post = $this->input->post();
            $mem_id = $this->mem_id;
            $this->api_output['page_title'] = 'Manage Account - ' . $this->data['site_settings']->site_name;

            $this->api_output['member'] = $this->member->getMemData($mem_id);
            $this->api_output['pro_profile'] = $this->master->getRow('professional_profile', array('mem_id' => $mem_id));
            
          

            http_response_code(200);
            echo json_encode($this->api_output);
            exit;
        } else {
            http_response_code(404);
            exit;
        }
    }

    function save_professional_profile_settings()
    {

        if ($this->input->post()) {
            $res = [];
            $res['status'] = 0;
            $res['validationErrors'] = '';
            $this->form_validation->set_rules('fname', 'Name', 'trim|required|min_length[2]|max_length[20]', ['min_length' => 'Name should contains atleast 2 letters.', 'max_length' => 'Name should not be greater than 20 letters.']);
            $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
            $this->form_validation->set_rules('address', 'Address', 'trim|required');
            $this->form_validation->set_rules('mem_bio', 'Personal Bio', 'trim|required');

            if ($this->form_validation->run() === FALSE) {
                $res['validationErrors'] = validation_errors();
            } else {
                $post = html_escape($this->input->post());
                $mem_id = $this->mem_id;
                $save_data = [
                    'mem_fname' => ucfirst($post['fname']),
                    'mem_phone' => $post['phone'],
                    'mem_address' => $post['address'],
                    'mem_bio' => $post['mem_bio']
                ];

                if (isset($_FILES["profile"]["name"]) && $_FILES["profile"]["name"] != "") {
                    $image = upload_file(UPLOAD_PATH . 'members', 'profile');
                    $save_data['mem_image'] = $image['file_name'];
                }
            
                $mem_id = $this->member->save($save_data, $mem_id);

                if ($mem_id) {                   
                    $res['status'] = 1;
                }
            }
            echo json_encode($res);
            exit;
        }
    }

    function save_business_data(){
        // pr($this->input->post());
        if ($this->input->post()) {
            $res = [];
            $res['status'] = 0;
            $res['validationErrors'] = '';
            
            $this->form_validation->set_rules('display_name', 'Dispaly Name', 'trim|required|min_length[2]|max_length[20]', ['min_length' => 'Dispaly Name should contains atleast 2 letters.', 'max_length' => 'Dispaly Name should not be greater than 20 letters.']);
            $this->form_validation->set_rules('business_name', 'Business Name', 'trim|required|min_length[2]|max_length[20]', ['min_length' => 'Dispaly Name should contains atleast 2 letters.', 'max_length' => 'Dispaly Name should not be greater than 20 letters.']);
            $this->form_validation->set_rules('business_phone', 'Business Phone', 'trim|required');
            $this->form_validation->set_rules('business_address', 'Business Address', 'trim|required');
            $this->form_validation->set_rules('specialization', 'Specializtion', 'trim|required');
            $this->form_validation->set_rules('bio', 'Business Bio', 'trim|required');


            if ($this->form_validation->run() === FALSE) {
                $res['validationErrors'] = validation_errors();
            } else {
                $post = html_escape($this->input->post());
                $mem_id = $this->mem_id;
                $save_data = [
                    'display_name' => $post['display_name'],
                    'business_name' => $post['business_name'],
                    'business_phone' => $post['business_phone'],
                    'specialization' => $post['specialization'],
                    'business_type' => $post['business_type'],
                    'no_of_employes' => $post['no_of_employes'],
                    'business_address' => $post['business_address'],
                    'bio' => $post['bio'],
                    'latitude' => $post['latitude'], 
                    'longitude' => $post['longitude'], 
                ];

                $profile_row = $this->master->getRow('professional_profile', array('mem_id' => $mem_id));
                if(!empty($profile_row)){
                    $id = $this->master->save('professional_profile', $save_data, 'id', $profile_row->id);
                }else{
                    $id = $this->master->save('professional_profile', $save_data);

                }
// pr($_FILES['portfolioImages']);
                if ($id) {
                    if(!empty($_FILES['portfolioImages'])){
                        $this->master->delete_where('portfolio_images', array('mem_id' => $mem_id));

                        foreach ($_FILES['portfolioImages']['name'] as $key => $file_name) {
                            // pr($file_name);
                            $_FILES['image_file']['name'] = $file_name;
                            $_FILES['image_file']['type'] = $_FILES['portfolioImages']['type'][$key];
                            $_FILES['image_file']['tmp_name'] = $_FILES['portfolioImages']['tmp_name'][$key];
                            $_FILES['image_file']['error'] = $_FILES['portfolioImages']['error'][$key];
                            $_FILES['image_file']['size'] = $_FILES['portfolioImages']['size'][$key];
                            if ($_FILES['image_file']['name'] != '') {
                                // pr($_FILES['image_file']);
                                $image = upload_file(UPLOAD_PATH . "members/portfolio/", 'image_file', 'image');
                                // pr($image);     
                                if (!empty($image['file_name'])) {
                                    $this->master->save('portfolio_images', array('mem_id' => $mem_id, 'image' => $image['file_name'], 'created_date' => date('Y-m-d H:i:s')));
                                } else {
                                    setMsg('error', 'Please upload a valid images file >> ' . strip_tags($image['error']));
                                }
                            }
                        }
                    }
                   
                    $res['status'] = 1;
                }
            }
            echo json_encode($res);
            exit;
        }
    }

    function update_sub_services(){
        $res = [];
        $res['status'] = 0;
        $res['validationErrors'] = '';
        if ($this->input->post()) {
            $post = $this->input->post();
            $mem_id = $this->mem_id;
            $member=$this->member->getMemData($mem_id);
            if(!empty($member)){
                if(!empty($post['sub_services']) && !empty($post['service_id'])){
                    if(countlength($post['sub_services']) > 0){
                        $mem_profiles = $this->master->getRow('professional_profile', array('mem_id' => $mem_id));
                        $this->master->delete_where('selected_sub_services', array('mem_id' => $mem_id));
                        foreach($post['sub_services'] as $key=>$val){
                            $this->master->save('selected_sub_services', ['mem_profile_id' => $mem_profiles->id, 'mem_id' => $mem_id, 'service_id' => $post['service_id'], 'sub_service_id' => json_decode($val)]);
                        }
                        $res['msg']='Updated successfully!';
                        $res['status']=1;
                    }
                    else{
                        $res['msg']='Please select sub service to continue!';
                    }
                }
                else{
                    $res['msg']='Please select sub service to continue!';
                }
            }
            else{
                $res['msg']='Invalid user!';
            }
            echo json_encode($res);
            exit;
        }
    }
    function get_mem_services_data()
    {
        if ($this->input->post()) {
            $post = $this->input->post();
            $mem_id = $this->mem_id;
            $this->api_output['page_title'] = 'Services - ' . $this->data['site_settings']->site_name;

            $this->api_output['member'] = $this->member->getMemData($mem_id);
            $mem_profile = $this->master->getRow('professional_profile', array('mem_id' => $mem_id));

            $this->api_output['pro_profile'] = $mem_profile;


            $this->api_output['mem_Services'] = array();

            if(!empty($mem_profile)){
                
                    $sub_services=array();
                    $service_data = $this->master->getRow("services", array('id' => $mem_profile->service_id));
                    $selected_sub_services = $this->master->getRows('selected_sub_services', array('mem_id' => $mem_id, 'mem_profile_id' => $mem_profile->id, 'service_id' => $service_data->id));
                    $service_sub_services = $this->master->getRows('sub_services', array('ser_id' => $service_data->id));
                    foreach($service_sub_services as $service_sub_service){
                        $selected_sub_service = $this->master->getRows('selected_sub_services', array('mem_id' => $mem_id, 'mem_profile_id' => $mem_profile->id, 'service_id' => $service_data->id,'sub_service_id'=>$service_sub_service->id));
                        if(!empty($selected_sub_service)){
                            $service_sub_service->selected=true;
                        }
                        $sub_services[]=$service_sub_service;
                    }
                    // pr($selected_sub_services);
                    $slected_sub_sers_data = [];
                    foreach($selected_sub_services as $sub_Ser){
                        $sub_data = get_subService($sub_Ser->sub_service_id);
                        $slected_sub_sers_data[] = [
                            'id' => $sub_data->id,
                            'title' => $sub_data->title,
                            'service_id' => $sub_data->ser_id
                        ];
                    }
                
                    $this->api_output['mem_Services'][] = [
                        'mem_profile_id' => $mem_profile->id,
                        'service_id' => $service_data->id,
                        'service_title' => get_service_title($service_data->id),
                        'sub_services' => $slected_sub_sers_data,
                        'all_sub_services' => $sub_services,
                    ];
                
            }
            $images = $this->master->getRows('portfolio_images', array('mem_id' => $mem_id));            
            $this->api_output['portfolioImages'] = array();
            foreach($images as $img) {
                $this->api_output['portfolioImages'][] = base_url('uploads/members/portfolio/'.$img->image) ;
            }

            http_response_code(200);
            echo json_encode($this->api_output);
            exit;
        } else {
            http_response_code(404);
            exit;
        }
    }

    function request_verify_phone(){
        if ($this->input->post()) {
            $res = [];
            $res['status'] = 0;
            $res['validationErrors'] = '';
        
            $this->form_validation->set_rules('phone', 'Phone Number', 'trim|required');

            if ($this->form_validation->run() === FALSE) {
                $res['validationErrors'] = validation_errors();
            } else {
                $post = html_escape($this->input->post());
                $mem_id = $this->mem_id;
                $memData = $this->member->getMember($mem_id);

                $phoneNumber = str_replace(' ', '', $post['phone']);
                
                if($post['type'] == "pro"){
                    $mem_profile = $this->master->getRow('professional_profile', array('mem_id' => $mem_id));
                    // check phone number is already exist or not
                    if($post['phone'] === $mem_profile->business_phone){
                        if($mem_profile->phone_verified == "0" || $mem_profile->phone_verified == 0){
                            $sendVerification = $this->twilio_lib->sendVerificationCode($phoneNumber);
                    
                            if(!empty($sendVerification->sid)){  
                                $this->master->save('professional_profile', ['temp_phone' => $post['phone']], 'id', $mem_profile->id);

                                $res['msg'] = "Verification Code Sent SuccessFully";
                                $res['status'] = true;
                            }else{
                                $res['validationErrors'] = "Error Occured Please Try Again Later.";
                                $res['status'] = false;
                            }
                        }else{
                            $res['msg'] = "This Phone Is Already Verified.";
                            $res['status'] = true;
                            $res['already_verified'] = true;
                        }
                       
                    }else{
                        // pr('hi');
                        $this->master->save('professional_profile', ['temp_phone' => $post['phone'], 'phone_verified' => 0], 'id', $mem_profile->id);
                        $sendVerification = $this->twilio_lib->sendVerificationCode($phoneNumber);
                    
                        if(!empty($sendVerification->sid)){
                                $this->master->save('professional_profile', ['temp_phone' => $post['phone']], 'id', $mem_profile->id);
                            
                            $res['msg'] = "Verification Code Sent SuccessFully";
                            $res['status'] = true;
                        }else{
                            $res['validationErrors'] = "Error Occured Please Try Again Later.";
                            $res['status'] = false;
                        }

                    }

                    $res['pro_profile'] = $this->master->getRow('professional_profile', array('mem_id' => $mem_id));
                    $res['phoneNumber'] = $post['phone'];


                }else{
                   
                    if($post['phone'] === $memData->mem_phone){
                        if($memData->mem_phone_verified == "0" || $memData->mem_phone_verified == 0){
                            $sendVerification = $this->twilio_lib->sendVerificationCode($phoneNumber);
                    
                            if(!empty($sendVerification->sid)){  
                                $this->master->save('members', ['mem_temp_phone' => $post['phone']], 'mem_id', $memData->mem_id);

                                $res['msg'] = "Verification Code Sent SuccessFully";
                                $res['status'] = true;
                            }else{
                                $res['validationErrors'] = "Error Occured Please Try Again Later.";
                                $res['status'] = false;
                            }
                        }else{
                            $res['msg'] = "This Phone Is Already Verified.";
                            $res['status'] = true;
                            $res['already_verified'] = true;
                        }
                       
                    }else{
                        // pr('hi');
                        $this->master->save('members', ['mem_temp_phone' => $post['phone'], 'mem_phone_verified' => 0], 'mem_id', $memData->mem_id);
                        $sendVerification = $this->twilio_lib->sendVerificationCode($phoneNumber);
                    
                        if(!empty($sendVerification->sid)){
                                $this->master->save('members', ['mem_temp_phone' => $post['phone']], 'mem_id', $memData->mem_id);
                        
                            $res['msg'] = "Verification Code Sent SuccessFully";
                            $res['status'] = true;
                        }else{
                            $res['validationErrors'] = "Error Occured Please Try Again Later.";
                            $res['status'] = false;
                        }

                    }

                    $res['memData'] = $this->master->getRow('members', array('mem_id' => $mem_id));
                    $res['phoneNumber'] = $post['phone'];
                }
                // die('here');
                 
            }
            echo json_encode($res);
            exit;
        }
    }

    function verify_phone(){
        if ($this->input->post()) {
            $res = [];
            $res['status'] = 0;
            $res['validationErrors'] = '';
        
            $this->form_validation->set_rules('phone', 'Phone ', 'trim|required');
            $this->form_validation->set_rules('code', 'Code', 'trim|required');

            if ($this->form_validation->run() === FALSE) {
                $res['validationErrors'] = validation_errors();
            } else {
                $post = html_escape($this->input->post());
                $mem_id = $this->mem_id;
                $memData = $this->member->getMember($mem_id);

                $phone = str_replace(' ', '', $post['phone']);
                $code = $post['code'];

                
                if($post['type'] == "pro"){
                    $mem_profile = $this->master->getRow('professional_profile', array('mem_id' => $mem_id));
                    if($post['phone'] === $mem_profile->temp_phone){
                        $verificationResult = $this->twilio_lib->verifyCode($phone, $code);
                        
                        if ($verificationResult->status === 'approved') {
                            $this->master->save('professional_profile', ['business_phone' => $post['phone'], 'temp_phone' => null, 'phone_verified' => 1], 'id', $mem_profile->id);

                            $res['msg'] = "Phone number verified successfully";
                            $res['status'] = true;
                        } else {
                            $res['validationErrors'] = "Verification Failed";
                            $res['status'] = false;
                        }
                        
                    }else{
                        $res['validationErrors'] = "Something Went Wrong";
                        $res['status'] = false;
                    }
                    $res['pro_profile'] = $this->master->getRow('professional_profile', array('mem_id' => $mem_id));
                }else{
                    
                    if($post['phone'] === $memData->mem_temp_phone){
                        $verificationResult = $this->twilio_lib->verifyCode($phone, $code);
                        
                        // pr($verificationResult);
                        if ($verificationResult->status === 'approved') {
                            $this->master->save('members', ['mem_phone' => $post['phone'], 'mem_temp_phone' => null, 'mem_phone_verified' => 1], 'mem_id', $memData->mem_id);

                            $res['msg'] = "Phone number verified successfully";
                            $res['status'] = true;
                        } else {
                            $res['validationErrors'] = "Verification Failed";
                            $res['status'] = false;
                        }
                        
                    }else{
                        $res['validationErrors'] = "Something Went Wrong";
                        $res['status'] = false;
                    }
                    $res['memData'] = $this->master->getRow('members', array('mem_id' => $mem_id));
                }
//                
            }
            echo json_encode($res);
            exit;
        }
    }

    function send_message(){
        if ($this->input->post()) {
            $res = [];
            $res['status'] = 0;
            $res['validationErrors'] = '';
        
            $this->form_validation->set_rules('pro_phone', 'Professional Phone Number', 'trim|required');

            if ($this->form_validation->run() === FALSE) {
                $res['validationErrors'] = validation_errors();
            } else {
                $post = html_escape($this->input->post());
                $mem_id = $this->mem_id;
                $memData = $this->member->getMember($mem_id);
                             
                if(!empty($post['work_scope'])){
                    $w_id = $post['work_scope'];
                    $w_id = intval(doDecode($w_id));
                    $workscope = $this->master->getRow('work_scopes', array('id' => $w_id, 'mem_id' => $mem_id));
                }

                $msg = "";
                $msg .= 'WeFitWork';
                $msg .= "\n\n";
                $msg .= 'Hi, '.$post['pro_name'];
                $msg .= "\n\n";
                $msg .= 'You got a new job request. Below are the details:';
                $msg .= "\n\n";
                $msg .= 'Buyer Name: '.$memData->mem_fname ;
                $msg .= "\n";
                $msg .= 'Buyer Phone: '.$memData->mem_phone;
                $msg .= "\n";
                if(empty($post['work_scope'])){
                    $msg .= 'Work Details: Work Scope not attached. Please contact buyer for work details or scope';
                    $msg .= "\n\n";
                    }else{
                    $msg .= 'Work Details: '.$post['base_path'].'/work/'.$workscope->id;
                        
                    }
                $msg .= "\n\n";
                
                $msg .= 'Please check your Dashboard for more details';
                $msg .= "\n";
                // pr($msg);

                $to_phone =  str_replace(' ', '', $post['pro_phone']);
                
                $message = $this->twilio_lib->send_sms($to_phone, $msg);
                if($message->sid){
                    $sent = $this->master->save('sent_sms', ['from_mem_id' => $mem_id, 'to_mem_id' => $post['pro'], 'work_scope_id' => $workscope ? $workscope->id : null, 'status' => 1]);
                    
                    $notify_arr = [
                        'sender_mem_id' => $mem_id,
                        'receiver_mem_id' => $post['pro'],
                        'txt' => get_mem_name($mem_id). ' Sent You the SMS Request on your Phone',
                        'read_status' => 0,
                        'created_at' => date('Y-m-d h:i:s'),
                        'sender' => 'buyer',
                        'receiver' => 'professional',
                        'type' => 'sms',
                    ];

                    $this->master->save('notifications', $notify_arr);
                    
                    $res['status'] = true;
                    $res['msg'] = "Message Sent Successfully to Professional";               
                    
                }else{
                    $res['status'] = false;
                    $res['msg'] = "Message Not Sent Successfully to Professional. Invalid Phone Number ";
                }
                
            }
            echo json_encode($res);
            exit;
        }
    }

    function get_pro_mem_subscriptions()
    {
        if ($this->input->post()) {
            $post = $this->input->post();
            $mem_id = $this->mem_id;
            $this->api_output['page_title'] = 'My Subscriptions - ' . $this->data['site_settings']->site_name;

            $this->api_output['member'] = $this->member->getMemData($mem_id);
            $mem_profile = $this->master->getRow('professional_profile', array('mem_id' => $mem_id));

            $this->api_output['pro_profile'] = $mem_profile;

            // $this->api_output['plans'] = $this->master->getRows('plans',array('status' => 1));
            $this->api_output['mem_active_subscription'] = $this->master->getRow('mem_subscriptions', array('mem_id' => $mem_id, 'subscription_status' => 'active'));
            // pr($this->api_output['mem_active_subscriptions']);

            $this->api_output['mem_subscriptions'] = $this->master->getRows('mem_subscriptions', array('mem_id' => $mem_id), '', '', 'DESC');

            http_response_code(200);
            echo json_encode($this->api_output);
            exit;
        } else {
            http_response_code(404);
            exit;
        }
    }


    function start_chat(){
        if ($this->input->post()) {
            $res = [];
            $res['status'] = 0;
            $res['validationErrors'] = '';
        
            $this->form_validation->set_rules('receiver_id', 'Receiver', 'trim|required');

            if ($this->form_validation->run() === FALSE) {
                $res['validationErrors'] = validation_errors();
            } else {
                $post = html_escape($this->input->post());
                $mem_id = $this->mem_id;
                $memData = $this->member->getMemData($mem_id);

                $save_data = [
                    'sender_id' => $mem_id,
                    'receiver_id' => $post['receiver_id'],
                    'created_date' => date('Y-m-d h:i:s'),
                    'status' => 1
                ];

                $convo_row = $this->chat->getConversation($mem_id, $post['receiver_id']);
                // pr($convo_row);

                if(!empty($convo_row)){
                    $convo_id = $convo_row->id;
                }else{
                    $convo_id = $this->master->save('conversations', $save_data);
                }

                if($convo_id > 0) {
                    $res['status'] = true;
                    $res['convo_id'] = doEncode($convo_id);
                }else{
                    $res['status'] = false;
                    
                }
                
                
            }
            echo json_encode($res);
            exit;
        }
    }


    function fetch_conversation_data()
    {
        if ($this->input->post()) {
            $post = $this->input->post();
            // echo gettype($post['chat_id']);
            // pr($post['chat_id']);
            $mem_id = $this->mem_id;
            $this->api_output['page_title'] = 'Chat - ' . $this->data['site_settings']->site_name;
            $this->api_output['member'] = $this->member->getMemData($mem_id);

            $convos = $this->chat->getUserConversations($mem_id);
            // pr($convos);

            $this->api_output['mem_conversations'] = null;
            foreach($convos as $con) {
                $this->api_output['mem_conversations'][] = [
                    'id' => $con->id,
                    'encrypted_id' => doEncode($con->id),
                    'sender_id' => $con->sender_id,
                    'receiver_id' => $con->receiver_id,
                    'receiver_name' => get_mem_name($con->receiver_id),
                    'receiver_image' => get_mem_image($con->receiver_id),
                    'created_date' => $con->created_date,
                    'status' => $con->status,

                ];
            }

            


            if($post['chat_id'] == "null" || $post['chat_id'] == null){

                $this->api_output['chat_data'] = null;
                $this->api_output['chat_messages'] = null;
                
            }else{
                $chat_id = doDecode($post['chat_id']);
                $chat_id = intval($chat_id);
                $chat = $this->master->getRow('conversations', array('id' => $chat_id));
    
            $this->api_output['chat_data'] = [
                'id' => $chat->id,
                'encrypted_id' => doEncode($chat->id),
                'sender_id' => $chat->sender_id,
                    'receiver_id' => $chat->receiver_id,
                    'receiver_name' => get_mem_name($chat->receiver_id),
                    'receiver_image' => get_mem_image($chat->receiver_id),
                    'created_date' => $chat->created_date,
                    'status' => $chat->status,
            ];

            $this->api_output['chat_messages'] = $this->chat->getChatMessages($chat->id);
            }

            
          

            http_response_code(200);
            echo json_encode($this->api_output);
            exit;
        } else {
            http_response_code(404);
            exit;
        }
    }



}
