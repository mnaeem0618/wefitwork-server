<?php
defined('BASEPATH') OR exit('No direct script access allowed');
#[AllowDynamicProperties]
class Help_topics_model extends CRUD_model {

    public function __construct() {
        parent::__construct();
        $this->table_name="help_topics";
        $this->field="id";
    }
}
?>



