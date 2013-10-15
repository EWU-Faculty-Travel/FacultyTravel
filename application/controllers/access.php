<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 This controls two different views, "access_view" and "access_denied_view"
*/
class Access extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url_helper');
		$this->load->helper('form');
		$this->load->library('cas');

		$this->load->database();
	}

	public function index()
	{
		//init variables used in php
		$data['jqgrids'] = "";
		$data['divTables'] = "";

		$data['orderedGrid'] = "";
		$data['orderedDiv'] = "";

		// Get the username from CAS
		$userName = $this->user_model->getUserName($this->cas->get_user());
		//$userName = $this->cas->get_user();

		// If get NULL from $userName, give meaningful message, instead of NULL.
		if ($userName == NULL)
			$userName = 'Username not found!';
		$data['username']=$userName;

		// Check if user is Admin
		$data['admin'] = $this->user_model->userIsAdmin($this->cas->get_user());

		// Check if user is authenticated (i.e. has logged in)
		$data['authSession']= $this->cas->check_authentication();

		$this->load->view('access_view',$data);
	}//end index

	public function denied()
	{
		$this->load->view('access_denied_view');
	}

	public function accountsettings()
	{
		// Get the current email address.
		$userName = $this->user_model->getUserName($this->cas->get_user());
		$userEmail = $this->email_model->getEmailAddress($userName);
		$data['emailaddress']=$userEmail;

		$this->load->view('accountsettings_view.php', $data);
	}//end accountsettings

	public function manageusers()
	{
		$data['jqgrids'] = "";
		$data['divTables'] = "";

		$data['jqgrids'] = $this->usergrid_model->get_jqgrid();
		$data['divTables'] = $this->jqgrid_model->get_divTables(1, "users");
		$this->load->view('manageusers_view',$data);
	}//end manageusers

	// Displays info about the PHP install, such as,
	// installed libraries, PHP version, etc.
	public function info()
	{
		phpinfo();
	}

	public function submitted()
	{
		$data['jqgrid'] = "";

		$data['divTable']= " ";

		//Generating the table Queries
		$submitted = $this->ordergrid_model->get_All_Orders_Submitted();

		//Rows
		$submittedRows = $submitted->num_rows();

                if($submittedRows != 0)
                {
			$data['jqgrid'] = $this->ordergrid_model->get_jqgrid($submitted, "submitted");
         	        $data['divTable'] = $this->jqgrid_model->get_divTables($submittedRows, "orders", "submitted");

                }
                else
                {
                        //If No tables return No orders String
                        $data['divTable'] = $this->jqgrid_model->no_Orders("orders", 'c');
                }
		$this->load->view('orders_view', $data);
	}
	
	public function updatemail()
	{
		/* if using jQuery, make sure the POST["variable here"] matches up
		 with the 'email', "data: {email: emval}" pair in the AJAX call..
		*/
		$email = $_POST["email"];

		// This is how we return data back to the jQuery result.
		echo $email;


		$userName = $this->user_model->getUserName($this->cas->get_user());
		$this->email_model->setEmailAddress($userName, $email);

	}

}

/* End of file access.php */
/* Location: ./application/controllers/access.php */
