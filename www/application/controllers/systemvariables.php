<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Controller/systemvariables
 *
 * Controller provides access and logic for displaying and
 * updating application variables for departments and the
 * overall system (for DTCs and TAs)
 *
 * Author: Reid Fortier, Josh Smith
 *
 * Created: 2013-05 
 * Last Edited: 2013-08-22
*/
class Systemvariables extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->validuser();
		
		//Models
		$this->load->model('profile_info');
		$this->load->model('system_variables');
		
		//Helpers
		$this->load->helper('form');
		$this->load->helper('array');
		
		//Libraries
		$this->load->library('form_validation');
	}
	
	// Loads the page to present to the user:
	public function view($page = 'System Variables', $success = 0)
	{
		if(!file_exists('application/views/dtcvars.php') || ! file_exists('application/views/tavars.php'))
		{
			//Whoops, we don't have a page for that!
			show_404();
		}

		$data['accordion'] = 2;
		
		//Database pull: determines the users system roles:
		$query = $this->user_roles->databaseQuery();

		$data['title'] = ucfirst($page); // Capitalize the first letter of the page title

		$this->load->view('templates/header', $data);
		$this->load->view('templates/dynamicnavbar', $data);
		
		// was the data update successful or not?
		$data['success'] = $success;

		// for each role and department display the system var information
		foreach($query->result() as $query)
		{
			/*
			department var editing disabled to simply Version 1 logic, structure still exists
			however 2013-07-27 Josh Smith
			
			if($query->role_id == 2)
			{
				$depts = $this->system_variables->dtcDatabaseQuery();
				$data['dtcpost'] = $_POST;
				foreach($depts->result() as $dept)
				{
					$data['dept_title'] = $dept;
					$data['dept'] = $dept;
					$this->load->view('dtcvars', $data);
				}
			} */
			
			// TA system wide variables
			if($query->role_id == 3)
			{
				$data['taquery'] = $this->system_variables->taDatabaseQuery();
				$data['tapost'] = $_POST;
				$this->load->view('tavars', $data);
			}
		}
		$this->load->view('templates/footer');
	}

	// this function updates the system wide variables:
	public function taUpdate()
	{
		
		$this->form_validation->set_rules('mileageRate', 'Mileage Rate', 'trim|required|greater_than[-.9]');
		$this->form_validation->set_rules('breakfast', 'Breakfast', 'trim|required|greater_than[-.9]');
		$this->form_validation->set_rules('lunch', 'Lunch', 'trim|required|greater_than[-.9]');
		$this->form_validation->set_rules('dinner', 'Dinner', 'trim|required|greater_than[-.9]');
		
		$form_data = $this->input->post();
		
		$validate = $this->form_validation->run();
		$percent_error = FALSE;
		
		if ($validate)
		{
			if (!( $form_data['breakfast'] + $form_data['lunch'] + $form_data['dinner'] == 100))
			{
				$validate = FALSE;
				$percent_error = TRUE;
			}
		}
		
		if ( $validate != FALSE)
		{
			
			//Save to the databse
			
			
			$data['form_data'] = $form_data;
			$data_array = $data['form_data'];
			
			$this->system_variables->taDatabaseUpdate($data_array);
			$this->view($page = 'System Variables', $success = 1);
			//echo "Success = 1";
		}
		else if (!$percent_error)
		{
			$this->view($page = 'System Variables', $success = 2);
			//echo "Success = 2";
		}
		else
		{
			$this->view($page = 'System Variables', $success = 3);
		}
	}
	
	// updates department variables (the department being updated is determined by which form
	// was submitted in the view (department code is a hidden field on each form)
	public function dtcUpdate()
	{
		//Save to the databse
		$box8 = isset($_POST['boxeight']) ? 1 : 0;
		$car = isset($_POST['personalcar']) ? 1 : 0;
		$form_id = $_POST['form_id'];
		
		$data_array = array($car, $box8, $form_id);
		
		$this->system_variables->dtcDatabaseUpdate($data_array);
		$this->view($page = 'System Variables', $success = 3);
	}
}