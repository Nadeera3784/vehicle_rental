<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Vehicle_blocking_model extends CI_Model {

    public function get_vehicle_blocking(){
        $query = $this->db->get('vehicle_bloking');
        return $query->result();
    }
    
    public function add_blocking($form_data){
        $this->db->insert('vehicle_bloking', $form_data);
    }

    public function update_blocking($vehicle_blocking_id, $form_data){
        $this->db->where('vehicle_bloking_id', $vehicle_blocking_id);
        $this->db->update('vehicle_bloking', $form_data);
    }

    public function get_block_by_id($vehicle_blocking_id){
        $this->db->where('vehicle_bloking_id', $vehicle_blocking_id);
        $result = $this->db->get('vehicle_bloking');
        return $result->row();
    }

    public function delete_block($bloking_id){
        $this->db->where('vehicle_bloking_id', $bloking_id);
        $this->db->delete('vehicle_bloking');
    }

}