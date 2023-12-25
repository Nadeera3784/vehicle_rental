<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Locations_model extends CI_Model {

    
    public function get_locations(){
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get('locations');
        return $query->result();
    }

    public function add_location($form_data){
        $this->db->insert('locations', $form_data);
    }

    public function get_location_by_id($location_id){
        $this->db->where('location_id', $location_id);
        $result = $this->db->get('locations');
        return $result->row();
    }

    public function update_location($location_id, $form_data){
        $this->db->where('location_id', $location_id);
        $this->db->update('locations', $form_data);
    }

    public function delete_location($location_id){
        $this->db->where('location_id', $location_id);
        $this->db->delete('locations');
    }

}