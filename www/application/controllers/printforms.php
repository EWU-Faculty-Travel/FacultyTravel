<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Controller/Printforms
 *
 * Allows the user to print a form 
 * 
 * Author: Jason Helms, Josh Smith
 *
 * Created: 2013-07 
 * Last Edited: 2013-08-25
*/
class Printforms extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->validuser();
		$this->securityCheck();
		
		$this->load->model('print_form');
		
		 //Helpers
		$this->load->helper('form');
		$this->load->helper('array');

		//Libraries
		$this->load->library('form_validation');
		$this->load->library('session');
	}
	
	public function view($page = 'Print Forms')
	{
		if( ! file_exists('application/views/printforms.php'))
		{
			//Whoops, we don't have a page for that!
			show_404();
		}
		$data['title'] = ucfirst($page); // Capitalize the first letter

		$this->load->view('printforms', $data);
	}
}
