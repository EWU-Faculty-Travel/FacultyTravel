<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Controller/dynamicprofile
 *
 * Controller handles logic for loading dynamic profile information for users
 * based on their CAS login id 
 * 
 *
 * Author: Reid Fortier, Josh Smith
 *
 * Created: 2013-05 
 * Last Edited: 2013-08-22
*/

class Dynamicprofile extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->validuser();
		
		//Models
		$this->load->model('profile_info');
		
		//Helpers
		$this->load->helper('form');
		$this->load->helper('array');
		
		//Libraries
		$this->load->library('form_validation');
	}
	
	/*
	 * Loads the view to be presented to the user
	*/
	public function view($page = 'Profile', $success = 0)
	{
		if( !file_exists('application/views/facultyprofile.php'))
		{
			//Whoops, we don't have a page for that!
			show_404();
		}

		//Database pull (determine what roles in the system the user has
		$query = $this->user_roles->databaseQuery();

		// set the page tile:
		$data['title'] = ucfirst($page); // Capitalize the first letter

		// load the page header and navigation bar
		$this->load->view('templates/header', $data);
		$this->load->view('templates/dynamicnavbar');

		// query for the users profile and station information:
		$profile = $this->profile_info->databaseQuery();
		$station = $this->profile_info->stationDatabaseQuery();
		
		// set in $data array for access in the view:
		$data['profile'] = $profile;
		$data['station'] = $station;
		$data['success'] = $success;
		
		
		if($success != 2)
		{
			$this->load->view('facultyprofile', $data);
		} else
		{
			$data['post'] = $_POST;
			$this->load->view('facultyprofile', $data);
		}

		$this->load->view('templates/footer');
	}

	// called if user submits the form to update their information:
	public function update()
	{
		// set codeigniter rules for server side form validation:
		$this->form_validation->set_rules('id', 'School ID', 'trim|required|exact_length[8]|numeric');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('phone', 'Phone number', 'trim|required|exact_length[12]');
		$this->form_validation->set_rules('ext', 'Extension', 'trim|numeric');
		$this->form_validation->set_rules('street', 'Street', 'trim|required');
		$this->form_validation->set_rules('city', 'City', 'trim|required');
		$this->form_validation->set_rules('state', 'State', 'trim|required|exact_length[2]|alpha');
		$this->form_validation->set_rules('zip', 'Zip', 'trim|required|exact_length[5]|numeric');
		$this->form_validation->set_rules('bldg_rm', 'Office Room', 'trim|required');

		if ($this->form_validation->run() != FALSE)
		{
			//Save to the database
			$form_data = $this->input->post();
			$data['form_data'] = $form_data;
			
			// Removing the tool tips functionality (but not structure) 2013-07-27
			
			//$checked = (isset($_POST['tooltips']))?true:false;

			/*
			if($checked == true)
			{
				$data_array = array(element('name', $form_data), element('id', $form_data), element('email', $form_data), element('phone', $form_data), element('ext', $form_data), element('city', $form_data), element('state', $form_data), element('zip', $form_data), element('street', $form_data), element('station_id', $form_data), element('bldg_rm', $form_data), 1, $this->cas->get_user());
			} else
			{
				$data_array = array(element('name', $form_data), element('id', $form_data), element('email', $form_data), element('phone', $form_data), element('ext', $form_data), element('city', $form_data), element('state', $form_data), element('zip', $form_data), element('street', $form_data), element('station_id', $form_data), element('bldg_rm', $form_data), 0, $this->cas->get_user());
			} 
			$this->profile_info->databaseUpdate($data_array);
			$this->view($page = 'Profile', $success = 1);
			*/
		
			// this array set replaces the two above based on the tool_tips which has been commentd out in the view
			$data_array = array(element('name', $form_data), element('id', $form_data), element('email', $form_data), element('phone', $form_data), element('ext', $form_data), element('city', $form_data), element('state', $form_data), element('zip', $form_data), element('street', $form_data), element('station_id', $form_data), element('bldg_rm', $form_data), 0, $this->cas->get_user());

			$this->profile_info->databaseUpdate($data_array);
			$this->view($page = 'Profile', $success = 1);
		}
		else
		{
			$this->view($page = 'Profile', $success = 2);
		}
	}
}