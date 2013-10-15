<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Controller/PreTrip
 *
 * Provides db calls and data processing for the pretrip worksheet 1
 *
 * Author: Reid Fortier, Josh Smith
 *
 * Created: 2013-05 
 * Last Edited: 2013-08-22
*/

class Pretrip extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->validuser();
		
		//Models
		$this->load->model('pretrip_model');
		$this->load->model('profile_info');
		$this->load->model('system_variables');
		
		//Helpers
		$this->load->helper('form');
		$this->load->helper('array');
		$this->load->helper('date');
		
		//Libraries
		$this->load->library('form_validation');
		$this->load->library('table');
		
		$this->profileForce($this->cas->get_user());
	}
    
	public function view($page = 'Pre-Trip Worksheet 1', $success = 0)
    {
    	if( ! file_exists('application/views/pretrip1.php') || ! file_exists('application/views/pretrip2.php'))
		{
			//Whoops, we don't have a page for that!
			show_404();
		}
		$data['title'] = ucfirst($page); // Capitalize the first letter

		$this->load->view('templates/header', $data);
		$this->load->view('templates/dynamicnavbar');
		
		$data['success'] = $success;
		
		//Database pull
		$dept = $this->pretrip_model->deptDatabaseQuery();
		$data['dept'] = $dept;
		$profile = $this->profile_info->databaseQuery();
		$data['profile'] = $profile;
        $data['body_title'] = "New Trip - Pre-Trip Worksheet 1";
		
		$this->load->view('pretrip1', $data);
		$this->load->view('templates/footer');
	}
	
	// saves the first worksheet's data
	public function save()
	{
		//Validation
        $this->form_validation->set_rules('trip_id', 'Trip ID', 'trim|required');
		$this->form_validation->set_rules('trip_name', 'Trip Name', 'trim|required');
		$this->form_validation->set_rules('start_date', 'Start Date', 'trim|required'); //Number date
		$this->form_validation->set_rules('end_date', 'End Date', 'trim|required'); //Number date
        $this->form_validation->set_rules('sidetrip', 'Sidetrip', 'trim');
        $this->form_validation->set_rules('start_side', 'start date for side trip', 'trim'); //Number date
		$this->form_validation->set_rules('end_side', 'end date for side trip', 'trim'); //Number date
		$this->form_validation->set_rules('ext', 'Extension', 'trim|numeric');
		$this->form_validation->set_rules('departure', 'Departure', 'trim|required');
		$this->form_validation->set_rules('destination', 'Destination', 'trim|required');
		$this->form_validation->set_rules('purpose', 'purpose of the trip', 'trim|required|max_length[250]'); //Need punctuation
		$this->form_validation->set_rules('group_count', 'number of people going on the trip', 'trim|required|integer');
        $this->form_validation->set_rules('plane', 'Airplane', 'trim');
        $this->form_validation->set_rules('train', 'Train', 'trim');
        $this->form_validation->set_rules('bus', 'Bus', 'trim');
        $this->form_validation->set_rules('ewu_motorpool', 'EWU Motorpool', 'trim');
        $this->form_validation->set_rules('private_car', 'Private Car', 'trim');
        $this->form_validation->set_rules('rental_car', 'Rental Car', 'trim');
        $this->form_validation->set_rules('charter', 'Charter', 'trim');
        $this->form_validation->set_rules('courtesy', 'Courtesy', 'trim');

		if ($this->form_validation->run() != FALSE)
		{
			//Save to the database
			$form_data = $this->input->post();
			$data['form_data'] = $form_data;
			
			$user_id = $this->pretrip_model->userIDDatabaseQuery()->row()->user_id;
            
			if(isset($form_data['return_to']))
			{
				$return_to = $form_data['return_to'];
			}
			else
			{
				$return_to = 1;
			}

			$trip_id = $form_data['trip_id'];
			
            if($trip_id == 0)
            {
                $data_array = array(element('dept_code', $form_data), element('trip_name', $form_data), $user_id, date('Y-m-d H:i:s', strtotime($this->input->post('start_date'))), date('Y-m-d H:i:s', strtotime($this->input->post('end_date'))), element('departure', $form_data), element('destination', $form_data), element('purpose', $form_data), element('group_count', $form_data));
                $this->pretrip_model->pageOneDatabaseSave($data_array);
                $trip_id = $this->pretrip_model->tripIDDatabaseQuery()->row()->trip_id;
            } else
            {
                $user_id = $this->pretrip_model->originalUserIDDatabaseQuery($trip_id)->row()->user_id;
                $data_array = array(element('dept_code', $form_data), element('trip_name', $form_data), $user_id, date('Y-m-d H:i:s', strtotime($this->input->post('start_date'))), date('Y-m-d H:i:s', strtotime($this->input->post('end_date'))), element('departure', $form_data), element('destination', $form_data), element('purpose', $form_data), element('group_count', $form_data), $trip_id);
                $this->pretrip_model->pageOneDatabaseUpdate($data_array);
            }
            $data['trip_id'] = $trip_id;

            //Modes
    		$plane = (isset($_POST['plane']))?$this->pretrip_model->modesDatabaseSave($trip_id, 1):$this->pretrip_model->modesDatabaseDelete($trip_id, 1);
    		$train = (isset($_POST['train']))?$this->pretrip_model->modesDatabaseSave($trip_id, 2):$this->pretrip_model->modesDatabaseDelete($trip_id, 2);
    		$bus = (isset($_POST['bus']))?$this->pretrip_model->modesDatabaseSave($trip_id, 3):$this->pretrip_model->modesDatabaseDelete($trip_id, 3);
    		$ewu_motorpool = (isset($_POST['ewu_motorpool']))?$this->pretrip_model->modesDatabaseSave($trip_id, 4):$this->pretrip_model->modesDatabaseDelete($trip_id, 4);
    		$private_car = (isset($_POST['private_car']))?$this->pretrip_model->modesDatabaseSave($trip_id, 5):$this->pretrip_model->modesDatabaseDelete($trip_id, 5);
    		$rental_car = (isset($_POST['rental_car']))?$this->pretrip_model->modesDatabaseSave($trip_id, 6):$this->pretrip_model->modesDatabaseDelete($trip_id, 6);
    		$charter = (isset($_POST['charter']))?$this->pretrip_model->modesDatabaseSave($trip_id, 7):$this->pretrip_model->modesDatabaseDelete($trip_id, 7);
    		$courtesy = (isset($_POST['courtesy']))?$this->pretrip_model->modesDatabaseSave($trip_id, 8):$this->pretrip_model->modesDatabaseDelete($trip_id, 8);
			
			
			//Sidetrip
			if(isset($_POST['sidetrip']))
			{
				$this->pretrip_model->sidetripDatabaseSave($trip_id, date('Y-m-d H:i:s', strtotime($this->input->post('start_side'))), date('Y-m-d H:i:s', strtotime($this->input->post('end_side'))));
			} else
			{
				$this->pretrip_model->sidetripDatabaseDelete($trip_id);
			}
			
			if(isset($_POST["save"]))
			{
                if($return_to == 1)
                {
                    redirect('triplist/view');
                } else
                {
                    redirect('triplist/dtcview');
                }
			} else if(isset($_POST["submit"])) // ******PRETRIP PAGE 2******
			{
				$page = "Pre-Trip Worksheet 2";
				$data['body_title'] = 'New Trip - Pre-Trip Worksheet 2';
				$data['title'] = ucfirst($page); // Capitalize the first letter
                $data['return_to'] = element('return_to', $form_data);

				$data['accordion'] = element('return_to', $form_data) - 1;
				$this->load->view('templates/header', $data);
				$this->load->view('templates/dynamicnavbar');
				
				$data['success'] = 0;
				
				//Database pull
				$modes = $this->pretrip_model->modesDatabaseQuery($trip_id);
				$data['modes'] = $modes;
				$rate = $this->pretrip_model->mileageRateDatabaseQuery()->row()->mileage_rate;
				$data['rate'] = $rate;
				
				// pull travel agency name:
				$agency_dept = element('dept_code', $form_data);
				$agency_record = $this->system_variables->getDeptTravelAgent($agency_dept);

                //Per Deim Percentages
                $data['breakfast_rate'] = $this->pretrip_model->perDeimRatesDatabaseQuery()->row()->breakfast;
                $data['lunch_rate'] = $this->pretrip_model->perDeimRatesDatabaseQuery()->row()->lunch;
                $data['dinner_rate'] = $this->pretrip_model->perDeimRatesDatabaseQuery()->row()->dinner;
				
				
				if ($agency_record->num_rows() > 0)
				{		
					$row = $agency_record->row();

					$data['travel_agent'] = $row->name;
					$data['travel_phone'] = $row->phone;
				}
				else
				{
					$data['travel_agent'] = 'An error has occured: contact your DTC';
					$data['travel_phone'] = '999-9999';
				}

				$this->load->view('pretrip2', $data);
				$this->load->view('templates/footer');
			}
		}
		else
		{
            redirect('triplist/view');
		}
	}
}
