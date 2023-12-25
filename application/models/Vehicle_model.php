<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Vehicle_model extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->model(array('Vehicle_price_model', 'Extra_model'));
        $this->load->library(array('component', 'config_manager'));
		$this->load->helper(array('app_helper', 'date'));
    }
    
    public function get_vehicles($where = NULL){
        if($where === NULL){
            $this->db->select('vehicles.*, locations.name');
            $this->db->from('vehicles');
            $this->db->join('locations', 'locations.location_id = vehicles.location_id','inner');
            $query = $this->db->get();
            return $query->result();
        }else{
            $this->db->select('vehicles.*, locations.name');
            $this->db->where($where);
            $this->db->from('vehicles');
            $this->db->join('locations', 'locations.location_id = vehicles.location_id','inner');
            $query = $this->db->get();
            return $query->result(); 
        }
    }

    public function get_vehicle_by_user_id($user_id){
        $this->db->select('vehicle_id');
        $this->db->from('vehicles');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        return $query->result();       
    }

    public function get_vehicle_type($type_id){
            $this->db->select('vehicles.vehicle_id, vehicles.model, vehicles.make, vehicle_types.vehicle_type_id');
            $this->db->from('vehicles');
            $this->db->where('vehicles.vehicle_type_id', $type_id);
            $this->db->join('vehicle_types', 'vehicle_types.vehicle_type_id = vehicles.vehicle_type_id','inner');
            $query = $this->db->get();
            return $query->result();
    }

    public function add_vehicles($form_data, $form_data2){
        $this->db->insert('vehicles', $form_data);
        $vehicle_id = $this->db->insert_id();
        $form_data2['vehicle_id'] = $vehicle_id;
        $this->db->insert('vehicle_prices', $form_data2);
    }

    public function get_vehicle_by_id($vehicle_id){
        $this->db->where('vehicle_id', $vehicle_id);
        $result = $this->db->get('vehicles');
        return $result->row();
    }

    public function update_vehicle($vehicle_id, $form_data){
        $this->db->where('vehicle_id', $vehicle_id);
        $this->db->update('vehicles', $form_data);
    }

    public function update_images($vehicle_id, $new_image_array){
        $data  = $this->get_vehicle_by_id($vehicle_id);
        $current_images = $data->images;
		$images = explode(',', $current_images); 
		$final = array_merge($images, $new_image_array);
		$img_array = implode(',', $final);
		return $img_array;
    }

    public function get_current_vehicle_images($vehicle_id){
        $data  = $this->get_vehicle_by_id($vehicle_id);
        $current_images = $data->images;
        $imagesArray = explode(',', $current_images);
        return  $imagesArray;
    }

    public function delete_vehicle($vehicle_id){
        $this->db->where('vehicle_id', $vehicle_id);
        $this->db->delete('vehicles');
    }

    public function get_images_by_vehicle_id($vehicle_id){
        $this->db->limit(1);
        $this->db->select('images');
        $this->db->from('vehicles');
        $this->db->where('vehicle_id', $vehicle_id);
        $query = $this->db->get(); 
        return $query->row(); 
    }

    public function get_not_availability_cars_ids($params, $config_interval){
        $start_date = $params['start_date'];
        $end_date   = $params['end_date'];

        $sd = $start_date - $config_interval * 60 * 60;
        $ed = $end_date   + $config_interval * 60 * 60;

        $booking_sql = "SELECT vehicle_id FROM `app_vehicle_booking` as `t1`
                WHERE (
                `t1`.`start_time` BETWEEN '" . $sd . "' AND '" . $ed . "') 
                OR (`t1`.`end_time` BETWEEN '" . $sd . "' AND '" . $ed . "')
                OR (`t1`.`start_time` <= '" . $sd . "' AND `t1`.`end_time`>= '" . $ed . "')
                ";

        $booking_query = $this->db->query($booking_sql);

        $item_id = array();

        foreach ($booking_query->result()  as $k => $v){
            $item_id[$v->vehicle_id] = $v->vehicle_id;
        }

        $blocking_sql = "SELECT vehicle_id  FROM `app_vehicle_bloking` as `t1`
            WHERE (
            `t1`.`from_date` BETWEEN '" . $start_date . "' AND '" . $end_date . "') 
            OR (`t1`.`to_date` BETWEEN '" . $start_date . "' AND '" . $end_date . "')
            OR (`t1`.`from_date` <= '" . $start_date . "' AND `t1`.`to_date`>= '" . $end_date . "')
            ";

        $bloking_query = $this->db->query($blocking_sql);

         
        foreach ($bloking_query->result()  as $k => $v){
            $item_id[$v->vehicle_id] = $v->vehicle_id;
        }

        return $item_id;
        
    }

    public function get_available_cars($where){
        $sql = "SELECT * FROM `app_vehicles` WHERE ".$where;
        $query = $this->db->query($sql);
        return $query->result();
        // $this->db->where($where);
        // $query = $this->db->get('vehicles');
        // return $query->result();
    }

    public function get_current_month_vehicle_listing($user_id){
        $this->db->select('vehicle_id');

        $this->db->where('MONTH(create_date)', date('m'));

        $this->db->where('YEAR(create_date)', date('Y'));

        $this->db->where('user_id', $user_id);

        $query = $this->db->get("vehicles");

        return $query->num_rows();
    }

    public function get_available_filter_cars($where){
        //SELECT * FROM blogs JOIN comments ON comments.id = blogs.id
        $sql = "SELECT * FROM `app_vehicles` 
        WHERE ".$where;
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function calclate_booking_price($params){
        $result = array(
            'age_tax'              => 0, 
            'extra_mileage'        => 0, 
            'price_for_extra_mileage' => 0, 
            'price_for_extra_hours' => 0, 
            'extra_hours'          => 0, 
            'car_price'            => 0, 
            'discount'             => 0, 
            'extra_price'          => 0, 
            'total'                => 0, 
            'tax'                  => 0, 
            'deposit'              => 0,
            'formated_car_price'   =>  0, 
            'formated_extra_price' =>  0, 
            'formated_discount'    =>  0, 
            'formated_total'       =>  0, 
            'formated_age_tax'     =>  0, 
            'formated_age_tax'     =>  0, 
            'formated_deposit'     =>  0
        );

        $start_date = human_to_unix(date($this->config_manager->config['date_format']." H:i:s A", strtotime($params['pickup_date']." " .$params['pickup_time'])));
        $end_date = human_to_unix(date($this->config_manager->config['date_format']." H:i:s A", strtotime($params['drop_date']." " .$params['drop_time'])));
        
        if ($start_date > $end_date) {
            $c = $end_date;
            $end_date = $start_date;
            $start_date = $c;
        }

        $res = get_price_calculation($start_date, $end_date, $this->config_manager->config['calculate_type']);

        $hours = $res['h'];

        $days = $res['d'];

        $price_arr = $this->Vehicle_price_model->get_vehicle_prices_by_id($params['vehicle_selected_price']);

        $price = 0;

        $price += $price_arr->price_per_hour * $hours;

        $price += $price_arr->price_per_day * $days;

        if (!empty($price)){

            $result['car_price'] = $price;

            $result['total'] = $price + $result['price_for_extra_hours'] + $result['price_for_extra_mileage'];

            $extra_price = 0;

            if (!empty($params['extra_id'])) {

                $extra_id = array();

                foreach ($params['extra_id'] as $id) {
                    $extra_id[] = $id;
                }

                $opts = implode(',', $extra_id);

                $sql = "SELECT * FROM `app_extra` WHERE extra_id IN ($opts)";

                $query = $this->db->query($sql);

                $extras_arr = $query->result();

                $days = ceil(($end_date - $start_date)/(60*60*24));
                
                foreach ($extras_arr as $extra) {
                    switch ($extra->type) {
                        case 'percount':
                            switch ($extra->calculate) {
                                case 'price':
                                    $extra_price += $extra->price * $params['extra_value'][$extra->extra_id];
                                    break;
                                case 'percent':
                                    $extra_price += ($result['total'] * $extra->price * $params['extra_value'][$extra->extra_id]) / 100;
                                    break;
                            }
                            break;
                        case 'perdaycount':
                            switch ($extra->calculate) {
                                case 'price':
                                    $extra_price += $extra->price * $days * $params['extra_value'][$extra->extra_id];
                                    break;
                                case 'percent':
                                    $extra_price += ($result['total'] * $extra->price * $days * $params['extra_value'][$extra->extra_id]) / 100;
                                    break;
                            }
                            break;
                        case 'perday':
                            switch ($extra->calculate) {
                                case 'price':
                                    $extra_price += $extra->price * $days;
                                    break;
                                case 'percent':
                                    $extra_price += ($result['total'] * $extra->price * $days) / 100;
                                    break;
                            }
                            break;
                        case 'percent':
                            switch ($extra->calculate) {
                                case 'price':
                                    $extra_price += $extra->price;
                                    break;
                                case 'percent':
                                    $extra_price += ($result['total'] * $extra->price) / 100;
                                    break;
                            }
                            break;
                    }
                }
                $result['total'] += $extra_price;
                $result['extra_price'] = $extra_price;
            }

            if (!empty($params['promo_code'])) {
                $sql = "SELECT * FROM `app_discount` WHERE `promo_code` = '".$params['promo_code']."' AND '".$start_date."' BETWEEN `from_date` AND `to_date` AND dlimit >= '1'";
                $query = $this->db->query($sql);
                $discount_arr = $query->result();

                if (!empty($discount_arr) && count($discount_arr) > 0) {

                    $discount = $discount_arr[0];
    
                    switch ($discount->type) {
                        case 'price':
                            $result['discount'] = $discount->discount;
                            $result['total'] -= $result['discount'];
                            break;
                        case 'percent':
                            $result['discount'] = $result['total'] * $discount->discount / 100;
                            $result['total'] -= $result['discount'];
                            break;
                    }
                }
            }

            if ($params['driving_age'] <= $this->config_manager->config['age_for_tax'] && !empty($this->config_manager->config['age_tax'])) {
                switch ($this->config_manager->config['age_tax_type']) {
                    case 'price':
                        $result['age_tax'] = $this->config_manager->config['age_tax'];
                        $result['total'] = $result['total'] + $result['age_tax'];
                        break;
                    case 'percent':
                        $result['age_tax'] = ($result['total'] * $this->config_manager->config['age_tax']) / 100;
                        $result['total'] = $result['total'] + $result['age_tax'];
                        break;
                }
            }

            if (!empty($this->config_manager->config['tax'])) {
                switch ($this->config_manager->config['tax_type']) {
                    case 'price':
                        $result['tax'] = $this->config_manager->config['tax'];
                        $result['total'] = $result['total'] + $result['tax'];
                        break;
                    case 'percent':
                        $result['tax'] = ($result['total'] * $this->config_manager->config['tax']) / 100;
                        $result['total'] = $result['total'] + $result['tax'];
                        break;
                }
            }

            if (!empty($this->config_manager->config['deposit'])) {
                switch ($this->config_manager->config['deposit_type']) {
                    case 'price':
                        $result['deposit'] = $this->config_manager->config['deposit'];
                        break;
                    case 'percent':
                        $result['deposit'] = ($result['total'] * $this->config_manager->config['deposit']) / 100;
                        break;
                }
            }

            $result['formated_extra_price'] = $this->config_manager->config['currency_symbol']. "" .round($result['extra_price']);
            $result['formated_discount']    = $this->config_manager->config['currency_symbol']. "" .round($result['discount']);
            $result['formated_deposit']     = $this->config_manager->config['currency_symbol']. "" .round($result['deposit']);
            $result['formated_total']       = $this->config_manager->config['currency_symbol']. "" .round($result['total']);
            $result['formated_car_price']   = $this->config_manager->config['currency_symbol']. "" .round($result['car_price']);
            $result['formated_tax']         = $this->config_manager->config['currency_symbol']. "" .round($result['tax']);
            $result['formated_age_tax']     = $this->config_manager->config['currency_symbol']. "" .round($result['age_tax']);

            $result['extra_price']          = round($result['extra_price']);
            $result['discount']             = round($result['discount']);
            $result['deposit']              = round($result['deposit']);
            $result['total']                = round($result['total']);
            $result['car_price']            = round($result['car_price']);
            $result['age_tax']              = round($result['age_tax']);
        }
        return $result;
    }

    public function calclate_extra_prices($params){
        $result = array(
            'vehicle_price' => 0,
            'discount' => 0, 
            'extra_price' => 0, 
            'total' => 0, 
            'tax' => 0, 
            'deposit' => 0, 
            'formated_vehicle_price' => 0,
            'formated_extra_price' => 0, 
            'formated_discount' => 0, 
            'formated_total' => 0, 
            'formated_tax' => 0, 
            'formated_deposit' => 0
        );

        $start_date = human_to_unix(date($this->config_manager->config['date_format']." H:i:s A", strtotime($params['pickup_date']." " .$params['pickup_time'])));
        $end_date = human_to_unix(date($this->config_manager->config['date_format']." H:i:s A", strtotime($params['drop_date']." " .$params['drop_time'])));

        if ($start_date > $end_date) {
            $c = $end_date;
            $end_date = $start_date;
            $start_date = $c;
        }

        $res = get_price_calculation($start_date, $end_date, $this->config_manager->config['calculate_type']);

        $hours = $res['h'];

        $days = $res['d'];

        $price_arr = $this->Vehicle_price_model->get_vehicle_prices_by_id($params['vehicle_selected_price']);

        $price = 0;

        $price += $price_arr->price_per_hour * $hours;

        $price += $price_arr->price_per_day * $days;

        $extra_price_arr = array();

        if (!empty($price)) {
            $result['vehicle_price'] = $price;
            $result['total'] = $price;

            if (!empty($params['extra_id'])) {

                $extra_id = array();

                foreach ($params['extra_id'] as $id) {
                    $extra_id[] = $id;
                }

                
                $opts = implode(',', $extra_id);

                $sql = "SELECT * FROM `app_extra` WHERE extra_id IN ($opts)";

                $query = $this->db->query($sql);

                $extras_arr = $query->result();

                $days = ceil(($end_date - $start_date)/(60*60*24));

                foreach ($extras_arr as $extra) {
                    $extra_price = 0;
                    
                    switch ($extra->type) {
                        case 'percount':
                            switch ($extra->calculate) {
                                case 'price':
                                    $extra_price += $extra->price * $params['extra_value'][$extra->extra_id];
                                    break;
                                case 'percent':
                                    $extra_price += ($result['total'] * $extra->price * $params['extra_value'][$extra->extra_id]) / 100;
                                    break;
                            }
                            break;
                        case 'perdaycount':
                            switch ($extra->calculate) {
                                case 'price':
                                    $extra_price += $extra->price * $days * $params['extra_value'][$extra->extra_id];
                                    break;
                                case 'percent':
                                    $extra_price += ($result['total'] * $extra->price * $days * $params['extra_value'][$extra->extra_id]) / 100;
                                    break;
                            }
                            break;
                        case 'perday':
                            switch ($extra->calculate) {
                                case 'price':
                                    $extra_price += $extra->price * $days;
                                    break;
                                case 'percent':
                                    $extra_price += ($result['total'] * $extra->price * $days) / 100;
                                    break;
                            }
                            break;
                        case 'percent':
                            switch ($extra->calculate) {
                                case 'price':
                                    $extra_price += $extra->price;
                                    break;
                                case 'percent':
                                    $extra_price += ($result['total'] * $extra->price) / 100;
                                    break;
                            }
                            break;
                    }

                    $extra_price_arr[$extra->extra_id] = $extra_price;
                }

            }
        }
        return $extra_price_arr;   
    }

    public function get_booking_by_user($user_id){
		$vehicles  =  $this->get_vehicle_by_user_id($user_id);

		$countItems = 0;
		$prep_string = "";
		foreach ($vehicles as  $vehicle) {
			if ($countItems == 0)
		    	$prep_string = $vehicle->vehicle_id;
			elseif ($countItems >= 1)
			     $prep_string = $prep_string . "," . $vehicle->vehicle_id;
		     $countItems++;
		}

		$sql = "SELECT * FROM `app_vehicle_booking` WHERE vehicle_id IN ($prep_string) ORDER BY `date` DESC";

        $query = $this->db->query($sql);
        
        return $query->result();
    }

    public function get_total_vehicles_by_user($user_id){
        $this->db->where('user_id', $user_id);
        $this->db->select('COUNT(vehicle_id) as count');
		return $this->db->get('vehicles')->row();
    }
    // TODO optimize query
    public function get_total_booking($user_id){

		$vehicles  =  $this->get_vehicle_by_user_id($user_id);

		$countItems = 0;
		$prep_string = "";
		foreach ($vehicles as  $vehicle) {
			if ($countItems == 0)
		    	$prep_string = $vehicle->vehicle_id;
			elseif ($countItems >= 1)
			     $prep_string = $prep_string . "," . $vehicle->vehicle_id;
		     $countItems++;
		}

		$sql = "SELECT COUNT(vehicle_booking_id) as total FROM `app_vehicle_booking` WHERE vehicle_id IN ($prep_string)";

		$query = $this->db->query($sql);
		
        return $query->row();
                
    }
    // TODO optimize query
    public function get_current_month_earning($user_id){
        $vehicles  =  $this->get_vehicle_by_user_id($user_id);

		$countItems = 0;
		$prep_string = "";
		foreach ($vehicles as  $vehicle) {
			if ($countItems == 0)
		    	$prep_string = $vehicle->vehicle_id;
			elseif ($countItems >= 1)
			     $prep_string = $prep_string . "," . $vehicle->vehicle_id;
		     $countItems++;
		}

		$sql = "SELECT SUM(total) AS earning  FROM `app_vehicle_booking` WHERE vehicle_id IN ($prep_string) AND FROM_UNIXTIME(date,'%Y') = YEAR(CURRENT_DATE) AND  FROM_UNIXTIME(date,'%m') = MONTH(CURRENT_DATE)";

		$query = $this->db->query($sql);
		
        return $query->row();
    }

    // TODO optimize query
    public function get_current_year_earning($user_id){
        $vehicles  =  $this->get_vehicle_by_user_id($user_id);

		$countItems = 0;
		$prep_string = "";
		foreach ($vehicles as  $vehicle) {
			if ($countItems == 0)
		    	$prep_string = $vehicle->vehicle_id;
			elseif ($countItems >= 1)
			     $prep_string = $prep_string . "," . $vehicle->vehicle_id;
		     $countItems++;
		}

		$sql = "SELECT SUM(total) AS earningy  FROM `app_vehicle_booking` WHERE vehicle_id IN ($prep_string) AND FROM_UNIXTIME(date,'%Y') = YEAR(CURRENT_DATE)";

		$query = $this->db->query($sql);
		
        return $query->row();        
    }

    public function get_earning_week_report($user_id, $date){
        $this->db->select("SUM(app_vehicle_booking.total) as total");
        $this->db->from('vehicle_booking');
        $this->db->join('vehicles', 'vehicles.vehicle_id=vehicle_booking.vehicle_id','inner');
        $this->db->where('vehicles.user_id', $user_id);
        $this->db->where('FROM_UNIXTIME(app_vehicle_booking.date, "%Y-%m-%d") =', $date);
        $this->db->group_by(array('FROM_UNIXTIME(app_vehicle_booking.date,"%m")'));
        $query = $this->db->get();
        return $query->row();
    }

    public function get_earning_yealy_report($user_id, $year, $month){
        $this->db->select("SUM(app_vehicle_booking.total) as total");
        $this->db->from('vehicle_booking');
        $this->db->join('vehicles', 'vehicles.vehicle_id=vehicle_booking.vehicle_id','inner');
        $this->db->where('vehicles.user_id', $user_id);
        $this->db->where('FROM_UNIXTIME(app_vehicle_booking.date, "%Y") =', $year);
        $this->db->where('FROM_UNIXTIME(app_vehicle_booking.date, "%m") =', $month);
        $this->db->group_by(array('FROM_UNIXTIME(app_vehicle_booking.date,"%m")'));
        $query = $this->db->get();
        return $query->row();
    }

    public function get_total_admin_booking(){
        return $this->db->count_all('vehicle_booking'); 
    }
    
    public function get_total_admin_vehicles(){
        return $this->db->count_all('vehicles'); 
    }

    public function get_total_revenue(){
        $this->db->select('SUM(total) as total');
        return  $this->db->get('vehicle_booking')->row();
    }

    public function get_earning_month_report($date){
        $this->db->select("SUM(app_vehicle_booking.total) as total");
        $this->db->from('vehicle_booking');
        $this->db->join('vehicles', 'vehicles.vehicle_id=vehicle_booking.vehicle_id','inner');
        $this->db->where('FROM_UNIXTIME(app_vehicle_booking.date, "%Y-%m-%d") =', $date);
        $this->db->group_by(array('FROM_UNIXTIME(app_vehicle_booking.date,"%m")'));
        $query = $this->db->get();
        return $query->row();
    }


    public function update_global_settings($key, $value){
        $data = array(
            'conf_value' => $value
        );
        $this->db->where('conf_key', $key); 
        $this->db->update('configuration', $data);
    }

    

}