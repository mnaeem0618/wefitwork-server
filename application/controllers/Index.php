<?php

class Index extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('member_model');
        $this->load->model('pages_model', 'page');
    }

    function index()
    {
        redirect('/admin/login', 'refresh');
    }

}
