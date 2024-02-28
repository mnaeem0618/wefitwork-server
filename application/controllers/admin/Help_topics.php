<?php

class Help_topics extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->isLogged();
        $this->load->model('help_model');
        $this->load->model('help_topics_model');
    }

    function index(){
        if ($this->data['help'] = $this->help_model->get_row($this->uri->segment('4'), 'id')) {
            $this->data['enable_datatable'] = TRUE;
            $this->data['pageView'] = ADMIN . '/help/help_topics';
            $this->data['rows'] = $this->master->getRows('help_topics', array('help_id'=>$this->data['help']->id), '', '', 'ASC', 'id');
            $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
        }
        else{
            show_404();
        }
    }

    function manage_topic(){
        if ($this->data['help'] = $this->help_model->get_row($this->uri->segment('4'), 'id')) {
            $this->data['enable_datatable'] = TRUE;
            $this->data['pageView'] = ADMIN . '/help/help_topics';
            $this->data['enable_editor'] = TRUE;
           
            if ($this->input->post()) {
                $vals = ($this->input->post());
                $vals['help_id']=$this->data['help']->id;

                $save_data = array(
                    'help_id' => $vals['help_id'], 
                    'title' => $vals['title'],
                    'status' => 1, 
                    'created_date' => date('Y-m-d h:i:s a')
                );
                
                $id=$this->help_topics_model->save($save_data, $this->uri->segment(5));
                    
                setMsg('success', 'Help Topic has been saved successfully.');
                redirect(ADMIN . '/help_topics/index/'.$this->uri->segment(4), 'refresh');
                exit;
            }

            $this->data['row'] = $this->master->getRow('help_topics',array('help_id'=>$this->data['help']->id,'id'=>$this->uri->segment('5')));
            $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
        }
        else{
            show_404();
        }
    }


    function delete_topic()
    {
         $this->master->delete('help_topics', 'id', $this->uri->segment(5));
         $this->master->delete_where('help_topic_articles', array('topic_id' => $this->uri->segment(5)) );

        
        setMsg('success', 'Help Topic has been deleted successfully.');
        redirect(ADMIN . '/help_topics/index/'.$this->uri->segment(4), 'refresh');
    }

    function help_topic_articles(){
        if ($this->data['help_topic'] = $this->help_topics_model->get_row($this->uri->segment('4'), 'id')) {
            $this->data['enable_datatable'] = TRUE;
            $this->data['pageView'] = ADMIN . '/help/help_topic_articles';
            $this->data['rows'] = $this->master->getRows('help_topic_articles', array('topic_id'=>$this->data['help_topic']->id), '', '', 'ASC', 'id');
            $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
        }
        else{
            show_404();
        }
    }

    function manage_help_topic_article(){
        if ($this->data['help_topic'] = $this->help_topics_model->get_row($this->uri->segment('4'), 'id')) {
            $this->data['enable_datatable'] = TRUE;
            $this->data['pageView'] = ADMIN . '/help/help_topic_articles';
            $this->data['enable_editor'] = TRUE;
           
            if ($this->input->post()) {
                $vals = ($this->input->post());
                $vals['topic_id']=$this->data['help_topic']->id;

                $content_row = $this->master->get_data_row('help_topic_articles', array('id'=>$this->uri->segment(5)));
            

            if (isset($_FILES["og_image"]["name"]) && $_FILES["og_image"]["name"] != "") {
                $this->remove_file($this->uri->segment(4), 'og_image');

                $og_image = upload_file(UPLOAD_PATH.'images/', 'og_image');
                    generate_thumb(UPLOAD_PATH . "images/", UPLOAD_PATH . "images/", $og_image['file_name'],1000,'thumb_');
                $vals['og_image']=$og_image['file_name'];
            }
            else{
                $vals['og_image']=$content_row->og_image;
            }

            $exist=$this->master->num_rows('help_topic_articles',array("slug"=>$vals['slug'],'id!='=>$this->uri->segment(4)));
            if($exist > 0){
                $vals['slug'] = url_title($vals['article_name'], '-', TRUE)."_1";
            }
            else{
                $vals['slug'] = url_title($vals['article_name'], '-', TRUE);
            }

            $created_date="";
            if(empty($content_row->created_date)){
                $created_date=date('Y-m-d h:i:s');
            }
            else{
                $created_date=$content_row->created_date;
            }

                $save_data = array(

                    'topic_id' => $vals['topic_id'], 
                    'meta_title'=>$vals['meta_title'],
                    'meta_keywords'=>$vals['meta_keywords'],
                    'meta_description'=>$vals['meta_description'],
                    'og_type'=>$vals['og_type'],
                    'og_title'=>$vals['og_title'],
                    'og_description'=>$vals['og_description'],
                    'og_image'=>$vals['og_image'],
                    'article_name'=>$vals['article_name'],
                    'slug'=>$vals['slug'],
                    'detail' =>$vals['detail'],
                    'status'=>$vals['status'],
                    'created_date'=>$created_date,

                );
                
                $id=$this->master->save('help_topic_articles', $save_data, 'id', $this->uri->segment(5));
                    
                setMsg('success', 'Topic Article has been saved successfully.');
                redirect(ADMIN . '/help_topics/help_topic_articles/'.$this->uri->segment(4), 'refresh');
                exit;
            }

            $this->data['row'] = $this->master->getRow('help_topic_articles',array('topic_id'=>$this->data['help_topic']->id,'id'=>$this->uri->segment('5')));
            $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
        }
        else{
            show_404();
        }
    }


    function delete_help_topic_article()
    {
         $this->master->delete('help_topic_articles', 'id', $this->uri->segment(5));
                 
        setMsg('success', 'Topic Article has been deleted successfully.');
        redirect(ADMIN . '/help_topics/help_topic_articles/'.$this->uri->segment(4), 'refresh');
    }


    function remove_file($id,$type) {
        $arr = $this->master->getRow('help_topic_articles',array('id'=>$id));
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
  

}

?>