<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
This is the gateway page.  Users will be directed here automatically upon connection to our site.
For dev purposes, the auto redirect will not be set until we're ready.
*/
class Gateway extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('cas');
		$this->load->helper('url_helper');
	}

	public function index()
	{
		// Check if user is authenticated (i.e. has logged in)
		if (! $this->cas->check_authentication())
                {
                    $this->cas->force_authenticate();
                }
                // set this cookie for later use
				setcookie('accordion', '0', 300000);
                // redirect to dashboard:
				redirect('dashboard/view');
	}
}

/* End of file gateway.php */
/* Location: ./application/controllers/gateway.php */
