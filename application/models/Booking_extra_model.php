<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Booking_extra_model extends CI_Model {

    public function add_booking_extra($form_data){
        $this->db->insert('vehicle_booking_extra', $form_data);
    }

    public function get_booking_by_id($vehicle_booking_id){
        $this->db->where('vehicle_booking_id', $vehicle_booking_id);
        $result = $this->db->get('vehicle_booking_extra');
        return $result->result();
    }

}