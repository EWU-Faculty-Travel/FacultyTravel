<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Controller/addusers
 *
 * Provides logic and functionality for adding users to the
 * travel application.
 *
 * Author: Josh Smith
 *
 * Created: 2013-07-24
 * Last Edited: 2013-07-28
*/

class Addusers extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->validuser();
		
		//Models
		$this->load->model('profile_info');
		$this->load->model('user_roles');
		$this->load->model('station_edit');
		
		//Helpers
		$this->load->helper('array');
		$this->load->helper('form');		
		
		//Libraries
		$this->load->library('form_validation');
		
		$this->securityCheck();
		$this->profileForce($this->cas->get_user());
	}
	
	// controls the accordion view if dtc link is clicked
	public function dtcview()
	{
		$this->view('Add User', 0, 1);
	}

	// controls the accordion view if the ta link is clicked
	public function taview()
	{
		$this->view('Add User', 0, 2);
	}
	
	// Provides the logic displaying the adduser form and loads
	// the page view for the user
	public function view($page = 'Add User', $success = 0, $accordion = 0)
	{
		if( ! file_exists('application/views/addusers.php'))
		{
			//Whoops, we don't have a page for that!
			show_404();
		}
		$data['title'] = ucfirst($page); // Capitalize the first letter

		// check if user is a travel admin
		if ($this->user_roles->isTravelAdmin() == true)
		{
			// yes get all the departments from the system:
			$depts = $this->user_roles->getAllDepartments();
		}
		else
		{
			// get only the departments the user is a DTC in:
			$depts = $this->user_roles->getDTCDepartments();
		}
		
		// pass deptartments to data
		$data['depts'] = $depts;
		$data['success'] = $success;
		// pass accordion container to activate
		$data['accordion'] = $accordion;
		
		$stations = $this->station_edit->databaseQuery();
		
		// pass valid stations to $data
		$data['stations'] = $stations;
		
		$this->load->view('templates/header', $data);
	
        $this->load->view('templates/dynamicnavbar', $data);
				
		$this->load->view('addusers', $data);

		$this->load->view('templates/footer');
	}
	
	// form validation & submission
	public function update()
	{

		// set codeigniter rules for server side form validation:
		$this->form_validation->set_rules('user_name', 'User name', 'trim|required');
		$this->form_validation->set_rules('ewu_id', 'EWU ID', 'trim|required|min_length[8]|max_length[8]|numeric');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|matches[email2]');
		$this->form_validation->set_rules('email2', 'Confirm Email', 'trim|required|valid_email');

		// stuff the posted form data into an array:
		$form_data = $this->input->post();
		$accordion = $form_data['accordion'];
		
		// valid data was submitted:
		if ($this->form_validation->run() != FALSE)
		{
			$user_name = $form_data['user_name'];
			$email = $form_data['email'];
			$dept_code = $form_data['dept_code'];
			$ewu_id = $form_data['ewu_id'];
			$station = $form_data['station_id'];
			
		
			// see if user exists already:
			$user_id = $this->profile_info->getUserID($user_name);
			
			// user doesn't exist at all, insert into db
			if ($user_id < 0)
			{
				$continue = $user_id = $this->profile_info->addUser($user_name, $email, $ewu_id, $station);
				if ( $continue < 0)
				{
					//$continue = -1 * $continue;
				}
				else
				{
					$this->load->library('email');

					$this->email->from('cstrav@csmail.cslabs.ewu.edu', 'Travel Voucher App');
					$this->email->to($email);

					$this->email->subject('You need to update your profile');
					$message = '<p>You have been added to the Travel Voucher Application!!!!!  </p>
								<p>You now need to fill out your profile by going to           '.base_url().'</p>
								<p>You must fill out your profile before you can submit any travel vouchers. </p>
								<p>Thank You</p>';
					$this->email->message($message);

					$this->email->send();
				}
				echo $this->email->print_debugger();
			}
			else
			{
				$continue = $user_id;
			}

			
			if ($continue > 0)
			{
				$continue = $this->user_roles->addUserRole($user_id, 1, $dept_code);
				
				if ( $continue < 0)
				{
					// push error to view (user was already in dept)
					$this->view($page = 'Add User', -3, $accordion);		
				}
				else
				{
					// reset the field data on the form:
					$this->form_validation->unset_field_data();
			
					$this->view($page = 'Add User', 1, $accordion);
				}
			}
			else // push errors from adding user to view
			{
				$this->view($page = 'Add User', $continue, $accordion);
			}
		}
		else
		{
			$this->view($page = 'Add User', 2, $accordion); 
		}
	}
}