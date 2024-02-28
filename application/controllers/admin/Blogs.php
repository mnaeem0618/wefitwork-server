<?php

class Blogs extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->isLogged();
        has_access(10);
    }

    public function index() {
        $this->data['enable_datatable'] = TRUE;
        $this->data['pageView'] = ADMIN . '/blogs';
        $this->data['blogs'] = $this->master->get_data_rows('blogs');
        // pr($this->data['blogs']);
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function manage() {
        $this->data['enable_editor'] = TRUE;
        $this->data['settings'] = $this->master->get_data_row('siteadmin');
        $this->data['pageView'] = ADMIN . '/blogs';
         if ($this->input->post()) {
            $vals = $this->input->post();
            $content_row = $this->master->get_data_row('blogs', array('id'=>$this->uri->segment(4)));
            if (isset($_FILES["image"]["name"]) && $_FILES["image"]["name"] != "") {
                $this->remove_file($this->uri->segment(4), 'image');
                $image1 = upload_file(UPLOAD_PATH.'blogs/', 'image');
                    // generate_thumb(UPLOAD_PATH . "blogs/", UPLOAD_PATH . "blogs/", $image1['file_name'],1000,'thumb_');
                $vals['image']=$image1['file_name'];
            }
            else{
                $vals['image']=$content_row->image;
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

            $exist=$this->master->num_rows('blogs',array("slug"=>$vals['slug'],'id!='=>$this->uri->segment(4)));
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
            //pr($image1);
            //$categories=implode(",",$vals['categories']);
            $values=array(
                'title'=>$vals['title'],
                'slug'=>$vals['slug'],
                'description'=>$vals['description'],
                'short_description'=>$vals['short_description'],
                'meta_title'=>$vals['meta_title'],
                'meta_keywords'=>$vals['meta_keywords'],
                'meta_description'=>$vals['meta_description'],
                'og_type'=>$vals['og_type'],
                'og_title'=>$vals['og_title'],
                'og_description'=>$vals['og_description'],
                'og_image'=>$vals['og_image'],
                'status'=>$vals['status'],
                // 'is_featured'=>$vals['is_featured'],
                'is_top_post'=>$vals['is_top_post'],
                'category_id' => $vals['category_id'],
                'image'=>$vals['image'],
                'image_alt_text'=>$vals['image_alt_text'],
                'created_date'=>$created_date,
            );
            $id = $this->master->save('blogs', $values, 'id', $this->uri->segment(4));

            // $categories = $vals['categories'];
            // unset($vals['categories']);
            // if(isset($categories))
            // {
            //     $this->master->delete_where('selected_blog_categories', array('blog_id'=> $id));
            //     foreach($categories as $val):   
            //         $this->master->save('selected_blog_categories', ['blog_id'=> $id, 'category_id'=> $val]);
            //     endforeach;
            // }
            //print_r($id);die;
            if($id > 0){
                setMsg('success', 'Blog has been saved successfully.');
                redirect(ADMIN . '/blogs', 'refresh');
                exit;
            }
        }
        // $selected_categories = $this->master->getRows('selected_blog_categories', ['blog_id'=> $this->uri->segment('4')]);
        // $this->data['selected_categories'] = [];
        // foreach($selected_categories as $val):
        //     $this->data['selected_categories'][] = $val->category_id;
        // endforeach; 
        
        $this->data['categories'] = $this->master->getRows('blog_categories', ['status'=> '1']);
        $this->data['row'] = $this->master->get_data_row('blogs',array('id'=>$this->uri->segment('4')));
        
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);        
    }

    function add_category(){
        $data=$this->input->post();
        $res=array();
        if(empty($data['cat_name'])){
            $res['status']=false;
            $res['empty']=true;
            echo json_encode($res);
        }
        else{
            $vals=array(
                'name'=>$data['cat_name']
            );
            $q=$this->master->save("categories",$vals);
            if($q>0){
                $res['status']=true;
                $res['success']=true;
                $res['cat_id']=$q;
            }
            else{
                 $res['status']=false; 
                 $res['fail']=false;  
            }
            echo json_encode($res);
        }
    }	


    function remove_file($id,$type) {

        $arr = $this->master->getRow('blogs',array('id'=>$id));

        if($type == 'image'){
            $filepath1 = "./" . UPLOAD_PATH . "/blogs/" . $arr->image;
            $filepath1_thumb = "./" . UPLOAD_PATH . "/blogs/thumb_" . $arr->image;


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
        $this->remove_file($this->uri->segment(4), 'image');
        $this->remove_file($this->uri->segment(4), 'og_image');

        $this->master->delete('blogs','id', $this->uri->segment(4));
        $this->master->delete('selected_blog_categories','blog_id', $this->uri->segment(4));

        setMsg('success', 'Blog has been deleted successfully.');
        redirect(ADMIN . '/Blogs', 'refresh');
    }
}

?>