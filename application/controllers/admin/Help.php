<?php

class Help extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->isLogged();
        has_access(10);
    }

    public function index() {
        $this->data['enable_datatable'] = TRUE;
        $this->data['pageView'] = ADMIN . '/help/index';
        $this->data['rows'] = $this->master->get_data_rows('help');
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function manage() {
        $this->data['enable_editor'] = TRUE;
        $this->data['settings'] = $this->master->get_data_row('siteadmin');
        
        $this->data['pageView'] = ADMIN . '/help/index';
         if ($this->input->post()) {
            $vals = $this->input->post();
            $content_row = $this->master->get_data_row('help', array('id'=>$this->uri->segment(4)));
            if (isset($_FILES["icon"]["name"]) && $_FILES["icon"]["name"] != "") {
                $this->remove_file($this->uri->segment(4), 'icon');
                $image1 = upload_file(UPLOAD_PATH.'help/', 'icon');
                    // generate_thumb(UPLOAD_PATH . "help/", UPLOAD_PATH . "help/", $image1['file_name'],100,'thumb_');
                $vals['icon']=$image1['file_name'];
            }
            else{
                $vals['icon']=$content_row->icon;
            }

            if (isset($_FILES["og_image"]["name"]) && $_FILES["og_image"]["name"] != "") {
                $this->remove_file($this->uri->segment(4), 'og_image');

                $og_image = upload_file(UPLOAD_PATH.'images/', 'og_image');
                    // generate_thumb(UPLOAD_PATH . "images/", UPLOAD_PATH . "images/", $og_image['file_name'],1000,'thumb_');
                $vals['og_image']=$og_image['file_name'];
            }
            else{
                $vals['og_image']=$content_row->og_image;
            }

            $exist=$this->master->num_rows('help',array("slug"=>$vals['slug'],'id!='=>$this->uri->segment(4)));
            if($exist > 0){
                $vals['slug'] = url_title($vals['title'], '-', TRUE)."_1";
            }
            else{
                $vals['slug'] = url_title($vals['title'], '-', TRUE);
            }

            $created_date="";
            if(empty($content_row->created_date)){
                $created_date=date('Y-m-d h:i:s');
            }
            else{
                $created_date=$content_row->created_date;
            }
            // pr($vals);
            //pr($image1);
            //$categories=implode(",",$vals['categories']);
            $values=array(
               
                'meta_title'=>$vals['meta_title'],
                'meta_keywords'=>$vals['meta_keywords'],
                'meta_description'=>$vals['meta_description'],
                'og_type'=>$vals['og_type'],
                'og_title'=>$vals['og_title'],
                'og_description'=>$vals['og_description'],
                'og_image'=>$vals['og_image'],
                'title'=>$vals['title'],
                'slug'=>$vals['slug'],
                'detail' =>$vals['detail'],
                'status'=>$vals['status'],
                'icon'=>$vals['icon'],
                'created_date'=>$created_date,

            );

            $id = $this->master->save('help', $values, 'id', $this->uri->segment(4));

            if($id > 0){
                      
                setMsg('success', 'Help has been saved successfully.');
                redirect(ADMIN . '/help', 'refresh');
                exit;
            }
        }
       
        $this->data['row'] = $this->master->get_data_row('help',array('id'=>$this->uri->segment('4')));
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);        
    }

    function remove_file($id,$type) {
        $arr = $this->master->getRow('help',array('id'=>$id));
        if($type == 'icon'){
            $filepath1 = "./" . UPLOAD_PATH . "/help/" . $arr->icon;
            $filepath1_thumb = "./" . UPLOAD_PATH . "/help/thumb_" . $arr->icon;

            if (is_file($filepath1)) {
                unlink($filepath1);
            }
            if (is_file($filepath1_thumb)) {
                unlink($filepath1_thumb);
            }

        }else{
            $filepath = "./" . UPLOAD_PATH . "/images/" . $arr->og_image;
            $filepath_thumb = "./" . UPLOAD_PATH . "/images/thumb_" . $arr->og_image;

            if (is_file($filepath)) {
                unlink($filepath);
            }
            if (is_file($filepath_thumb)) {
                unlink($filepath_thumb);
            }
        }

        return;
    }

    function delete()
    {
        has_access(17);
        $this->remove_file($this->uri->segment(4), 'icon');
        $this->remove_file($this->uri->segment(4), 'og_image');

        $this->master->delete('help','id', $this->uri->segment(4));
      
        setMsg('success', 'Help has been deleted successfully.');
        redirect(ADMIN . '/help', 'refresh');
    }
}

?>