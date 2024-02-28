<?php

class Blog_categories extends Admin_Controller
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
        $this->data['pageView'] = ADMIN . '/blog_categories';

        $this->data['rows'] = $this->master->getRows('blog_categories', array(), '', '', 'acs', '');
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function manage()
    {
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = ADMIN . '/blog_categories';
        if ($this->input->post()) {
            $vals = $this->input->post();

            $this->master->save('blog_categories', $vals, 'id', $this->uri->segment(4));
            setMsg('success', 'Blogs Category has been saved successfully.');
            if(empty(intval($this->uri->segment(4)))){
                redirect(ADMIN . '/blog_categories', 'refresh');
                exit;
            }
        }

        $this->data['row'] = $this->master->getRow('blog_categories', array('id' => $this->uri->segment('4')));
        $this->data['page_title'] = $this->data['row'] ? "Edit Blogs Category" : "Add New Blogs Category";
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function delete()
    {
        $this->master->delete('blog_categories', 'id', $this->uri->segment(4));
        setMsg('success', 'Blogs Category has been deleted successfully.');
        redirect(ADMIN . '/blog_categories', 'refresh');
    }

}

?>