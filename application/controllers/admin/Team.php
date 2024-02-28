<?php

class Team extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->isLogged();
        $this->load->model('team_model');
    }

    function index()
    {
        $this->data['enable_datatable'] = TRUE;
        $this->data['pageView'] = ADMIN . '/team';

        $this->data['rows'] = $this->team_model->get_rows(array());
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function manage()
    {
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = ADMIN . '/team';
        if ($this->input->post()) {
            $vals = $this->input->post();
            if (($_FILES["image"]["name"] != "")) {
                $this->remove_file($this->uri->segment(4));
                $image = upload_image(UPLOAD_PATH . "team/", 'image');
                if (!empty($image['file_name'])) {
                    $vals['image'] = $image['file_name'];
                    // generate_thumb(UPLOAD_PATH . "team/", UPLOAD_PATH . "team/", $image['file_name'],100,'thumb_');
                    // generate_thumb(UPLOAD_PATH . "team/", UPLOAD_PATH . "team/", $image['file_name'],200,'200p_');
                } else {
                    setMsg('error', 'Please upload a valid image file >> ' . strip_tags($image['error']));
                    redirect(ADMIN . '/team/manage/' . $this->uri->segment(4), 'refresh');
                    exit;
                }
            }
            $this->team_model->save($vals, $this->uri->segment(4));
            setMsg('success', 'Testimonial has been saved successfully.');
            redirect(ADMIN . '/team', 'refresh');
            exit;
        }
        $this->data['row'] = $this->team_model->get_row_where(array('id' => $this->uri->segment('4')));
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function delete($id) {
        $id = intval($id);
        if ($row = $this->team_model->get_row($id)) {
            $this->team_model->delete($this->uri->segment('4'));
            setMsg('success', 'Testimonial has been deleted successfully.');
            redirect(ADMIN . '/team', 'refresh');
            exit;
        }
        else
            show_404();
    }

    function remove_file($id) {
        $arr = $this->team_model->get_row($id);

        $filepath = "./" . UPLOAD_PATH . "/team/" . $arr->image;
        $filepath_thumb = "./" . UPLOAD_PATH . "/team/thumb_" . $arr->image;
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