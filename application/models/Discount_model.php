<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Discount_model extends CI_Model {

    
    public function get_discount(){
        $query = $this->db->get('discount');
        return $query->result();
    }

    public function add_discount($form_data){
        $this->db->insert('discount', $form_data);
    }

    public function get_discount_by_id($discount_id){
        $this->db->where('discount_id', $discount_id);
        $result = $this->db->get('discount');
        return $result->row();
    }

    public function update_discount($discount_id, $form_data){
        $this->db->where('discount_id', $discount_id);
        $this->db->update('discount', $form_data);
    }

    public function delete_discount($discount_id){
        $this->db->where('discount_id', $discount_id);
        $this->db->delete('discount');
    }

}