<?php

class Maintenance_covers extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->isLogged();
    }

    function index()
    {
        $this->data['enable_datatable'] = TRUE;
        $this->data['pageView'] = ADMIN . '/maintenance_covers';
        $this->data['rows'] = $this->master->getRows('maintenance_covers');
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }
    
    function manage()
    {
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = ADMIN . '/maintenance_covers';
        if ($this->input->post()) {
            $vals = $this->input->post();

            $save_data = [
                'service_title' => $vals['service_title'],
                'title' => $vals['title'],
                'paystack_plan_code' => $vals['paystack_plan_code'],
                'price' => $vals['price'],
                'short_desc' => $vals['short_desc'],
                'detail' => $vals['detail'],
                'status' => $vals['status'],
                'created_date' => $vals['created_date'],
                'interval' => $vals['interval']
            ];

            $id = $this->master->save('maintenance_covers', $save_data, 'id', $this->uri->segment(4));

            if($id > 0){
                $content_data = [
                    'sec2_heading' => $vals['sec2_heading'],
                    'sec2_tagline' => $vals['sec2_tagline'],
                    'sec3_heading' => $vals['sec3_heading'],
                    'sec3_tagline' => $vals['sec3_tagline'],
                    'sec3_heading2' => $vals['sec3_heading2'],
                    'sec3_tagline2' => $vals['sec3_tagline2'],
                    'sec3_button1_text' => $vals['sec3_button1_text'],
                    'sec4_heading' => $vals['sec4_heading'],
                    'sec4_detail' => $vals['sec4_detail'],
                ];                             
        
                $content_row = $this->master->getRow('maintenance_covers', array('id' => $id));
                $content_row = unserialize($content_row->content);
    
                if (!is_array($content_row)) {
                    $content_row = array();
                }
    
                for ($i = 1; $i <= 2; $i++) {
                    if (isset($_FILES["image" . $i]["name"]) && $_FILES["image" . $i]["name"] != "") {
                        $image = upload_file(UPLOAD_PATH . 'maintenance_covers/', 'image' . $i);
                        if (!empty($image['file_name'])) {
                            // generate_thumb(UPLOAD_PATH . "maintenance_covers/", UPLOAD_PATH . "maintenance_covers/", $image['file_name'], 1920, 'thumb_');
                            if (isset($content_row['image' . $i])) {
                                $this->remove_file_content(UPLOAD_PATH . "maintenance_covers/" . $content_row['image' . $i]);
                            }
                            $content_data['image' . $i] = $image['file_name'];
                        }
                    }
                }
                $c_data = serialize(array_merge($content_row, $content_data));
    
                $this->master->update('maintenance_covers', array('content' => $c_data), array('id' => $id));


                $included['title'] = $vals['included_title'];
                unset($vals['included_title']);
                $this->master->delete_where('included', array('maintenance_cover_id'=> $id));
                $includeds = array('title' => $included['title']);
                saveIncluded($includeds, $id);

                $excluded['title'] = $vals['excluded_title'];
                unset($vals['excluded_title']);
                $this->master->delete_where('excluded', array('maintenance_cover_id'=> $id));
                $excludeds = array('title' => $excluded['title']);
                saveExcluded($excludeds, $id);


                $faq['question'] = $vals['question'];
                $faq['answer'] = $vals['answer'];
                $faq['sort_order'] = $vals['sort_order'];

                unset($vals['question'], $vals['answer'], $vals['sort_order']);
                $this->master->delete_where('mcover_faqs', array('maintenance_cover_id'=> $id));
                $faqs = array('question' => $faq['question'], 'answer' => $faq['answer'], 'sort_order' => $faq['sort_order']);
                saveMcoverFaqs($faqs, $id);

            }

            setMsg('success', 'Maintenance Cover has been saved successfully.');
            redirect(ADMIN . '/maintenance_covers', 'refresh');
            exit;
        }
        $this->data['row'] = $this->master->getRow('maintenance_covers', array('id' => $this->uri->segment('4')));
        $this->data['content'] = unserialize($this->data['row']->content);

        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function delete($id) {
        $id = intval($id);
        if ($row = $this->mastere->getRow('maintenance_covers', array('id' => $id))) {
            $this->master->delete_where('maintenance_covers', array('id' => $this->uri->segment('4')));
            setMsg('success', 'Maintenance Cover has been deleted successfully.');
            redirect(ADMIN . '/maintenance_covers', 'refresh');
            exit;
        }
        else
            show_404();
    }

    function add_sub_services(){
        if ($this->data['maintenance_cover'] = $this->master->getRow('maintenance_covers', array('id' => $this->uri->segment('4')))) {
            $this->data['enable_datatable'] = TRUE;
            $this->data['pageView'] = ADMIN . '/mc_sub_services';

            $this->data['rows'] = $this->master->getRows('mc_sub_services',array('maintenance_cover_id'=>$this->data['maintenance_cover']->id), '', '', 'ASC', 'id');
            $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
        }
        else{
            show_404();
        }
    }

    function manage_sub_services(){
        if ($this->data['maintenance_cover'] = $this->master->getRow('maintenance_covers', array('id' => $this->uri->segment('4')))) {
            $this->data['enable_datatable'] = TRUE;
            $this->data['pageView'] = ADMIN . '/mc_sub_services';
            $this->data['enable_editor'] = TRUE;
           
            if ($this->input->post()) {
                $vals = ($this->input->post());
                $vals['maintenance_cover_id']=$this->data['maintenance_cover']->id;
                $save_data = array('maintenance_cover_id' => $vals['maintenance_cover_id'], 'title' => $vals['title']);
               
    
                $id=$this->master->save('mc_sub_services', $save_data, 'id', $this->uri->segment(5));
                    
                setMsg('success', 'Sub Service saved successfully.');
                redirect(ADMIN . '/maintenance_covers/add_sub_services/'.$this->uri->segment(4), 'refresh');
                exit;
            }

            $this->data['row'] = $this->master->getRow('mc_sub_services',array('maintenance_cover_id'=>$this->data['maintenance_cover']->id, 'id' => $this->uri->segment('5')), '', '', 'DESC', 'id');
            $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
        }
        else{
            show_404();
        }
    }

    function delete_sub_services()
    {
        $this->master->delete('mc_sub_services', 'id', $this->uri->segment(5));
        
        setMsg('success', 'Sub Service deleted successfully.');
        redirect(ADMIN . '/maintenance_covers/add_sub_services/'.$this->uri->segment(4), 'refresh');
    }



    public function remove_file_content($filepath)
    {

        if (is_file($filepath)) {
            unlink($filepath);
        }

        return;

    }

}

?>