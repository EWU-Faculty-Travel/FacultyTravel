<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Controller/dashboard
 *
 * Provides queries models for information to display to a
 * user regarding their account upon login to travel app.
 *
 * Author: Jason Helms, Josh Smith
 *
 * Created: 2013-05
 * Last Edited: 2013-07-27
*/

class Dashboard extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

		//Models
		$this->load->model('profile_info');
		$this->load->model('user_roles');
		
		//Helpers
		$this->load->helper('array');
		
		$this->validuser();
		$this->profileForce($this->cas->get_user());
	}

	// provides all basic logic and loads views
	public function view($page = 'Dashboard')
	{
		if( ! file_exists('application/views/dashboard.php'))
		{
			//Whoops, we don't have a page for that!
			show_404();
		}
		$data['title'] = ucfirst($page); // Capitalize the first letter
		
		// run DB query against user table:
		$profile = $this->profile_info->databaseQuery();
		$roles = $this->user_roles->fetchRoles();
		$isTravelAdmin = $this->user_roles->isTravelAdmin();
		
		// add query results to be passed to view:
		$data['profile'] = $profile;
		$data['roles'] = $roles;
		$data['isAdmin'] = $isTravelAdmin;
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/dynamicnavbar');
		$this->load->view('dashboard', $data);
		$this->load->view('templates/footer');
	}
}
