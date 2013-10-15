<?php
/* Controller/deleteusers
 *
 * Provides logic and functionality for deleting users from the
 * travel application.
 *
 * Author: Josh Smith
 *
 * Created: 2013-07-28
 * Last Edited: 2013-07-28
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Deleteuser extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->validuser();
		
		//Models
		$this->load->model('profile_info');
		$this->load->model('user_roles');
		
		//Helpers
		$this->load->helper('array');
		$this->load->helper('form');		
		
		//Libraries
		$this->load->library('form_validation');
	}
	
	// Provides the logic displaying the adduser form and loads
	// the page view for the user
	public function view($page = 'Add User')
	{		
		/*
			
		Ideally the inital delete view would present the user with
		a form to select which dept. to find the user in to delete.
		As we are coding for just the CSCD deptartment we'll skip
		that step and move to the usersView which will load the users
		for the selected dept. In a multi dept. system this would be
		done in the update() function. [2013-7-28 Josh Smith]
		
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
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/dynamicnavbar');
		
		// this  view not built: [2013-07-28 JDS]
		$this->load->view('selectdept', $data);

		$this->load->view('templates/footer'); */
		

		// skip offering a choice and get right to listing the CSCD
		// users.
		
		$this->usersView('CSCD', 'Select User to Delete', 0);
	}
	
	// Loads the view presenting the users in a dept. for selection for deletion
	public function usersView($dept, $page = 'Select User to Delete', $success = 0)
	{
		if( ! file_exists('application/views/deleteuser.php'))
		{
			//Whoops, we don't have a page for that!
			show_404();
		}

		$data['title'] = ucfirst($page); // Capitalize the first letter
		$data['success'] = $success;
		$data['dept'] = $dept;
		
		// query for user list:
		$users = $this->user_roles->getDeptUsers($dept);
		
		$data['users'] = $users;
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/dynamicnavbar');
		
		$this->load->view('deleteuser', $data);
		$this->load->view('templates/footer'); 
		
	}
	
	// this function load the view for the user to confirm
	// their selection for deletion:
	public function confirmDelete()
	{
		$data['title'] = 'Confirm User Deletion';
		
		$form_data = $this->input->post();
		
		$dept = $form_data['dept'];
		$username = $form_data['user'];
	
		$data['dept'] = $dept;
		
		echo $dept;
		
		// get user info:
		$profile = $this->profile_info->getUserInfo($username);
		$data['profile'] = $profile;
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/dynamicnavbar');
		
		$this->load->view('confirmdelete', $data);
		$this->load->view('templates/footer'); 
	}

	// handles a confirmed request to delete a user from the system
	public function deleteUser()
	{
		$form_data = $this->input->post();
		
		$dept = $form_data['dept'];
		$username = $form_data['username'];
		
		$this->profile_info->deleteUser($username);
		
		$this->usersView('CSCD', 'Select User to Delete', 1);
	}
}