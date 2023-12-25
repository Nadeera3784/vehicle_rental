<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Vehicle_price_model extends CI_Model {

    
    public function get_vehicle_prices(){
        $query = $this->db->get('vehicle_prices');
        return $query->result();
    }

    public function get_vehicle_price_relations(){
        $this->db->select('vehicle_prices.*, vehicles.vehicle_id, vehicles.model, vehicles.make');
        $this->db->from('vehicle_prices');
        $this->db->join('vehicles', 'vehicles.vehicle_id = vehicle_prices.vehicle_id','inner');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_vehicle_price_by_vehicle_id($vehicle_id){
        $this->db->where('vehicle_id', $vehicle_id);
        $result = $this->db->get('vehicle_prices');
        return $result->result();
    }

    public function get_single_vehicle_price_by_vehicle_id($vehicle_id){
        $this->db->where('vehicle_id', $vehicle_id);
        $result = $this->db->get('vehicle_prices');
        return $result->row();
    }

    public function add_vehicle_prices($form_data){
        $this->db->insert('vehicle_prices', $form_data);
    }

    public function get_vehicle_prices_by_id($price_id){
        $this->db->where('vehicle_price_id', $price_id);
        $result = $this->db->get('vehicle_prices');
        return $result->row();
    }

    public function update_vehicle_prices($price_id, $form_data){
        $this->db->where('vehicle_price_id', $price_id);
        $this->db->update('vehicle_prices', $form_data);
    }

    public function delete_price_plan($price_id){
        $this->db->where('vehicle_price_id', $price_id);
        $this->db->delete('vehicle_prices');
    }

    public function delete_vehicle_price_by_vehicle_id($vehicle_id){
        $this->db->where('vehicle_id', $vehicle_id);
        $this->db->delete('vehicle_prices');
    }
    
    public function get_vehicle_prices_by_vehicle_id($vehicle_id, $params = array(), $option_arr_values){
        $arr = array();

        $start_date = $params['start_date'];
        $end_date   = $params['end_date'];

        if ($start_date > $end_date) {
            $c = $end_date;
            $end_date = $start_date;
            $start_date = $c;
        }

        $res = get_price_calculation($start_date, $end_date, $option_arr_values);

        $hours = $res['h'];

        $days = $res['d'];

        $this->db->where('vehicle_id', $vehicle_id);
        $query = $this->db->get('vehicle_prices');

        foreach ($query->result() as $key => $value) {
            $arr[$key] = $value;

            $price = 0;

            $price += $value->price_per_hour * $hours;
            $price += $value->price_per_day * $days;

            $arr[$key]->price = $price;
        }
        return $arr;
    }

}