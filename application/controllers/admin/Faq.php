<?php

class Faq extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->isLogged();
        has_access(7);
    }

    function index()
    {
        $this->data['enable_datatable'] = TRUE;
        $this->data['pageView'] = ADMIN . '/faq';

        $this->data['rows'] = $this->master->getRows('faqs', array(), '', '', 'acs', 'sort_order');
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function manage()
    {
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = ADMIN . '/faq';
        if ($this->input->post()) {
            $vals = $this->input->post();

            $this->master->save('faqs', $vals, 'id', $this->uri->segment(4));
            setMsg('success', 'Question has been saved successfully.');
            if(empty(intval($this->uri->segment(4)))){
                redirect(ADMIN . '/faq', 'refresh');
                exit;
            }
        }

        $this->data['row'] = $this->master->getRow('faqs', array('id' => $this->uri->segment('4')));
        $this->data['page_title'] = $this->data['row'] ? "Edit FAQ" : "Add New FAQ";
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function delete()
    {
        $this->master->delete('faqs', 'id', $this->uri->segment(4));
        setMsg('success', 'Question has been deleted successfully.');
        redirect(ADMIN . '/faq', 'refresh');
    }

}

?>