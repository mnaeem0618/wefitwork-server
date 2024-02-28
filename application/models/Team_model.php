<?php
defined('BASEPATH') OR exit('No direct script access allowed');
#[AllowDynamicProperties]
class Team_model extends CRUD_model {

    public function __construct() {
        parent::__construct();
        $this->table_name="team";
        $this->field="id";
    }
}
?>



