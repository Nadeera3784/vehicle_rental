<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Extra_model extends CI_Model {

    
    public function get_extra(){
        $query = $this->db->get('extra');
        return $query->result();
    }

    public function add_extra($form_data){
        $this->db->insert('extra', $form_data);
        $last_id = $this->db->insert_id();
        return  $last_id;
    }

    public function add_extra_relation($form_data){
        $this->db->insert('vehicle_extra_relation', $form_data);
    }

    public function get_extra_by_id($extra_id){
        $this->db->where('extra_id', $extra_id);
        $result = $this->db->get('extra');
        return $result->row();
    }

    public function delete_extra($extra_id){
        $this->db->where('extra_id', $extra_id);
        $this->db->delete('extra');
        $this->db->where('extra_id', $extra_id);
        $this->db->delete('vehicle_extra_relation');
    }
    
    public function get_extra_relations($extra_id){
        $this->db->where('extra_id', $extra_id);
        $result = $this->db->get('vehicle_extra_relation');
        return $result->result();
    }

    public function update_extra($extra_id, $form_data){
        $this->db->where('extra_id', $extra_id);
        $this->db->update('extra', $form_data);
    }

    public function update_extra_relation($extra_id, $form_data){
        $this->db->where('extra_id', $extra_id);
        $this->db->update('vehicle_extra_relation', $form_data);
    }

    public function delete_extra_relation($extra_id){
        $this->db->where('extra_id', $extra_id);
        $this->db->delete('vehicle_extra_relation');
    }

    public function get_extra_by_vehicle_id($vehilce_id){
        $this->db->select('extra.*');
        $this->db->from('extra');
        $this->db->where('vehicle_extra_relation.vehicle_id', $vehilce_id);
        $this->db->join('vehicle_extra_relation', 'vehicle_extra_relation.extra_id = extra.extra_id','inner');
        $query = $this->db->get();
        return $query->result();
    }


}