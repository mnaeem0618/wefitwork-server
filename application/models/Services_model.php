<?php

defined('BASEPATH') OR exit('No direct script access allowed');
#[AllowDynamicProperties]
class Services_model extends CRUD_model {



    public function __construct() {

        parent::__construct();

        $this->table_name="services";

        $this->field="id";

    }

}

?>







