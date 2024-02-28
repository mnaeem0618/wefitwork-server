<?php

class Paystack extends MY_Controller
{

    private $mem_id = '';
    public function __construct()
    {
        parent::__construct();

        header('Content-Type: application/json');
        $this->load->model('Member_model', 'member');
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

        $this->api_output['site_settings'] = (Object)[
            'site_name' => $this->data['site_settings']->site_name,
            'site_email' => $this->data['site_settings']->site_email,
            'site_logo' => $this->data['site_settings']->site_logo,
            'site_footer_logo' => $this->data['site_settings']->site_footer_logo,
            'site_icon' => $this->data['site_settings']->site_icon,
            ];

            $this->load->library('my_paystack_lib');

    }

    function create_customer()
    {

        if ($this->input->post()) {
            $post = $this->input->post();
            // pr($post);
            $mem_id = $this->mem_id;
            $memData = $this->member->getMemData($mem_id);


            $result = $this->my_paystack_lib->create_customer($post['email'], $post['name']);

            $customer_data = json_decode($result);

            // pr($customer_data);
            if($customer_data->data->customer_code !== '' || $customer_data->data->customer_code){
                $this->member->update(['mem_type' => 'professional', 'mem_professionl_profile' => 1, 'mem_address' => $post['business_address'], 'mem_latitude' => $post['latitude'], 'mem_longitude' => $post['longitude']], array('mem_id' => $mem_id));

                $this->api_output['customer_code'] = $customer_data->data->customer_code;
                $this->api_output['status'] = true;
            }else{
                $this->api_output['status'] = false;
                $this->api_output['customer_code'] = '';

            }
           
            

            // $this->api_output['post'] = $post;


            http_response_code(200);
            echo json_encode($this->api_output);
            exit;
        } else {
            http_response_code(404);
            exit;
        }
    }


    function fetch_customer()
    {
        // pr('hi');

        if ($this->input->post()) {
            $post = $this->input->post();
            // pr($post);
            $mem_id = $this->mem_id;
            $memData = $this->member->getMemData($mem_id);

            // pr($memData);

            $result = $this->my_paystack_lib->fetch_customer($memData->mem_paystack_customer_code);

            $customer_data = json_decode($result);

           pr($customer_data);
           
            

            // $this->api_output['post'] = $post;


            http_response_code(200);
            echo json_encode($this->api_output);
            exit;
        } else {
            http_response_code(404);
            exit;
        }
    }

}
