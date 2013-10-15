<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Controller/PreTrip2
 *
 * Provides db calls and data processing for the pretrip worksheet 2
 *
 * Author: Reid Fortier, Josh Smith
 *
 * Created: 2013-05 
 * Last Edited: 2013-08-22
*/

class Pretrip2 extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->validuser();
		
		//Models
		$this->load->model('pretrip_model');
		$this->load->model('profile_info');
        $this->load->model('view_trips_model');
		
		//Helpers
		$this->load->helper('form');
		$this->load->helper('array');
		$this->load->helper('date');
		
		//Libraries
		$this->load->library('form_validation');
	}
	
	
	public function save()
	{
		//Validation
		
		$this->form_validation->set_rules('trip_id', 'Trip ID', 'trim|required');
        $this->form_validation->set_rules('return_to', 'Return To', 'trim|required');

		if ($this->form_validation->run() != FALSE)
		{
			//Save to the database
			$form_data = $this->input->post();
			$data['form_data'] = $form_data;
            $return_to = $form_data['return_to'];
			
			$trip_id = element('trip_id', $form_data);
			
			// get the agency associated with the trip:
			$agent_id = $this->pretrip_model->getAgencyID($trip_id);
			
			//Privately Owned Vehicle Mileage
			$this->pretrip_model->mileageDatabaseDelete(element('trip_id', $form_data));
			for ($count = 0; $count < 5; $count++)
			{
				if(isset($form_data['miles_'.$count]) && $form_data['miles_'.$count] > 0)
				{
					$data_array = array(element('trip_id', $form_data), element('from_'.$count, $form_data), element('to_'.$count, $form_data), element('miles_'.$count, $form_data));
					$this->pretrip_model->mileageDatabaseUpdate($data_array);
				}
			}
			
			//Misc Expenses
			$this->pretrip_model->miscDatabaseDelete(element('trip_id', $form_data));
			for ($count = 0; $count < 5; $count++)
			{
				if($form_data['amount_'.$count] > 0)
				{
					$data_array = array(element('trip_id', $form_data), element('expense_'.$count, $form_data), element('amount_'.$count, $form_data));
					$this->pretrip_model->miscDatabaseUpdate($data_array);
				}
			}
			
			//Per Deim
			$this->pretrip_model->perDeimDatabaseDelete(element('trip_id', $form_data));
			for ($count = 0; $count < 7; $count++)
			{
				if($form_data['per_deim_rate_'.$count] > 0)
				{
					$data_array = array(element('trip_id', $form_data), date('Y-m-d', strtotime($this->input->post('per_deim_date_'.$count))), element('per_deim_from_'.$count, $form_data), date('H:i:s', strtotime($this->input->post('per_deim_departure_'.$count))), element('per_deim_to_'.$count, $form_data), date('H:i:s', strtotime($this->input->post('per_deim_arrival_'.$count))), element('per_deim_b_'.$count, $form_data), element('per_deim_l_'.$count, $form_data), element('per_deim_d_'.$count, $form_data), element('per_deim_hotel_'.$count, $form_data), element('per_deim_days_'.$count, $form_data));
					$this->pretrip_model->perDeimDatabaseUpdate($data_array);
				}
			}
			
			//Registration
			if(isset($form_data['registration']))
			{
				$amount = $form_data['registration'];
				
				$payby = element('reg_paid', $form_data);
				// if the user didn't select an option default to department travel acct. for payby:
				if ($payby == 0)
				{
					$payby = 2;
				}
				
				$data_array = array(element('trip_id', $form_data), $amount, $payby);
				$this->pretrip_model->registrationDatabaseUpdate($data_array);
			}
            if(!isset($form_data['registration']) || $form_data['registration'] <= 0)
            {
                $this->pretrip_model->registrationDatabaseDelete(element('trip_id', $form_data));
            }
			
			//Airfare
			if(isset($form_data['airfare_artistic'])) // Agency ID - 7 -- change to $agent_id
			{
				$amount = $form_data['airfare_artistic'];
				$data_array = array(element('trip_id', $form_data), $agent_id, 1, $amount);
				$this->pretrip_model->travelQuotesDatabaseUpdate($data_array);
				//Transfer Requests
				$data_array = array(element('trip_id', $form_data), 1, 2, $agent_id);
				$this->pretrip_model->transferRequestsDatabaseUpdate($data_array);
			}
			
			// Train
			if(isset($form_data['train_quote'])) // Agency ID - 7
			{
				$amount = $form_data['train_quote'];
				$data_array = array(element('trip_id', $form_data), $agent_id, 2, $amount);
				$this->pretrip_model->travelQuotesDatabaseUpdate($data_array);
				//Transfer Requests
				$data_array = array(element('trip_id', $form_data), 2, 2, $agent_id);
				$this->pretrip_model->transferRequestsDatabaseUpdate($data_array);
			}

			// bus
			if(isset($form_data['bus_quote'])) // Agency ID - 7
			{
				$amount = $form_data['bus_quote'];
				$data_array = array(element('trip_id', $form_data), $agent_id, 3, $amount);
				$this->pretrip_model->travelQuotesDatabaseUpdate($data_array);

			}
			
			// motor pool
			if(isset($form_data['mpool_quote'])) 
			{
				$amount = $form_data['mpool_quote'];
				$data_array = array(element('trip_id', $form_data), $agent_id, 4, $amount);
				$this->pretrip_model->travelQuotesDatabaseUpdate($data_array);

			}

			// charter vehicle
			if(isset($form_data['charter_quote'])) 
			{
				$amount = $form_data['charter_quote'];
				$data_array = array(element('trip_id', $form_data), $agent_id, 7, $amount);
				$this->pretrip_model->travelQuotesDatabaseUpdate($data_array);

			}
			
			// courtesy car
			if(isset($form_data['courtesy_quote'])) 
			{
				$amount = $form_data['courtesy_quote'];
				$data_array = array(element('trip_id', $form_data), $agent_id, 8, $amount);
				$this->pretrip_model->travelQuotesDatabaseUpdate($data_array);


			}
			
			//Rental Car
			if(isset($form_data['rental_car_enterprise'])) 
			{
				$amount = $form_data['rental_car_enterprise'];
				$data_array = array(element('trip_id', $form_data), $agent_id, 6, $amount);
				$this->pretrip_model->travelQuotesDatabaseUpdate($data_array);
				//Transfer Requests
				
				$payby = element('rental_paid', $form_data);
				// if the user didn't select an option default to department travel acct. for payby:
				if ($payby == 0)
				{
					$payby = 2;
				}
				
				$data_array = array(element('trip_id', $form_data), 6, $payby, $agent_id);
				$this->pretrip_model->transferRequestsDatabaseUpdate($data_array);
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
                $this->view_trips_model->submittedDatabaseUpdate(element('trip_id', $form_data), 1);
                // *************SEND EMAIL FOR SUBMITTING*************
				$DTCemails = $this->pretrip_model->getDTCEmails();
				foreach($DTCemails->result() as $row)
				{
					$this->load->library('email');

					$this->email->from('cstrav@csmail.cslabs.ewu.edu', 'Travel Voucher App');
					
					$this->email->to($row->email);

					$this->email->subject('Pre-trip form has been submitted!!!');
					
					$name = $this->pretrip_model->getName($this->cas->get_user());
					
					$message = '<p>'.$name.' has submitted a pre-trip form for review. </p>
								<p> Trip id: '.element('trip_id', $form_data).'.</p>
								<p>Thank You</p>';
					$this->email->message($message);

					$this->email->send();
				}
                if($return_to == 1)
                {
                    redirect('triplist/view');
                } else
                {
                    redirect('triplist/dtcview');
                }
            }
		}
		else
		{
			//Not saving
            echo "Breaking!<br />";
            echo validation_errors();
		}
	}
}
