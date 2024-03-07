<?php

class Pages extends MY_Controller
{

    private $mem_id = '';
    public function __construct()
    {

        parent::__construct();
        header('Content-Type: application/json');
        $this->load->model('Pages_model', 'page');
        $this->load->model('Member_model', 'member');

        $this->load->library('Sendinblue', 'sendinblue');

        if (!empty($this->input->post('token'))) {
            $tokenResponse = $this->verifyAuthToken($this->input->post('token'), $this->input->ip_address());
            if ($tokenResponse['error'] === 0) {
                $this->mem_id = $tokenResponse['mem_id'];
            }
        }

        $this->api_output;
        $this->load->library('my_paystack_lib');

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

    function site_settings()
    {

        // pr($this->input->post('token'));
        $post = $this->input->post();
        if (empty($post['token'])) {
            $memData = null;
        } else {
            // pr('hi');
            $mem_id = $this->mem_id;
            $memData = $this->member->getMemData($mem_id);
            // pr($memData);
        }
        $this->data['site_settings']->memData = $memData;
        $this->data['memData'] = $memData;

        http_response_code(200);
        echo json_encode($this->data);
    }

    function home()
    {

        $meta = $this->page->getMetaContent('home');
        $this->api_output['page_title'] = $meta->page_name . ' - ' . $this->data['site_settings']->site_name;
        $this->api_output['slug'] = $meta->slug;
        $data = $this->page->getPageContent('home');
        // pr($data);
        if ($data) {
            $this->api_output['content'] = $content = unserialize($data->code);
            $this->api_output['banner_pics'] = $this->master->getRows('banner_images', array('section' => 'home-banner', 'status' => 1));
            // $this->api_output['details'] = ($data->full_code);
            $this->api_output['meta_desc'] = json_decode($meta->content);
            $this->api_output['featured_services'] = $this->master->getRows('services', ['status' => 1, 'featured' => 1], '', '', 'ASC', 'id');
            $this->api_output['most_searched'] = $this->master->getRows('services', ['status' => 1, 'searched' => 1], '', '', 'ASC', 'id');
            $this->api_output['testimonials'] = $this->master->getRows('testimonials', ['status' => 1], '', '', 'desc', 'id');
            $this->api_output['services'] = $this->master->getRows('services', array('status' => 1));
            $this->api_output['states'] = $this->master->getRows('nigeria_states', array('status' => 1));



            http_response_code(200);
            echo json_encode($this->api_output);
        } else {
            http_response_code(404);
        }
    }

    function about()
    {
        $meta = $this->page->getMetaContent('about');
        $this->api_output['page_title'] = $meta->page_name . ' - ' . $this->data['site_settings']->site_name;
        $this->api_output['slug'] = $meta->slug;
        $data = $this->page->getPageContent('about');
        // pr($data);
        if ($data) {
            $this->api_output['content'] = $content = unserialize($data->code);
            // $this->api_output['details'] = ($data->full_code);
            $this->api_output['meta_desc'] = json_decode($meta->content);
            $this->api_output['testimonials'] = $this->master->getRows('testimonials', ['status' => 1], '', '', 'desc', 'id');
            $this->api_output['our_team'] = $this->master->getRows('team', ['status' => 1], '', '', 'asc', 'id');


            http_response_code(200);
            echo json_encode($this->api_output);
        } else {
            http_response_code(404);
        }
    }

    function become_pro()
    {
        $meta = $this->page->getMetaContent('become_pro');
        $this->api_output['page_title'] = $meta->page_name . ' - ' . $this->data['site_settings']->site_name;
        $this->api_output['slug'] = $meta->slug;
        $data = $this->page->getPageContent('become_pro');
        // pr($data);
        if ($data) {
            $this->api_output['site_settings'] = (object)[
                'site_phone' => $this->data['site_settings']->site_phone,
            ];
            $this->api_output['content'] = $content = unserialize($data->code);
            // $this->api_output['details'] = ($data->full_code);
            $this->api_output['meta_desc'] = json_decode($meta->content);
            $this->api_output['how_works'] = getMultiText('about-sec3');

            http_response_code(200);
            echo json_encode($this->api_output);
        } else {
            http_response_code(404);
        }
    }

    function help()
    {
        $meta = $this->page->getMetaContent('help');
        $this->api_output['page_title'] = $meta->page_name . ' - ' . $this->data['site_settings']->site_name;
        $this->api_output['slug'] = $meta->slug;
        $data = $this->page->getPageContent('help');
        // pr($data);
        if ($data) {
            $this->api_output['content'] = $content = unserialize($data->code);
            // $this->api_output['details'] = ($data->full_code);
            $this->api_output['meta_desc'] = json_decode($meta->content);
            $this->api_output['helps'] = $this->master->getRows('help', array('status' => 1));

            http_response_code(200);
            echo json_encode($this->api_output);
        } else {
            http_response_code(404);
        }
    }

    function help_detail($slug)
    {

        $help = $this->master->get_data_row('help', array("status" => 1, 'slug' => $slug));
        if (!empty($slug) && !empty($help)) {
            $meta = $this->page->getMetaContent('help');
            $this->api_output['page_title'] = $help->title . ' - ' . $this->data['site_settings']->site_name;
            $this->api_output['slug'] = $meta->slug;
            $data = $this->page->getPageContent('help');
            $this->api_output['help'] = $help;

            $this->api_output['meta_desc'] = [
                'meta_title' => $help->meta_title,
                'meta_description' => $help->meta_description,
                'meta_keywords' => $help->meta_keywords,
                'og_type' => $help->og_type,
                'og_title' => $help->og_title,
                'og_description' => $help->og_description,
                'og_image' => $help->og_image,
                'twitter_image' => $help->og_image,
            ];
            $this->api_output['content'] = $content = unserialize($data->code);
            $this->api_output['helps'] = $this->master->getRows('help', array('status' => 1));
            $help_topics = $this->master->getRows('help_topics', array('help_id' => $help->id, 'status' => 1));

            foreach ($help_topics as $topic) {
                $this->api_output['help_topics'][] = [
                    'topic' => $topic,
                    'articles' => $this->master->getRows('help_topic_articles', array('topic_id' => $topic->id, 'status' => 1)),
                ];
            }


            http_response_code(200);
            echo json_encode($this->api_output);
        } else {
            http_response_code(404);
        }
    }

    function maintenance_covers()
    {
        $post = $this->input->post();
        if (empty($post['token'])) {
            $memData = null;
        } else {
            // pr('hi');
            $mem_id = $this->mem_id;
            $memData = $this->member->getMemData($mem_id);
            $this->api_output['memData'] = $memData;
        }
        $meta = $this->page->getMetaContent('maintenance_cover');
        $this->api_output['page_title'] = $meta->page_name . ' - ' . $this->data['site_settings']->site_name;
        $this->api_output['slug'] = $meta->slug;
        $data = $this->page->getPageContent('maintenance_cover');
        // pr($data);
        if ($data) {
            $this->api_output['content'] = $content = unserialize($data->code);
            // $this->api_output['details'] = ($data->full_code);
            $this->api_output['meta_desc'] = json_decode($meta->content);
            $maintenance_covers = $this->master->getRows('maintenance_covers', array('status' => 1));
            $this->api_output['maintenance_covers'] = [];

            foreach($maintenance_covers as $mc){
                $this->api_output['maintenance_covers'][] = (Object)[
                    "id" => $mc->id,
                    "service_title" => $mc->service_title,
                    "title" => $mc->title,
                    "short_desc" => $mc->short_desc,
                    "detail" => $mc->detail,
                    "price" => $mc->price,
                    "status" => $mc->status,
                    "created_date" => $mc->created_date,
                    "paystack_plan_code" => $mc->paystack_plan_code,
                    "interval" => $mc->interval,
                    'included' => getIncluded($mc->id),
                ];
            }
            $this->api_output['how_works'] = getMultiText('maintenance-cover-sec4');
            $this->api_output['testimonials'] = $this->master->getRows('testimonials', ['status' => 1], '', '', 'desc', 'id');


            http_response_code(200);
            echo json_encode($this->api_output);
        } else {
            http_response_code(404);
        }
    }

    function maintenance_cover_detail($id)
    {
        $id = intval($id);
        $mc = $this->master->get_data_row('maintenance_covers', array("status" => 1, 'id' => $id));

        $post = $this->input->post();
        if (empty($post['token'])) {
            $memData = null;
        } else {
            // pr('hi');
            $mem_id = $this->mem_id;
            $memData = $this->member->getMemData($mem_id);
            $this->api_output['memData'] = $memData;
        }
        // pr($mc);
        if (!empty($id) && !empty($mc)) {
            $this->api_output['page_title'] = $mc->service_title . ' - ' . $this->data['site_settings']->site_name;
            $this->api_output['maintenance_cover'] = $mc;

            $this->api_output['meta_desc'] = [
                'meta_title' => $mc->service_title,
                'meta_description' => $mc->short_desc,
                'meta_keywords' => 'mc',
                'og_type' => 'website',
                'og_title' => $mc->service_title,
                'og_description' =>$mc->short_desc,
                'og_image' => $this->data['site_settings']->site_thumb,
                'twitter_image' => $this->data['site_settings']->site_thumb,
            ];

            $this->api_output['mc_content'] = $mc_content = unserialize($mc->content);
            $this->api_output['included'] = getIncluded($mc->id);
            $this->api_output['excluded'] = getExcluded($mc->id);
            $this->api_output['faqs'] = getMcoverFaqs($mc->id);

            http_response_code(200);
            echo json_encode($this->api_output);
        } else {
            http_response_code(404);
        }
    }

    function checkout_page($id)
    {
        $id = intval($id);
        $mc = $this->master->get_data_row('maintenance_covers', array("status" => 1, 'id' => $id));

        $post = $this->input->post();
        if (empty($post['token'])) {
            $memData = null;
        } else {
            // pr('hi');
            $mem_id = $this->mem_id;
            $memData = $this->member->getMemData($mem_id);

            if ($memData->mem_paystack_customer_code == '' || $memData->mem_paystack_customer_code == null || empty($memData->mem_paystack_customer_code)) {
                $result = $this->my_paystack_lib->create_customer($memData->mem_email, $memData->mem_fname);
                $customer_data = json_decode($result);
                // pr($customer_data);
                if ($customer_data->data->customer_code !== '' || $customer_data->data->customer_code) {
                    $this->member->update(['mem_paystack_customer_code' => $customer_data->data->customer_code], array('mem_id' => $mem_id));
                    $this->api_output['customer_code'] = $customer_data->data->customer_code;
                } else {
                    $this->api_output['customer_creation_failed'] = true;
                }

                $memData = $this->member->getMemData($mem_id);
            }

            $this->api_output['memData'] = $memData;
        }
        // pr($mc);
        if (!empty($id) && !empty($mc)) {
            $meta = $this->page->getMetaContent('checkout_page');
        $this->api_output['page_title'] = $meta->page_name . ' - ' . $this->data['site_settings']->site_name;
        $this->api_output['slug'] = $meta->slug;
        $data = $this->page->getPageContent('checkout_page');
       
            $this->api_output['content'] = $content = unserialize($data->code);
            $this->api_output['meta_desc'] = json_decode($meta->content);

            $this->api_output['maintenance_cover'] = $mc;
            $this->api_output['type_prices'] = $this->master->getRows('mc_prices', array('maintenance_cover_id' => $mc->id),'', '', "ASC", 'sort_order');


            $this->api_output['included'] = getIncluded($mc->id);


            http_response_code(200);
            echo json_encode($this->api_output);
        
        } else {
            http_response_code(404);
        }
    }

    function contact_us()
    {
        $meta = $this->page->getMetaContent('contact_us');
        $this->api_output['page_title'] = $meta->page_name . ' - ' . $this->data['site_settings']->site_name;
        $this->api_output['slug'] = $meta->slug;
        $data = $this->page->getPageContent('contact_us');

        if ($data) {
            $this->api_output['content'] = unserialize($data->code);
            $this->api_output['details'] = ($data->full_code);
            $this->api_output['meta_desc'] = json_decode($meta->content);

            $this->api_output['site_settings'] = (object)[
                'site_name' => $this->data['site_settings']->site_name,
                'site_email' => $this->data['site_settings']->site_email,
                'site_general_email' => $this->data['site_settings']->site_general_email,
                'site_noreply_email' => $this->data['site_settings']->site_noreply_email,
                'site_phone' => $this->data['site_settings']->site_phone,
                'site_address' => $this->data['site_settings']->site_address,
                'site_facebook' => $this->data['site_settings']->site_facebook,
                'site_twitter' => $this->data['site_settings']->site_twitter,
                'site_google' => $this->data['site_settings']->site_google,
                'site_instagram' => $this->data['site_settings']->site_instagram,
                'site_linkedin' => $this->data['site_settings']->site_linkedin,
                'site_youtube' => $this->data['site_settings']->site_youtube,
            ];

            http_response_code(200);
            echo json_encode($this->api_output);
        } else {
            http_response_code(404);
        }
        exit;
    }

    function terms_and_conditions()
    {

        $meta = $this->page->getMetaContent('terms_and_conditions');
        $this->api_output['page_title'] = $meta->page_name . ' - ' . $this->data['site_settings']->site_name;
        $this->api_output['slug'] = $meta->slug;
        $data = $this->page->getPageContent('terms_and_conditions');
        if ($data) {
            $this->api_output['content'] = unserialize($data->code);
            $this->api_output['details'] = ($data->full_code);
            $this->api_output['meta_desc'] = json_decode($meta->content);

            http_response_code(200);
            echo json_encode($this->api_output);
        } else {
            http_response_code(404);
        }
        exit;
    }

    function privacy_policy()
    {

        $meta = $this->page->getMetaContent('privacy_policy');
        $this->api_output['page_title'] = $meta->page_name . ' - ' . $this->data['site_settings']->site_name;
        $this->api_output['slug'] = $meta->slug;
        $data = $this->page->getPageContent('privacy_policy');

        if ($data) {
            $this->api_output['content'] = unserialize($data->code);
            $this->api_output['details'] = ($data->full_code);
            $this->api_output['meta_desc'] = json_decode($meta->content);

            http_response_code(200);
            echo json_encode($this->api_output);
        } else {
            http_response_code(404);
        }
        exit;
    }

    function login()
    {

        $meta = $this->page->getMetaContent('login');
        $this->api_output['page_title'] = $meta->page_name . ' - ' . $this->data['site_settings']->site_name;
        $this->api_output['slug'] = $meta->slug;
        $data = $this->page->getPageContent('login');
        if ($data) {
            $this->api_output['content'] = unserialize($data->code);
            $this->api_output['details'] = ($data->full_code);
            $this->api_output['meta_desc'] = json_decode($meta->content);

            $this->api_output['site_settings'] = (object)[
                'site_name' => $this->data['site_settings']->site_name,
                'site_email' => $this->data['site_settings']->site_email,
                'site_logo' => $this->data['site_settings']->site_logo,
                'site_footer_logo' => $this->data['site_settings']->site_footer_logo,
                'site_icon' => $this->data['site_settings']->site_icon,
            ];

            http_response_code(200);
            echo json_encode($this->api_output);
        } else {
            http_response_code(404);
        }
        exit;
    }

    function signup()
    {
        $meta = $this->page->getMetaContent('signup');
        $this->api_output['page_title'] = $meta->page_name . ' - ' . $this->data['site_settings']->site_name;
        $this->api_output['slug'] = $meta->slug;
        $data = $this->page->getPageContent('signup');
        if ($data) {
            $this->api_output['content'] = unserialize($data->code);
            $this->api_output['details'] = ($data->full_code);
            $this->api_output['meta_desc'] = json_decode($meta->content);

            $this->api_output['site_settings'] = (object)[
                'site_name' => $this->data['site_settings']->site_name,
                'site_email' => $this->data['site_settings']->site_email,
                'site_logo' => $this->data['site_settings']->site_logo,
                'site_footer_logo' => $this->data['site_settings']->site_footer_logo,
                'site_icon' => $this->data['site_settings']->site_icon,
            ];

            http_response_code(200);
            echo json_encode($this->api_output);
        } else {
            http_response_code(404);
        }
        exit;
    }

    function professional_signup_page()
    {
        $post = $this->input->post();
        $this->api_output['post'] = $post;
        if (!empty($post['token'])) {
            $mem_id = $this->mem_id;
            $memData = $this->member->getMemData($mem_id);

            // pr($memData->mem_paystack_customer_code);

            if ($memData->mem_paystack_customer_code == '' || $memData->mem_paystack_customer_code == null || empty($memData->mem_paystack_customer_code)) {
                $result = $this->my_paystack_lib->create_customer($memData->mem_email, $memData->mem_fname);
                $customer_data = json_decode($result);
                // pr($customer_data);
                if ($customer_data->data->customer_code !== '' || $customer_data->data->customer_code) {
                    $this->member->update(['mem_paystack_customer_code' => $customer_data->data->customer_code], array('mem_id' => $mem_id));
                    $this->api_output['customer_code'] = $customer_data->data->customer_code;
                } else {
                    $this->api_output['customer_creation_failed'] = true;
                }

                $memData = $this->member->getMemData($mem_id);
            }


            $meta = $this->page->getMetaContent('pro_signup');
            $this->api_output['page_title'] = $meta->page_name . ' - ' . $this->data['site_settings']->site_name;
            $this->api_output['slug'] = $meta->slug;
            $data = $this->page->getPageContent('pro_signup');
            if ($data) {
                $this->api_output['content'] = unserialize($data->code);
                $this->api_output['details'] = ($data->full_code);
                $this->api_output['meta_desc'] = json_decode($meta->content);
                $this->api_output['services'] = $this->master->getRows('services', array('status' => 1));
                $this->api_output['subscription_plans'] = $this->master->getRows('plans', array('status' => 1));

                $this->api_output['site_settings'] = (object)[
                    'site_name' => $this->data['site_settings']->site_name,
                    'site_email' => $this->data['site_settings']->site_email,
                    'site_logo' => $this->data['site_settings']->site_logo,
                    'site_footer_logo' => $this->data['site_settings']->site_footer_logo,
                    'site_icon' => $this->data['site_settings']->site_icon,
                ];

                $this->api_output['memData'] = $memData;

                http_response_code(200);
                echo json_encode($this->api_output);
            }
        } else {
            $this->api_output['memData'] = null;
            http_response_code(404);
        }
        exit;
    }

    function forgot_password_content()
    {

        $meta = $this->page->getMetaContent('forgot_password');
        $this->api_output['page_title'] = $meta->page_name . ' - ' . $this->data['site_settings']->site_name;
        $this->api_output['slug'] = $meta->slug;
        $data = $this->page->getPageContent('forgot_password');
        if ($data) {
            $this->api_output['content'] = unserialize($data->code);
            $this->api_output['details'] = ($data->full_code);
            $this->api_output['meta_desc'] = json_decode($meta->content);

            $this->api_output['site_settings'] = (object)[
                'site_name' => $this->data['site_settings']->site_name,
                'site_email' => $this->data['site_settings']->site_email,
                'site_logo' => $this->data['site_settings']->site_logo,
                'site_footer_logo' => $this->data['site_settings']->site_footer_logo,
                'site_icon' => $this->data['site_settings']->site_icon,
            ];

            http_response_code(200);
            echo json_encode($this->api_output);
        } else {
            http_response_code(404);
        }
        exit;
    }

    function email_verify_content()
    {
        $meta = $this->page->getMetaContent('email_verify');
        $this->api_output['page_title'] = $meta->page_name . ' - ' . $this->data['site_settings']->site_name;
        $this->api_output['slug'] = $meta->slug;
        $data = $this->page->getPageContent('email_verify');

        if ($data) {
            $this->api_output['content'] = unserialize($data->code);
            $this->api_output['details'] = ($data->full_code);
            $this->api_output['meta_desc'] = json_decode($meta->content);

            $this->api_output['site_settings'] = (object)[
                'site_name' => $this->data['site_settings']->site_name,
                'site_email' => $this->data['site_settings']->site_email,
                'site_logo' => $this->data['site_settings']->site_logo,
                'site_footer_logo' => $this->data['site_settings']->site_footer_logo,
                'site_icon' => $this->data['site_settings']->site_icon,
            ];

            http_response_code(200);
            echo json_encode($this->api_output);
        } else {
            http_response_code(404);
        }
        exit;
    }

    function reset_password_content()
    {
        $meta = $this->page->getMetaContent('change_password');
        $this->api_output['page_title'] = $meta->page_name . ' - ' . $this->data['site_settings']->site_name;
        $this->api_output['slug'] = $meta->slug;
        $data = $this->page->getPageContent('change_password');

        if ($data) {
            $this->api_output['content'] = unserialize($data->code);
            $this->api_output['details'] = ($data->full_code);
            $this->api_output['meta_desc'] = json_decode($meta->content);

            $this->api_output['site_settings'] = (object)[
                'site_name' => $this->data['site_settings']->site_name,
                'site_email' => $this->data['site_settings']->site_email,
                'site_logo' => $this->data['site_settings']->site_logo,
                'site_footer_logo' => $this->data['site_settings']->site_footer_logo,
                'site_icon' => $this->data['site_settings']->site_icon,
            ];

            http_response_code(200);
            echo json_encode($this->api_output);
        } else {
            http_response_code(404);
        }
        exit;
    }

    function blogs(){
        $meta = $this->page->getMetaContent('blogs');
        $this->api_output['page_title'] = $meta->page_name . ' - ' . $this->data['site_settings']->site_name;
        $this->api_output['slug'] = $meta->slug;

        $data = $this->page->getPageContent('blogs');
        if ($data) {
            $this->api_output['content'] = unserialize($data->code);
            $this->api_output['details'] = ($data->full_code);
            $this->api_output['meta_desc'] = json_decode($meta->content);
            $blogs = $this->master->getRows('blogs', ['status' => 1], '', '', 'desc', 'id');
            $this->api_output['blogs'] = array();

            foreach($blogs as $blog){
                $this->api_output['blogs'][] = [
                    'id' => $blog->id, 
                    'category_id' => get_cat_name($blog->category_id), 
                    'title' => $blog->title, 
                    'slug' => $blog->slug, 
                    'short_description' => $blog->short_description, 
                    'description' => $blog->description, 
                    'meta_title' => $blog->meta_title, 
                    'meta_keywords' => $blog->meta_keywords, 
                    'meta_description' => $blog->meta_description, 
                    'og_type' => $blog->og_type, 
                    'og_title' => $blog->og_title, 
                    'og_description' => $blog->og_description, 
                    'og_image' => $blog->og_image, 
                    'image' => $blog->image, 
                    'image_alt_text' => $blog->image_alt_text, 
                    'status' => $blog->status, 
                    'is_featured' => $blog->is_featured, 
                    'created_date' => $blog->created_date, 
                    'is_top_post' => $blog->is_top_post, 
                ];
                
            }

            $this->api_output['top_posts'] = $this->master->getRows('blogs', ['status' => 1, 'is_top_post' => 1], '', '', 'desc', 'id');
            $this->api_output['cats']  = $this->master->getRows('blog_categories', ['status' => 1]);

           

            http_response_code(200);
            echo json_encode($this->api_output);
        } else {
            http_response_code(404);
        }
        exit;
    }

    function blogsByCat(){
        $post =  $this->input->post();
    
        if (!empty($post['cat_id'])) {
           
            $blogs = $this->master->getRows('blogs', ['status' => 1, 'category_id' => $post['cat_id']], '', '', 'desc', 'id');
            $this->api_output['blogs'] = array();

            foreach($blogs as $blog){
                $this->api_output['blogs'][] = [
                    'id' => $blog->id, 
                    'category_id' => get_cat_name($blog->category_id), 
                    'title' => $blog->title, 
                    'slug' => $blog->slug, 
                    'short_description' => $blog->short_description, 
                    'description' => $blog->description, 
                    'meta_title' => $blog->meta_title, 
                    'meta_keywords' => $blog->meta_keywords, 
                    'meta_description' => $blog->meta_description, 
                    'og_type' => $blog->og_type, 
                    'og_title' => $blog->og_title, 
                    'og_description' => $blog->og_description, 
                    'og_image' => $blog->og_image, 
                    'image' => $blog->image, 
                    'image_alt_text' => $blog->image_alt_text, 
                    'status' => $blog->status, 
                    'is_featured' => $blog->is_featured, 
                    'created_date' => $blog->created_date, 
                    'is_top_post' => $blog->is_top_post, 
                ];
                
            }

            $this->api_output['status'] = true;
 
        } else {
            $this->api_output['blogs'] = array();
            $this->api_output['status'] = false;

        }
        http_response_code(200);
            echo json_encode($this->api_output);
        exit;
    }

    function blog_detail($slug){
        $meta = $this->page->getMetaContent('blogs');
        $this->api_output['slug'] = $meta->slug;
        $this->api_output['meta_desc'] = json_decode($meta->content);
         $blog = $this->master->getRow('blogs', ['slug' => $slug]);
        $this->api_output['page_title'] = $blog->title . ' - ' . $this->data['site_settings']->site_name;
        //META
        $this->api_output['meta_desc'] = [
                'meta_title' => $blog->meta_title,
                'meta_description' => $blog->meta_description,
                'meta_keywords' => $blog->meta_keywords,
                'og_type' => $blog->og_type,
                'og_title' => $blog->og_title,
                'og_description' => $blog->og_description,
                'og_image' => $blog->og_image,
                'twitter_image' => $blog->og_image,
            ];

            $this->api_output['blog'] = [
                'id' => $blog->id, 
                    'category_id' => get_cat_name($blog->category_id), 
                    'title' => $blog->title, 
                    'slug' => $blog->slug, 
                    'short_description' => $blog->short_description, 
                    'description' => $blog->description, 
                    'meta_title' => $blog->meta_title, 
                    'meta_keywords' => $blog->meta_keywords, 
                    'meta_description' => $blog->meta_description, 
                    'og_type' => $blog->og_type, 
                    'og_title' => $blog->og_title, 
                    'og_description' => $blog->og_description, 
                    'og_image' => $blog->og_image, 
                    'image' => $blog->image, 
                    'image_alt_text' => $blog->image_alt_text, 
                    'status' => $blog->status, 
                    'is_featured' => $blog->is_featured, 
                    'created_date' => $blog->created_date, 
                    'is_top_post' => $blog->is_top_post,
            ];
            $this->api_output['top_posts'] = $this->master->getRows('blogs', ['status' => 1, 'is_top_post' => 1], '', '', 'desc', 'id');
            $this->api_output['cats']  = $this->master->getRows('blog_categories', ['status' => 1]);

        // $this->api_output['previous'] = $this->page->getPreviosNextRecord('blogs', $id, 'previous');
        // $this->api_output['next'] = $this->page->getPreviosNextRecord('blogs', $id, 'next');

        http_response_code(200);
        echo json_encode($this->api_output);
    }


    function get_sub_services()
    {

        if ($this->input->post()) {
            // pr($this->input->post());
            $post = $this->input->post();
            if (!empty($post['service_id'])) {
                $data = $this->master->getRows("sub_services", array('ser_id' => $post['service_id']));
                // pr($data);
                if (!empty($data)) {
                    $this->api_output['sub_services'] = $data;
                    $this->api_output['status'] = true;
                    // $this->api_output['msg'] = ''
                } else {
                    $this->api_output['status'] = false;
                    $this->api_output['msg'] = 'No Sub Services Found for this Service';
                }
            } else {
                // $this->api_output['status'] = false;
                $this->api_output['sub_services'] = '';
            }


            http_response_code(200);
            echo json_encode($this->api_output);
        } else {
            http_response_code(404);
        }
    }

    function get_mc_sub_services()
    {

        if ($this->input->post()) {
            // pr($this->input->post());
            $post = $this->input->post();
            if (!empty($post['purchase_id'])) {
                $row = $this->master->getRow("purchased_maint_covers", array('id' => intval($post['purchase_id'])));
                // pr($row);
                $data = $this->master->getRows("mc_sub_services", array('maintenance_cover_id' => intval($row->maintenance_cover_id)));
                
                if (!empty($data)) {
                    $this->api_output['sub_services'] = $data;
                    $this->api_output['status'] = true;
                    // $this->api_output['msg'] = ''
                } else {
                    $this->api_output['status'] = false;
                    $this->api_output['msg'] = 'No Sub Services Found for this Service';
                }
            } else {
                // $this->api_output['status'] = false;
                $this->api_output['sub_services'] = '';
            }


            http_response_code(200);
            echo json_encode($this->api_output);
        } else {
            http_response_code(404);
        }
    }

    function save_contact_message()
    {
        if ($this->input->post()) {
            $res = [];
            $res['status'] = 0;
            $res['validationErrors'] = '';
            $this->form_validation->set_rules('full_name', 'Full Name', 'trim|required|min_length[4]|max_length[30]', ['min_length' => 'Please enter full name.', 'max_length' => 'Name too long.']);
            $this->form_validation->set_rules('phone', 'Phone Number', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('msg', 'Message', 'trim|required|min_length[10]|max_length[1000]', ['min_length' => 'Please write a complete sentence of minimum 10 characters.', 'max_length' => '1000 character limit reached.']);
            if ($this->form_validation->run() === FALSE) {
                $res['validationErrors'] = validation_errors();
            } else {
                $post = html_escape($this->input->post());
                $is_added = $this->master->save('contact', $post);
                $name = $post['full_name'];
                $mem_data = [
                    'name' => $name,
                    "email" => $post['email'],
                    'msg' => trim($post['msg'])
                ];

                if ($is_added) {
                    // $this->send_query_successful($mem_data);
                    // $this->send_query_recieved_admin($mem_data);
                    $res['status'] = 1;
                    $res['msg'] = "Mesasage Sent Successfully!";
                } else {
                    $res['status'] = 0;
                    $res['msg'] = "Mesasage Not Sent!";
                }
            }
            echo json_encode($res);
            exit;
        }
    }

    function save_newsletter()
    {
        // pr("hi");
        $res = array();
        if ($this->input->post()) {
            $this->form_validation->set_rules(
                'email',
                'Email',
                'required|valid_email|is_unique[newsletter.email]',
                array(
                    'required'      => 'You have not provided %s.',
                    'is_unique'     => 'This %s already joined.'
                )
            );
            if ($this->form_validation->run() === FALSE) {
                $res['validation_error'] = validation_errors();
            } else {
                $vals = html_escape($this->input->post());
                $data = array(
                    'email' => $vals['email'],
                    'status' => 0
                );
                $id = $this->master->save("newsletter", $data);
                if ($id > 0) {
                    $res['msg'] = 'Subscribed successfully!';
                    $res['status'] = 1;
                } else {
                    $res['msg'] = 'Technical problem!';
                    $res['status'] = 0;
                }
            }
        }
        exit(json_encode($res));
    }


    function save_search()
    {
        // pr($this->session->session_id);
        if ($this->input->post()) {

            $res = [];
            $res['status'] = 0;
            $res['validationErrors'] = '';
            // $this->form_validation->set_rules('service_id', 'Service ', 'required');
            // $this->form_validation->set_rules('sub_service_id', 'Sub Service', 'required');
            // $this->form_validation->set_rules('state', 'State', 'required');
            // $this->form_validation->set_rules('latitude', 'Location Lat', 'required');
            // $this->form_validation->set_rules('longitude', 'Location Long', 'required');
            $this->form_validation->set_rules('work_scope', 'Work Scope', 'required');
            $this->form_validation->set_rules('budget', 'Your Budget', 'required');
            $this->form_validation->set_rules('job_start', 'Job Start', 'required');

            if ($this->form_validation->run() === FALSE) {
                $res['validationErrors'] = validation_errors();
            } else {
                $post = html_escape($this->input->post());
                // pr($_FILES);
                if (empty($post['token'])) {
                    $memData = null;
                    $this->data['memData'] = $memData;
                    $session_id = $this->session->session_id;
                } else {
                    $mem_id = $this->mem_id;
                    $memData = $this->member->getMemData($mem_id);
                    $this->data['memData'] = $memData;
                }

                $search_data = [
                    'service_id' => intval($post['service_id']),
                    'state' => $post['state'],
                    'latitude' => $post['latitude'],
                    'longitude' => $post['longitude'],
                    'sub_service_id' => intval($post['sub_service_id']),
                ];

                $save_data = [
                    'session_id' => $session_id ? $session_id : null,
                    'mem_id' => $mem_id ? $mem_id : null,
                    'work_scope' => $post['work_scope'],
                    'budget' => $post['budget'],
                    'job_start' => $post['job_start'],
                    'status' => 1,
                    'created_date' => date('Y-m-d h:i:s'),

                ];

                // pr($_FILES["doc_file"]['name']);

                if (isset($_FILES["doc_file"]["name"]) && $_FILES["doc_file"]["name"] != "") {
                    // pr(UPLOAD_PATH);
                    $doc_file = upload_file(UPLOAD_PATH . 'documents', 'doc_file', 'file');
                    // generate_thumb(UPLOAD_PATH.'members/',UPLOAD_PATH.'members/',$image['file_name'],100,'thumb_');
                    // pr($doc_file);
                    $save_data['doc_file'] = $doc_file['file_name'];
                }
                // pr($save_data);

                $work_scope_id = $this->master->save('work_scopes', $save_data);

                if ($work_scope_id > 0) {
                    $search_results = $this->member->search_member_data($post['service_id']);
                    // $this->send_query_successful($mem_data);
                    // $this->send_query_recieved_admin($mem_data);
                    $res['search_results'] = $search_results;
                    $res['search_data'] = $search_data;
                    $res['work_scope'] = doEncode($work_scope_id);
                    $res['status'] = 1;
                    $res['msg'] = "Search Success";
                } else {
                    $res['status'] = 0;
                    $res['msg'] = "Failed";
                }
            }
            echo json_encode($res);
            exit;
        }
    }

    function search_profession_page_for_review()
    {
        $post = $this->input->post();
        if (empty($post['token'])) {
            $memData = null;
        } else {
            // pr('hi');
            $mem_id = $this->mem_id;
            $memData = $this->member->getMemData($mem_id);
            $this->api_output['memData'] = $memData;
        }

        $final_data = array();
        
            $data = $this->member->getAllVerifiedProMemeber();
            // pr($data);
            foreach ($data as $mem) {
                $mem_profile = $this->master->getRow('professional_profile', array('mem_id' => $mem->mem_id));
                $sub_services = $this->master->getRows('selected_sub_services', array('mem_id' => $mem->mem_id, 'service_id' => $mem_profile->service_id));

                $selected_sub_ser = array();
                foreach ($sub_services as $sub) {
                    $selected_sub_ser[] = get_sub_service_title($sub->sub_service_id);
                }

                $final_data[] = [
                    'mem_id' => $mem->mem_id,
                    'mem_type' => $mem->mem_type,
                    'mem_fname' => $mem->mem_fname,
                    'mem_lname' => $mem->mem_lname,
                    'mem_display_name' => $mem->mem_display_name,
                    'mem_email' => $mem->mem_email,
                    'mem_phone' => $mem->mem_phone,
                    'mem_image' => $mem->mem_image,
                    'mem_address' => $mem->mem_address,
                    'mem_verified' => $mem->mem_verified,
                    'mem_status' => $mem->mem_status,
                    'mem_professionl_profile' => $mem->mem_professionl_profile,
                    'mem_specialization' => $mem->mem_specialization,
                    'mem_phone_verified' => $mem->mem_phone_verified,
                    'distance' => $mem->distance,
                    'service_title' => get_service_title($mem_profile->service_id),
                    'sub_services' => $selected_sub_ser,
                    'business_name' => $mem_profile->business_name,
                    'business_phone' => $mem_profile->business_phone,
                    'reviews_counts' => intval(get_count_pro_mem_reviews($mem->mem_id)),
                    'avg_rating' => floatval(get_count_pro_mem_avg_rating($mem->mem_id)),
                    'completed_projects' => intval($mem_profile->completed_projects),


                ];
            }
            $this->api_output['status'] = false;
            $this->api_output['professions'] = $final_data;
        

        $this->api_output['page_title'] = 'Professionals' . ' - ' . $this->data['site_settings']->site_name;

        $this->api_output['meta_desc'] = [
            'meta_title' => 'Professionals - ' . $this->data['site_settings']->site_name,
            'meta_description' => 'Professionals - ' . $this->data['site_settings']->site_name,
            'meta_keywords' => 'Professionals - ' . $this->data['site_settings']->site_name,
            'og_type' => 'website',
            'og_title' => 'Professionals - ' . $this->data['site_settings']->site_name,
            'og_description' => 'Professionals - ' . $this->data['site_settings']->site_name,
            'og_image' => '',
            'twitter_image' => '',
        ];

        http_response_code(200);
        echo json_encode($this->api_output);
        // } else {
        //     http_response_code(404);
        // }

    }

    function search_profession()
    {
        $post = $this->input->post();
       
        
        
        if (empty($post['token'])) {
            $memData = null;
        } else {
            // pr('hi');
            $mem_id = $this->mem_id;
            $memData = $this->member->getMemData($mem_id);
            $this->api_output['memData'] = $memData;
        }

        $final_data = array();
        if (!empty($post)) {

            $data = $this->member->search_pro_members($post);
            // pr($this->db->last_query());

            if (!empty($data)) {

                foreach ($data as $mem) {
                    $mem_profile = $this->master->getRow('professional_profile', array('mem_id' => $mem->mem_id));
                    $sub_services = $this->master->getRows('selected_sub_services', array('mem_id' => $mem->mem_id, 'service_id' => $mem_profile->service_id), '', '', 'ASC', 'sub_service_id',);

                    $selected_sub_ser = array();
                    foreach ($sub_services as $sub) {
                        $selected_sub_ser[] = get_sub_service_title($sub->sub_service_id);
                    }
                    $mem_reviews = $this->master->getRows('reviews', array('pro_mem_id' => $mem->mem_id));
                    
                    
                    
                    $final_data[] = [
                        'mem_id' => $mem->mem_id,
                        'mem_type' => $mem->mem_type,
                        'mem_fname' => $mem->mem_fname,
                        'mem_lname' => $mem->mem_lname,
                        'mem_display_name' => $mem->mem_display_name,
                        'mem_email' => $mem->mem_email,
                        'mem_phone' => $mem->mem_phone,
                        'mem_image' => $mem->mem_image,
                        'mem_address' => $mem->mem_address,
                        'mem_verified' => $mem->mem_verified,
                        'mem_status' => $mem->mem_status,
                        'mem_professionl_profile' => $mem->mem_professionl_profile,
                        'mem_specialization' => $mem->mem_specialization,
                        'mem_phone_verified' => $mem->mem_phone_verified,
                        'bussiness_phone_verified' => $mem_profile->phone_verified,
                        'distance' => $mem->distance,
                        'service_title' => get_service_title($mem_profile->service_id),
                        'sub_services' => $selected_sub_ser,
                        'business_name' => $mem_profile->business_name,
                        'business_phone' => $mem_profile->business_phone,
                        'reviews_counts' => intval(get_count_pro_mem_reviews($mem->mem_id)),
                    'avg_rating' => floatval(get_count_pro_mem_avg_rating($mem->mem_id)),
                    'completed_projects' => intval($mem_profile->completed_projects),


                    ];
                }
                if (!empty($post['service_id'])) {
                    $this->api_output['selected_service'] = $this->master->getRow('services', array('id' => $post['service_id']));;
                }

                if (!empty($post['sub_service_id'])) {
                    $this->api_output['selected_sub_service'] = $this->master->getRow('sub_services', array('id' => $post['sub_service_id']));;
                }

                $this->api_output['professions'] = $final_data;

                $this->api_output['status'] = true;
            } else {
                $this->api_output['status'] = false;
                $this->api_output['msg'] = 'No Professions Found';
                $this->api_output['professions'] = $final_data;
            }
        } else {
            $data = $this->member->getAllVerifiedProMemeber();
            // pr($data);
            foreach ($data as $mem) {
                $mem_profile = $this->master->getRow('professional_profile', array('mem_id' => $mem->mem_id));
                $sub_services = $this->master->getRows('selected_sub_services', array('mem_id' => $mem->mem_id, 'service_id' => $mem_profile->service_id));

                $selected_sub_ser = array();
                foreach ($sub_services as $sub) {
                    $selected_sub_ser[] = get_sub_service_title($sub->sub_service_id);
                }

                $final_data[] = [
                    'mem_id' => $mem->mem_id,
                    'mem_type' => $mem->mem_type,
                    'mem_fname' => $mem->mem_fname,
                    'mem_lname' => $mem->mem_lname,
                    'mem_display_name' => $mem->mem_display_name,
                    'mem_email' => $mem->mem_email,
                    'mem_phone' => $mem->mem_phone,
                    'mem_image' => $mem->mem_image,
                    'mem_address' => $mem->mem_address,
                    'mem_verified' => $mem->mem_verified,
                    'mem_status' => $mem->mem_status,
                    'mem_professionl_profile' => $mem->mem_professionl_profile,
                    'mem_specialization' => $mem_profile->specialization,
                    'mem_phone_verified' => $mem->mem_phone_verified,
                    'bussiness_phone_verified' => $mem_profile->phone_verified,
                    'distance' => $mem->distance,
                    'service_title' => get_service_title($mem_profile->service_id),
                    'sub_services' => $selected_sub_ser,
                    'business_name' => $mem_profile->business_name,
                    'business_phone' => $mem_profile->business_phone,
                    'reviews_counts' => intval(get_count_pro_mem_reviews($mem->mem_id)),
                    'avg_rating' => floatval(get_count_pro_mem_avg_rating($mem->mem_id)),
                    'completed_projects' => intval($mem_profile->completed_projects),

                ];
            }
            $this->api_output['status'] = false;
            $this->api_output['professions'] = $final_data;
        }

        $this->api_output['services'] = $this->master->getRows('services', array('status' => 1));

        $this->api_output['page_title'] = 'Search Results' . ' - ' . $this->data['site_settings']->site_name;

        $this->api_output['meta_desc'] = [
            'meta_title' => 'Search Results - ' . $this->data['site_settings']->site_name,
            'meta_description' => 'Search Results - ' . $this->data['site_settings']->site_name,
            'meta_keywords' => 'Search Results - ' . $this->data['site_settings']->site_name,
            'og_type' => 'website',
            'og_title' => 'Search Results - ' . $this->data['site_settings']->site_name,
            'og_description' => 'Search Results - ' . $this->data['site_settings']->site_name,
            'og_image' => '',
            'twitter_image' => '',
        ];

        http_response_code(200);
        echo json_encode($this->api_output);
        // } else {
        //     http_response_code(404);
        // }

    }

    function search_detail($pro_mem_id)
    {


        $pro_mem_id = intval($pro_mem_id);
        $post = $this->input->post();

        if (!empty($pro_mem_id) && !empty($pro_mem = $this->member->getMemData($pro_mem_id))) {
            if (!empty($post['token'])) {
                $mem_id = $this->mem_id;
                $memData = $this->member->getMemData($mem_id);
                $this->api_output['memData'] = $memData;
                $this->api_output['mem_wishlist'] = $this->master->getRow('wishlist', array('mem_id' => $mem_id, 'pro_mem_id' => $pro_mem_id, 'status' => 1));
            }
            $pro_profile = $this->master->getRow('professional_profile', array('mem_id' => $pro_mem_id));
            $this->api_output['pro_mem_profile'] = $pro_profile;
            
            $this->api_output['page_title'] = 'Profession Details' . ' - ' . $this->data['site_settings']->site_name;

            $this->api_output['pro_mem_service'] = get_service_title($pro_profile->service_id);

            $selected_sub_services = $this->master->getRows('selected_sub_services', ['mem_id' => $pro_mem_id, 'mem_profile_id' => $pro_profile->id]);

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
                        'mem_specialization' => $pro_profile->mem_specialization,
                        'mem_phone_verified' => $pro_mem->mem_phone_verified,
                        'bussiness_phone_verified' => $pro_profile->phone_verified,

                        'distance' => $pro_mem->distance,
                        'service_title' => get_service_title($pro_profile->service_id),
                        'sub_services' => $this->api_output['pro_mem_sub_services'],
                        'business_name' => $pro_profile->business_name,
                        'business_phone' => $pro_profile->business_phone,
                        'completed_projects' => intval($pro_profile->completed_projects),
                        
            ];
            $this->api_output['portfolio_images'] = $this->master->getRows('portfolio_images', array('mem_id' => $pro_mem_id));
            $this->api_output['meta_desc'] = [
                'meta_title' => 'Profession Detail - ' . $this->data['site_settings']->site_name,
                'meta_description' => 'Profession Detail - ' . $this->data['site_settings']->site_name,
                'meta_keywords' => 'Profession Detail - ' . $this->data['site_settings']->site_name,
                'og_type' => 'website',
                'og_title' => 'Profession Detail - ' . $this->data['site_settings']->site_name,
                'og_description' => 'Profession Detail - ' . $this->data['site_settings']->site_name,
                'og_image' => '',
                'twitter_image' => '',
            ];
            $this->api_output['reviews_counts'] = intval(get_count_pro_mem_reviews($pro_mem->mem_id));
            $this->api_output['avg_rating'] = floatval(get_count_pro_mem_avg_rating($pro_mem->mem_id));

            $this->api_output['avg_reliability_timekeeping'] = floatval(get_count_pro_mem_avg_reliability_timekeeping($pro_mem->mem_id));
            $this->api_output['avg_quality_workmanship'] = floatval(get_count_pro_mem_avg_quality_workmanship($pro_mem->mem_id));
            $this->api_output['avg_tidiness'] = floatval(get_count_pro_mem_avg_tidiness($pro_mem->mem_id));
            $this->api_output['avg_courtesy'] = floatval(get_count_pro_mem_avg_courtesy($pro_mem->mem_id));

            $this->api_output['pro_wishlisted'] = !empty($this->api_output['mem_wishlist']) ? true : false;



            $user_reviews = $this->master->getRows('reviews', array('pro_mem_id' => $pro_mem->mem_id));
            // pr($user_reviews);
            $this->api_output['reviews'] = array();

            foreach($user_reviews as $rev){
                $this->api_output['reviews'][] = [
                    'id' => $rev->id, 
                    'review_from_mem_id' => $rev->review_from_mem_id, 
                    'review_from_mem_name' => get_mem_name($rev->review_from_mem_id), 
                    'review_from_mem_image' => get_mem_image($rev->review_from_mem_id), 
                    'pro_mem_id' => $rev->pro_mem_id, 
                    'reliability_timekeeping' => $rev->reliability_timekeeping, 
                    'quality_workmanship' => $rev->quality_workmanship, 
                    'tidiness' => $rev->tidiness, 
                    'courtesy' => $rev->courtesy, 
                    'workscope' => $rev->workscope, 
                    'rating' => $rev->rating, 
                    'review' => $rev->review, 
                    'recomended' => $rev->recomended, 
                    'status' => $rev->status, 
                    'created_date' => $rev->created_date, 
                ];
            }

            http_response_code(200);
            echo json_encode($this->api_output);
        } else {
            http_response_code(404);
        }
    }

    function search_services()
    {

        if ($this->input->post()) {
            $post = $this->input->post();
            if (!empty($post['search'])) {
                $data = $this->master->fetch_rows("SELECT * FROM `tbl_services` WHERE `title` LIKE '" . $post['search'] . "%'");
                if (!empty($data)) {
                    $this->api_output['services'] = $data;
                    $this->api_output['status'] = true;
                    // $this->api_output['msg'] = ''
                } else {
                    $this->api_output['status'] = false;
                    $this->api_output['msg'] = 'No Comapny Found with this Name';
                }
            } else {
                // $this->api_output['status'] = false;
                $this->api_output['services'] = $this->master->getRows('services', ['status' => 1], '', '', 'ASC', 'id');
            }


            http_response_code(200);
            echo json_encode($this->api_output);
        } else {
            http_response_code(404);
        }
    }

    function work_scope($work_scope_id)
    {

        $workscope = $this->master->getRow('work_scopes', array('id' => $work_scope_id));

        if (!empty($work_scope_id) && !empty($workscope)) {
            $meta = $this->page->getMetaContent('workscope');
            $this->api_output['page_title'] = 'WorkScope' . ' - ' . $this->data['site_settings']->site_name;
            $this->api_output['slug'] = $meta->slug;
            $data = $this->page->getPageContent('workscope');
            $this->api_output['work_scope'] = $workscope;

            $this->api_output['meta_desc'] = [
                'meta_title' => 'WorkScope - ' . $this->data['site_settings']->site_name,
                'meta_description' => 'WorkScope - ' . $this->data['site_settings']->site_name,
                'meta_keywords' => 'WorkScope - ' . $this->data['site_settings']->site_name,
                'og_type' => 'website',
                'og_title' => 'WorkScope - ' . $this->data['site_settings']->site_name,
                'og_description' => 'WorkScope - ' . $this->data['site_settings']->site_name,
                'og_image' => '',
                'twitter_image' => '',
            ];
            $this->api_output['content'] = $content = unserialize($data->code);


            http_response_code(200);
            echo json_encode($this->api_output);
        } else {
            http_response_code(404);
        }
    }

    function upload_file()
    {
        if ($this->input->post()) {
            $res = [];
            $res['status'] = 0;
            $res['validationErrors'] = '';
            
                $post = html_escape($this->input->post());
                $mem_id = $this->mem_id;
                
                if (isset($_FILES["file"]["name"]) && $_FILES["file"]["name"] != "") {
                    // pr($_FILES["file"]["name"]);
                    $file = upload_file(UPLOAD_PATH . 'msg_attachments', 'file');
                    // pr($file);
                    if(!empty($file['file_name'])){
                        $res['status'] = 1;
                        $res['file_name_text'] = $_FILES["file"]["name"];
                        $res['file'] = $file['file_name'];
                    }else{
                        $res['status'] = 0;
                        $res['msg'] = "File Upload Failed";
                    }
                    
                }

            echo json_encode($res);
            exit;
        }
    }

    function check_twilio(){
        $post = $this->input->post();
        $this->load->library('twilio_lib');


        $sendVerification = $this->twilio_lib->sendVerificationCode($post['phone']);
        pr($sendVerification);
    }

    function check_twilio_verify_code(){
        $post = $this->input->post();
        $this->load->library('twilio_lib');


        $verificationResult = $this->twilio_lib->verifyCode($post['email'], $post['code']);
        pr($verificationResult);
    }
}
