<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Controller/EditAgent
 *
 * Provides the ability for a DTC to edit their departments
 * preferred travel agency for travel quotes
 *
 * Author: Josh Smith
 *
 * Created: 2013-08-03
 * Last Edited: 2013-08-03
*/

class Editagent extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->validuser();
		
		//Models
		$this->load->model('system_variables');
		$this->load->model('user_roles');
		
		//Helpers
		$this->load->helper('array');
		$this->load->helper('form');		
		
		//Libraries
		$this->load->library('form_validation');
	}
	
	
	// Provides the logic displaying the adduser form and loads
	// the page view for the user
	public function view($page = 'Edit Travel Agents', $success = 0)
	{
		if( ! file_exists('application/views/addusers.php'))
		{
			//Whoops, we don't have a page for that!
			show_404();
		}
		$data['title'] = ucfirst($page); // Capitalize the first letter

		// get only the departments the user is a DTC in:
		$depts = $this->user_roles->getDTCDepartments();

		// set DTC accordion open
		$data['accordion'] = 1;
		// pass success to $data
		$data['success'] = $success;
		
		$this->load->view('templates/header', $data);
        $this->load->view('templates/dynamicnavbar', $data);
		
		// load view per dept:
  		foreach ($depts->result() as $row)
		{
			$data['dept'] = $row->dept_code;
			$query = $this->system_variables->getDeptTravelAgent($row->dept_code);
			
			$agentinfo = $query->row();
			
			$data['name'] = $agentinfo->name;
			$data['phone'] = $agentinfo->phone;
			$this->load->view('editagent', $data);
		}
		$this->load->view('templates/footer');
	}
	
	// form validation & submission
	public function update()
	{

		// set codeigniter rules for server side form validation:
		$this->form_validation->set_rules('agency_name', 'Agency name', 'trim|required');
		$this->form_validation->set_rules('phone', 'Phone number', 'trim|required|trim|required|exact_length[12]');

		// valid data was submitted:
		if ($this->form_validation->run() != FALSE)
		{
			// stuff the posted form data into an array:
			$form_data = $this->input->post();
			
			$update['name'] = $form_data['agency_name'];
			$update['phone'] = $form_data['phone'];
			$update['dept'] = $form_data['dept'];
		
			$this->system_variables->saveDeptTravelAgent($update);
			$this->view($page = 'Edit Travel Agent', $success = 1);
		}
		else
		{
			$this->view($page = 'Edit Travel Agent', $success = 2); 
		}
	}
}