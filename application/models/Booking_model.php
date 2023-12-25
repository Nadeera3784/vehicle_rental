<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Booking_model extends CI_Model {

    public function add_booking($form_data){
        $this->db->insert('vehicle_booking', $form_data);
        $last_id = $this->db->insert_id();
        return  $last_id;
    }

    public function get_booking_by_id($vehicle_booking_id){
        $this->db->where('vehicle_booking_id', $vehicle_booking_id);
        $result = $this->db->get('vehicle_booking');
        return $result->row();
    }

    public function get_booking(){
        $query = $this->db->get('vehicle_booking');
        return $query->result(); 
    }
    
    public function get_booking_status($vehicle_booking_id){
        $this->db->where('vehicle_booking_id', $vehicle_booking_id);
        $result = $this->db->get('vehicle_booking');
        return $result->row()->status;
    }

    public function update_booking_status($vehicle_booking_id, $form_data){
        $this->db->where('vehicle_booking_id', $vehicle_booking_id);
        $this->db->update('vehicle_booking', $form_data);
    }

    public function delete_bookings($vehicle_booking_id){
        $this->db->where('vehicle_booking_id', $vehicle_booking_id);
        $this->db->delete('vehicle_booking');
        $this->db->where('vehicle_booking_id', $vehicle_booking_id);
        $this->db->delete('vehicle_booking_extra');
    }
}