<?php

class States extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->isLogged();
        
        
    }

    function index()
    {
        $this->data['enable_datatable'] = TRUE;
        $this->data['pageView'] = ADMIN . '/states';
        $this->data['rows'] = $this->master->getRows('nigeria_states', array());
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function manage()
    {
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = ADMIN . '/states';
        if ($this->input->post()) {
            $vals = $this->input->post();
            
            $this->master->save('nigeria_states', $vals, 'id', $this->uri->segment(4));
            setMsg('success', 'State has been saved successfully.');
            redirect(ADMIN . '/states', 'refresh');
            exit;
        }
       
        $this->data['row'] = $this->master->getRow('nigeria_states', array('id' => $this->uri->segment('4')));
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function delete($id) {
        $id = intval($id);
        if ($row = $this->master->getRow('nigeria_states', array('id' => $id))) {
            $this->master->delete_where('nigeria_states', array('id' => $this->uri->segment('4')));
            setMsg('success', 'State has been deleted successfully.');
            redirect(ADMIN . '/states', 'refresh');
            exit;
        }
        else
            show_404();
    }

}

?>