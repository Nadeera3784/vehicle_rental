<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

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
		$this->load->helper(array('string','app_helper','text','date'));
		$this->config->load('app');
		$this->load->model(array(
			'Vehicle_type_model', 
			'Locations_model', 
			'Vehicle_model',
			'TDVehicles_model',
			'TDBooking_model',
			'Vehicle_blocking_model',
			'Discount_model',
			'Extra_model',
			'Vehicle_price_model',
			'Membership_model',
			'Booking_extra_model',
			'Booking_model'
		));
		$this->access_level_verifier();
		$this->form_validation->set_error_delimiters('<div class="alert alert-warning" role="alert">', '</div>');
	}

	public function index(){
		$data['js'] = array(
			$this->config->item('app_frontend_asset_root').'/js/raphael.min.js',
			$this->config->item('app_frontend_asset_root').'/js/morris.min.js',
			$this->config->item('app_backend_asset_root').'/js/app.js'
		);

		$data['users'] = $this->ion_auth->users('agent')->result();

		$data['totalbookings'] = $this->Vehicle_model->get_total_admin_booking();

		$data['totalvehicles'] = $this->Vehicle_model->get_total_admin_vehicles();

		$data['totalrevenue'] = $this->Vehicle_model->get_total_revenue();

		$this->load->view('admin/header', $data);
		$this->load->view('admin/dashboard', $data);
		$this->load->view('admin/footer', $data);

	}

	public function vehicle_types(){
	    $data['css'] = array(
			$this->config->item('app_backend_asset_root').'/css/dataTables.bootstrap4.css',
			$this->config->item('app_backend_asset_root').'/css/responsive.dataTables.css',
			$this->config->item('app_backend_asset_root').'/css/datatables.css',
			$this->config->item('app_backend_asset_root').'/css/notie.css'
		);

		$data['js'] = array(
			$this->config->item('app_backend_asset_root').'/js/jquery.dataTables.js',
			$this->config->item('app_backend_asset_root').'/js/dataTables.bootstrap4.js',
			$this->config->item('app_backend_asset_root').'/js/responsive.dataTables.js',
			$this->config->item('app_backend_asset_root').'/js/datatables.js',
			$this->config->item('app_backend_asset_root').'/js/notie.js',
			$this->config->item('app_backend_asset_root').'/js/app.js'
		);

		$data["vehicle_type"]    = $this->Vehicle_type_model->get_vehicle_type();

		$this->load->view('admin/header', $data);
		$this->load->view('admin/vehicle_types', $data);
		$this->load->view('admin/footer', $data);
	}

	public function add_vehicle_type(){
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
		if ($this->form_validation->run() == FALSE){
			$this->load->view('admin/header');
			$this->load->view('admin/add_vehicle_type');
			$this->load->view('admin/footer');
		}else{
			$form_data['title']        = $this->input->post('title', TRUE);
			$form_data['description']  = $this->input->post('description', TRUE);
			$this->Vehicle_type_model->add_vehicle_type($form_data);
			$this->session->set_flashdata('success', "Vehicle type has been added successfully!");
            redirect('admin/vehicle_types', 'refresh');
		}
	}

	public function update_vehicle_type($type_id){
		$data["vehicle_type"] = $this->Vehicle_type_model->get_vehicle_type_by_id($this->hasher->decrypt($type_id));
		$this->load->view('admin/header');
		$this->load->view('admin/update_vehicle_type', $data);
		$this->load->view('admin/footer');
	}

	public function save_vehicle_type(){
		$id = $this->input->post('id', TRUE);
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');

		if ($this->form_validation->run() == FALSE){
			$this->update_vehicle_type($id);
		}else{
			$form_data['title']        = $this->input->post('title', TRUE);
			$form_data['description']  = $this->input->post('description', TRUE);
			$this->Vehicle_type_model->update_vehicle_type($this->hasher->decrypt($id), $form_data);
			$this->session->set_flashdata('success', "Vehicle type has been updated successfully!");
            redirect('admin/vehicle_types', 'refresh');
		}
	}
	 
	public function delete_vehicle_type(){
		if($this->input->is_ajax_request()){
			$vehicle_type_id   = $this->hasher->decrypt($this->input->post('vehicle_type_id', TRUE));
			$this->Vehicle_type_model->delete_vehicle_type($vehicle_type_id);
			$response  =  array('type' => 'success', 'message' =>  "Vehicle type has been deleted successfully!");
            header("Content-type: application/json");	
            echo json_encode($response);
		}else{
			$response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
            header("Content-type: application/json");	
            echo json_encode($response);
		}
	}

	public function delete_vehicle_type_multiple(){
		if($this->input->is_ajax_request()){
			$vehicle_type_ids   = $this->input->post('vehicle_type_id', TRUE);
			if(!empty($this->input->post('vehicle_type_id', TRUE))){
				foreach($vehicle_type_ids as $vti){
					$this->Vehicle_type_model->delete_vehicle_type($vti);
				}
				$response  =  array('type' => 'success', 'message' =>  "Vehicle type has been deleted successfully!");
				header("Content-type: application/json");	
				echo json_encode($response);
			}else{
				$response  =  array('type' => 'error', 'message' =>  "Something went wrong please try again later");
				header("Content-type: application/json");	
				echo json_encode($response);
			}
		}else{
			$response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
			header("Content-type: application/json");	
			echo json_encode($response);
		}
	}

	public function locations(){

		$data['css'] = array(
			$this->config->item('app_backend_asset_root').'/css/dataTables.bootstrap4.css',
			$this->config->item('app_backend_asset_root').'/css/responsive.dataTables.css',
			$this->config->item('app_backend_asset_root').'/css/datatables.css',
			$this->config->item('app_backend_asset_root').'/css/notie.css'
		);

		$data['js'] = array(
			$this->config->item('app_backend_asset_root').'/js/jquery.dataTables.js',
			$this->config->item('app_backend_asset_root').'/js/dataTables.bootstrap4.js',
			$this->config->item('app_backend_asset_root').'/js/responsive.dataTables.js',
			$this->config->item('app_backend_asset_root').'/js/datatables.js',
			$this->config->item('app_backend_asset_root').'/js/notie.js',
			$this->config->item('app_backend_asset_root').'/js/app.js'
		);

		$data["locations"]    =   $this->Locations_model->get_locations();

		$this->load->view('admin/header', $data);
		$this->load->view('admin/locations', $data);
		$this->load->view('admin/footer', $data);
	}

	public function add_location(){
		$this->form_validation->set_rules('name', 'Name', 'trim|required|is_unique[locations.name]', array('is_unique' => 'This %s already exists.'));
		$this->form_validation->set_rules('latitude', 'latitude', 'trim|required');
		$this->form_validation->set_rules('longitude', 'Longitude', 'trim|required');
		if ($this->form_validation->run() == FALSE){
			$this->load->view('admin/header');
			$this->load->view('admin/add_location');
			$this->load->view('admin/footer');
		}else{
			$form_data['name']        = $this->input->post('name', TRUE);
			$form_data['latitude']    = $this->input->post('latitude', TRUE);
			$form_data['longitude']   = $this->input->post('longitude', TRUE);
			$this->Locations_model->add_location($form_data);
			$this->session->set_flashdata('success', "Location has been added successfully!");
            redirect('admin/locations', 'refresh');
		}
	}

	public function update_location($location_id){
		$data["location"] = $this->Locations_model->get_location_by_id($this->hasher->decrypt($location_id));
		$this->load->view('admin/header');
		$this->load->view('admin/update_location', $data);
		$this->load->view('admin/footer');

	}

	public function save_location(){
		$id = $this->input->post('id', TRUE);
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('latitude', 'Latitude', 'trim|required');
		$this->form_validation->set_rules('longitude', 'Longitude', 'trim|required');
		
		if ($this->form_validation->run() == FALSE){
			$this->update_location($id);
		}else{
			$form_data['name']        = $this->input->post('name', TRUE);
			$form_data['latitude']    = $this->input->post('latitude', TRUE);
			$form_data['longitude']   = $this->input->post('longitude', TRUE);
			$this->Locations_model->update_location($this->hasher->decrypt($id), $form_data);
			$this->session->set_flashdata('success', "Location has been updated successfully!");
            redirect('admin/locations', 'refresh');
		}
	}

	public function delete_location(){
		if($this->input->is_ajax_request()){
			$location_id   = $this->hasher->decrypt($this->input->post('location_id', TRUE));
			$this->Locations_model->delete_location($location_id);
			$response  =  array('type' => 'success', 'message' =>  "Location has been deleted successfully!");
            header("Content-type: application/json");	
            echo json_encode($response);
		}else{
			$response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
            header("Content-type: application/json");	
            echo json_encode($response);
		}

	}

	public function delete_location_multiple(){
		if($this->input->is_ajax_request()){
			$location_id   = $this->input->post('location_id', TRUE);
			if(!empty($this->input->post('location_id', TRUE))){
				foreach($location_id as $loc){
					$this->Locations_model->delete_location($loc);
				}
				$response  =  array('type' => 'success', 'message' =>  "Location has been deleted successfully!");
				header("Content-type: application/json");	
				echo json_encode($response);
			}else{
				$response  =  array('type' => 'error', 'message' =>  "Something went wrong please try again later");
				header("Content-type: application/json");	
				echo json_encode($response);
			}
		}else{
			$response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
			header("Content-type: application/json");	
			echo json_encode($response);
		}

	}

	public function vehicles(){

		$data['css'] = array(
			$this->config->item('app_backend_asset_root').'/css/dataTables.bootstrap4.css',
			$this->config->item('app_backend_asset_root').'/css/responsive.dataTables.css',
			$this->config->item('app_backend_asset_root').'/css/datatables.css',
			$this->config->item('app_backend_asset_root').'/css/notie.css',
			$this->config->item('app_backend_asset_root').'/css/datepicker.css',
			$this->config->item('app_backend_asset_root').'/css/lightbox.css'
		);

		$data['js'] = array(
			$this->config->item('app_backend_asset_root').'/js/jquery.dataTables.js',
			$this->config->item('app_backend_asset_root').'/js/dataTables.bootstrap4.js',
			$this->config->item('app_backend_asset_root').'/js/responsive.dataTables.js',
			$this->config->item('app_backend_asset_root').'/js/datatables.js',
			$this->config->item('app_backend_asset_root').'/js/notie.js',
			$this->config->item('app_backend_asset_root').'/js/datepicker.js',
			$this->config->item('app_backend_asset_root').'/js/lightbox.js',
			$this->config->item('app_backend_asset_root').'/js/app.js'
		);

		$data['vehicles']     = $this->Vehicle_model->get_vehicles();
		$data["locations"]    =   $this->Locations_model->get_locations();

		$this->load->view('admin/header', $data);
		$this->load->view('admin/vehicles', $data);
		$this->load->view('admin/footer', $data);
	}

	public function add_vehicle(){
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
				$this->config->item('app_backend_asset_root').'/css/select2.css'
			);

			$data['js'] = array(
				$this->config->item('app_backend_asset_root').'/js/select2.js',
				$this->config->item('app_backend_asset_root').'/js/app.js'
			);

			$data["locations"]       = $this->Locations_model->get_locations();
			$data["vehicle_type"]    = $this->Vehicle_type_model->get_vehicle_type();
			$this->load->view('admin/header', $data);
			$this->load->view('admin/add_vehicle', $data);
			$this->load->view('admin/footer', $data);
		}else{
			$images = implode(',',$this->cached_data); 
			$user = $this->ion_auth->user()->row();
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
            redirect('admin/vehicles', 'refresh');
		}
	}

	public function vehicle_list(){
        if($this->input->is_ajax_request()){
            $list = $this->TDVehicles_model->get_datatables();
            $data = array();
            $no = $_POST['start'];

            foreach ($list as $vehicle) {
				$split_images = explode(',', $vehicle->images);
                $no++;
                $row = array();
                $row[] = $vehicle->vehicle_id;
                $row[] = $split_images[0];
                $row[] = $vehicle->name;
                $row[] = $vehicle->registration_number;
                $row[] = $vehicle->status;
                $row[] = $this->hasher->encrypt($vehicle->vehicle_id);
                $data[] = $row;
            }
    
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->TDVehicles_model->count_all(),
                "recordsFiltered" => $this->TDVehicles_model->count_filtered(),
                "data" => $data,
			);
			header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT');
            header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");
            header('Content-Type: application/json');
            echo json_encode($output);
        }else{
            $response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
            header("Content-type: application/json");	
            echo json_encode($response);
        }
	}
	
	public function update_vehicle_status($vehicle_id){
		$data['current_vehicle_status'] = $this->Vehicle_model->get_vehicle_by_id($this->hasher->decrypt($vehicle_id));
		$change_to = ($data['current_vehicle_status']->status == "0") ? "1" : "0";
		$notify    = ($data['current_vehicle_status']->status == "0") ? "approved" : "disabled";
		$form_data['status']   = $change_to;
		$this->Vehicle_model->update_vehicle($this->hasher->decrypt($vehicle_id), $form_data);
		$this->session->set_flashdata('success', "Vehicle has been ".$notify." successfully");
		redirect('admin/vehicles', 'refresh');
	}

	public function update_vehicle($vehicle_id){
		$data['css'] = array(
			$this->config->item('app_backend_asset_root').'/css/notie.css',
			$this->config->item('app_backend_asset_root').'/css/uploader.css',
			$this->config->item('app_backend_asset_root').'/css/awesome-bootstrap-checkbox.css'
		);

		$data['js'] = array(
			$this->config->item('app_backend_asset_root').'/js/notie.js',
			$this->config->item('app_backend_asset_root').'/js/app.js'
		);

		$data['vehicle']          =   $this->Vehicle_model->get_vehicle_by_id($this->hasher->decrypt($vehicle_id));
		$data["locations"]        =   $this->Locations_model->get_locations();
		$data["vehicle_type"]     =   $this->Vehicle_type_model->get_vehicle_type();

		$this->load->view('admin/header', $data);
		$this->load->view('admin/update_vehicle', $data);
		$this->load->view('admin/footer', $data);

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

			$user = $this->ion_auth->user()->row();
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
			$this->Vehicle_model->update_vehicle($this->hasher->decrypt($vehicle_id), $form_data);
			$this->session->set_flashdata('success', "Vehicle has been updated successfully");
            redirect('admin/vehicles', 'refresh');
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

	public function delete_vehicle_multiple(){
		if($this->input->is_ajax_request()){
			$vehicle_id   = $this->input->post('vehicle_id', TRUE);
			if(!empty($this->input->post('vehicle_id', TRUE))){
				foreach($vehicle_id as $vid){
					$images_array = $this->Vehicle_model->get_current_vehicle_images($vid);
					foreach($images_array as $value){
						$value = trim($value);
						if (file_exists('./frontend/images/vehicles/'.$value)){
							unlink('./frontend/images/vehicles/'.$value);
						}
					}
		
					$this->Vehicle_price_model->delete_vehicle_price_by_vehicle_id($vid);
		
					$this->Vehicle_model->delete_vehicle($vid);
				}
				$response  =  array('type' => 'success', 'message' =>  "Vehicle has been deleted successfully!");
				header("Content-type: application/json");	
				echo json_encode($response);
			}else{
				$response  =  array('type' => 'error', 'message' =>  "Something went wrong please try again later");
				header("Content-type: application/json");	
				echo json_encode($response);
			}
		}else{
			$response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
			header("Content-type: application/json");	
			echo json_encode($response);
		}
	}

	public function users(){
		$data['css'] = array(
			$this->config->item('app_backend_asset_root').'/css/awesome-bootstrap-checkbox.css',
			$this->config->item('app_backend_asset_root').'/css/dataTables.bootstrap4.css',
			$this->config->item('app_backend_asset_root').'/css/responsive.dataTables.css',
			$this->config->item('app_backend_asset_root').'/css/datatables.css',
			$this->config->item('app_backend_asset_root').'/css/notie.css'
		);

		$data['js'] = array(
			$this->config->item('app_backend_asset_root').'/js/jquery.dataTables.js',
			$this->config->item('app_backend_asset_root').'/js/dataTables.bootstrap4.js',
			$this->config->item('app_backend_asset_root').'/js/responsive.dataTables.js',
			$this->config->item('app_backend_asset_root').'/js/datatables.js',
			$this->config->item('app_backend_asset_root').'/js/notie.js',
			$this->config->item('app_backend_asset_root').'/js/app.js'
		);

		$data['users'] = $this->ion_auth->users()->result();
			

		foreach ($data['users'] as $k => $user){
			$data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
		}

		$data["memberships"]  =   $this->Membership_model->get_membership();

		foreach ($data['memberships'] as $key => $value) {
			$data['membership_id'][$value->membership_id] = $value;
		}

		$this->load->view('admin/header', $data);
		$this->load->view('admin/users', $data);
		$this->load->view('admin/footer', $data);
	}

	//TODO
	public function add_user(){
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[users.email]',  array('is_unique' => 'This %s already exists.'));
		$this->form_validation->set_rules('avatar', 'Avatar', 'callback_user_profile_image_check');
		$this->form_validation->set_rules('password', 'Password' , 'required|min_length[5]|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', 'Password Confirm' , 'required');
		
		if ($this->form_validation->run() == FALSE){
			$data['css'] = array(
				$this->config->item('app_backend_asset_root').'/css/imageupload.css'
			);
	
			$data['js'] = array(
				$this->config->item('app_backend_asset_root').'/js/imageupload.js'
			);
	
			$this->load->view('admin/header', $data);
			$this->load->view('admin/add_user');
			$this->load->view('admin/footer', $data);
		}else{
			$form_data['first_name'] = $this->input->post('first_name', TRUE);
			$form_data['last_name']  = $this->input->post('last_name', TRUE);
			$form_data['phone']      = $this->input->post('phone', TRUE);
			$form_data['active']     =  ($this->input->post('active', TRUE) == "on")? "1" : "0";

			$identity =   $this->input->post('email', TRUE);
			$email    =   $this->input->post('email', TRUE);
			$password =   $this->input->post('password', TRUE);

			if(!empty($this->cached_data)){
				$form_data['avatar']  =  $this->cached_data[0];
			}

			if($this->ion_auth->register($identity, $password, $email, $form_data)){
				$this->session->set_flashdata('success', "User has been added successfully");
				redirect('admin/users', 'refresh');
			}else{
				$this->session->set_flashdata('error', "Something went wrong, Please try again later");
				redirect('admin/users', 'refresh');
			}

		}


	}

	public function update_user($user_id){
		$data['css'] = array(
			$this->config->item('app_backend_asset_root').'/css/imageupload.css'
		);

		$data['js'] = array(
			$this->config->item('app_backend_asset_root').'/js/imageupload.js'
		);

		$data['user'] = $this->ion_auth->user($this->hasher->decrypt($user_id))->row();

		$this->load->view('admin/header', $data);
		$this->load->view('admin/update_user', $data);
		$this->load->view('admin/footer', $data);

	}

	public function save_user(){

		$user_id = $this->input->post('id');

		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
		$this->form_validation->set_rules('avatar', 'Avatar', 'callback_user_profile_image_check');

		if($this->input->post('email')){
		  $this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[users.email]',  array('is_unique' => 'This %s already exists.'));
		}

		if ($this->input->post('password')){
			$this->form_validation->set_rules('password', 'Password' , 'required|min_length[5]|matches[password_confirm]');
			$this->form_validation->set_rules('password_confirm', 'Password Confirm' , 'required');
		}

		if ($this->form_validation->run() == FALSE){
			$this->update_user($user_id);
		}else{
			$form_data['first_name'] = $this->input->post('first_name', TRUE);
			$form_data['last_name']  = $this->input->post('last_name', TRUE);
			$form_data['phone']      = $this->input->post('phone', TRUE);
			$form_data['active']     =  ($this->input->post('active', TRUE) == "on")? "1" : "0";

			if($this->input->post('email')){
				$form_data['email']      = $this->input->post('email', TRUE);
			}

			if ($this->input->post('password')){
				$form_data['password']  =  $this->input->post('password', TRUE);
			}

			if(!empty($this->cached_data)){

				$this->db->where('id', $this->hasher->decrypt($user_id));
				$result = $this->db->get('users');
				$image = $result->row()->avatar;
				if($image != "0"){
					if (file_exists('./frontend/images/profile/'.$image)){
						unlink('./frontend/images/profile/'.$image);
					}
				}

				$form_data['avatar']  =  $this->cached_data[0];
			}

			if($this->ion_auth->update($this->hasher->decrypt($user_id), $form_data)){
				$this->session->set_flashdata('success', "User has been updated successfully");
				redirect('admin/users', 'refresh');
			}else{
				$this->session->set_flashdata('error', "Something went wrong, Please try again later");
				redirect('admin/users', 'refresh');
			}

		}
	}

	public function delete_user(){
		if($this->input->is_ajax_request()){

			$user_id   = $this->hasher->decrypt($this->input->post('user_id', TRUE));

			$user = $this->ion_auth->user($user_id)->row();

			if($user->avatar != "0"){
				if (file_exists('./frontend/images/profile/'.$user->avatar)){
					unlink('./frontend/images/profile/'.$user->avatar);
				}
			}

			if($this->ion_auth->delete_user($user_id)){
				$response  =  array('type' => 'success', 'message' =>  "User has been deleted successfully!");
				header("Content-type: application/json");	
				echo json_encode($response);
			}else{
				$response  =  array('type' => 'error', 'message' =>  "Something went wrong");
				header("Content-type: application/json");	
				echo json_encode($response);
			}
		}else{
			$response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
            header("Content-type: application/json");	
            echo json_encode($response);
		}
	}

	public function delete_user_multiple(){
		if($this->input->is_ajax_request()){
			$user_id   = $this->input->post('user_id', TRUE);
			if(!empty($this->input->post('user_id', TRUE))){
				foreach($user_id as $uid){
					$user = $this->ion_auth->user($uid)->row();
					if($user->avatar != "0"){
						if (file_exists('./frontend/images/profile/'.$user->avatar)){
							unlink('./frontend/images/profile/'.$user->avatar);
						}
					}
					$this->ion_auth->delete_user($uid);
				}
				$response  =  array('type' => 'success', 'message' =>  "User has been deleted successfully");
				header("Content-type: application/json");	
				echo json_encode($response);
			}else{
				$response  =  array('type' => 'error', 'message' =>  "Something went wrong please try again later");
				header("Content-type: application/json");	
				echo json_encode($response);
			}
		}else{
			$response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
			header("Content-type: application/json");	
			echo json_encode($response);
		}
	}

	public function blocking(){
		$data['css'] = array(
			$this->config->item('app_backend_asset_root').'/css/dataTables.bootstrap4.css',
			$this->config->item('app_backend_asset_root').'/css/responsive.dataTables.css',
			$this->config->item('app_backend_asset_root').'/css/datatables.css',
			$this->config->item('app_backend_asset_root').'/css/notie.css'
		);

		$data['js'] = array(
			$this->config->item('app_backend_asset_root').'/js/jquery.dataTables.js',
			$this->config->item('app_backend_asset_root').'/js/dataTables.bootstrap4.js',
			$this->config->item('app_backend_asset_root').'/js/responsive.dataTables.js',
			$this->config->item('app_backend_asset_root').'/js/datatables.js',
			$this->config->item('app_backend_asset_root').'/js/notie.js',
			$this->config->item('app_backend_asset_root').'/js/app.js'
		);

		
		$data["vehicle_blocking"]  =   $this->Vehicle_blocking_model->get_vehicle_blocking();

		$this->load->view('admin/header', $data);
		$this->load->view('admin/blocking', $data);
		$this->load->view('admin/footer', $data);

	}

	public function add_blocking(){
		
		$this->form_validation->set_rules('vehicle', 'Vehicle', 'trim|required|callback_check_default');
		$this->form_validation->set_rules('from', 'From', 'trim|required');
		$this->form_validation->set_rules('to', 'To', 'trim|required');

		if ($this->form_validation->run() == FALSE){
			$data['css'] = array(
				$this->config->item('app_backend_asset_root').'/css/datepicker.css',
				$this->config->item('app_backend_asset_root').'/css/select2.css'
			);
			$data['js'] = array(
				$this->config->item('app_backend_asset_root').'/js/datepicker.js',
				$this->config->item('app_backend_asset_root').'/js/select2.js',
				$this->config->item('app_backend_asset_root').'/js/app.js'
			);
	
			$data['vehicles']   = $this->Vehicle_model->get_vehicles(array('vehicles.status' => "1"));
	
			$this->load->view('admin/header', $data);
			$this->load->view('admin/add_blocking', $data);
			$this->load->view('admin/footer', $data);
		}else{
			$form_data['vehicle_id'] = $this->input->post('vehicle', TRUE);
			$form_data['from_date']  = mysql_to_unix(date($this->config_manager->config['date_format'], strtotime($this->input->post('from', TRUE))));
			$form_data['to_date']    = mysql_to_unix(date($this->config_manager->config['date_format'], strtotime($this->input->post('to', TRUE))));
			$this->Vehicle_blocking_model->add_blocking($form_data);
			$this->session->set_flashdata('success', "Vehicle Block has been added successfully");
            redirect('admin/blocking', 'refresh');
		}


	}

	public function update_blocking($blocking_id){

		$data['css'] = array(
			$this->config->item('app_backend_asset_root').'/css/datepicker.css',
			$this->config->item('app_backend_asset_root').'/css/select2.css'
		);
		$data['js'] = array(
			$this->config->item('app_backend_asset_root').'/js/datepicker.js',
			$this->config->item('app_backend_asset_root').'/js/select2.js',
			$this->config->item('app_backend_asset_root').'/js/app.js'
		);

		$data['vehicles']   = $this->Vehicle_model->get_vehicles(array('vehicles.status' => "1"));
		$data['blocking']   = $this->Vehicle_blocking_model->get_block_by_id($this->hasher->decrypt($blocking_id));

		$this->load->view('admin/header', $data);
		$this->load->view('admin/update_blocking', $data);
		$this->load->view('admin/footer', $data);
	}

	public function save_blocking(){
		$blocking_id = $this->input->post('id', TRUE);

		$this->form_validation->set_rules('vehicle', 'Vehicle', 'trim|required|callback_check_default');
		$this->form_validation->set_rules('from', 'From', 'trim|required');
		$this->form_validation->set_rules('to', 'To', 'trim|required');

		if ($this->form_validation->run() == FALSE){
			$this->update_blocking($blocking_id);
		}else{
			$form_data['vehicle_id'] = $this->input->post('vehicle', TRUE);
			$form_data['from_date']  = date_to_timestamp($this->config_manager->config['date_format'] , $this->input->post('from', TRUE));
			$form_data['to_date']    = date_to_timestamp($this->config_manager->config['date_format'] , $this->input->post('to', TRUE));
			$this->Vehicle_blocking_model->update_blocking($this->hasher->decrypt($blocking_id), $form_data);
			$this->session->set_flashdata('success', "Vehicle Block has been updated successfully");
            redirect('admin/blocking', 'refresh');
		}
	}

	public function delete_blocking(){
		if($this->input->is_ajax_request()){
			$blocking_id   = $this->hasher->decrypt($this->input->post('blocking_id', TRUE));
			$this->Vehicle_blocking_model->delete_block($blocking_id);
			$response  =  array('type' => 'success', 'message' =>  "Blocking has been deleted successfully");
            header("Content-type: application/json");	
            echo json_encode($response);
		}else{
			$response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
            header("Content-type: application/json");	
            echo json_encode($response);
		}
	}

	public function delete_block_multiple(){
		if($this->input->is_ajax_request()){
			$blocking_id  = $this->input->post('blocking_id', TRUE);
			if(!empty($this->input->post('blocking_id', TRUE))){
				foreach($blocking_id as $bid){
					$this->Vehicle_blocking_model->delete_block($bid);
				}
				$response  =  array('type' => 'success', 'message' =>  "Blocking has been deleted successfully");
				header("Content-type: application/json");	
				echo json_encode($response);
			}else{
				$response  =  array('type' => 'error', 'message' =>  "Something went wrong please try again later");
				header("Content-type: application/json");	
				echo json_encode($response);
			}
		}else{
			$response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
			header("Content-type: application/json");	
			echo json_encode($response);
		}
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
	
	public function  discount(){
		$data['css'] = array(
			$this->config->item('app_backend_asset_root').'/css/dataTables.bootstrap4.css',
			$this->config->item('app_backend_asset_root').'/css/responsive.dataTables.css',
			$this->config->item('app_backend_asset_root').'/css/datatables.css',
			$this->config->item('app_backend_asset_root').'/css/notie.css'
		);

		$data['js'] = array(
			$this->config->item('app_backend_asset_root').'/js/jquery.dataTables.js',
			$this->config->item('app_backend_asset_root').'/js/dataTables.bootstrap4.js',
			$this->config->item('app_backend_asset_root').'/js/responsive.dataTables.js',
			$this->config->item('app_backend_asset_root').'/js/datatables.js',
			$this->config->item('app_backend_asset_root').'/js/notie.js',
			$this->config->item('app_backend_asset_root').'/js/app.js'
		);

		
		$data["discount"]  =   $this->Discount_model->get_discount();

		$this->load->view('admin/header', $data);
		$this->load->view('admin/discount', $data);
		$this->load->view('admin/footer', $data);
	}

	public function add_discount(){
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('limit', 'Limit', 'trim|required');
		$this->form_validation->set_rules('pcode', 'Promo code', 'trim|required');
		$this->form_validation->set_rules('discount', 'Discount', 'trim|required');
		$this->form_validation->set_rules('from', 'From', 'trim|required');
		$this->form_validation->set_rules('to', 'To', 'trim|required');
		if ($this->form_validation->run() == FALSE){
			$data['css'] = array(
				$this->config->item('app_backend_asset_root').'/css/datepicker.css'
			);
			$data['js'] = array(
				$this->config->item('app_backend_asset_root').'/js/datepicker.js',
				$this->config->item('app_backend_asset_root').'/js/app.js'
			);
			$this->load->view('admin/header', $data);
			$this->load->view('admin/add_discount');
			$this->load->view('admin/footer', $data);
		}else{
			$form_data['dlimit']     = $this->input->post('limit', TRUE);
			$form_data['title']      = $this->input->post('title', TRUE);
			$form_data['promo_code'] = $this->input->post('pcode', TRUE);
			$form_data['discount']   = $this->input->post('discount', TRUE);
			$form_data['type']       = $this->input->post('type', TRUE);
			$form_data['from_date']  = date_to_timestamp($this->config_manager->config['date_format'] , $this->input->post('from', TRUE));
			$form_data['to_date']    = date_to_timestamp($this->config_manager->config['date_format'] , $this->input->post('to', TRUE));
			
			$this->Discount_model->add_discount($form_data);
			$this->session->set_flashdata('success', "Discount has been added successfully");
            redirect('admin/discount', 'refresh');
		}
	}

	public function update_discount($discount_id){
		$data['css'] = array(
			$this->config->item('app_backend_asset_root').'/css/datepicker.css'
		);
		$data['js'] = array(
			$this->config->item('app_backend_asset_root').'/js/datepicker.js',
			$this->config->item('app_backend_asset_root').'/js/app.js'
		);
		$data['discount'] = $this->Discount_model->get_discount_by_id($this->hasher->decrypt($discount_id));

		$this->load->view('admin/header', $data);
		$this->load->view('admin/update_discount', $data);
		$this->load->view('admin/footer', $data);
	}

	public function save_discount(){
		$discount_id     = $this->input->post('id', TRUE);

		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('limit', 'Limit', 'trim|required');
		$this->form_validation->set_rules('pcode', 'Promo code', 'trim|required');
		$this->form_validation->set_rules('discount', 'Discount', 'trim|required');
		$this->form_validation->set_rules('from', 'From', 'trim|required');
		$this->form_validation->set_rules('to', 'To', 'trim|required');

		if ($this->form_validation->run() == FALSE){
			$this->update_discount($discount_id);
		}else{
            $form_data['dlimit']     = $this->input->post('limit', TRUE);
			$form_data['title']      = $this->input->post('title', TRUE);
			$form_data['promo_code'] = $this->input->post('pcode', TRUE);
			$form_data['discount']   = $this->input->post('discount', TRUE);
			$form_data['type']       = $this->input->post('type', TRUE);
			$form_data['from_date']  = date_to_timestamp($this->config_manager->config['date_format'] , $this->input->post('from', TRUE));
			$form_data['to_date']    = date_to_timestamp($this->config_manager->config['date_format'] , $this->input->post('to', TRUE));
			$this->Discount_model->update_discount($this->hasher->decrypt($discount_id) , $form_data);
			$this->session->set_flashdata('success', "Discount has been updated successfully");
            redirect('admin/discount', 'refresh');
		}
	}

	public function delete_discount(){
		if($this->input->is_ajax_request()){
			$discount_id   = $this->hasher->decrypt($this->input->post('discount_id', TRUE));
			$this->Discount_model->delete_discount($discount_id);
			$response  =  array('type' => 'success', 'message' =>  "Discount has been deleted successfully");
            header("Content-type: application/json");	
            echo json_encode($response);
		}else{
			$response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
            header("Content-type: application/json");	
            echo json_encode($response);
		}
	}

	public function delete_discount_multiple(){
		if($this->input->is_ajax_request()){
			$discount_id  = $this->input->post('discount_id', TRUE);
			if(!empty($this->input->post('discount_id', TRUE))){
				foreach($discount_id as $did){
					$this->Discount_model->delete_discount($did);
				}
				$response  =  array('type' => 'success', 'message' =>  "Discount has been deleted successfully");
				header("Content-type: application/json");	
				echo json_encode($response);
			}else{
				$response  =  array('type' => 'error', 'message' =>  "Something went wrong please try again later");
				header("Content-type: application/json");	
				echo json_encode($response);
			}
		}else{
			$response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
			header("Content-type: application/json");	
			echo json_encode($response);
		}
	}

	public function extra(){
		$data['css'] = array(
			$this->config->item('app_backend_asset_root').'/css/dataTables.bootstrap4.css',
			$this->config->item('app_backend_asset_root').'/css/responsive.dataTables.css',
			$this->config->item('app_backend_asset_root').'/css/datatables.css',
			$this->config->item('app_backend_asset_root').'/css/notie.css'
		);

		$data['js'] = array(
			$this->config->item('app_backend_asset_root').'/js/jquery.dataTables.js',
			$this->config->item('app_backend_asset_root').'/js/dataTables.bootstrap4.js',
			$this->config->item('app_backend_asset_root').'/js/responsive.dataTables.js',
			$this->config->item('app_backend_asset_root').'/js/datatables.js',
			$this->config->item('app_backend_asset_root').'/js/notie.js',
			$this->config->item('app_backend_asset_root').'/js/app.js'
		);

		
		$data["extra"]  =   $this->Extra_model->get_extra();

		$this->load->view('admin/header', $data);
		$this->load->view('admin/extra', $data);
		$this->load->view('admin/footer', $data);
	}

	public function add_extra(){
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
		$this->form_validation->set_rules('price', 'Price', 'trim|required');
		$this->form_validation->set_rules('vehicles[]', 'Vehicles', 'trim|required');

		if ($this->form_validation->run() == FALSE){
			$data['css'] = array(
				$this->config->item('app_backend_asset_root').'/css/select2.css'
			);
			$data['js'] = array(
				$this->config->item('app_backend_asset_root').'/js/select2.js',
				$this->config->item('app_backend_asset_root').'/js/app.js'
			);
	
			$data['vehicles']   = $this->Vehicle_model->get_vehicles(array('vehicles.status' => "1"));
	
			$this->load->view('admin/header', $data);
			$this->load->view('admin/add_extra', $data);
			$this->load->view('admin/footer', $data);
		}else{
			$form_data['title']           = $this->input->post('title', TRUE);
			$form_data['description']     = $this->input->post('description', TRUE);
			$form_data['price']           = $this->input->post('price', TRUE);
			$form_data['calculate']       = $this->input->post('calculate', TRUE);
			$form_data['type']            = $this->input->post('type', TRUE);

			$extra_id = $this->Extra_model->add_extra($form_data);
			
			foreach($this->input->post('vehicles', TRUE) as $vehicle){
				$form_data2['vehicle_id']   = $vehicle;
				$form_data2['extra_id']     = $extra_id;
				$this->Extra_model->add_extra_relation($form_data2);
			}
			$this->session->set_flashdata('success', "Extra price has been added successfully");
            redirect('admin/extra', 'refresh');
		}

	}

	public function update_extra($extra_id){
		$data['css'] = array(
			$this->config->item('app_backend_asset_root').'/css/select2.css'
		);
		$data['js'] = array(
			$this->config->item('app_backend_asset_root').'/js/select2.js',
			$this->config->item('app_backend_asset_root').'/js/app.js'
		);

		$data['vehicles']        = $this->Vehicle_model->get_vehicles(array('vehicles.status' => "1"));
		$data['extra']           = $this->Extra_model->get_extra_by_id($this->hasher->decrypt($extra_id));
		$data['extra_relation']  = $this->Extra_model->get_extra_relations($this->hasher->decrypt($extra_id));

		foreach ($data['extra_relation'] as $key => $value) {
			$data['vehicle_id'][$value->vehicle_id] = $value;
		}

		$this->load->view('admin/header', $data);
		$this->load->view('admin/update_extra', $data);
		$this->load->view('admin/footer', $data);
	}

	public function save_extra(){
		$extra_id = $this->input->post('id', TRUE);

		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
		$this->form_validation->set_rules('price', 'Price', 'trim|required');
		$this->form_validation->set_rules('vehicles[]', 'Vehicles', 'trim|required');

		if ($this->form_validation->run() == FALSE){
			$this->update_extra($extra_id);
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

			$this->session->set_flashdata('success', "Extra Price has been updated successfully");
            redirect('admin/extra', 'refresh');

		}

	}

	public function delete_extra(){
		if($this->input->is_ajax_request()){
			$extra_id   = $this->hasher->decrypt($this->input->post('extra_id', TRUE));
			$this->Extra_model->delete_extra($extra_id);
			$response  =  array('type' => 'success', 'message' =>  "Discount has been deleted successfully");
            header("Content-type: application/json");	
            echo json_encode($response);
		}else{
			$response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
            header("Content-type: application/json");	
            echo json_encode($response);
		}
	}

	public function price_plan(){

		$data['css'] = array(
			$this->config->item('app_backend_asset_root').'/css/dataTables.bootstrap4.css',
			$this->config->item('app_backend_asset_root').'/css/responsive.dataTables.css',
			$this->config->item('app_backend_asset_root').'/css/datatables.css',
			$this->config->item('app_backend_asset_root').'/css/notie.css'
		);

		$data['js'] = array(
			$this->config->item('app_backend_asset_root').'/js/jquery.dataTables.js',
			$this->config->item('app_backend_asset_root').'/js/dataTables.bootstrap4.js',
			$this->config->item('app_backend_asset_root').'/js/responsive.dataTables.js',
			$this->config->item('app_backend_asset_root').'/js/datatables.js',
			$this->config->item('app_backend_asset_root').'/js/notie.js',
			$this->config->item('app_backend_asset_root').'/js/app.js'
		);

		$data['vehicles']   = $this->Vehicle_model->get_vehicles(array('vehicles.status' => "1"));
		$data['vehicle_prices']   = $this->Vehicle_price_model->get_vehicle_price_relations();

		$this->load->view('admin/header', $data);
		$this->load->view('admin/price_plan', $data);
		$this->load->view('admin/footer', $data);
	}

	public function add_price_plan(){
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
		$this->form_validation->set_rules('price_per_day', 'Price Per Day', 'trim|required');
		$this->form_validation->set_rules('price_per_hour', 'Price Per Hour', 'trim|required');
		$this->form_validation->set_rules('limit_mileage', 'Limit Mileage', 'trim|required');
		$this->form_validation->set_rules('price_for_extra_mileage', 'Price for extra mileage', 'trim|required');
		$this->form_validation->set_rules('extra_hour_price', 'Extra hour price', 'trim|required');
		$this->form_validation->set_rules('type', 'Type', 'trim|required|callback_check_default');
		$this->form_validation->set_rules('vehicle', 'Vehicle', 'trim|required|callback_check_default');

		if ($this->form_validation->run() == FALSE){
			$data['css'] = array(
				$this->config->item('app_backend_asset_root').'/css/select2.css',
				$this->config->item('app_backend_asset_root').'/css/notie.css'
			);
			$data['js'] = array(
				$this->config->item('app_backend_asset_root').'/js/select2.js',
				$this->config->item('app_backend_asset_root').'/js/notie.js',
				$this->config->item('app_backend_asset_root').'/js/app.js'
			);
	
			$data["vehicle_type"]    = $this->Vehicle_type_model->get_vehicle_type();
	
			$this->load->view('admin/header', $data);
			$this->load->view('admin/add_price_plan', $data);
			$this->load->view('admin/footer', $data);
		}else{
			$form_data['title']                     = $this->input->post('title', TRUE);
			$form_data['description']               = $this->input->post('description', TRUE);
			$form_data['price_per_day']             = $this->input->post('price_per_day', TRUE);
			$form_data['price_per_hour']            = $this->input->post('price_per_hour', TRUE);
			$form_data['limit_mileage']             = $this->input->post('limit_mileage', TRUE);
			$form_data['extra_mileage_price']       = $this->input->post('price_for_extra_mileage', TRUE);
			$form_data['extra_hour_price']          = $this->input->post('extra_hour_price', TRUE);
			$form_data['type_id']                   = $this->input->post('type', TRUE);
			$form_data['vehicle_id']                = $this->input->post('vehicle', TRUE);

			$this->Vehicle_price_model->add_vehicle_prices($form_data);

			$this->session->set_flashdata('success', "Price Plan has been added successfully");
            redirect('admin/price_plan', 'refresh');
		}

	}

	public function update_price_plan($price_plan_id){
		$data['css'] = array(
			$this->config->item('app_backend_asset_root').'/css/select2.css'
		);
		$data['js'] = array(
			$this->config->item('app_backend_asset_root').'/js/select2.js',
			$this->config->item('app_backend_asset_root').'/js/app.js'
		);

		$data["vehicle_type"]    = $this->Vehicle_type_model->get_vehicle_type();
		$data["vehicle_price"]  =  $this->Vehicle_price_model->get_vehicle_prices_by_id($this->hasher->decrypt($price_plan_id));

		$this->load->view('admin/header', $data);
		$this->load->view('admin/update_price_plan', $data);
		$this->load->view('admin/footer', $data);
	}

	public function save_price_plan(){

		$price_plan_id    = $this->input->post('id', TRUE);

		$this->form_validation->set_rules('price_per_day', 'Price Per Day', 'trim|required');
		$this->form_validation->set_rules('price_per_hour', 'Price Per Hour', 'trim|required');
		$this->form_validation->set_rules('limit_mileage', 'Limit Mileage', 'trim|required');
		$this->form_validation->set_rules('price_for_extra_mileage', 'Price for extra mileage', 'trim|required');
		$this->form_validation->set_rules('extra_hour_price', 'Extra hour price', 'trim|required');
		$this->form_validation->set_rules('type', 'Type', 'trim|required|callback_check_default');
		$this->form_validation->set_rules('vehicle', 'Vehicle', 'trim|required|callback_check_default');

		if ($this->form_validation->run() == FALSE){
            $this->update_price_plan($price_plan_id);
		}else{
			$form_data['price_per_day']             = $this->input->post('price_per_day', TRUE);
			$form_data['price_per_hour']            = $this->input->post('price_per_hour', TRUE);
			$form_data['limit_mileage']             = $this->input->post('limit_mileage', TRUE);
			$form_data['extra_mileage_price']       = $this->input->post('price_for_extra_mileage', TRUE);
			$form_data['extra_hour_price']          = $this->input->post('extra_hour_price', TRUE);
			$form_data['type_id']                   = $this->input->post('type', TRUE);
			$form_data['vehicle_id']                = $this->input->post('vehicle', TRUE);

			$this->Vehicle_price_model->update_vehicle_prices($this->hasher->decrypt($price_plan_id), $form_data);
			$this->session->set_flashdata('success', "Price Plan has been updated successfully");
            redirect('admin/price_plan', 'refresh');
		}

	}

	public function delete_price_plan(){
		if($this->input->is_ajax_request()){
			$price_plan_id   = $this->hasher->decrypt($this->input->post('price_plan_id', TRUE));
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
	
	public function delete_price_plan_multiple(){
		if($this->input->is_ajax_request()){
			$price_plan_id  = $this->input->post('price_plan_id', TRUE);
			if(!empty($this->input->post('price_plan_id', TRUE))){
				foreach($price_plan_id as $ppi){
					$this->Vehicle_price_model->delete_price_plan($ppi);
				}
				$response  =  array('type' => 'success', 'message' =>  "Price plan has been deleted successfully");
				header("Content-type: application/json");	
				echo json_encode($response);
			}else{
				$response  =  array('type' => 'error', 'message' =>  "Something went wrong please try again later");
				header("Content-type: application/json");	
				echo json_encode($response);
			}
		}else{
			$response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
			header("Content-type: application/json");	
			echo json_encode($response);
		}
	}

	public function get_vehicle_type(){
		if($this->input->is_ajax_request()){
			$vehicle_type   = $this->input->post('vehicle_type', TRUE);
			$data['vehicle'] = $this->Vehicle_model->get_vehicle_type($vehicle_type);
			$prep_array = [];
			foreach($data['vehicle'] as $vc){
				$prep_array[$vc->vehicle_id] = $vc->make . " " . $vc->model;
			}
			$response  =  array('type' => 'success', 'message' =>  $prep_array);
            header("Content-type: application/json");	
            echo json_encode($response);
		}else{
			$response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
            header("Content-type: application/json");	
            echo json_encode($response);
		}

	}

	public function memberships(){
		$data['css'] = array(
			$this->config->item('app_backend_asset_root').'/css/dataTables.bootstrap4.css',
			$this->config->item('app_backend_asset_root').'/css/responsive.dataTables.css',
			$this->config->item('app_backend_asset_root').'/css/datatables.css',
			$this->config->item('app_backend_asset_root').'/css/notie.css'
		);

		$data['js'] = array(
			$this->config->item('app_backend_asset_root').'/js/jquery.dataTables.js',
			$this->config->item('app_backend_asset_root').'/js/dataTables.bootstrap4.js',
			$this->config->item('app_backend_asset_root').'/js/responsive.dataTables.js',
			$this->config->item('app_backend_asset_root').'/js/datatables.js',
			$this->config->item('app_backend_asset_root').'/js/notie.js',
			$this->config->item('app_backend_asset_root').'/js/app.js'
		);

		
		$data["memberships"]  =   $this->Membership_model->get_membership();

		$this->load->view('admin/header', $data);
		$this->load->view('admin/memberships', $data);
		$this->load->view('admin/footer', $data);
	}

	public function add_membership(){
		$this->form_validation->set_rules('title', 'title', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
		$this->form_validation->set_rules('price', 'Price', 'trim|required');
		$this->form_validation->set_rules('limitation', 'Limitation', 'trim|required');
		$this->form_validation->set_rules('duration', 'Duration', 'trim|required');
		if ($this->form_validation->run() == FALSE){
			$this->load->view('admin/header');
			$this->load->view('admin/add_membership');
			$this->load->view('admin/footer');
		}else{
			$form_data['title']        = $this->input->post('title', TRUE);
			$form_data['description']  = $this->input->post('description', TRUE);
			$form_data['price']        = $this->input->post('price', TRUE);
			$form_data['limitation']   = $this->input->post('limitation', TRUE);
			$form_data['duration']     = $this->input->post('duration', TRUE);
			$this->Membership_model->add_membership($form_data);
			$this->session->set_flashdata('success', "Membership has been added successfully!");
            redirect('admin/memberships', 'refresh');
		}
	}

	public function update_membership($membership_id){
		$data["membership"] = $this->Membership_model->get_membership_by_id($this->hasher->decrypt($membership_id));
		$this->load->view('admin/header');
		$this->load->view('admin/update_membership', $data);
		$this->load->view('admin/footer');
	}

	public function save_membership(){
		$membership_id = $this->input->post('id', TRUE);

		$this->form_validation->set_rules('title', 'title', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
		$this->form_validation->set_rules('price', 'Price', 'trim|required');
		$this->form_validation->set_rules('limitation', 'Limitation', 'trim|required');
		$this->form_validation->set_rules('duration', 'Duration', 'trim|required');

		if ($this->form_validation->run() == FALSE){
			$this->update_membership($membership_id);
		}else{
			$form_data['title']        = $this->input->post('title', TRUE);
			$form_data['description']  = $this->input->post('description', TRUE);
			$form_data['price']        = $this->input->post('price', TRUE);
			$form_data['limitation']   = $this->input->post('limitation', TRUE);
			$form_data['duration']     = $this->input->post('duration', TRUE);
			$this->Membership_model->update_membership($this->hasher->decrypt($membership_id), $form_data);
			$this->session->set_flashdata('success', "Membership has been updated successfully!");
            redirect('admin/memberships', 'refresh');
		}
	}

	public function delete_membership(){
		if($this->input->is_ajax_request()){
			$membership_id   = $this->hasher->decrypt($this->input->post('membership_id', TRUE));
			$this->Membership_model->delete_membership($membership_id);
			$response  =  array('type' => 'success', 'message' =>  "Membership plan has been deleted successfully");
            header("Content-type: application/json");	
            echo json_encode($response);
		}else{
			$response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
            header("Content-type: application/json");	
            echo json_encode($response);
		}
	}

	public function delete_membership_multiple(){
		if($this->input->is_ajax_request()){
			$membership_id  = $this->input->post('membership_id', TRUE);
			if(!empty($this->input->post('membership_id', TRUE))){
				foreach($membership_id as $mmid){
					$this->Membership_model->delete_membership($mmid);
				}
				$response  =  array('type' => 'success', 'message' =>  "Membership has been deleted successfully");
				header("Content-type: application/json");	
				echo json_encode($response);
			}else{
				$response  =  array('type' => 'error', 'message' =>  "Something went wrong please try again later");
				header("Content-type: application/json");	
				echo json_encode($response);
			}
		}else{
			$response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
			header("Content-type: application/json");	
			echo json_encode($response);
		}
	}

	public function change_membership(){
		if($this->input->is_ajax_request()){
			$user_id                     = $this->hasher->decrypt($this->input->post('user_id', TRUE));
			$membership_id               = $this->input->post('membership_id', TRUE);
			$form_data['membership_id']  = $membership_id;
			$this->ion_auth->update($user_id, $form_data);
			$response  =  array('type' => 'success', 'message' =>  "Membership plan has been updated successfully");
            header("Content-type: application/json");	
            echo json_encode($response);
		}else{
			$response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
            header("Content-type: application/json");	
            echo json_encode($response);
		}
	}

	public function booking(){
		$data['css'] = array(
			$this->config->item('app_backend_asset_root').'/css/dataTables.bootstrap4.css',
			$this->config->item('app_backend_asset_root').'/css/responsive.dataTables.css',
			$this->config->item('app_backend_asset_root').'/css/datatables.css',
			$this->config->item('app_backend_asset_root').'/css/notie.css',
			$this->config->item('app_backend_asset_root').'/css/datepicker.css',
			$this->config->item('app_backend_asset_root').'/css/lightbox.css'
		);

		$data['js'] = array(
			$this->config->item('app_backend_asset_root').'/js/jquery.dataTables.js',
			$this->config->item('app_backend_asset_root').'/js/dataTables.bootstrap4.js',
			$this->config->item('app_backend_asset_root').'/js/responsive.dataTables.js',
			$this->config->item('app_backend_asset_root').'/js/datatables.js',
			$this->config->item('app_backend_asset_root').'/js/notie.js',
			$this->config->item('app_backend_asset_root').'/js/datepicker.js',
			$this->config->item('app_backend_asset_root').'/js/lightbox.js',
			$this->config->item('app_backend_asset_root').'/js/app.js'
		);

		$data['vehicles']     = $this->Vehicle_model->get_vehicles();
		$data["locations"]    =   $this->Locations_model->get_locations();
		$data['users']        =  $this->ion_auth->users('agent')->result();
		$this->load->view('admin/header', $data);
		$this->load->view('admin/booking', $data);
		$this->load->view('admin/footer', $data);
	}

    public function booking_list(){
        if($this->input->is_ajax_request()){
            $list = $this->TDBooking_model->get_datatables();
            $data = array();
            $no = $_POST['start'];

            foreach ($list as $booking) {
                $no++;
                $row = array();
                $row[] = $booking->vehicle_booking_id;
                $row[] = $booking->booking_number;
                $row[] = ucfirst($booking->payment_method);
                $row[] = $booking->total;
                $row[] = $booking->status;
                $row[] = $this->hasher->encrypt($booking->vehicle_booking_id);
                $data[] = $row;
            }
    
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->TDBooking_model->count_all(),
                "recordsFiltered" => $this->TDBooking_model->count_filtered(),
                "data" => $data,
            );
            header('Content-Type: application/json');
            echo json_encode($output);
        }else{
            $response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
            header("Content-type: application/json");	
            echo json_encode($response);
        }
	}

	public function get_booking_details($vehicle_booking_id){
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

		$data['bookingid'] = $this->hasher->decrypt($vehicle_booking_id);

		$data['js'] = array(
			$this->config->item('app_backend_asset_root').'/js/jquery.dataTables.js',
			$this->config->item('app_backend_asset_root').'/js/dataTables.bootstrap4.js',
			$this->config->item('app_backend_asset_root').'/js/responsive.dataTables.js',
			$this->config->item('app_backend_asset_root').'/js/datatables.js',
			$this->config->item('app_backend_asset_root').'/js/notie.js',
			$this->config->item('app_backend_asset_root').'/js/app.js'
		);


		$this->load->view('admin/header', $data);
		$this->load->view('admin/booking_details', $data);
		$this->load->view('admin/footer', $data);


	}

	public function delete_booking(){
		if($this->input->is_ajax_request()){
			$booking_id  = $this->input->post('booking_id', TRUE);
			$this->Booking_model->delete_bookings($this->hasher->decrypt($booking_id));
			$response  =  array('type' => 'success', 'message' =>  "Booking has been deleted successfully");
            header("Content-type: application/json");	
            echo json_encode($response);
		}else{
			$response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
			header("Content-type: application/json");	
			echo json_encode($response);
		}
	}

	public function update_booking_status($vehicle_booking_id){
		$current_status = $this->Booking_model->get_booking_status($this->hasher->decrypt($vehicle_booking_id));
		if($current_status == "pending"){
		   $form_data['status'] = "confirmed";
		   //TO DO send confirm mail
		}else{
		   $form_data['status'] = "pending";
		}
		$this->Booking_model->update_booking_status($this->hasher->decrypt($vehicle_booking_id), $form_data);
		$this->session->set_flashdata('success', "Booking has been updated successfully!");
		redirect('admin/booking', 'refresh');
	}

	public function delete_booking_multiple(){
		if($this->input->is_ajax_request()){
			$booking_id  = $this->input->post('booking_id', TRUE);
			if(!empty($this->input->post('booking_id', TRUE))){
				foreach($booking_id as $bk){
					$this->Booking_model->delete_bookings($bk);
				}
				$response  =  array('type' => 'success', 'message' =>  "Booking has been deleted successfully");
				header("Content-type: application/json");	
				echo json_encode($response);
			}else{
				$response  =  array('type' => 'error', 'message' =>  "Something went wrong please try again later");
				header("Content-type: application/json");	
				echo json_encode($response);
			}
		}else{
			$response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
			header("Content-type: application/json");	
			echo json_encode($response);
		}
	}

	public function get_revenue_report(){
		if($this->input->is_ajax_request()){

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
				$monthdata	=	$this->Vehicle_model->get_earning_month_report($date);
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

	public function settings(){
		$this->load->view('admin/header');
		$this->load->view('admin/settings');
		$this->load->view('admin/footer');
	}

	public function save_settings(){
		$date_format     = $this->input->post('date_format', TRUE);
		$time_format     = $this->input->post('time_format', TRUE);
		$rent_interval   = $this->input->post('rent_interval', TRUE);
		$calculate_type  = $this->input->post('calculate_type', TRUE);
		$currency_symbol = $this->input->post('currency_symbol', TRUE);
		$deposit         = $this->input->post('deposit', TRUE);
		$deposit_type    = $this->input->post('deposit_type', TRUE);
		$tax             = $this->input->post('tax', TRUE);
		$tax_type        = $this->input->post('tax_type', TRUE);
		$age_tax         = $this->input->post('age_tax', TRUE);
		$age_tax_type    = $this->input->post('age_tax_type', TRUE);
		$age_for_tax     = $this->input->post('age_for_tax', TRUE);

		$this->Vehicle_model->update_global_settings('date_format', $date_format);
		$this->Vehicle_model->update_global_settings('time_format', $time_format);
		$this->Vehicle_model->update_global_settings('rent_interval', $rent_interval);
		$this->Vehicle_model->update_global_settings('calculate_type', $calculate_type);
		$this->Vehicle_model->update_global_settings('currency_symbol', $currency_symbol);
		$this->Vehicle_model->update_global_settings('deposit', $deposit);
		$this->Vehicle_model->update_global_settings('deposit_type', $deposit_type);
		$this->Vehicle_model->update_global_settings('tax', $tax);
		$this->Vehicle_model->update_global_settings('tax_type', $tax_type);
		$this->Vehicle_model->update_global_settings('age_tax', $age_tax);
		$this->Vehicle_model->update_global_settings('age_tax_type', $age_tax_type);
		$this->Vehicle_model->update_global_settings('age_for_tax', $age_for_tax);
		
		$this->session->set_flashdata('success', "Settings has been updated successfully!");
		redirect('admin/settings', 'refresh');
	}

	public function booking_calendar(){
		$data['css'] = array(
			$this->config->item('app_backend_asset_root').'/css/fullcalendar.css'
		);

		$data['js'] = array(
			$this->config->item('app_backend_asset_root').'/js/fullcalendar.js',
			$this->config->item('app_backend_asset_root').'/js/app.js'
		);


		$this->load->view('admin/header', $data);
		$this->load->view('admin/booking_calendar', $data);
		$this->load->view('admin/footer', $data);
	}

	public function get_calendar_events(){
		if($this->input->is_ajax_request()){
			$calendar_events = $this->Booking_model->get_booking();
			$data = array();
			foreach($calendar_events as $ce){
				$events = new stdClass();
				$events->id = $ce->vehicle_booking_id;
				$events->start = nice_date(unix_to_human($ce->start_time), 'Y-m-d');
				$events->end = nice_date(unix_to_human($ce->end_time), 'Y-m-d');
				$events->title = ucwords($ce->booking_number); 
				$events->pickup = $this->Locations_model->get_location_by_id($ce->pickup_location_id)->name; 
				$events->drop = $this->Locations_model->get_location_by_id($ce->return_location_id)->name; 
				array_push($data, $events); 
			}
			header("Content-type: application/json");	
			echo json_encode($data);
		}else{
			$response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
			header("Content-type: application/json");	
			echo json_encode($response); 
		}
	}

	public function check_default($selection){
		if ($selection == '0'){
			$this->form_validation->set_message('check_default', 'Please Select An Option');
			return FALSE;
		}else{
			return TRUE;
		}
		// if ($_POST['location'] == '0'){
		// 	$this->form_validation->set_message('check_default', 'You need to select something other than the default');
		// 	return FALSE;
		// }else{
		// 	return TRUE;
		// }
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

	public function user_profile_image_check(){
		if(isset($_FILES['avatar']) && !empty($_FILES['avatar']) && $_FILES['avatar']['name'] != ""){
			$config['upload_path']      = 'frontend/images/profile/'; 
			$config['allowed_types']    = 'jpg|jpeg|png|gif';
			$config['max_size']         = '5000'; 
			$config['file_name']        =  random_string('numeric', 5);;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
	
			if($this->upload->do_upload('avatar')){
				array_push($this->cached_data, $this->upload->data()['file_name']);
				return TRUE;
			}else{
				$this->form_validation->set_message('user_profile_image_check', $this->upload->display_errors());
				return FALSE;
			}
		}else{
			return TRUE;
		}
	}

    public function access_level_verifier(){
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()){
            return true;
        }else{
            $this->session->set_flashdata('message', "You must be an administrator to view this page");
            redirect('auth/login');
        }
	}
	
}
