<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Vehicle_type_model extends CI_Model {

    
    public function get_vehicle_type(){
        $query = $this->db->get('vehicle_types');
        return $query->result();
    }

    public function add_vehicle_type($form_data){
        $this->db->insert('vehicle_types', $form_data);
    }

    public function get_vehicle_type_by_id($type_id){
        $this->db->where('vehicle_type_id', $type_id);
        $result = $this->db->get('vehicle_types');
        return $result->row();
    }

    public function get_vehicle_type_array_by_id($type_id){
        $this->db->where('vehicle_type_id', $type_id);
        $result = $this->db->get('vehicle_types');
        return $result->result();
    }

    public function update_vehicle_type($type_id, $form_data){
        $this->db->where('vehicle_type_id', $type_id);
        $this->db->update('vehicle_types', $form_data);
    }

    public function delete_vehicle_type($type_id){
        $this->db->where('vehicle_type_id', $type_id);
        $this->db->delete('vehicle_types');
    }

}