<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agent extends MY_Controller {

	protected $cached_data = array();

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library(array(
			'ion_auth',
			'form_validation',
			'session', 
			'email', 
			'hasher', 
			'component',
			'config_manager'
		));
		$this->load->helper(array('string','app_helper'));
		$this->config->load('app');
		$this->load->model(array(
			'Vehicle_type_model', 
			'Locations_model', 
			'Vehicle_model',
			'Vehicle_blocking_model',
			'Discount_model',
			'Vehicle_price_model',
			'Membership_model',
			'Extra_model',
			'Booking_model',
			'Booking_extra_model'
		));
		$this->lang->load('auth');
		$this->access_level_verifier();
		$this->form_validation->set_error_delimiters('<div class="alert alert-warning" role="alert">', '</div>');
    }

    public function index(){
		$data['css'] = array(
			$this->config->item('app_frontend_asset_root').'/css/animate.min.css',
			$this->config->item('app_frontend_asset_root').'/css/dashboard.css',
			$this->config->item('app_frontend_asset_root').'/css/list.css',

		);

		$data['js'] = array(
			$this->config->item('app_frontend_asset_root').'/js/raphael.min.js',
			$this->config->item('app_frontend_asset_root').'/js/morris.min.js',
			$this->config->item('app_frontend_asset_root').'/js/agent.js',
			$this->config->item('app_frontend_asset_root').'/js/app.js'
		);

		$user = $this->ion_auth->user()->row();

		$data['numberofvehicles'] = $this->Vehicle_model->get_total_vehicles_by_user($user->id);

		$data['numberofbooking'] = $this->Vehicle_model->get_total_booking($user->id);

		$data['current_month_earning'] = $this->Vehicle_model->get_current_month_earning($user->id);
		
		$data['current_year_earning'] = $this->Vehicle_model->get_current_year_earning($user->id);

		$data["navigation_class"]   =   "bg-white";
		$data["footer_bottom"]       =   FALSE;
		
		$this->load->view('agent/header', $data);
		$this->load->view('agent/dashboard', $data);
		$this->load->view('agent/footer', $data);
    }
	
	public function listing(){
		$data['css'] = array(
			$this->config->item('app_backend_asset_root').'/css/dataTables.bootstrap4.css',
			$this->config->item('app_backend_asset_root').'/css/responsive.dataTables.css',
			$this->config->item('app_backend_asset_root').'/css/datatables.css',
			$this->config->item('app_frontend_asset_root').'/css/dialog.css',
			$this->config->item('app_frontend_asset_root').'/css/animate.min.css',
			$this->config->item('app_frontend_asset_root').'/css/dashboard.css'
		);

		$data['js'] = array(
			$this->config->item('app_backend_asset_root').'/js/jquery.dataTables.js',
			$this->config->item('app_backend_asset_root').'/js/dataTables.bootstrap4.js',
			$this->config->item('app_backend_asset_root').'/js/responsive.dataTables.js',
			$this->config->item('app_backend_asset_root').'/js/datatables.js',
			$this->config->item('app_frontend_asset_root').'/js/dialog.js',
			$this->config->item('app_frontend_asset_root').'/js/app.js',
			$this->config->item('app_frontend_asset_root').'/js/agent.js'
		);

		$user = $this->ion_auth->user()->row();

		$data["navigation_class"]   =   "bg-white";
		$data["footer_bottom"]       =   FALSE;

		$vehicles  =  $this->Vehicle_model->get_vehicles(array("vehicles.user_id" => $user->id));


		foreach ($vehicles as $key => &$value) {
			$data['vehicles'][$key] = $value;
			$data['vehicles'][$key]->type     = $this->Vehicle_type_model->get_vehicle_type_by_id($value->vehicle_type_id);
		}


		$this->load->view('agent/header', $data);
		$this->load->view('agent/listing', $data);
		$this->load->view('agent/footer', $data);
	}

	public function add_vehicle(){

		$user = $this->ion_auth->user()->row();

		$listing_count = $this->Vehicle_model->get_current_month_vehicle_listing($user->id);

		$user_current_membership = $this->Membership_model->get_membership_by_id($user->membership_id);

		if($user_current_membership->limitation > $listing_count){
			$this->form_validation->set_rules('location', 'Location', 'trim|required|callback_check_default');
			$this->form_validation->set_rules('type', 'Type', 'trim|required|callback_check_default');
			$this->form_validation->set_rules('year', 'Year', 'trim|required|min_length[4]');
			$this->form_validation->set_rules('registration_number', 'Registration Number', 'trim|required|is_unique[vehicles.registration_number]',  array('is_unique' => 'This %s already exists.'));
			$this->form_validation->set_rules('mileage', 'Mileage', 'trim|required');
			$this->form_validation->set_rules('fuel', 'Fuel', 'trim|required|callback_check_default');
			$this->form_validation->set_rules('passengers', 'Passengers', 'trim|required');
			$this->form_validation->set_rules('bags', 'Bags', 'trim|required');
			$this->form_validation->set_rules('doors', 'Doors', 'trim|required');
			$this->form_validation->set_rules('transmission', 'Transmission', 'trim|required|callback_check_default');
			$this->form_validation->set_rules('make', 'Make', 'trim|required');
			$this->form_validation->set_rules('model', 'Model', 'trim|required');
			$this->form_validation->set_rules('description', 'Description', 'trim|required');
			$this->form_validation->set_rules('image', 'Image', 'callback_vehicle_multiple_image_check');
			$this->form_validation->set_rules('price_per_day', 'Per Day', 'trim|required|numeric');
			$this->form_validation->set_rules('price_per_hour', 'Per Hour', 'trim|required|numeric');
			$this->form_validation->set_rules('limit_mileage', 'Limit Mileage', 'trim|required|numeric');
			$this->form_validation->set_rules('extra_mileage_price', 'Extra Mileage Price', 'trim|required|numeric');
			$this->form_validation->set_rules('extra_hour_price', 'Extra hour Price', 'trim|required|numeric');

			if ($this->form_validation->run() == FALSE){
				$data['css'] = array(
					$this->config->item('app_backend_asset_root').'/css/awesome-bootstrap-checkbox.css',
					$this->config->item('app_backend_asset_root').'/css/select2.css',
					$this->config->item('app_frontend_asset_root').'/css/dashboard.css'
				);

				$data['js'] = array(
					$this->config->item('app_backend_asset_root').'/js/select2.js',
					$this->config->item('app_frontend_asset_root').'/js/app.js',
					$this->config->item('app_frontend_asset_root').'/js/agent.js'
				);

				$data["locations"]       = $this->Locations_model->get_locations();
				$data["vehicle_type"]    = $this->Vehicle_type_model->get_vehicle_type();

				$data["navigation_class"]   =   "bg-white";

				$data["footer_bottom"]       =   FALSE;

				$this->load->view('agent/header', $data);
				$this->load->view('agent/add_vehicle', $data);
				$this->load->view('agent/footer', $data);
			}else{
				$images = implode(',',$this->cached_data); 
				
				$form_data['vehicle_type_id'] = $this->input->post('type', TRUE);
				$form_data['user_id'] = $user->id;
				$form_data['year'] = $this->input->post('year', TRUE);
				$form_data['make'] = $this->input->post('make', TRUE);
				$form_data['model'] = $this->input->post('model', TRUE);
				$form_data['registration_number'] = $this->input->post('registration_number', TRUE);
				$form_data['mileage'] = $this->input->post('mileage', TRUE);
				$form_data['fuel'] = $this->input->post('fuel', TRUE);
				$form_data['description'] = $this->input->post('description', TRUE);
				$form_data['location_id'] = $this->input->post('location', TRUE);
				$form_data['passengers'] = $this->input->post('passengers', TRUE);
				$form_data['bags'] = $this->input->post('bags', TRUE);
				$form_data['doors'] = $this->input->post('doors', TRUE);
				$form_data['transmission'] = $this->input->post('transmission', TRUE);
				$form_data['air_conditioning'] = $this->input->post('aircon', TRUE);
				$form_data['images'] = $images;

				$form_data2['type_id']             = $this->input->post('type', TRUE);
				$form_data2['price_per_day']       = $this->input->post('price_per_day', TRUE);
				$form_data2['price_per_hour']      = $this->input->post('price_per_hour', TRUE);
				$form_data2['limit_mileage']       = $this->input->post('limit_mileage', TRUE);
				$form_data2['extra_mileage_price'] = $this->input->post('extra_mileage_price', TRUE);
				$form_data2['extra_hour_price']    = $this->input->post('extra_hour_price', TRUE);

				$this->Vehicle_model->add_vehicles($form_data, $form_data2);
				$this->session->set_flashdata('success', "Vehicle has been added successfully!");
				redirect('agent/listing', 'refresh');
			}
		}else{
			$this->session->set_flashdata('danger', "You have exeeded your listing. please upgrade you subscription");
			redirect('agent/subscription', 'refresh');
		}

	}

	public function update_vehicle($vehicle_id){
		$data['css'] = array(
			$this->config->item('app_frontend_asset_root').'/css/dashboard.css',
			$this->config->item('app_backend_asset_root').'/css/uploader.css',
			$this->config->item('app_frontend_asset_root').'/css/dialog.css',
			$this->config->item('app_backend_asset_root').'/css/awesome-bootstrap-checkbox.css'
		);

		$data['js'] = array(
			$this->config->item('app_frontend_asset_root').'/js/dialog.js',
			$this->config->item('app_frontend_asset_root').'/js/app.js',
			$this->config->item('app_frontend_asset_root').'/js/agent.js'
		);

		$data['vehicle']          =   $this->Vehicle_model->get_vehicle_by_id($this->hasher->decrypt($vehicle_id));
		$data["locations"]        =   $this->Locations_model->get_locations();
		$data["vehicle_type"]     =   $this->Vehicle_type_model->get_vehicle_type();

		$data["navigation_class"]   =   "bg-white";
		$data["footer_bottom"]       =   FALSE;

		$this->load->view('agent/header', $data);
		$this->load->view('agent/update_vehicle', $data);
		$this->load->view('agent/footer', $data);
	}

	public function delete_vehicle_images(){
		if($this->input->is_ajax_request()){
			$vehicle_id     = $this->hasher->decrypt($this->input->post('vehicle_id', TRUE));
			$vehicle_image  = $this->input->post('vehicle_image', TRUE);
			$stored_images  = $this->Vehicle_model->get_images_by_vehicle_id($vehicle_id);
			$multiple_image_array = explode(',',$stored_images->images);
			$key = array_search($vehicle_image, $multiple_image_array);
			if(!empty($key)){
				unset($multiple_image_array[$key]);
				if (file_exists('./frontend/images/vehicles/'.$vehicle_image)){
					unlink('./frontend/images/vehicles/'.$vehicle_image);
				}
				$updated_image_array = implode(',',$multiple_image_array);
				$form_data['images'] =  $updated_image_array;
				$this->Vehicle_model->update_vehicle($vehicle_id, $form_data);
				$response  =  array('type' => 'success', 'message' =>  "Image has been deleted successfully");
				header("Content-type: application/json");	
				echo json_encode($response);
			}
		}else{
			$response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
			header("Content-type: application/json");	
			echo json_encode($response);
		}
	}

	public function save_vehicle(){
		$this->form_validation->set_rules('location', 'Location', 'trim|required|callback_check_default');
		$this->form_validation->set_rules('type', 'Type', 'trim|required|callback_check_default');
		$this->form_validation->set_rules('year', 'Year', 'trim|required|min_length[4]');
		$this->form_validation->set_rules('registration_number', 'Registration Number', 'trim|required');
		$this->form_validation->set_rules('mileage', 'Mileage', 'trim|required');
		$this->form_validation->set_rules('fuel', 'Fuel', 'trim|required|callback_check_default');
		$this->form_validation->set_rules('passengers', 'Passengers', 'trim|required');
		$this->form_validation->set_rules('bags', 'Bags', 'trim|required');
		$this->form_validation->set_rules('doors', 'Doors', 'trim|required');
		$this->form_validation->set_rules('transmission', 'Transmission', 'trim|required|callback_check_default');
		$this->form_validation->set_rules('make', 'Make', 'trim|required');
		$this->form_validation->set_rules('model', 'Model', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
		$this->form_validation->set_rules('image', 'Image', 'callback_update_vehicle_multiple_image_check');

		$vehicle_id = $this->input->post('vehicle_id', TRUE);

		if ($this->form_validation->run() == FALSE){
			$this->update_vehicle($vehicle_id);
		}else{
			 if(!empty($this->cached_data)){
				$images = $this->Vehicle_model->update_images($this->hasher->decrypt($vehicle_id), $this->cached_data);
				$form_data['images'] = $images;
			 }

			$form_data['vehicle_type_id'] = $this->input->post('type', TRUE);
			$form_data['year'] = $this->input->post('year', TRUE);
			$form_data['make'] = $this->input->post('make', TRUE);
			$form_data['model'] = $this->input->post('model', TRUE);
			$form_data['registration_number'] = $this->input->post('registration_number', TRUE);
			$form_data['mileage'] = $this->input->post('mileage', TRUE);
			$form_data['fuel'] = $this->input->post('fuel', TRUE);
			$form_data['description'] = $this->input->post('description', TRUE);
			$form_data['location_id'] = $this->input->post('location', TRUE);
			$form_data['passengers'] = $this->input->post('passengers', TRUE);
			$form_data['bags'] = $this->input->post('bags', TRUE);
			$form_data['doors'] = $this->input->post('doors', TRUE);
			$form_data['transmission'] = $this->input->post('transmission', TRUE);
			$form_data['air_conditioning'] = $this->input->post('aircon', TRUE);
			$this->Vehicle_model->update_vehicle($this->hasher->decrypt($vehicle_id), $form_data);
			$this->session->set_flashdata('success', "Vehicle has been updated successfully");
            redirect('agent/listing', 'refresh');
		}
	}

    public function delete_vehicle(){
		if($this->input->is_ajax_request()){
			$vehicle_id  =  $this->hasher->decrypt($this->input->post('vehicle_id', TRUE));
			$images_array = $this->Vehicle_model->get_current_vehicle_images($vehicle_id);
			foreach($images_array as $value){
				$value = trim($value);
				if (file_exists('./frontend/images/vehicles/'.$value)){
					unlink('./frontend/images/vehicles/'.$value);
				}
			}

			$this->Vehicle_price_model->delete_vehicle_price_by_vehicle_id($vehicle_id);

			$this->Vehicle_model->delete_vehicle($vehicle_id);

			$response  =  array('type' => 'success', 'message' =>  "Vehicle has been deleted successfully");
			header("Content-type: application/json");	
			echo json_encode($response);
		}else{
			$response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
			header("Content-type: application/json");	
			echo json_encode($response);
		}
	}

	public function vehicle_price($vehicle_id){
		$data['css'] = array(
			$this->config->item('app_backend_asset_root').'/css/dataTables.bootstrap4.css',
			$this->config->item('app_backend_asset_root').'/css/responsive.dataTables.css',
			$this->config->item('app_backend_asset_root').'/css/datatables.css',
			$this->config->item('app_frontend_asset_root').'/css/dialog.css',
			$this->config->item('app_frontend_asset_root').'/css/animate.min.css',
			$this->config->item('app_frontend_asset_root').'/css/dashboard.css'
		);

		$data['js'] = array(
			$this->config->item('app_backend_asset_root').'/js/jquery.dataTables.js',
			$this->config->item('app_backend_asset_root').'/js/dataTables.bootstrap4.js',
			$this->config->item('app_backend_asset_root').'/js/responsive.dataTables.js',
			$this->config->item('app_backend_asset_root').'/js/datatables.js',
			$this->config->item('app_frontend_asset_root').'/js/dialog.js',
			$this->config->item('app_frontend_asset_root').'/js/app.js',
			$this->config->item('app_frontend_asset_root').'/js/agent.js'
		);

		$data['vehicle']  =   $this->Vehicle_model->get_vehicle_by_id($this->hasher->decrypt($vehicle_id));
		$data['prices']   =   $this->Vehicle_price_model->get_vehicle_price_by_vehicle_id($this->hasher->decrypt($vehicle_id));
		$data['vehicle_type']  = $this->Vehicle_type_model->get_vehicle_type_by_id($data['vehicle']->vehicle_type_id);

		$data["navigation_class"]   =   "bg-white";
		$data["footer_bottom"]       =   FALSE;

		$data['vehicle_id'] = $vehicle_id;

		$data['vehicle_type_id'] = $data['vehicle_type']->vehicle_type_id;

		$this->load->view('agent/header', $data);
		$this->load->view('agent/vehicle_price', $data);
		$this->load->view('agent/footer', $data);
		 
	}

	public function update_vehicle_price($price_plan_id){
		$data['css'] = array(
			$this->config->item('app_frontend_asset_root').'/css/dialog.css',
			$this->config->item('app_frontend_asset_root').'/css/animate.min.css',
			$this->config->item('app_frontend_asset_root').'/css/dashboard.css'
		);

		$data['js'] = array(
			$this->config->item('app_frontend_asset_root').'/js/dialog.js',
			$this->config->item('app_frontend_asset_root').'/js/app.js',
			$this->config->item('app_frontend_asset_root').'/js/agent.js'
		);


		$data["vehicle_price"]  =  $this->Vehicle_price_model->get_vehicle_prices_by_id($this->hasher->decrypt($price_plan_id));

		$data["navigation_class"]   =   "bg-white";

		$data["footer_bottom"]       =   FALSE;

		$this->load->view('agent/header', $data);
		$this->load->view('agent/update_price_plan', $data);
		$this->load->view('agent/footer', $data);
	}

	public function save_price_plan(){

		$price_plan_id    = $this->input->post('id', TRUE);

		$vehicle_id    = $this->input->post('vehicle_id', TRUE);

		$this->form_validation->set_rules('price_per_day', 'Price Per Day', 'trim|required');
		$this->form_validation->set_rules('price_per_hour', 'Price Per Hour', 'trim|required');
		$this->form_validation->set_rules('limit_mileage', 'Limit Mileage', 'trim|required');
		$this->form_validation->set_rules('price_for_extra_mileage', 'Price for extra mileage', 'trim|required');
		$this->form_validation->set_rules('extra_hour_price', 'Extra hour price', 'trim|required');

		if ($this->form_validation->run() == FALSE){
            $this->update_vehicle_price($price_plan_id);
		}else{
			$form_data['price_per_day']             = $this->input->post('price_per_day', TRUE);
			$form_data['price_per_hour']            = $this->input->post('price_per_hour', TRUE);
			$form_data['limit_mileage']             = $this->input->post('limit_mileage', TRUE);
			$form_data['extra_mileage_price']       = $this->input->post('price_for_extra_mileage', TRUE);
			$form_data['extra_hour_price']          = $this->input->post('extra_hour_price', TRUE);

			$this->Vehicle_price_model->update_vehicle_prices($this->hasher->decrypt($price_plan_id), $form_data);

			$this->session->set_flashdata('success', "Vehicle Price has been updated successfully");
			
            redirect('agent/vehicle_price/'.$vehicle_id, 'refresh');
		}
	}
	
	public function add_vehicle_price(){
		if($this->input->is_ajax_request()){

			$form_data['title']                     = $this->input->post('title', TRUE);
			$form_data['description']               = $this->input->post('description', TRUE);
			$form_data['price_per_day']             = $this->input->post('price_per_day', TRUE);
			$form_data['price_per_hour']            = $this->input->post('price_per_hour', TRUE);
			$form_data['limit_mileage']             = $this->input->post('limit_mileage', TRUE);
			$form_data['extra_mileage_price']       = $this->input->post('price_for_extra_mileage', TRUE);
			$form_data['extra_hour_price']          = $this->input->post('extra_hour_price', TRUE);
			$form_data['type_id']                   = $this->hasher->decrypt($this->input->post('vehicle_type_id', TRUE));
			$form_data['vehicle_id']                = $this->hasher->decrypt($this->input->post('vehicle_id', TRUE));

			$this->Vehicle_price_model->add_vehicle_prices($form_data);

			$response  =  array('type' => 'success', 'message' =>  "Price has been added successfully");
			header("Content-type: application/json");	
			echo json_encode($response);
		}else{
			$response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
			header("Content-type: application/json");	
			echo json_encode($response);
		}
	}
	
	public function delete_vehicle_price(){
		if($this->input->is_ajax_request()){
		   $price_plan_id  =  $this->hasher->decrypt($this->input->post('price_id', TRUE));
		   $this->Vehicle_price_model->delete_price_plan($price_plan_id);
		   $response  =  array('type' => 'success', 'message' =>  "Price plan has been deleted successfully");
		   header("Content-type: application/json");	
		   echo json_encode($response);
		}else{
			$response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
			header("Content-type: application/json");	
			echo json_encode($response);
		}
	}

	public function subscription(){
		$data['css'] = array(
			$this->config->item('app_frontend_asset_root').'/css/dashboard.css'
		);

		$data['js'] = array(
			$this->config->item('app_frontend_asset_root').'/js/app.js',
			$this->config->item('app_frontend_asset_root').'/js/agent.js'
		);

		$user = $this->ion_auth->user()->row();

		$data["memberships"]          = $this->Membership_model->get_membership();

		$data["navigation_class"]     =   "bg-white";

		$data["footer_bottom"]        =   FALSE;

		$data["user_membership_id"]   =   $user->membership_id;

		$this->load->view('agent/header', $data);
		$this->load->view('agent/subscription', $data);
		$this->load->view('agent/footer', $data);
	}

	public function vehicle_extra_options($vehicle_id){

		$data['css'] = array(
			$this->config->item('app_backend_asset_root').'/css/dataTables.bootstrap4.css',
			$this->config->item('app_backend_asset_root').'/css/responsive.dataTables.css',
			$this->config->item('app_backend_asset_root').'/css/datatables.css',
			$this->config->item('app_frontend_asset_root').'/css/dialog.css',
			$this->config->item('app_frontend_asset_root').'/css/animate.min.css',
			$this->config->item('app_frontend_asset_root').'/css/dashboard.css'
		);

		$data['js'] = array(
			$this->config->item('app_backend_asset_root').'/js/jquery.dataTables.js',
			$this->config->item('app_backend_asset_root').'/js/dataTables.bootstrap4.js',
			$this->config->item('app_backend_asset_root').'/js/responsive.dataTables.js',
			$this->config->item('app_backend_asset_root').'/js/datatables.js',
			$this->config->item('app_frontend_asset_root').'/js/dialog.js',
			$this->config->item('app_frontend_asset_root').'/js/app.js',
			$this->config->item('app_frontend_asset_root').'/js/agent.js'
		);

		$data["navigation_class"]   =   "bg-white";

		$data["footer_bottom"]       =   FALSE;

		$data["vehicle_id"]         =   $vehicle_id;

		$data['extra_options']  =  $this->Extra_model->get_extra_by_vehicle_id($this->hasher->decrypt($vehicle_id));

		$data['vehicle']        =   $this->Vehicle_model->get_vehicle_by_id($this->hasher->decrypt($vehicle_id));

		$this->load->view('agent/header', $data);
		$this->load->view('agent/vehicle_extra_options', $data);
		$this->load->view('agent/footer', $data);

	}

	public function add_extra_options(){
		if($this->input->is_ajax_request()){
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
	    	$this->form_validation->set_rules('description', 'Description', 'trim|required');
			$this->form_validation->set_rules('price', 'Price', 'trim|required');

			if ($this->form_validation->run() == FALSE){
				$response  =  array('type' => 'validation', 'message' =>  $this->form_validation->error_array());	
				header("Content-type: application/json");	
				echo json_encode($response);
			}else{
				$form_data['title']           = $this->input->post('title', TRUE);
				$form_data['description']     = $this->input->post('description', TRUE);
				$form_data['price']           = $this->input->post('price', TRUE);
				$form_data['calculate']       = $this->input->post('calculate', TRUE);
				$form_data['type']            = $this->input->post('type', TRUE);

				$extra_id = $this->Extra_model->add_extra($form_data);

				$form_data2['vehicle_id']   = $this->hasher->decrypt($this->input->post('vehicle_id', TRUE));
				$form_data2['extra_id']     = $extra_id;
				$this->Extra_model->add_extra_relation($form_data2);

				$response  =  array('type' => 'success', 'message' =>  "Extra option has been added successfully");
				header("Content-type: application/json");	
				echo json_encode($response);

			}
			
		}else{
			$response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
            header("Content-type: application/json");	
            echo json_encode($response);
		}
	}

	public function update_extra_options($extra_id){

		$data['vehicles']        = $this->Vehicle_model->get_vehicles(array('vehicles.status' => "1"));
		$data['extra']           = $this->Extra_model->get_extra_by_id($this->hasher->decrypt($extra_id));
		$data['extra_relation']  = $this->Extra_model->get_extra_relations($this->hasher->decrypt($extra_id));


		foreach ($data['extra_relation'] as $key => $value) {
			$data['vehicle_id'][$value->vehicle_id] = $value;
		}
		
		$data['css'] = array(
			$this->config->item('app_backend_asset_root').'/css/awesome-bootstrap-checkbox.css',
			$this->config->item('app_backend_asset_root').'/css/select2.css',
			$this->config->item('app_frontend_asset_root').'/css/dashboard.css'
		);

		$data['js'] = array(
			$this->config->item('app_backend_asset_root').'/js/select2.js',
			$this->config->item('app_frontend_asset_root').'/js/app.js',
			$this->config->item('app_frontend_asset_root').'/js/agent.js'
		);


		$data["navigation_class"]   =   "bg-white";

		$data["footer_bottom"]       =   FALSE;
		
		$this->load->view('agent/header', $data);
		$this->load->view('agent/update_extra_options', $data);
		$this->load->view('agent/footer', $data);

	}

	public function save_extra_options(){

		$extra_id = $this->input->post('id', TRUE);

		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
		$this->form_validation->set_rules('price', 'Price', 'trim|required');

		if ($this->form_validation->run() == FALSE){
			$this->update_extra_options($extra_id);
		}else{
			$form_data['title']           = $this->input->post('title', TRUE);
			$form_data['description']     = $this->input->post('description', TRUE);
			$form_data['price']           = $this->input->post('price', TRUE);
			$form_data['calculate']       = $this->input->post('calculate', TRUE);
			$form_data['type']            = $this->input->post('type', TRUE);

			$this->Extra_model->update_extra($this->hasher->decrypt($extra_id), $form_data);

			$this->Extra_model->delete_extra_relation($this->hasher->decrypt($extra_id));

			foreach($this->input->post('vehicles', TRUE) as $vehicle){
				$form_data2['vehicle_id']   = $vehicle;
				$form_data2['extra_id']     = $this->hasher->decrypt($extra_id);
				$this->Extra_model->add_extra_relation($form_data2);
			}

			$this->session->set_flashdata('success', "Extra option has been updated successfully");
            redirect('agent/listing/', 'refresh');

		}

	}

	public function delete_extra(){
		if($this->input->is_ajax_request()){
			$extra_id   = $this->hasher->decrypt($this->input->post('extra_id', TRUE));
			$this->Extra_model->delete_extra($extra_id);
			$response  =  array('type' => 'success', 'message' =>  "Extra option has been deleted successfully");
            header("Content-type: application/json");	
            echo json_encode($response);
		}else{
			$response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
            header("Content-type: application/json");	
            echo json_encode($response);
		}
	}

	public function profile(){
		$data['css'] = array(
			$this->config->item('app_frontend_asset_root').'/css/dashboard.css'
		);

		$data['js'] = array(
			$this->config->item('app_frontend_asset_root').'/js/app.js',
			$this->config->item('app_frontend_asset_root').'/js/agent.js'
		);

		$data['user'] = $this->ion_auth->user()->row();

		$data["navigation_class"]     =   "bg-white";

		$data["footer_bottom"]        =   FALSE;

		$this->load->view('agent/header', $data);
		$this->load->view('agent/update_profile', $data);
		$this->load->view('agent/footer', $data);
	}

	public function save_profile(){

		$id = $this->input->post('id', TRUE);

		$user = $this->ion_auth->user($id)->row();

		$this->form_validation->set_rules('first_name', 'First name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last name', 'trim|required');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required');

		if ($user->id != $this->input->post('id')){
			redirect('auth/logout', 'refresh');
		}

		if ($this->input->post('password')){
			$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[password_confirm]');
			$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
		}

		if ($this->form_validation->run() == FALSE){
			$this->profile();
		}else{
			if($_FILES['image']['name'] != ""){
                $config['upload_path']          = './frontend/images/profile/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                $config['encrypt_name']         = TRUE;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if(!$this->upload->do_upload('image')){
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    $this->profile();
                }else{
                    $this->db->where('id', $id);
                    $result = $this->db->get('users');
                    $image = $result->row()->avatar;
                    if (file_exists('./frontend/images/profile/'.$image)){
                       if($image != "default.png"){
                          unlink('./frontend/images/profile/'.$image);
                        }
                    }

					$form_data['first_name']   = $this->input->post('first_name', TRUE);
					$form_data['last_name']    = $this->input->post('last_name', TRUE);
					$form_data['phone']        = $this->input->post('phone', TRUE);
					$form_data['avatar']       =  $this->upload->data()['file_name'];

					if ($this->input->post('password')){
						$form_data['password']  = $this->input->post('password', TRUE);
					}

					$this->ion_auth->update($user->id, $form_data);
					
					$this->session->set_flashdata('success', "Profile has been updated successfully");
					
					redirect('agent/profile/', 'refresh');

				}
				
			}else{
				$form_data['first_name']   = $this->input->post('first_name', TRUE);
				$form_data['last_name']    = $this->input->post('last_name', TRUE);
				$form_data['phone']        = $this->input->post('phone', TRUE);

				if ($this->input->post('password')){
					$form_data['password']  = $this->input->post('password', TRUE);
				}

				$this->ion_auth->update($user->id, $form_data);
				
				$this->session->set_flashdata('success', "Profile has been updated successfully");
				
				redirect('agent/profile/', 'refresh');
			}
                
		}

	}

	public function booking(){
		$data['css'] = array(
			$this->config->item('app_backend_asset_root').'/css/dataTables.bootstrap4.css',
			$this->config->item('app_backend_asset_root').'/css/responsive.dataTables.css',
			$this->config->item('app_backend_asset_root').'/css/datatables.css',
			$this->config->item('app_frontend_asset_root').'/css/dialog.css',
			$this->config->item('app_frontend_asset_root').'/css/animate.min.css',
			$this->config->item('app_frontend_asset_root').'/css/dashboard.css'
		);

		$data['js'] = array(
			$this->config->item('app_backend_asset_root').'/js/jquery.dataTables.js',
			$this->config->item('app_backend_asset_root').'/js/dataTables.bootstrap4.js',
			$this->config->item('app_backend_asset_root').'/js/responsive.dataTables.js',
			$this->config->item('app_backend_asset_root').'/js/datatables.js',
			$this->config->item('app_frontend_asset_root').'/js/dialog.js',
			$this->config->item('app_frontend_asset_root').'/js/app.js',
			$this->config->item('app_frontend_asset_root').'/js/agent.js'
		);

		$user = $this->ion_auth->user()->row();

		$data["navigation_class"]   =   "bg-white";
		$data["footer_bottom"]       =   FALSE;

		$vehicles = $this->Vehicle_model->get_booking_by_user($user->id);

		foreach ($vehicles as $key => &$value) {
			$data['booking'][$key] = $value;
			$data['booking'][$key]->vehicle_details =  $this->Vehicle_model->get_vehicle_by_id($value->vehicle_id);
			$data['booking'][$key]->pickup_location = $this->Locations_model->get_location_by_id($value->pickup_location_id);
			$data['booking'][$key]->drop_location = $this->Locations_model->get_location_by_id($value->return_location_id);
		}

		$this->load->view('agent/header', $data);
		$this->load->view('agent/booking', $data);
		$this->load->view('agent/footer', $data);
	}

	public function booking_details($vehicle_booking_id){
		$data['booking_details'] = $this->Booking_model->get_booking_by_id($this->hasher->decrypt($vehicle_booking_id));
		$data['pickup_location'] = $this->Locations_model->get_location_by_id($data['booking_details']->pickup_location_id);
		$data['drop_location']   = $this->Locations_model->get_location_by_id($data['booking_details']->return_location_id);
		$data['vehicle_details'] = $this->Vehicle_model->get_vehicle_by_id($data['booking_details']->vehicle_id);
		$booking_extra           = $this->Booking_extra_model->get_booking_by_id($this->hasher->decrypt($vehicle_booking_id));

		$data['booking_extra'] = array();

		foreach ($booking_extra as $key => $value) {
			  $data['booking_extra'][$value->extra_id] = $value;
		}

		$vehicle_extra_array = $this->Extra_model->get_extra_by_vehicle_id($data['booking_details']->vehicle_id);

		foreach ($vehicle_extra_array as $key => $value) {
			$data['extra_c'][$key] = $value->extra_id;
		}

		$prep_string_2 = implode(',', $data['extra_c']);

		$sql2 = "SELECT * FROM `app_extra` WHERE extra_id IN ($prep_string_2)";

		$query2 = $this->db->query($sql2);

		$data['extras'] = $query2->result();

		// foreach ($this->tpl['extras'] as $extra) {
		// 	echo !empty($this->tpl['booking_extra']) && array_key_exists($extra->extra_id, $this->tpl['booking_extra']) ? 'checked=checked' : '';
		// 	echo !empty($this->tpl['booking_extra']) && array_key_exists($extra->extra_id, $this->tpl['booking_extra']) ? $extra->extra_id : '';

		// }

		$data['css'] = array(
			$this->config->item('app_frontend_asset_root').'/css/dashboard.css'
		);

		$data['js'] = array(
			$this->config->item('app_frontend_asset_root').'/js/app.js',
			$this->config->item('app_frontend_asset_root').'/js/agent.js'
		);


		$data["navigation_class"]     =   "bg-white";

		$data["footer_bottom"]        =   FALSE;

		$this->load->view('agent/header', $data);
		$this->load->view('agent/booking_details', $data);
		$this->load->view('agent/footer', $data);


	}

	public function update_booking(){
		if($this->input->is_ajax_request()){
			$vehicle_booking_id   = $this->hasher->decrypt($this->input->post('vehicle_booking_id', TRUE));
			$current_status = $this->Booking_model->get_booking_status($vehicle_booking_id);
			if($current_status == "pending"){
			   $form_data['status'] = "confirmed";
			   //TO DO send confirm mail
			}else{
			   $form_data['status'] = "pending";
			}
			$this->Booking_model->update_booking_status($vehicle_booking_id, $form_data);
			$response  =  array('type' => 'success', 'message' =>  "Booking status has been updated successfully");
            header("Content-type: application/json");	
            echo json_encode($response);
		}else{
			$response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
            header("Content-type: application/json");	
            echo json_encode($response);
		}
	}

	public function get_earning_weekly_report(){
		if($this->input->is_ajax_request()){

			$user = $this->ion_auth->user()->row();

			$data['weekdata']	=	array();
			$weekstart	=	date("Y-m-d", strtotime("- 6 DAYS"));
			$wbegin = new DateTime($weekstart);
			$wend = new DateTime(date('Y-m-d', strtotime("+ 1 DAYS")));
			$winterval = DateInterval::createFromDateString('1 day');
			$wperiod = new DatePeriod($wbegin, $winterval, $wend);
			$i=0;

			foreach($wperiod as $dt){
				$date		=	 $dt->format( "Y-m-d" );	
				$dayno		=	 $dt->format( "N" );
				$day		=	 $dt->format( "D" );
				$day		=	strtolower($day);
				$weekdata	=	$this->Vehicle_model->get_earning_week_report($user->id, $date);
				$data['weekdata'][$i]['date']	=	date('d M', strtotime($date));
				$data['weekdata'][$i]['booking']	=	@$weekdata->total;
			$i++;
			}

			header("Content-type: application/json");	
			echo json_encode($data);
		}else{
			$response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
            header("Content-type: application/json");	
            echo json_encode($response);			
		}
	}

	public function get_earning_monthly_report(){
		if($this->input->is_ajax_request()){

			$user = $this->ion_auth->user()->row();

			$data['monthdata']	=	array();
			$mbegin             = new DateTime(date("Y-m-d", strtotime("- 30 DAYS")));
			$mend               = new DateTime(date('Y-m-d', strtotime("+ 1 DAYS")));
			$minterval          = DateInterval::createFromDateString('1 day');
			$mperiod            = new DatePeriod($mbegin, $minterval, $mend);
			$i=0;

			foreach($mperiod as $dt){
				$date		=	 $dt->format( "Y-m-d" );	
				$dayno		=	 $dt->format( "N" );
				$day		=	 $dt->format( "D" );
				$day		=	strtolower($day);
				$monthdata	=	$this->Vehicle_model->get_earning_week_report($user->id, $date);
				$data['monthdata'][$i]['date']	=	date('d M', strtotime($date));
				$data['monthdata'][$i]['booking']	=	@$monthdata->total;
			$i++;
			}
			header("Content-type: application/json");	
			echo json_encode($data);
		}else{
			$response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
            header("Content-type: application/json");	
            echo json_encode($response);			
		}
	}

	public function get_earning_yearly_report(){
		if($this->input->is_ajax_request()){

			$user = $this->ion_auth->user()->row();
			$data['yeardata']	=	array();
			$start = $month = strtotime("- 365 days");
			$end = strtotime('+ 1 day');
			$i=0;
			while($month < $end){
				$month = strtotime("+1 month", $month);
				 $Y	= date('Y', $month);
				 $M	= date('m', $month);
				$yeardata	=	$this->Vehicle_model->get_earning_yealy_report($user->id, $Y,$M); 
				$data['yeardata'][$i]['date']	    =	date('M', $month)." ".date('Y', $month);
				$data['yeardata'][$i]['booking']	=	@$yeardata->total;
				$i++;	 
			}                        
			$response  =  array('type' => 'success', 'message' =>  $data);
			header("Content-type: application/json");	
			echo json_encode($response); 
		}else{
			$response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
            header("Content-type: application/json");	
            echo json_encode($response);			
		}
	}

	public function booking_calendar(){
			
		$this->load->library('calendar');

		
		$data['css'] = array(
			$this->config->item('app_frontend_asset_root').'/css/dashboard.css'
		);

		$data['js'] = array(
			$this->config->item('app_frontend_asset_root').'/js/app.js',
			$this->config->item('app_frontend_asset_root').'/js/agent.js'
		);

		$data['user'] = $this->ion_auth->user()->row();

		$data["navigation_class"]     =   "bg-white";

		$data["footer_bottom"]        =   FALSE;


		$booking = $this->Vehicle_model->get_booking_by_user($data['user']->id);

		$cal_array = array();

	    foreach($booking as $bk){
            $cal_array[nice_date(unix_to_human($bk->start_time), 'd')] = "booking_details/".$this->hasher->encrypt($bk->vehicle_booking_id);
		}
		 

		if(isset($_GET['m']) && strlen($this->input->get('m', TRUE)) != 10){
			$data['requYMD'] = preg_replace("/[^0-9\-]/i", '', $this->security->xss_clean($this->input->get('m', TRUE))).'-01';
			$reqdates = explode("-", $this->security->xss_clean($this->input->get('m', TRUE)));
			$current_year = $reqdates[0];
			$current_month =  $reqdates[1];
		}else{
			$data['requYMD'] =  date('Y-m-d');
			$current_year = date('Y');
			$current_month =  date('m');
		}


		$data['calendar'] = $this->calendar->generate($current_year, $current_month, $cal_array);
		   
		$this->load->view('agent/header', $data);
		$this->load->view('agent/booking_calendar', $data);
		$this->load->view('agent/footer', $data);
	}

	public function vehicle_multiple_image_check(){
		if(isset($_FILES['image']) && is_array($_FILES['image']) && !empty($_FILES['image']) && count($_FILES['image']) > 0 && $_FILES['image']['name'][0] !=""){
			$config['upload_path']      = 'frontend/images/vehicles/'; 
			$config['allowed_types']    = 'jpg|jpeg|png|gif';
			$config['max_size']         = '5000'; 
			$config['file_name']        =  random_string('numeric', 5);;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
	
			if($this->upload->do_multi_upload('image')){
				foreach($this->upload->get_multi_data() as $files){
					array_push($this->cached_data, $files['file_name']);
				} 
				return TRUE;
			}else{
				$this->form_validation->set_message('vehicle_multiple_image_check', $this->upload->display_errors());
				return FALSE;
			}
		}else{
			$this->form_validation->set_message('vehicle_multiple_image_check',  'The {field} field can not be empty!');
			return FALSE;;
		}
	}
	
	public function update_vehicle_multiple_image_check(){
		if(isset($_FILES['image']) && is_array($_FILES['image']) && !empty($_FILES['image']) && count($_FILES['image']) > 0 && $_FILES['image']['name'][0] !=""){
			$config['upload_path']      = 'frontend/images/vehicles/'; 
			$config['allowed_types']    = 'jpg|jpeg|png|gif';
			$config['max_size']         = '5000'; 
			$config['file_name']        =  random_string('numeric', 5);;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
	
			if($this->upload->do_multi_upload('image')){
				foreach($this->upload->get_multi_data() as $files){
					array_push($this->cached_data, $files['file_name']);
				} 
				return TRUE;
			}else{
				$this->form_validation->set_message('update_vehicle_multiple_image_check', $this->upload->display_errors());
				return FALSE;
			}
		}else{
			return TRUE;
		}
	}

	public function check_default($selection){
		if ($selection == '0'){
			$this->form_validation->set_message('check_default', 'Please Select An Option');
			return FALSE;
		}else{
			return TRUE;
		}
	}

    public function access_level_verifier(){
        if ($this->ion_auth->logged_in() && $this->ion_auth->in_group("agent")){
            return true;
        }else{
            $this->session->set_flashdata('message', "You must be an administrator to view this page");
            redirect('auth/login');
        }
	}

	public function unit(){

		$this->load->library('unit_test');

		$this->unit->active(FALSE);

		$user = $this->ion_auth->user()->row();

		$test_case_01  =  $this->Vehicle_model->get_vehicles(array("vehicles.user_id" => $user->id));

        $test_name = 'Test case 33 check if the $this->Vehicle_model-> returns an array';

        $this->unit->run($test_case_01, 'is_array', $test_name);

         echo $this->unit->report();
	}

}