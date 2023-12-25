<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Membership_model extends CI_Model {

    
    public function get_membership(){
        $query = $this->db->get('membership');
        return $query->result();
    }

    public function add_membership($form_data){
        $this->db->insert('membership', $form_data);
    }

    public function get_membership_by_id($membership_id){
        $this->db->where('membership_id', $membership_id);
        $result = $this->db->get('membership');
        return $result->row();
    }

    public function update_membership($membership_id, $form_data){
        $this->db->where('membership_id', $membership_id);
        $this->db->update('membership', $form_data);
    }

    public function delete_membership($membership_id){
        $this->db->where('membership_id', $membership_id);
        $this->db->delete('membership');
    }

}