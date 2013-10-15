<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends MY_Controller
{
	
	function __construct()
	{
		parent::__construct();
		
		$this->validuser();
	}
	
	public function view($page = 'Test', $success = 0)
	{
		$this->load->view('/templates/header');
		$this->load->view('test');
/*
		if( !file_exists('application/views/facultyprofile.php') || ! file_exists('application/views/dtcprofile.php') || ! file_exists('application/views/taprofile.php'))
		{
				//Whoops, we don't have a page for that!
				show_404();
		}

		//Helpers
		$this->load->helper('form');
		$this->load->helper('array');

		//Models
		$this->load->model('profile_info');
		
		//Libraries
		$this->load->library('form_validation');

		//Database pull
		$query = $this->user_roles->databaseQuery();
		//$data['user_role'] = $query;
		
		//Set validation rules
		$this->form_validation->set_rules('id', 'School ID', 'trim|required|exact_length[8]|numeric');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('phone', 'Phone number', 'trim|required|exact_length[10]|numeric');
		$this->form_validation->set_rules('ext', 'Extension', 'trim|numeric');
		$this->form_validation->set_rules('street', 'Street', 'trim|required');
		$this->form_validation->set_rules('city', 'City', 'trim|required');
		$this->form_validation->set_rules('state', 'State', 'trim|required|exact_length[2]|alpha');
		$this->form_validation->set_rules('zip', 'Zip', 'trim|required|exact_length[5]|numeric');


		$data['title'] = ucfirst($page); // Capitalize the first letter

		$this->load->view('templates/header', $data);
		$this->load->view('templates/dynamicnavbar');

		foreach($query->result() as $query)
		{
			if($query->role_id == 1)
			{
				$profile = $this->profile_info->databaseQuery();
				$data['profile'] = $profile;
				$data['success'] = $success;
				if ($this->form_validation->run() != FALSE)
				{
					//Save to the databse
					$form_data = $this->input->post();
					$data['form_data'] = $form_data;
					$checked = (isset($_POST['tooltips']))?true:false;

					if($checked == true)
					{
						$data_array = array(element('name', $form_data), element('id', $form_data), element('email', $form_data), element('phone', $form_data), element('ext', $form_data), element('city', $form_data), element('state', $form_data), element('zip', $form_data), element('street', $form_data), 1, $this->cas->get_user());
					} else
					{
						$data_array = array(element('name', $form_data), element('id', $form_data), element('email', $form_data), element('phone', $form_data), element('ext', $form_data), element('city', $form_data), element('state', $form_data), element('zip', $form_data), element('street', $form_data), 0, $this->cas->get_user());
					}
					$this->profile_info->databaseUpdate($data_array);
					
					$this->load->view('facultyprofile', $data);
				} else
				{
					$data['post'] = $_POST;
					$this->load->view('failedfacultyprofile', $data);
				}
			}
			if($query->role_id == 2)
			{
				$this->load->view('dtcprofile');
			}
			if($query->role_id == 3)
			{
				$this->load->view('taprofile');
			}
		}
		$this->load->view('templates/footer');
*/
	}
}