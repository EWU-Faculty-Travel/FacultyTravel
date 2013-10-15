<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Controller/logout
 *
 * Loads the logout view
 *
 * Author: Reid Fortier
 *
 * Created: 2013-05
 * Last Edited: 2013-08-22
*/
class Logout extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->validuser();
	}
	public function view($page = 'logout')
	{
		if( ! file_exists('application/views/logout.php'))
		{
			//Whoops, we don't have a page for that!
			show_404();
		}
		$data['title'] = ucfirst($page); // Capitalize the first letter

		$this->load->view('templates/header', $data);
		$this->load->view('logout');
		$this->load->view('templates/footer');
		$this->cas->logout();
	}
}
