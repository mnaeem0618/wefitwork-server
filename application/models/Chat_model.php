<?php
defined('BASEPATH') OR exit('No direct script access allowed');
#[AllowDynamicProperties]
class Chat_model extends CRUD_model {

    public function __construct() {
        parent::__construct();
        $this->table_name="conversations";
        $this->field="id";
    }

    function getConversation($sender_id, $receiver_id){
        $query = $this->db->query("
        SELECT * 
        FROM tbl_conversations 
        WHERE (sender_id = $sender_id OR receiver_id = $sender_id) 
        AND (sender_id = $receiver_id OR receiver_id = $receiver_id)
    ");

    return $query->row();
    }

    function getUserConversations($sender_id){
        $query = $this->db->query("
        SELECT * 
        FROM tbl_conversations 
        WHERE (sender_id = $sender_id OR receiver_id = $sender_id) 
    ");

    return $query->result();
    }

    function getChatMessages($chat_id){
        $this->db->select('*');
        $this->db->from("messages");
        $this->db->where('convo_id', $chat_id);
        $query = $this->db->get();

            $result = $query->result();
            return $result;
    }

}
?>



