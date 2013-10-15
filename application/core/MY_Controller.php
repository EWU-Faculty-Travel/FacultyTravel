<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Core/MY_Controller
 *
 * New base controller that all other controllers inherit
 *
 * Author: Reid Fortier, Jason Helms
 *
 * Created: 2013-07
 * Last Edited: 2013-08-22
*/

class MY_Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		//Models
		$this->load->model('user_roles');

        //Library
		$this->load->library('session');
	}
	
	function validuser()
	{	
		$username = $this->cas->get_user();
		if (strlen($username) < 1)
		{
			redirect('gateway/index');
		} else
		{
			$this->session->set_userdata('user_name', $username);
			//Database pull
			$query = $this->user_roles->databaseQuery();
			if($query->num_rows() < 1) {
				redirect('nothankyou/view');
			}			
			//Empty Body	
		}
	}
	
	function securityCheck()
	{
		$this->load->library('session');
		$user_name_cookie = $this->session->userdata('user_name');
		$user_name = $this->cas->get_user();
		$equal = strcmp($user_name_cookie, $user_name);
		if($equal != 0)
			redirect('gateway/index');
	}
	
	function profileForce($username)
	{
		$profileFilledOut = $this->user_roles->profile($username);
			
			foreach($profileFilledOut->result() as $row)
			{
				if($row->init_profile == 0)
					redirect('dynamicprofile/view');
			}
	}

}