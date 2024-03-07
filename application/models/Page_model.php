<?php
#[AllowDynamicProperties]
class Page_model extends CRUD_model {

    public function __construct() {
        parent::__construct();
        $this->table_name="sitecontent";
        $this->field="id";
    }
    function save($vals, $ckey = '',$field='',$site_lang="") {

        $this->db->set($vals);
        $this->db->where('site_lang', $site_lang);
        if ($ckey != '') {

            $this->db->where($ckey, $field);
            
            $this->db->update($this->table_name);

            return $ckey;

        } else {

            $this->db->insert($this->table_name);

            //return $this->db->last_query(); 

            return $this->db->insert_id();

        }

    }

}

?>