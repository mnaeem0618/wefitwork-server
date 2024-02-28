<?php
class Sitecontent extends Admin_Controller
{
    public function __construct(){
        parent::__construct();
        $this->isLogged();
        has_access(21);
        $this->table_name = 'sitecontent';
        $this->load->model('page_model');
    }

    public function home(){
        $check = $this->page_model->num_rows(array('ckey' => $this->uri->segment(3)));
        if (!$check) {
            $this->page_model->save(array('ckey' => $this->uri->segment(3)));
            $check_meta = $this->master->num_rows('meta_info', array('slug' => $this->uri->segment(3)));
            // pr($check_meta);
            if($check_meta  == 0){
                $this->master->save('meta_info', ['slug' => $this->uri->segment(3), 'page_name' => $this->uri->segment(3)]);
            }
        }
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = ADMIN . '/site_home';
        
        if ($vals = $this->input->post()) {
            
            $content_row = $this->master->getRow($this->table_name, array('ckey' => $this->uri->segment(3)));

            if ($content_row && $content_row->code !== null) {
                $content_row = unserialize($content_row->code);
            } else {
                $content_row = array();
            }

           
            if (!is_array($content_row))
                $content_row = array();

            for ($i = 1; $i <= 7; $i++) {
                if (isset($_FILES["image" . $i]["name"]) && $_FILES["image" . $i]["name"] != "") {

                    $image = upload_file(UPLOAD_PATH . 'images/', 'image' . $i);

                    // if ($i === 1 || $i === 2 || $i === 3) {
                    //     generate_thumb(UPLOAD_PATH . 'images/', UPLOAD_PATH . 'images/', $image['file_name'], 100, 'thumb_');
                       
                    // }else{
                    //     generate_thumb(UPLOAD_PATH . 'images/', UPLOAD_PATH . 'images/', $image['file_name'], 650, 'thumb_');

                    // }

                    if (!empty($image['file_name'])) {
                        if (isset($content_row['image' . $i])) {
                            
                                $this->remove_file(UPLOAD_PATH . "images/" . $content_row['image' . $i]);
                                $this->remove_file(UPLOAD_PATH . "images/thumb_" . $content_row['image' . $i]);
                            
                        }
                        $vals['image' . $i] = $image['file_name'];
                    }
                }
            }
            // pr($_FILES);
            $bannerPhto['pics'] = $vals['banner_pics'];
            unset($vals['banner_pics']);
            $this->master->delete('banner_images', 'section', 'home-banner');
            saveBannerImgs('./uploads/images/', $_FILES['banner_image'], 'banner_image', 'home-banner', $bannerPhto['pics'], 850);

            $data = serialize(array_merge($content_row, $vals));
            $this->master->save($this->table_name, array('code' => $data), 'ckey', $this->uri->segment(3));
            setMsg('success', 'Settings updated successfully !');
            redirect(ADMIN . "/sitecontent/".$this->uri->segment(3));
            exit;
        }

        $this->data['row'] = $this->master->getRow($this->table_name, array('ckey' => $this->uri->segment(3)));
        

        if ($this->data['row'] && isset($this->data['row']->code) && $this->data['row']->code !== null) {
            $this->data['row'] = unserialize($this->data['row']->code);
        } else {
            $this->data['row'] = array(); // or handle it in a way that makes sense for your application
        }


        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    public function dummy_test(){
        $check = $this->page_model->num_rows(array('ckey' => $this->uri->segment(3)));
        if (!$check) {
            $this->page_model->save(array('ckey' => $this->uri->segment(3)));
            $check_meta = $this->master->num_rows('meta_info', array('slug' => $this->uri->segment(3)));
            // pr($check_meta);
            if($check_meta  == 0){
                $this->master->save('meta_info', ['slug' => $this->uri->segment(3), 'page_name' => $this->uri->segment(3)]);
            }
        }
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = ADMIN . '/site_dummy_test';
        
        if ($vals = $this->input->post()) {
            
            $content_row = $this->master->getRow($this->table_name, array('ckey' => $this->uri->segment(3)));
            if ($content_row && $content_row->code !== null) {
                $content_row = unserialize($content_row->code);
            } else {
                $content_row = array();
            }
           
            if (!is_array($content_row))
                $content_row = array();

            for ($i = 1; $i <= 7; $i++) {
                if (isset($_FILES["image" . $i]["name"]) && $_FILES["image" . $i]["name"] != "") {

                    $image = upload_file(UPLOAD_PATH . 'images/', 'image' . $i);

                    // if ($i === 1 || $i === 2 || $i === 3) {
                    //     generate_thumb(UPLOAD_PATH . 'images/', UPLOAD_PATH . 'images/', $image['file_name'], 100, 'thumb_');
                       
                    // }else{
                    //     generate_thumb(UPLOAD_PATH . 'images/', UPLOAD_PATH . 'images/', $image['file_name'], 650, 'thumb_');

                    // }

                    if (!empty($image['file_name'])) {
                        if (isset($content_row['image' . $i])) {
                            
                                $this->remove_file(UPLOAD_PATH . "images/" . $content_row['image' . $i]);
                                $this->remove_file(UPLOAD_PATH . "images/thumb_" . $content_row['image' . $i]);
                            
                        }
                        $vals['image' . $i] = $image['file_name'];
                    }
                }
            }
            // pr($_FILES);
            

            $data = serialize(array_merge($content_row, $vals));
            $this->master->save($this->table_name, array('code' => $data), 'ckey', $this->uri->segment(3));
            setMsg('success', 'Settings updated successfully !');
            redirect(ADMIN . "/sitecontent/".$this->uri->segment(3));
            exit;
        }

        $this->data['row'] = $this->master->getRow($this->table_name, array('ckey' => $this->uri->segment(3)));
        if ($this->data['row'] && isset($this->data['row']->code) && $this->data['row']->code !== null) {
            $this->data['row'] = unserialize($this->data['row']->code);
        } else {
            $this->data['row'] = array(); // or handle it in a way that makes sense for your application
        }
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    public function about(){
        $check = $this->page_model->num_rows(array('ckey' => $this->uri->segment(3)));
        if (!$check) {
            $this->page_model->save(array('ckey' => $this->uri->segment(3)));
            $check_meta = $this->master->num_rows('meta_info', array('slug' => $this->uri->segment(3)));
            // pr($check_meta);
            if($check_meta  == 0){
                $this->master->save('meta_info', ['slug' => $this->uri->segment(3), 'page_name' => $this->uri->segment(3)]);
            }
        }
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = ADMIN . '/site_about';
        
        if ($vals = $this->input->post()) {
            
            $content_row = $this->master->getRow($this->table_name, array('ckey' => $this->uri->segment(3)));
            if ($content_row && $content_row->code !== null) {
                $content_row = unserialize($content_row->code);
            } else {
                $content_row = array();
            }
           
            if (!is_array($content_row))
                $content_row = array();

            for ($i = 1; $i <= 6; $i++) {
                if (isset($_FILES["image" . $i]["name"]) && $_FILES["image" . $i]["name"] != "") {

                    $image = upload_file(UPLOAD_PATH . 'images/', 'image' . $i);

                    // if ($i === 2 || $i === 3 || $i === 4) {
                    //     generate_thumb(UPLOAD_PATH . 'images/', UPLOAD_PATH . 'images/', $image['file_name'], 100, 'thumb_');
                       
                    // }else{
                    //     generate_thumb(UPLOAD_PATH . 'images/', UPLOAD_PATH . 'images/', $image['file_name'], 850, 'thumb_');

                    // }

                    if (!empty($image['file_name'])) {
                        if (isset($content_row['image' . $i])) {
                            
                                $this->remove_file(UPLOAD_PATH . "images/" . $content_row['image' . $i]);
                                $this->remove_file(UPLOAD_PATH . "images/thumb_" . $content_row['image' . $i]);
                            
                        }
                        $vals['image' . $i] = $image['file_name'];
                    }
                }
            }
            // pr($_FILES);
        
            $data = serialize(array_merge($content_row, $vals));
            $this->master->save($this->table_name, array('code' => $data), 'ckey', $this->uri->segment(3));
            setMsg('success', 'Settings updated successfully !');
            redirect(ADMIN . "/sitecontent/".$this->uri->segment(3));
            exit;
        }

        $this->data['row'] = $this->master->getRow($this->table_name, array('ckey' => $this->uri->segment(3)));
        if ($this->data['row'] && isset($this->data['row']->code) && $this->data['row']->code !== null) {
            $this->data['row'] = unserialize($this->data['row']->code);
        } else {
            $this->data['row'] = array(); // or handle it in a way that makes sense for your application
        }
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    public function blogs(){
        $check = $this->page_model->num_rows(array('ckey' => $this->uri->segment(3)));
        if (!$check) {
            $this->page_model->save(array('ckey' => $this->uri->segment(3)));
            $check_meta = $this->master->num_rows('meta_info', array('slug' => $this->uri->segment(3)));
            // pr($check_meta);
            if($check_meta  == 0){
                $this->master->save('meta_info', ['slug' => $this->uri->segment(3), 'page_name' => $this->uri->segment(3)]);
            }
        }

        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = ADMIN . '/site_blogs';
        if ($vals = $this->input->post()) {
            $content_row = $this->master->getRow($this->table_name, array('ckey' => $this->uri->segment(3)));
            if ($content_row && $content_row->code !== null) {
                $content_row = unserialize($content_row->code);
            } else {
                $content_row = array();
            }

            if (!is_array($content_row))
                $content_row = array();

                
            $data = serialize(array_merge($content_row, $vals));
            $this->master->save($this->table_name, array('code' => $data), 'ckey', $this->uri->segment(3));
            setMsg('success', 'Settings updated successfully !');
            redirect(ADMIN . "/sitecontent/".$this->uri->segment(3));
            exit;
        }

        $this->data['row'] = $this->master->getRow($this->table_name, array('ckey' => $this->uri->segment(3)));
        if ($this->data['row'] && isset($this->data['row']->code) && $this->data['row']->code !== null) {
            $this->data['row'] = unserialize($this->data['row']->code);
        } else {
            $this->data['row'] = array(); // or handle it in a way that makes sense for your application
        }
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    public function contact_us(){
        $check = $this->page_model->num_rows(array('ckey' => $this->uri->segment(3)));
        if (!$check) {
            $this->page_model->save(array('ckey' => $this->uri->segment(3)));
            $check_meta = $this->master->num_rows('meta_info', array('slug' => $this->uri->segment(3)));
            // pr($check_meta);
            if($check_meta  == 0){
                $this->master->save('meta_info', ['slug' => $this->uri->segment(3), 'page_name' => $this->uri->segment(3)]);
            }
        }

        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = ADMIN . '/site_contact_us';
        if ($vals = $this->input->post()) {
            $content_row = $this->master->getRow($this->table_name, array('ckey' => $this->uri->segment(3)));
            if ($content_row && $content_row->code !== null) {
                $content_row = unserialize($content_row->code);
            } else {
                $content_row = array();
            }

            if (!is_array($content_row))
                $content_row = array();

                
            $data = serialize(array_merge($content_row, $vals));
            $this->master->save($this->table_name, array('code' => $data), 'ckey', $this->uri->segment(3));
            setMsg('success', 'Settings updated successfully !');
            redirect(ADMIN . "/sitecontent/".$this->uri->segment(3));
            exit;
        }

        $this->data['row'] = $this->master->getRow($this->table_name, array('ckey' => $this->uri->segment(3)));
        if ($this->data['row'] && isset($this->data['row']->code) && $this->data['row']->code !== null) {
            $this->data['row'] = unserialize($this->data['row']->code);
        } else {
            $this->data['row'] = array(); // or handle it in a way that makes sense for your application
        }
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    public function checkout_page(){
        $check = $this->page_model->num_rows(array('ckey' => $this->uri->segment(3)));
        if (!$check) {
            $this->page_model->save(array('ckey' => $this->uri->segment(3)));
            $check_meta = $this->master->num_rows('meta_info', array('slug' => $this->uri->segment(3)));
            // pr($check_meta);
            if($check_meta  == 0){
                $this->master->save('meta_info', ['slug' => $this->uri->segment(3), 'page_name' => $this->uri->segment(3)]);
            }
        }

        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = ADMIN . '/site_checkout_page';
        if ($vals = $this->input->post()) {
            $content_row = $this->master->getRow($this->table_name, array('ckey' => $this->uri->segment(3)));
            if ($content_row && $content_row->code !== null) {
                $content_row = unserialize($content_row->code);
            } else {
                $content_row = array();
            }

            if (!is_array($content_row))
                $content_row = array();

                
            $data = serialize(array_merge($content_row, $vals));
            $this->master->save($this->table_name, array('code' => $data), 'ckey', $this->uri->segment(3));
            setMsg('success', 'Settings updated successfully !');
            redirect(ADMIN . "/sitecontent/".$this->uri->segment(3));
            exit;
        }

        $this->data['row'] = $this->master->getRow($this->table_name, array('ckey' => $this->uri->segment(3)));
        if ($this->data['row'] && isset($this->data['row']->code) && $this->data['row']->code !== null) {
            $this->data['row'] = unserialize($this->data['row']->code);
        } else {
            $this->data['row'] = array(); // or handle it in a way that makes sense for your application
        }
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }


    public function become_pro(){
        $check = $this->page_model->num_rows(array('ckey' => $this->uri->segment(3)));
        if (!$check) {
            $this->page_model->save(array('ckey' => $this->uri->segment(3)));
            $check_meta = $this->master->num_rows('meta_info', array('slug' => $this->uri->segment(3)));
            // pr($check_meta);
            if($check_meta  == 0){
                $this->master->save('meta_info', ['slug' => $this->uri->segment(3), 'page_name' => $this->uri->segment(3)]);
            }
        }
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = ADMIN . '/site_become_pro';
        
        if ($vals = $this->input->post()) {
            
            $content_row = $this->master->getRow($this->table_name, array('ckey' => $this->uri->segment(3)));
            if ($content_row && $content_row->code !== null) {
                $content_row = unserialize($content_row->code);
            } else {
                $content_row = array();
            }
           
            if (!is_array($content_row))
                $content_row = array();

            for ($i = 1; $i <= 4; $i++) {
                if (isset($_FILES["image" . $i]["name"]) && $_FILES["image" . $i]["name"] != "") {

                    $image = upload_file(UPLOAD_PATH . 'images/', 'image' . $i);

                    // if ($i === 1) {
                    //     generate_thumb(UPLOAD_PATH . 'images/', UPLOAD_PATH . 'images/', $image['file_name'], 1920, 'thumb_');
                       
                    // }else{
                    //     generate_thumb(UPLOAD_PATH . 'images/', UPLOAD_PATH . 'images/', $image['file_name'], 850, 'thumb_');

                    // }

                    if (!empty($image['file_name'])) {
                        if (isset($content_row['image' . $i])) {
                            
                                $this->remove_file(UPLOAD_PATH . "images/" . $content_row['image' . $i]);
                                $this->remove_file(UPLOAD_PATH . "images/thumb_" . $content_row['image' . $i]);
                            
                        }
                        $vals['image' . $i] = $image['file_name'];
                    }
                }
            }
            // pr($_FILES);

            $sec3['title'] = $vals['sec3_title'];
            $sec3['txt1'] = $vals['sec3_txt1'];
            $sec3['order_no'] = $vals['sec3_order_no'];
            $sec3Phto['pics'] = $vals['sec3_pics'];
            unset($vals['sec3_pics'],$vals['sec3_order_no'],$vals['sec3_title'],$vals['sec3_txt1']);
            $this->master->delete_where('multi_text', array('section'=> 'about-sec3'));
            $sec3s = array('order_no' => $sec3['order_no'],'title' => $sec3['title'], 'txt1' => $sec3['txt1']);
            saveMultiMediaFieldsImgs('./uploads/images/', $_FILES['sec3_image'], 'sec3_image', 'about-sec3', $sec3Phto['pics'], $sec3s, 'eng',120);
            
        
            $data = serialize(array_merge($content_row, $vals));
            $this->master->save($this->table_name, array('code' => $data), 'ckey', $this->uri->segment(3));
            setMsg('success', 'Settings updated successfully !');
            redirect(ADMIN . "/sitecontent/".$this->uri->segment(3));
            exit;
        }

        $this->data['row'] = $this->master->getRow($this->table_name, array('ckey' => $this->uri->segment(3)));
        if ($this->data['row'] && isset($this->data['row']->code) && $this->data['row']->code !== null) {
            $this->data['row'] = unserialize($this->data['row']->code);
        } else {
            $this->data['row'] = array(); // or handle it in a way that makes sense for your application
        }
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    public function maintenance_cover(){
        $check = $this->page_model->num_rows(array('ckey' => $this->uri->segment(3)));
        if (!$check) {
            $this->page_model->save(array('ckey' => $this->uri->segment(3)));
            $check_meta = $this->master->num_rows('meta_info', array('slug' => $this->uri->segment(3)));
            // pr($check_meta);
            if($check_meta  == 0){
                $this->master->save('meta_info', ['slug' => $this->uri->segment(3), 'page_name' => $this->uri->segment(3)]);
            }
        }
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = ADMIN . '/site_maintenance_cover';
        
        if ($vals = $this->input->post()) {
            
            $content_row = $this->master->getRow($this->table_name, array('ckey' => $this->uri->segment(3)));
            if ($content_row && $content_row->code !== null) {
                $content_row = unserialize($content_row->code);
            } else {
                $content_row = array();
            }
           
            if (!is_array($content_row))
                $content_row = array();

            for ($i = 1; $i <= 6; $i++) {
                if (isset($_FILES["image" . $i]["name"]) && $_FILES["image" . $i]["name"] != "") {

                    $image = upload_file(UPLOAD_PATH . 'images/', 'image' . $i);

                    // if ($i === 1) {
                    //     generate_thumb(UPLOAD_PATH . 'images/', UPLOAD_PATH . 'images/', $image['file_name'], 1920, 'thumb_');
                       
                    // }else{
                    //     generate_thumb(UPLOAD_PATH . 'images/', UPLOAD_PATH . 'images/', $image['file_name'], 850, 'thumb_');

                    // }

                    if (!empty($image['file_name'])) {
                        if (isset($content_row['image' . $i])) {
                            
                                $this->remove_file(UPLOAD_PATH . "images/" . $content_row['image' . $i]);
                                $this->remove_file(UPLOAD_PATH . "images/thumb_" . $content_row['image' . $i]);
                            
                        }
                        $vals['image' . $i] = $image['file_name'];
                    }
                }
            }
            // pr($_FILES);

            $sec4['title'] = $vals['sec4_title'];
            $sec4['txt1'] = $vals['sec4_txt1'];
            $sec4['order_no'] = $vals['sec4_order_no'];
            $sec4Phto['pics'] = $vals['sec4_pics'];
            unset($vals['sec4_pics'],$vals['sec4_order_no'],$vals['sec4_title'],$vals['sec4_txt1']);
            $this->master->delete_where('multi_text', array('section'=> 'maintenance-cover-sec4'));
            $sec4s = array('order_no' => $sec4['order_no'],'title' => $sec4['title'], 'txt1' => $sec4['txt1']);
            saveMultiMediaFieldsImgs('./uploads/images/', $_FILES['sec4_image'], 'sec4_image', 'maintenance-cover-sec4', $sec4Phto['pics'], $sec4s, 'eng',120);
            
        
            $data = serialize(array_merge($content_row, $vals));
            $this->master->save($this->table_name, array('code' => $data), 'ckey', $this->uri->segment(3));
            setMsg('success', 'Settings updated successfully !');
            redirect(ADMIN . "/sitecontent/".$this->uri->segment(3));
            exit;
        }

        $this->data['row'] = $this->master->getRow($this->table_name, array('ckey' => $this->uri->segment(3)));
        if ($this->data['row'] && isset($this->data['row']->code) && $this->data['row']->code !== null) {
            $this->data['row'] = unserialize($this->data['row']->code);
        } else {
            $this->data['row'] = array(); // or handle it in a way that makes sense for your application
        }
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }


    public function help(){
        $check = $this->page_model->num_rows(array('ckey' => $this->uri->segment(3)));
        if (!$check) {
            $this->page_model->save(array('ckey' => $this->uri->segment(3)));
            $check_meta = $this->master->num_rows('meta_info', array('slug' => $this->uri->segment(3)));
            // pr($check_meta);
            if($check_meta  == 0){
                $this->master->save('meta_info', ['slug' => $this->uri->segment(3), 'page_name' => $this->uri->segment(3)]);
            }
        }
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = ADMIN . '/site_help';
        
        if ($vals = $this->input->post()) {
            
            $content_row = $this->master->getRow($this->table_name, array('ckey' => $this->uri->segment(3)));
            if ($content_row && $content_row->code !== null) {
                $content_row = unserialize($content_row->code);
            } else {
                $content_row = array();
            }
           
            if (!is_array($content_row))
                $content_row = array();
                   
            $data = serialize(array_merge($content_row, $vals));
            $this->master->save($this->table_name, array('code' => $data), 'ckey', $this->uri->segment(3));
            setMsg('success', 'Settings updated successfully !');
            redirect(ADMIN . "/sitecontent/".$this->uri->segment(3));
            exit;
        }

        $this->data['row'] = $this->master->getRow($this->table_name, array('ckey' => $this->uri->segment(3)));
        if ($this->data['row'] && isset($this->data['row']->code) && $this->data['row']->code !== null) {
            $this->data['row'] = unserialize($this->data['row']->code);
        } else {
            $this->data['row'] = array(); // or handle it in a way that makes sense for your application
        }
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }


    public function signup(){
        $check = $this->page_model->num_rows(array('ckey' => $this->uri->segment(3)));
        if (!$check) {
            $this->page_model->save(array('ckey' => $this->uri->segment(3)));
            $check_meta = $this->master->num_rows('meta_info', array('slug' => $this->uri->segment(3)));
            // pr($check_meta);
            if($check_meta  == 0){
                $this->master->save('meta_info', ['slug' => $this->uri->segment(3), 'page_name' => $this->uri->segment(3)]);
                
            }
        }
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = ADMIN . '/site_signup';
        if ($vals = $this->input->post()) {
            for ($i = 1; $i <= 1; $i++) {
                if (isset($_FILES["image" . $i]["name"]) && $_FILES["image" . $i]["name"] != "") {

                    $image = upload_file(UPLOAD_PATH . 'images/', 'image' . $i);
                    if (!empty($image['file_name'])) {
                        if (isset($content_row['image' . $i])) {
                            if ($i === 1) {
                                $this->remove_file(UPLOAD_PATH . "images/" . $content_row['image' . $i]);
                            }
                        }
                        $vals['image' . $i] = $image['file_name'];
                    }
                }
            }
            $content_row = $this->master->getRow($this->table_name, array('ckey' => $this->uri->segment(3)));
            if ($content_row && $content_row->code !== null) {
                $content_row = unserialize($content_row->code);
            } else {
                $content_row = array();
            }

            if (!is_array($content_row))
                $content_row = array();


            $data = serialize(array_merge($content_row, $vals));
            $this->master->save($this->table_name, array('code' => $data), 'ckey', $this->uri->segment(3));
            setMsg('success', 'Settings updated successfully !');
            redirect(ADMIN . "/sitecontent/".$this->uri->segment(3));
            exit;
        }

        $this->data['row'] = $this->master->getRow($this->table_name, array('ckey' => $this->uri->segment(3)));
        if ($this->data['row'] && isset($this->data['row']->code) && $this->data['row']->code !== null) {
            $this->data['row'] = unserialize($this->data['row']->code);
        } else {
            $this->data['row'] = array(); // or handle it in a way that makes sense for your application
        }
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    public function pro_signup(){
        $check = $this->page_model->num_rows(array('ckey' => $this->uri->segment(3)));
        if (!$check) {
            $this->page_model->save(array('ckey' => $this->uri->segment(3)));
            $check_meta = $this->master->num_rows('meta_info', array('slug' => $this->uri->segment(3)));
            // pr($check_meta);
            if($check_meta  == 0){
                $this->master->save('meta_info', ['slug' => $this->uri->segment(3), 'page_name' => $this->uri->segment(3)]);
                
            }
        }
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = ADMIN . '/site_pro_signup';
        if ($vals = $this->input->post()) {
            for ($i = 1; $i <= 2; $i++) {
                if (isset($_FILES["image" . $i]["name"]) && $_FILES["image" . $i]["name"] != "") {

                    $image = upload_file(UPLOAD_PATH . 'images/', 'image' . $i);
                    if (!empty($image['file_name'])) {
                        if (isset($content_row['image' . $i])) {
                            if ($i === 1) {
                                $this->remove_file(UPLOAD_PATH . "images/" . $content_row['image' . $i]);
                            }
                        }
                        $vals['image' . $i] = $image['file_name'];
                    }
                }
            }
            $content_row = $this->master->getRow($this->table_name, array('ckey' => $this->uri->segment(3)));
            if ($content_row && $content_row->code !== null) {
                $content_row = unserialize($content_row->code);
            } else {
                $content_row = array();
            }

            if (!is_array($content_row))
                $content_row = array();


            $data = serialize(array_merge($content_row, $vals));
            $this->master->save($this->table_name, array('code' => $data), 'ckey', $this->uri->segment(3));
            setMsg('success', 'Settings updated successfully !');
            redirect(ADMIN . "/sitecontent/".$this->uri->segment(3));
            exit;
        }

        $this->data['row'] = $this->master->getRow($this->table_name, array('ckey' => $this->uri->segment(3)));
        if ($this->data['row'] && isset($this->data['row']->code) && $this->data['row']->code !== null) {
            $this->data['row'] = unserialize($this->data['row']->code);
        } else {
            $this->data['row'] = array(); // or handle it in a way that makes sense for your application
        }
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }
    
    public function login()
    {
        $check = $this->page_model->num_rows(array('ckey' => $this->uri->segment(3)));
        // pr($this->db->last_query());
        if (!$check) {
            $this->page_model->save(array('ckey' => $this->uri->segment(3)));

            $check_meta = $this->master->num_rows('meta_info', array('slug' => $this->uri->segment(3)));
            // pr($check_meta);
            if($check_meta  == 0){
                $this->master->save('meta_info', ['slug' => $this->uri->segment(3), 'page_name' => $this->uri->segment(3)]);

                // pr($this->db->last_query());
            }
        }
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = ADMIN . '/site_signin';
        if ($vals = $this->input->post()) {
            $content_row = $this->master->getRow($this->table_name, array('ckey' => $this->uri->segment(3)));
            if ($content_row && $content_row->code !== null) {
                $content_row = unserialize($content_row->code);
            } else {
                $content_row = array();
            }

            if (!is_array($content_row))
                $content_row = array();

            for ($i = 1; $i <= 2; $i++) {
                if (isset($_FILES["image" . $i]["name"]) && $_FILES["image" . $i]["name"] != "") {

                    $image = upload_file(UPLOAD_PATH . 'images/', 'image' . $i);

                    // if($i === 1)
                    // {
                    //     generate_thumb(UPLOAD_PATH.'images/',UPLOAD_PATH.'images/',$image['file_name'],300,'thumb_');
                    //     generate_thumb(UPLOAD_PATH.'images/',UPLOAD_PATH.'images/',$image['file_name'],500,'500p_');
                    //     generate_thumb(UPLOAD_PATH.'images/',UPLOAD_PATH.'images/',$image['file_name'],800,'800p_');
                    // }

                    if (!empty($image['file_name'])) {
                        if (isset($content_row['image' . $i])) {
                            if ($i === 1 || $i === 2) {
                                $this->remove_file(UPLOAD_PATH . "images/" . $content_row['image' . $i]);
                                // $this->remove_file(UPLOAD_PATH."images/thumb_".$content_row['image'.$i]);
                                // $this->remove_file(UPLOAD_PATH."images/500p_".$content_row['image'.$i]);
                                // $this->remove_file(UPLOAD_PATH."images/800p_".$content_row['image'.$i]);
                            }
                        }
                        $vals['image' . $i] = $image['file_name'];
                    }
                }
            }

            $data = serialize(array_merge($content_row, $vals));
            $this->master->save($this->table_name, array('code' => $data), 'ckey', $this->uri->segment(3));
            setMsg('success', 'Settings updated successfully !');
            redirect(ADMIN . "/sitecontent/".$this->uri->segment(3));
            exit;
        }

        $this->data['row'] = $this->master->getRow($this->table_name, array('ckey' => $this->uri->segment(3)));
        if ($this->data['row'] && isset($this->data['row']->code) && $this->data['row']->code !== null) {
            $this->data['row'] = unserialize($this->data['row']->code);
        } else {
            $this->data['row'] = array(); // or handle it in a way that makes sense for your application
        }
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    public function forgot_password(){

        $check = $this->page_model->num_rows(array('ckey' => $this->uri->segment(3)));
        // pr($this->db->last_query());
        if (!$check) {
            $this->page_model->save(array('ckey' => $this->uri->segment(3)));

            $check_meta = $this->master->num_rows('meta_info', array('slug' => $this->uri->segment(3)));
            // pr($check_meta);
            if($check_meta  == 0){
                $this->master->save('meta_info', ['slug' => $this->uri->segment(3), 'page_name' => $this->uri->segment(3)]);

                // pr($this->db->last_query());
            }
        }

        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = ADMIN . '/site_forgot_password';
        if ($vals = $this->input->post()) {
            $content_row = $this->master->getRow($this->table_name, array('ckey' => $this->uri->segment(3)));
            if ($content_row && $content_row->code !== null) {
                $content_row = unserialize($content_row->code);
            } else {
                $content_row = array();
            }

            if (!is_array($content_row))
                $content_row = array();

            for ($i = 1; $i <= 1; $i++) {
                if (isset($_FILES["image" . $i]["name"]) && $_FILES["image" . $i]["name"] != "") {

                    $image = upload_file(UPLOAD_PATH . 'images/', 'image' . $i);

                    // if($i === 1)
                    // {
                    //     generate_thumb(UPLOAD_PATH.'images/',UPLOAD_PATH.'images/',$image['file_name'],300,'thumb_');
                    //     generate_thumb(UPLOAD_PATH.'images/',UPLOAD_PATH.'images/',$image['file_name'],500,'500p_');
                    //     generate_thumb(UPLOAD_PATH.'images/',UPLOAD_PATH.'images/',$image['file_name'],800,'800p_');
                    // }

                    if (!empty($image['file_name'])) {
                        if (isset($content_row['image' . $i])) {
                            if ($i === 1) {
                                $this->remove_file(UPLOAD_PATH . "images/" . $content_row['image' . $i]);
                                // $this->remove_file(UPLOAD_PATH."images/thumb_".$content_row['image'.$i]);
                                // $this->remove_file(UPLOAD_PATH."images/500p_".$content_row['image'.$i]);
                                // $this->remove_file(UPLOAD_PATH."images/800p_".$content_row['image'.$i]);
                            }
                        }
                        $vals['image' . $i] = $image['file_name'];
                    }
                }
            }

            $data = serialize(array_merge($content_row, $vals));
            $this->master->save($this->table_name, array('code' => $data), 'ckey', $this->uri->segment(3));
            setMsg('success', 'Settings updated successfully !');
            redirect(ADMIN . "/sitecontent/".$this->uri->segment(3));
            exit;
        }

        $this->data['row'] = $this->master->getRow($this->table_name, array('ckey' => $this->uri->segment(3)));
        if ($this->data['row'] && isset($this->data['row']->code) && $this->data['row']->code !== null) {
            $this->data['row'] = unserialize($this->data['row']->code);
        } else {
            $this->data['row'] = array(); // or handle it in a way that makes sense for your application
        }
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    public function email_verify()
    {

        $check = $this->page_model->num_rows(array('ckey' => $this->uri->segment(3)));
        // pr($this->db->last_query());
        if (!$check) {
            $this->page_model->save(array('ckey' => $this->uri->segment(3)));

            $check_meta = $this->master->num_rows('meta_info', array('slug' => $this->uri->segment(3)));
            // pr($check_meta);
            if($check_meta  == 0){
                $this->master->save('meta_info', ['slug' => $this->uri->segment(3), 'page_name' => $this->uri->segment(3)]);

                // pr($this->db->last_query());
            }
        }

        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = ADMIN . '/site_email_verify';
        if ($vals = $this->input->post()) {
            $content_row = $this->master->getRow($this->table_name, array('ckey' => $this->uri->segment(3)));
            if ($content_row && $content_row->code !== null) {
                $content_row = unserialize($content_row->code);
            } else {
                $content_row = array();
            }

            if (!is_array($content_row))
                $content_row = array();

            for ($i = 1; $i <= 1; $i++) {
                if (isset($_FILES["image" . $i]["name"]) && $_FILES["image" . $i]["name"] != "") {

                    $image = upload_file(UPLOAD_PATH . 'images/', 'image' . $i);

                    // if($i === 1)
                    // {
                    //     generate_thumb(UPLOAD_PATH.'images/',UPLOAD_PATH.'images/',$image['file_name'],300,'thumb_');
                    //     generate_thumb(UPLOAD_PATH.'images/',UPLOAD_PATH.'images/',$image['file_name'],500,'500p_');
                    //     generate_thumb(UPLOAD_PATH.'images/',UPLOAD_PATH.'images/',$image['file_name'],800,'800p_');
                    // }

                    if (!empty($image['file_name'])) {
                        if (isset($content_row['image' . $i])) {
                            if ($i === 1) {
                                $this->remove_file(UPLOAD_PATH . "images/" . $content_row['image' . $i]);
                                // $this->remove_file(UPLOAD_PATH."images/thumb_".$content_row['image'.$i]);
                                // $this->remove_file(UPLOAD_PATH."images/500p_".$content_row['image'.$i]);
                                // $this->remove_file(UPLOAD_PATH."images/800p_".$content_row['image'.$i]);
                            }
                        }
                        $vals['image' . $i] = $image['file_name'];
                    }
                }
            }

            $data = serialize(array_merge($content_row, $vals));
            $this->master->save($this->table_name, array('code' => $data), 'ckey', $this->uri->segment(3));
            setMsg('success', 'Settings updated successfully !');
            redirect(ADMIN . "/sitecontent/".$this->uri->segment(3));
            exit;
        }

        $this->data['row'] = $this->master->getRow($this->table_name, array('ckey' => $this->uri->segment(3)));
        if ($this->data['row'] && isset($this->data['row']->code) && $this->data['row']->code !== null) {
            $this->data['row'] = unserialize($this->data['row']->code);
        } else {
            $this->data['row'] = array(); // or handle it in a way that makes sense for your application
        }
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    public function change_password()
    {

        $check = $this->page_model->num_rows(array('ckey' => $this->uri->segment(3)));
        // pr($this->db->last_query());
        if (!$check) {
            $this->page_model->save(array('ckey' => $this->uri->segment(3)));

            $check_meta = $this->master->num_rows('meta_info', array('slug' => $this->uri->segment(3)));
            // pr($check_meta);
            if($check_meta  == 0){
                $this->master->save('meta_info', ['slug' => $this->uri->segment(3), 'page_name' => $this->uri->segment(3)]);

                // pr($this->db->last_query());
            }
        }

        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = ADMIN . '/site_reset_password';
        if ($vals = $this->input->post()) {
            $content_row = $this->master->getRow($this->table_name, array('ckey' => $this->uri->segment(3)));
            if ($content_row && $content_row->code !== null) {
                $content_row = unserialize($content_row->code);
            } else {
                $content_row = array();
            }

            if (!is_array($content_row))
                $content_row = array();

            for ($i = 1; $i <= 1; $i++) {
                if (isset($_FILES["image" . $i]["name"]) && $_FILES["image" . $i]["name"] != "") {

                    $image = upload_file(UPLOAD_PATH . 'images/', 'image' . $i);

                    // if($i === 1)
                    // {
                    //     generate_thumb(UPLOAD_PATH.'images/',UPLOAD_PATH.'images/',$image['file_name'],300,'thumb_');
                    //     generate_thumb(UPLOAD_PATH.'images/',UPLOAD_PATH.'images/',$image['file_name'],500,'500p_');
                    //     generate_thumb(UPLOAD_PATH.'images/',UPLOAD_PATH.'images/',$image['file_name'],800,'800p_');
                    // }

                    if (!empty($image['file_name'])) {
                        if (isset($content_row['image' . $i])) {
                            if ($i === 1) {
                                $this->remove_file(UPLOAD_PATH . "images/" . $content_row['image' . $i]);
                                // $this->remove_file(UPLOAD_PATH."images/thumb_".$content_row['image'.$i]);
                                // $this->remove_file(UPLOAD_PATH."images/500p_".$content_row['image'.$i]);
                                // $this->remove_file(UPLOAD_PATH."images/800p_".$content_row['image'.$i]);
                            }
                        }
                        $vals['image' . $i] = $image['file_name'];
                    }
                }
            }

            $data = serialize(array_merge($content_row, $vals));
            $this->master->save($this->table_name, array('code' => $data), 'ckey', $this->uri->segment(3));
            setMsg('success', 'Settings updated successfully !');
            redirect(ADMIN . "/sitecontent/".$this->uri->segment(3));
            exit;
        }

        $this->data['row'] = $this->master->getRow($this->table_name, array('ckey' => $this->uri->segment(3)));
        if ($this->data['row'] && isset($this->data['row']->code) && $this->data['row']->code !== null) {
            $this->data['row'] = unserialize($this->data['row']->code);
        } else {
            $this->data['row'] = array(); // or handle it in a way that makes sense for your application
        }
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    } 

    public function faq()
    {
        $check = $this->page_model->num_rows(array('ckey' => $this->uri->segment(3)));
        // pr($this->db->last_query());
        if (!$check) {
            $this->page_model->save(array('ckey' => $this->uri->segment(3)));

            $check_meta = $this->master->num_rows('meta_info', array('slug' => $this->uri->segment(3)));
            // pr($check_meta);
            if($check_meta  == 0){
                $this->master->save('meta_info', ['slug' => $this->uri->segment(3), 'page_name' => $this->uri->segment(3)]);

                // pr($this->db->last_query());
            }
        }
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = ADMIN . '/site_faq';
        if ($vals = $this->input->post()) {
            $content_row = $this->master->getRow($this->table_name, array('ckey' => $this->uri->segment(3)));
            if ($content_row && $content_row->code !== null) {
                $content_row = unserialize($content_row->code);
            } else {
                $content_row = array();
            }

            if (!is_array($content_row))
                $content_row = array();

                for ($i = 1; $i <= 1; $i++) {
                    if (isset($_FILES["image" . $i]["name"]) && $_FILES["image" . $i]["name"] != "") {
    
                        $image = upload_file(UPLOAD_PATH . 'images/', 'image' . $i);
    
                        // if($i === 1)
                        // {
                        //     generate_thumb(UPLOAD_PATH.'images/',UPLOAD_PATH.'images/',$image['file_name'],300,'thumb_');
                        //     generate_thumb(UPLOAD_PATH.'images/',UPLOAD_PATH.'images/',$image['file_name'],500,'500p_');
                        //     generate_thumb(UPLOAD_PATH.'images/',UPLOAD_PATH.'images/',$image['file_name'],800,'800p_');
                        // }
    
                        if (!empty($image['file_name'])) {
                            if (isset($content_row['image' . $i])) {
                                if ($i === 1) {
                                    $this->remove_file(UPLOAD_PATH . "images/" . $content_row['image' . $i]);
                                    // $this->remove_file(UPLOAD_PATH."images/thumb_".$content_row['image'.$i]);
                                    // $this->remove_file(UPLOAD_PATH."images/500p_".$content_row['image'.$i]);
                                    // $this->remove_file(UPLOAD_PATH."images/800p_".$content_row['image'.$i]);
                                }
                            }
                            $vals['image' . $i] = $image['file_name'];
                        }
                    }
                }



            $data = serialize(array_merge($content_row, $vals));
            $this->master->save($this->table_name, array('code' => $data), 'ckey', $this->uri->segment(3));
            setMsg('success', 'Settings updated successfully !');
            redirect(ADMIN . "/sitecontent/".$this->uri->segment(3));
            exit;
        }



        $this->data['row'] = $this->master->getRow($this->table_name, array('ckey' => $this->uri->segment(3)));
        if ($this->data['row'] && isset($this->data['row']->code) && $this->data['row']->code !== null) {
            $this->data['row'] = unserialize($this->data['row']->code);
        } else {
            $this->data['row'] = array(); // or handle it in a way that makes sense for your application
        }
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    
    public function terms_and_conditions(){
        $check = $this->page_model->num_rows(array('ckey' => $this->uri->segment(3)));
        // pr($this->db->last_query());
        if (!$check) {
            $this->page_model->save(array('ckey' => $this->uri->segment(3)));

            $check_meta = $this->master->num_rows('meta_info', array('slug' => $this->uri->segment(3)));
            // pr($check_meta);
            if($check_meta  == 0){
                $this->master->save('meta_info', ['slug' => $this->uri->segment(3), 'page_name' => $this->uri->segment(3)]);

                // pr($this->db->last_query());
            }
        }
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = ADMIN . '/site_terms_and_conditions';
        if ($vals = $this->input->post()) {
            $content_row = $this->master->getRow($this->table_name, array('ckey' => $this->uri->segment(3)));
            if ($content_row && $content_row->code !== null) {
                $content_row = unserialize($content_row->code);
            } else {
                $content_row = array();
            }

            if (!is_array($content_row))
                $content_row = array();

        
            


            $data = serialize(array_merge($content_row, $vals));
            $this->master->save($this->table_name, array('code' => $data), 'ckey', $this->uri->segment(3));
            setMsg('success', 'Settings updated successfully !');
            redirect(ADMIN . "/sitecontent/".$this->uri->segment(3));
            exit;
        }

        $this->data['row'] = $this->master->getRow($this->table_name, array('ckey' => $this->uri->segment(3)));
        if ($this->data['row'] && isset($this->data['row']->code) && $this->data['row']->code !== null) {
            $this->data['row'] = unserialize($this->data['row']->code);
        } else {
            $this->data['row'] = array(); // or handle it in a way that makes sense for your application
        }
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    

    public function privacy_policy()
    {
        $check = $this->page_model->num_rows(array('ckey' => $this->uri->segment(3)));
        // pr($this->db->last_query());
        if (!$check) {
            $this->page_model->save(array('ckey' => $this->uri->segment(3)));

            $check_meta = $this->master->num_rows('meta_info', array('slug' => $this->uri->segment(3)));
            // pr($check_meta);
            if($check_meta  == 0){
                $this->master->save('meta_info', ['slug' => $this->uri->segment(3), 'page_name' => $this->uri->segment(3)]);

                // pr($this->db->last_query());
            }
        }
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = ADMIN . '/site_privacy_policy';
        if ($vals = $this->input->post()) {
            $content_row = $this->master->getRow($this->table_name, array('ckey' => $this->uri->segment(3)));
            if ($content_row && $content_row->code !== null) {
                $content_row = unserialize($content_row->code);
            } else {
                $content_row = array();
            }

            if (!is_array($content_row))
                $content_row = array();

        
            


            $data = serialize(array_merge($content_row, $vals));
            $this->master->save($this->table_name, array('code' => $data), 'ckey', $this->uri->segment(3));
            setMsg('success', 'Settings updated successfully !');
            redirect(ADMIN . "/sitecontent/".$this->uri->segment(3));
            exit;
        }

        $this->data['row'] = $this->master->getRow($this->table_name, array('ckey' => $this->uri->segment(3)));
        if ($this->data['row'] && isset($this->data['row']->code) && $this->data['row']->code !== null) {
            $this->data['row'] = unserialize($this->data['row']->code);
        } else {
            $this->data['row'] = array(); // or handle it in a way that makes sense for your application
        }
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }
    

    public function delete()
    {
        $arr = $this->input->post('delete');
        foreach ($arr as $key => $values) {
            $this->master->delete($this->table_name, 'id', $values);
        }
        redirect("admin/sitecontent/slider", 'refresh');
    }

    function remove_file($filepath)
    {
        if (is_file($filepath))
            unlink($filepath);
        return;
    }
}
