<?php

class Mc_requests extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->isLogged();
    }

    function index()
    {
        $this->data['enable_datatable'] = TRUE;
        $this->data['pageView'] = ADMIN . '/mc_requests';
        $this->data['rows'] = $this->master->getRows('mcover_requests');
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }
    
    function manage()
    {
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = ADMIN . '/mc_requests';
        if ($this->input->post()) {
            $vals = $this->input->post();

            $this->master->save('mcover_requests', $vals, 'id', $this->uri->segment(4));
            setMsg('success', 'Request Status updated successfully.');
            redirect(ADMIN . '/mc_requests/manage/'.$this->uri->segment('4'), 'refresh');
            exit;
        }
        $this->data['row'] = $this->master->getRow('mcover_requests', array('id' => $this->uri->segment('4')));
        $this->data['request_images'] = $this->master->getRows('mc_req_images', array('request_id' => $this->uri->segment('4')));

        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function delete($id) {
        $id = intval($id);
        if ($row = $this->mastere->getRow('mcover_requests', array('id' => $id))) {
            $this->master->delete_where('plans', array('id' => $this->uri->segment('4')));
            setMsg('success', 'Plan has been deleted successfully.');
            redirect(ADMIN . '/plans', 'refresh');
            exit;
        }
        else
            show_404();
    }

}

?>