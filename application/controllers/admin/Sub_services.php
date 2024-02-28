<?php

class Sub_services extends Admin_Controller
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
        $this->data['pageView'] = ADMIN . '/sub_services';
        $this->data['rows'] = $this->master->getRows('sub_services', array());
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function manage()
    {
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = ADMIN . '/sub_services';
        if ($this->input->post()) {
            $vals = $this->input->post();
            
            $this->master->save('sub_services', $vals, 'id', $this->uri->segment(4));
            setMsg('success', 'Sub Service has been saved successfully.');
            redirect(ADMIN . '/sub_services', 'refresh');
            exit;
        }
        $this->data['services'] = $this->services_model->get_rows(array('status' => 1));
        $this->data['row'] = $this->master->getRow('sub_services', array('id' => $this->uri->segment('4')));
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function delete($id) {
        $id = intval($id);
        if ($row = $this->master->getRow('sub_services', array('id' => $id))) {
            $this->master->delete_where('sub_services', array('id' => $this->uri->segment('4')));
            setMsg('success', 'Sub Service has been deleted successfully.');
            redirect(ADMIN . '/sub_services', 'refresh');
            exit;
        }
        else
            show_404();
    }

}

?>