<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Controller/nothankyou
 *
 * Loads the nothankyou view
 *
 * Author: Reid Fortier
 *
 * Created: 2013-05
 * Last Edited: 2013-08-22
*/
class Nothankyou extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		
		//$this->validuser(); //Shouldn't need it
	}
	
	public function view($page = 'No Thank You')
	{
		if( ! file_exists('application/views/nothankyou.php'))
		{
			//Whoops, we don't have a page for that!
			show_404();
		}

		$data['title'] = ucfirst($page); // Capitalize the first letter

		$this->load->view('templates/header', $data);
		$this->load->view('nothankyou');
		$this->load->view('templates/footer');
	}
}
