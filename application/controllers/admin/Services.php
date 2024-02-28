<?php

class Services extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->isLogged();
        $this->load->model('services_model');
    }

    function index()
    {
        $this->data['enable_datatable'] = TRUE;
        $this->data['pageView'] = ADMIN . '/services';
        $this->data['rows'] = $this->services_model->get_rows(array());
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function manage()
    {
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = ADMIN . '/services';
        if ($this->input->post()) {
            $vals = $this->input->post();

            if (($_FILES["icon"]["name"] != "")) {
                $this->remove_file($this->uri->segment(4));
                $icon = upload_image(UPLOAD_PATH . "services/", 'icon');
                if (!empty($icon['file_name'])) {
                    $vals['icon'] = $icon['file_name'];
                    // generate_thumb(UPLOAD_PATH . "services/", UPLOAD_PATH . "services/", $icon['file_name'],120,'thumb_');
                    
                } else {
                    setMsg('error', 'Please upload a valid image file >> ' . strip_tags($icon['error']));
                    redirect(ADMIN . '/services/manage/' . $this->uri->segment(4), 'refresh');
                    exit;
                }
            }
            
            $this->services_model->save($vals, $this->uri->segment(4));
            setMsg('success', 'Service has been saved successfully.');
            redirect(ADMIN . '/services', 'refresh');
            exit;
        }
        $this->data['row'] = $this->services_model->get_row_where(array('id' => $this->uri->segment('4')));
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function delete($id) {
        $id = intval($id);
        if ($row = $this->services_model->get_row($id)) {
            $this->services_model->delete($this->uri->segment('4'));
            $this->master->delete_where('sub_services', array('ser_id' => $this->uri->segment('4')));

            setMsg('success', 'Service has been deleted successfully.');
            redirect(ADMIN . '/services', 'refresh');
            exit;
        }
        else
            show_404();
    }

    function remove_file($id) {
        $arr = $this->services_model->get_row($id);

        $filepath = "./" . UPLOAD_PATH . "/services/" . $arr->icon;
        $filepath_thumb = "./" . UPLOAD_PATH . "/services/thumb_" . $arr->icon;
        if (is_file($filepath)) {
            unlink($filepath);
        }
        if (is_file($filepath_thumb)) {
            unlink($filepath_thumb);
        }
        return;
    }

}

?>