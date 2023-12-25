<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends MY_Controller {

	protected $cached_data = array();

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->config->load('app');
		$this->load->library(array('ion_auth','component', 'config_manager', 'session', 'form_validation', 'mailer'));
		$this->load->helper(array('app_helper', 'date', 'string'));
		$this->load->model(array(
			'Locations_model',
			'Vehicle_model',
			'Locations_model',
			'Vehicle_type_model',
			'Vehicle_price_model',
			'Extra_model',
			'Discount_model',
			'Booking_extra_model',
			'Booking_model'
		));
		$this->form_validation->set_error_delimiters('<div class="alert alert-primary" role="alert">', '</div>');
		
	}

	public function index(){

	    $data['css'] = array(
			$this->config->item('app_frontend_asset_root').'/css/animate.min.css',
			$this->config->item('app_frontend_asset_root').'/css/slick.css',
			$this->config->item('app_frontend_asset_root').'/css/slick-theme.css',
			$this->config->item('app_frontend_asset_root').'/css/flatpickr.css',
			$this->config->item('app_frontend_asset_root').'/css/timepicker.css'

		);

		$data['js'] = array(
			$this->config->item('app_frontend_asset_root').'/js/wow.min.js',
			$this->config->item('app_frontend_asset_root').'/js/slick.js',
			$this->config->item('app_frontend_asset_root').'/js/flatpickr.js',
			$this->config->item('app_frontend_asset_root').'/js/timepicker.js',
			$this->config->item('app_frontend_asset_root').'/js/validate.js',
			$this->config->item('app_frontend_asset_root').'/js/app.js'
		);

		$data["locations"]    =   $this->Locations_model->get_locations();
		
		$data["navigation_class"]   =   "bg-default";
		$data["footer_bottom"]       =   TRUE;

		$this->load->view('header', $data);
		$this->load->view('app', $data);
		$this->load->view('footer', $data);
	}

	public function search(){
		if(isset($_POST['submit'])){
			
			$this->form_validation->set_rules('pickup_location', 'Pickup Location', 'trim|required|callback_check_default');
			$this->form_validation->set_rules('pickup_date', 'Pickup Date', 'trim|required');
			$this->form_validation->set_rules('pickup_time', 'Pickup Time', 'trim|required');
			$this->form_validation->set_rules('drop_date', 'Drop Date', 'trim|required');
			$this->form_validation->set_rules('drop_time', 'Drop Time', 'trim|required');


			if ($this->form_validation->run() == FALSE){
			    $this->index();
			}else{
				if (!empty($_POST['return_to_pickup_location']) && $_POST['return_to_pickup_location'] == 1) {
					$_POST['drop_location'] = $_POST['pickup_location'];
				}

				
				$params = $_POST;
				
				$start_date = human_to_unix(date($this->config_manager->config['date_format']." H:i:s A", strtotime($this->input->post('pickup_date', TRUE)." " .$this->input->post('pickup_time', TRUE))));
				$end_date = human_to_unix(date($this->config_manager->config['date_format']." H:i:s A", strtotime($this->input->post('drop_date', TRUE)." " .$this->input->post('drop_time', TRUE))));

				if ($start_date > $end_date) {
					$c = $start_date;
					$start_date = $end_date;
					$end_date = $c;

					$c = $this->input->post('pickup_time', TRUE);
					$_POST['pickup_time'] = $_POST['drop_time'];
					$_POST['drop_time'] = $c;

					$c = $this->input->post('pickup_date', TRUE);
					$_POST['pickup_date'] = $_POST['drop_date'];
					$_POST['drop_date'] = $c;
				}


				$params['start_date'] = $start_date;

				$params['end_date'] = $end_date;

				$ids =  $this->Vehicle_model->get_not_availability_cars_ids($params, $this->config_manager->config['rent_interval']);

				$findQuery = "location_id=".$this->input->post('pickup_location', TRUE)." AND status = '1'";

				if (!empty($ids)) {		   
				$findQuery .= " AND vehicle_id NOT IN ('" . implode("','", $ids) . "')";
				}
				
				$vehicles = $this->Vehicle_model->get_available_cars($findQuery);


				foreach ($vehicles as $key => &$value) {
					$data['vehicle'][$key] = $value;
					$data['vehicle'][$key]->type     = $this->Vehicle_type_model->get_vehicle_type_by_id($value->vehicle_type_id);
					$data['vehicle'][$key]->location = $this->Locations_model->get_location_by_id($value->location_id);
					$data['vehicle'][$key]->prices   = $this->Vehicle_price_model->get_vehicle_prices_by_vehicle_id($value->vehicle_id, $params, $this->config_manager->config['calculate_type']);
					$data['vehicle'][$key]->daily    = $this->Vehicle_price_model->get_single_vehicle_price_by_vehicle_id($value->vehicle_id);
				}

				$data['css'] = array(
					$this->config->item('app_frontend_asset_root').'/css/animate.min.css',
					$this->config->item('app_frontend_asset_root').'/css/flatpickr.css',
					$this->config->item('app_frontend_asset_root').'/css/timepicker.css',
					$this->config->item('app_frontend_asset_root').'/css/jPages.css',
					$this->config->item('app_frontend_asset_root').'/css/list.css',

				);

				$data['js'] = array(
					$this->config->item('app_frontend_asset_root').'/js/jPages.js',
					$this->config->item('app_frontend_asset_root').'/js/flatpickr.js',
					$this->config->item('app_frontend_asset_root').'/js/timepicker.js',
					$this->config->item('app_frontend_asset_root').'/js/validate.js',
					$this->config->item('app_frontend_asset_root').'/js/app.js'
				);

				$data['cached_data'] = $params;

				$data["vehicle_type"]    = $this->Vehicle_type_model->get_vehicle_type();

				$data["locations"]    =   $this->Locations_model->get_locations();

				$datetime1 = new DateTime($this->input->post('pickup_date', TRUE)." " .$this->input->post('pickup_time', TRUE));

				$datetime2 = new DateTime($this->input->post('drop_date', TRUE)." " .$this->input->post('drop_time', TRUE));

				$pickup_location = $this->input->post('pickup_location', TRUE);

				if($this->input->post('drop_location', TRUE)){
					$drop_location = $this->input->post('drop_location', TRUE);
				}else{
					$drop_location = $this->input->post('pickup_location', TRUE);
				}

				$data['pickup_location'] = $this->Locations_model->get_location_by_id($pickup_location);

				$data['drop_location'] = $this->Locations_model->get_location_by_id($drop_location);

				$data['duration'] =  $datetime1->diff($datetime2);

				$data["navigation_class"]   =   "bg-white";

				$data["footer_bottom"]       =   FALSE;

				$this->load->view('header', $data);
				$this->load->view('search', $data);
				$this->load->view('footer', $data);
		   }

		}else{
			redirect('app', 'refresh');
		}
	}

	public function get_filter_vehicles(){
		if($this->input->is_ajax_request()){

			$params = $_POST;
			
			$start_date = human_to_unix(date($this->config_manager->config['date_format']." H:i:s A", strtotime($this->input->post('pickup_date', TRUE)." " .$this->input->post('pickup_time', TRUE))));
			$end_date = human_to_unix(date($this->config_manager->config['date_format']." H:i:s A", strtotime($this->input->post('drop_date', TRUE)." " .$this->input->post('drop_time', TRUE))));

			$params['start_date'] = $start_date;

			$params['end_date'] = $end_date;


			$ids =  $this->Vehicle_model->get_not_availability_cars_ids($params, $this->config_manager->config['rent_interval']);

			$findQuery = "location_id=".$this->input->post('pickup_location', TRUE)." AND status = '1'";

			if (!empty($ids)) {		   
			  $findQuery .= " AND vehicle_id NOT IN ('" . implode("','", $ids) . "')";
			}

			if (!empty($_POST['type']) && is_array($_POST['type'])) {
				$findQuery .= " AND vehicle_type_id  IN ('" . implode("','", $this->input->post('type', TRUE)) . "')";
			}

			
			if (!empty($_POST['transmission']) && is_array($_POST['transmission'])) {
				$findQuery .= " AND transmission  IN ('" . implode("','", $this->input->post('transmission', TRUE)) . "')";
			}

			if (!empty($_POST['passengers']) && is_array($_POST['passengers'])) {
				if (!empty($_POST['passengers'][5])) {
					$findQuery .= " AND passengers  IN ('" . implode("','", $this->input->post('passengers', TRUE)) . "') OR `passengers`> 5";
				} else {
					$findQuery .= " AND passengers  IN ('" . implode("','", $this->input->post('passengers', TRUE)) . "')";
				}
			}

			$vehicles = $this->Vehicle_model->get_available_filter_cars($findQuery);

			
			foreach ($vehicles as $key => &$value) {
				$data['vehicle'][$key] = $value;
				$data['vehicle'][$key]->type     = $this->Vehicle_type_model->get_vehicle_type_by_id($value->vehicle_type_id);
				$data['vehicle'][$key]->location = $this->Locations_model->get_location_by_id($value->location_id);
				$data['vehicle'][$key]->prices   = $this->Vehicle_price_model->get_vehicle_prices_by_vehicle_id($value->vehicle_id, $params, $this->config_manager->config['calculate_type']);
				$data['vehicle'][$key]->daily    = $this->Vehicle_price_model->get_single_vehicle_price_by_vehicle_id($value->vehicle_id);
			}


			$datetime1 = new DateTime($this->input->post('pickup_date', TRUE)." " .$this->input->post('pickup_time', TRUE));

            $datetime2 = new DateTime($this->input->post('drop_date', TRUE)." " .$this->input->post('drop_time', TRUE));

			$data['duration'] =  $datetime1->diff($datetime2);
			
			$data['cached_data'] = $params;

			$this->load->view('filter', $data);

            // if(isset($data['vehicle'])){
			// 	$this->load->view('filter', $data);
			// }else{
			// 	$data['vehicle'] = '';
			// 	$this->load->view('filter', $data);
			// }

			//$response  =  array('type' => 'success', 'message' =>  implode("','", $_POST['type']));
			//header("Content-type: application/json");	
			//echo json_encode($response);
		}else{
			$response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
			header("Content-type: application/json");	
			echo json_encode($response);
		}
	}

	public function booking_details(){

		$params = $_POST;

		$price_id   = $this->input->post('vehicle_selected_price', TRUE);

		$vehicle_id = $this->input->post('vehicle_id', TRUE);

		$pickup_location = $this->input->post('pickup_location', TRUE);

		if($this->input->post('drop_location', TRUE)){
			$drop_location = $this->input->post('drop_location', TRUE);
		}else{
			$drop_location = $this->input->post('pickup_location', TRUE);
		}

		$data["vehicle_price"]  =  $this->Vehicle_price_model->get_vehicle_prices_by_id($price_id);

		$data['css'] = array(
			$this->config->item('app_frontend_asset_root').'/css/animate.min.css',
			$this->config->item('app_frontend_asset_root').'/css/flatpickr.css',
			$this->config->item('app_frontend_asset_root').'/css/timepicker.css',
			$this->config->item('app_frontend_asset_root').'/css/slick.css',
			$this->config->item('app_frontend_asset_root').'/css/slick-theme.css',
			$this->config->item('app_frontend_asset_root').'/css/list.css',

		);

		$data['js'] = array(
			$this->config->item('app_frontend_asset_root').'/js/slick.js',
			$this->config->item('app_frontend_asset_root').'/js/flatpickr.js',
			$this->config->item('app_frontend_asset_root').'/js/timepicker.js',
			$this->config->item('app_frontend_asset_root').'/js/validate.js',
			$this->config->item('app_frontend_asset_root').'/js/app.js'
		);

		$datetime1 = new DateTime($this->input->post('pickup_date', TRUE)." " .$this->input->post('pickup_time', TRUE));

		$datetime2 = new DateTime($this->input->post('drop_date', TRUE)." " .$this->input->post('drop_time', TRUE));

		$data['duration'] =  $datetime1->diff($datetime2);

		$data['cached_data'] = $params;
		
		$data['pickup_location'] = $this->Locations_model->get_location_by_id($pickup_location);

		$data['drop_location'] = $this->Locations_model->get_location_by_id($drop_location);
		
		$data["navigation_class"]   =   "bg-white";

		$data["footer_bottom"]  =   FALSE;

		$data['vehicle'] = $this->Vehicle_model->get_vehicle_by_id($vehicle_id);

		$data['extra_options'] = $this->Extra_model->get_extra_by_vehicle_id($vehicle_id);

		$data["locations"]    =   $this->Locations_model->get_locations();

		$data["calculation"]  = $this->Vehicle_model->calclate_booking_price($params);

		$this->load->view('header', $data);
		$this->load->view('booking_details', $data);
		$this->load->view('footer', $data);
		
	}

	public function calculate_Price() {
		if($this->input->is_ajax_request()){
			$params = array();

			$params = $_POST;
				
			$price = $this->Vehicle_model->calclate_booking_Price(array_merge($params, $_POST));
			header("Content-Type: application/json", true);
			echo json_encode($price);
		}else{
			$response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
			header("Content-type: application/json");	
			echo json_encode($response);
		}
	}
	
	public function add_vehicle(){
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group("agent")){
			redirect('agent/add_vehicle');
        }else{
            $this->session->set_flashdata('message', "You must be an administrator to view this page");
            redirect('auth/login');
        }
	}

	public function pay(){
		if(isset($_POST['submit']) && !$this->input->is_ajax_request()){
			  $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
			  $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
			  $this->form_validation->set_rules('phone', 'Phone', 'trim|required|numeric');
			  $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			  $this->form_validation->set_rules('city', 'City', 'trim|required');
			  $this->form_validation->set_rules('postcode', 'Postcode', 'trim|required|numeric');
			  $this->form_validation->set_rules('address', 'Address', 'trim|required');
			  $this->form_validation->set_rules('gender', 'Gender', 'trim|required|callback_check_gender_default');

			  if ($this->form_validation->run() == FALSE){
				 $this->booking_details(); 
			  }else{
				if($this->input->post('payment_option', TRUE) == "offline"){

					$pickup_time = explode(':', $this->input->post('pickup_time', TRUE));
					$return_time = explode(':', $this->input->post('drop_time', TRUE));

					$params = $_POST;

					$booking_id = "BID" . random_string('numeric', 7);

					$vehicle_price = $this->Vehicle_model->calclate_booking_Price(array_merge($params, $_POST));

					$start_date = human_to_unix(date($this->config_manager->config['date_format']." H:i:s A", strtotime($this->input->post('pickup_date', TRUE)." " .$this->input->post('pickup_time', TRUE))));
					$end_date = human_to_unix(date($this->config_manager->config['date_format']." H:i:s A", strtotime($this->input->post('drop_date', TRUE)." " .$this->input->post('drop_time', TRUE))));
	
					$vehicle = $this->Vehicle_model->get_vehicle_by_id($this->security->xss_clean($this->input->post('vehicle_id', TRUE)));

					if($this->input->post('drop_location', TRUE)){
						$drop_location = $this->input->post('drop_location', TRUE);
					}else{
						$drop_location = $this->input->post('pickup_location', TRUE);
					}

					$form_data['vehicle_price'] =  $vehicle_price['car_price'];
					$data['amount']             = ($vehicle_price['deposit'] > 0) ? $vehicle_price['deposit'] : $vehicle_price['total'];
					$form_data['amount']        = number_format($data['amount'], 2, '.', '');
					$form_data['total']         = $vehicle_price['total'];
					$form_data['tax']           = $vehicle_price['tax'];
					$form_data['age_tax']       = $vehicle_price['age_tax'];
					$form_data['discount']      = $vehicle_price['discount'];
					$form_data['deposit']       = $vehicle_price['deposit'];
					$form_data['extra_price']   = $vehicle_price['extra_price'];


					$form_data['booking_number'] = $booking_id;
					$form_data['start_time']     = $start_date;
					$form_data['end_time']       = $end_date;
					$form_data['pickup_date']    = $start_date;
					$form_data['pickup_hour']    = $pickup_time[1];
					$form_data['pickup_minutes'] = $pickup_time[0];
					$form_data['return_date']    = $end_date;
					$form_data['return_hour']    = $return_time[0];
					$form_data['return_minutes'] = $return_time[1];
					$form_data['status']         = "pending";
					$form_data['vehicle_id']     = $this->input->post('vehicle_id', TRUE);
					$form_data['price_id']       = $this->input->post('vehicle_selected_price', TRUE);
					$form_data['pickup_mileage'] = $vehicle->mileage;
					$form_data['return_location_id'] = $drop_location;
					$form_data['pickup_location_id'] = $this->input->post('pickup_location', TRUE);
					$form_data['date']           = strtotime(date("Y-m-d"));

					$form_data['first_name']   = $this->input->post('first_name', TRUE);
					$form_data['second_name']   = $this->input->post('last_name', TRUE);
					$form_data['male']    = $this->input->post('gender', TRUE);
					$form_data['phone']    = $this->input->post('phone', TRUE);
					$form_data['email']    = $this->input->post('email', TRUE);
					if ($this->input->post('company_name')){
					   $form_data['company']  = $this->input->post('company_name', TRUE);
					}
					$form_data['city']  = $this->input->post('city', TRUE);
					$form_data['postcode']  = $this->input->post('postcode', TRUE);
					$form_data['address']  = $this->input->post('address', TRUE);
					$form_data['additional']  = $this->input->post('order_notes', TRUE);
					$form_data['payment_method']  = $this->input->post('payment_option', TRUE);
					$form_data['age']  = $this->input->post('driving_age', TRUE);

					$just_saved_id = $this->Booking_model->add_booking($form_data);

					if(!empty($just_saved_id)) {
						if (!empty($_POST['promo_code'])) {
							$sql = "SELECT * FROM `app_discount` WHERE `promo_code` = '".$this->security->xss_clean($this->input->post('promo_code', TRUE))."' AND '".$start_date."' BETWEEN `from_date` AND `to_date` AND dlimit >= '1'";
							$query = $this->db->query($sql);
							$discount_arr = $query->result();
			
							if (!empty($discount_arr)) {
			
								$discountid = $discount_arr[0]->discount_id;
								$form_data2['dlimit'] = $discount_arr[0]->limit - 1;
								$this->Discount_model->update_discount($discountid, $form_data2);
							}
						}
					}

					if (!empty($_POST['extra_id'])) {
					   $extra_price = $this->Vehicle_model->calclate_extra_prices($params);

					   foreach ($this->input->post('extra_id', TRUE) as $extra_id) {
						 $form_data3['extra_id'] = $extra_id;
						 $form_data3['vehicle_booking_id'] = $just_saved_id;
						 $form_data3['price'] = $extra_price[$extra_id];
							if (!empty($_POST['extra_value'][$extra_id])) {
								$form_data3['count'] = $_POST['extra_value'][$extra_id];
							}
						 $this->Booking_extra_model->add_booking_extra($form_data3);
					   }
					}	
					
					//send mail

					$data['css'] = array(
						$this->config->item('app_frontend_asset_root').'/css/animate.min.css',
						$this->config->item('app_frontend_asset_root').'/css/list.css'
			
					);
			
					$data['js'] = array(
						$this->config->item('app_frontend_asset_root').'/js/app.js'
					);
			
					$data["navigation_class"]    =   "bg-white";
					$data["footer_bottom"]       =   FALSE;
					$data["booking_id"]          =   $booking_id;
					$this->load->view('header', $data);
					$this->load->view('payment_success', $data);
					$this->load->view('footer', $data);

   
				 }elseif($this->input->post('payment_option', TRUE) == "paypal"){
					  echo "not imlimented";
				 }
			  }

		}else{
			redirect('app', 'refresh');
		}
	}

	public function register(){
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]', array('is_unique' => 'This %s already exists.'));
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', 'Password Confirm', 'required');
		if ($this->form_validation->run() == FALSE){
			$data['css'] = array(
				$this->config->item('app_frontend_asset_root').'/css/animate.min.css',
				$this->config->item('app_frontend_asset_root').'/css/authentication.css',
			);
			$this->load->view('register', $data);
		}else{

			$additional_data = [
				'first_name' => $this->input->post('first_name', TRUE),
				'last_name' => $this->input->post('last_name', TRUE)
			];

			$identity =  $this->input->post('email');

			$password = $this->input->post('password');

			$email = strtolower($this->input->post('email'));

			$this->ion_auth->register($identity, $password, $email, $additional_data);
			
            //TODO SEND Welcome mail
			$this->session->set_flashdata('message', $this->ion_auth->messages());

			redirect("auth", 'refresh');
		}

	}

	public function terms(){

		$data['js'] = array(
			$this->config->item('app_frontend_asset_root').'/js/wow.min.js',
			$this->config->item('app_frontend_asset_root').'/js/app.js'
		);

		$data["navigation_class"]    =   "bg-default";
		$data["footer_bottom"]       =   FALSE;
		$this->load->view('header', $data);
		$this->load->view('terms', $data);
		$this->load->view('footer', $data);
	}

	public function privacy_policy(){

		$data['js'] = array(
			$this->config->item('app_frontend_asset_root').'/js/wow.min.js',
			$this->config->item('app_frontend_asset_root').'/js/app.js'
		);

		$data["navigation_class"]    =   "bg-default";
		$data["footer_bottom"]       =   FALSE;
		$this->load->view('header', $data);
		$this->load->view('privacy_policy', $data);
		$this->load->view('footer', $data);
	}

	public function check_default($selection){
		if ($selection == '0'){
			$this->form_validation->set_message('check_default', 'Please Select A Location');
			return FALSE;
		}else{
			return TRUE;
		}
	}

	public function check_gender_default($selection){
		if ($selection == '0'){
			$this->form_validation->set_message('check_gender_default', 'Please Select Gender');
			return FALSE;
		}else{
			return TRUE;
		}
	}


}
