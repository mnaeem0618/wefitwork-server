<?php
defined('BASEPATH') OR exit('No direct script access allowed');
#[AllowDynamicProperties]
class Categories_model extends CRUD_model {

    public function __construct() {
        parent::__construct();
        $this->table_name="profession_categories";
        $this->field="id";
    }
}
?>



