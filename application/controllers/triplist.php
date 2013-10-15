<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Controller/TripList
 *
 * Provides access to either the user's trips or the trips for a DTC to edit.
 *
 * Author: Reid Fortier, Josh Smith
 *
 * Created: 2013-05
 * Last Edited: 2013-08-29
*/

class Triplist extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->validuser();

		//Library
		$this->load->library('table');
		$this->load->library('session');
        $this->load->library('email');

		//Helpers
		$this->load->helper('array');
		$this->load->helper('form');

		//Models
		$this->load->model('view_trips_model');
		$this->load->model('profile_info');
		$this->load->model('pretrip_model');
        $this->load->model('posttrip_model');
		$this->load->model('system_variables');
		$this->load->model('print_form');

		$this->profileForce($this->cas->get_user());
	}

	public function view($page = 'Trip Listing', $success = 0)
    {
        if( ! file_exists('application/views/triplist.php'))
        {
            //Whoops, we don't have a page for that!
            show_404();
        }
        $data['title'] = ucfirst($page); // Capitalize the first letter

        $this->load->view('templates/header', $data);
        $this->load->view('templates/dynamicnavbar');

        $trip_id = $this->view_trips_model->allPretripIDDatabaseQuery();
        $data['trip_id'] = $trip_id;
        $triplist = $this->view_trips_model->pretripListDatabaseQuery();
        $data['triplist'] = $triplist;
        $post_trip_id = $this->view_trips_model->allPosttripIDDatabaseQuery();
        $data['post_trip_id'] = $post_trip_id;
        $post_triplist = $this->view_trips_model->posttripListDatabaseQuery();
        $data['post_triplist'] = $post_triplist;
        $data['success'] = $success;
        $data['return_to'] = 1;

        $this->load->view('triplist', $data);

        $this->load->view('templates/footer');
    }

	// provides DTC specific access to deptatrtment trips
    public function dtcview($page = 'DTC Trip Listing', $success = 0)
    {
        if( ! file_exists('application/views/triplist.php'))
        {
            //Whoops, we don't have a page for that!
            show_404();
        }
        $data['title'] = ucfirst($page); // Capitalize the first letter

		$data['accordion'] = 1;
        $this->load->view('templates/header', $data);
        $this->load->view('templates/dynamicnavbar', $data);

        $trip_id = $this->view_trips_model->allPretripIDDTCDatabaseQuery();
        $data['trip_id'] = $trip_id;
        $triplist = $this->view_trips_model->pretripListDTCDatabaseQuery();
        $data['triplist'] = $triplist;
        $post_trip_id = $this->view_trips_model->allPosttripIDDTCDatabaseQuery();
        $data['post_trip_id'] = $post_trip_id;
        $post_triplist = $this->view_trips_model->posttripListDTCDatabaseQuery();
        $data['post_triplist'] = $post_triplist;
        $data['success'] = $success;
        $data['return_to'] = 2;

        $this->load->view('triplist', $data);

        $this->load->view('templates/footer');
    }

	public function action($page = 'Trip Listing')
    {
		$form_data = $this->input->post();
		$data['form_data'] = $form_data;

		if(isset($form_data['return_to']))
		{
			$return_to = $form_data['return_to'];
        }
		else
		{
			$return_to = 1;
		}

		$data['accordion'] = $return_to - 1;

		$data['return_to'] = $return_to;
		$trip_id = $form_data['trip_id'];
        $data['trip_id'] = $form_data['trip_id'];
        $status = $this->view_trips_model->statusCodeDatabaseQuery($trip_id)->row()->status_code;

		if(element('action', $form_data) == 'page1') //EDIT PAGE ONE
        {
			//Database pull
			$dept = $this->pretrip_model->deptDatabaseQuery();
			$data['dept'] = $dept;
			$profile = $this->profile_info->databaseQuery();
			$data['profile'] = $profile;
			$data['body_title'] = "Edit Pre-Trip Worksheet Page 1";
			$data['title'] = "Edit Pre-Trip Worksheet Page 1";

			$this->load->view('templates/header', $data);
			$this->load->view('templates/dynamicnavbar');

            $data['success'] = 0;
			$page_one_data = $this->view_trips_model->pageOneDataDatabaseQuery($trip_id);
			$page_one_modes = $this->view_trips_model->pageOneModesDatabaseQuery($trip_id);
            $page_one_sidetrip = $this->view_trips_model->pageOneSideTripsDatabaseQuery($trip_id);

            if(isset($page_one_sidetrip->row()->trip_start))
			{
				$data['start_side'] = $page_one_sidetrip->row()->trip_start;
            	$data['end_side'] = $page_one_sidetrip->row()->trip_end;
				$data['sidetrip'] = 1;
			}

			foreach($page_one_modes->result() as $page_one_modes)
			{
				if($page_one_modes->mode == 1)
				{
					$data['plane'] = TRUE;
				} else if($page_one_modes->mode == 2)
				{
					$data['train'] = TRUE;
				} else if($page_one_modes->mode == 3)
				{
					$data['bus'] = TRUE;
				} else if($page_one_modes->mode == 4)
				{
					$data['ewu_motorpool'] = TRUE;
				} else if($page_one_modes->mode == 5)
				{
					$data['private_car'] = TRUE;
				} else if($page_one_modes->mode == 6)
				{
					$data['rental_car'] = TRUE;
				} else if($page_one_modes->mode == 7)
				{
					$data['charter'] = TRUE;
				} else if($page_one_modes->mode == 8)
				{
					$data['courtesy'] = TRUE;
				}
			}

            $data['trip_name'] = $page_one_data->row()->trip_name;
			$data['trip_owner'] = $page_one_data->row()->name;
            $data['departure'] = $page_one_data->row()->departure;
            $data['destination'] = $page_one_data->row()->destination;
            $data['purpose'] = $page_one_data->row()->purpose;
            $data['start_date'] = $page_one_data->row()->start_date;
            $data['end_date'] = $page_one_data->row()->end_date;
            $data['group_count'] = $page_one_data->row()->group_count;

			$this->load->view('pretrip1', $data);
            $this->load->view('templates/footer');

		} else if(element('action', $form_data) == 'page2') //EDIT PAGE TWO
		{
			//Database pull
			$dept = $this->pretrip_model->deptDatabaseQuery();
			$data['dept'] = $dept;
			$profile = $this->profile_info->databaseQuery();
			$data['profile'] = $profile;
			$data['body_title'] = "Edit Pre-Trip Worksheet Page 2";
			$data['title'] = "Edit Pre-Trip Worksheet Page 2";

			$this->load->view('templates/header', $data);
			$this->load->view('templates/dynamicnavbar');

            $data['success'] = 0;
			$page_one_data = $this->view_trips_model->pageOneDataDatabaseQuery($trip_id);
			$page_one_modes = $this->view_trips_model->pageOneModesDatabaseQuery($trip_id);
			$data['modes'] = $page_one_modes;
			$rate = $this->pretrip_model->mileageRateDatabaseQuery()->row()->mileage_rate;
			$data['rate'] = $rate;

			//Pull travel agency name:
			$agency_record = $this->system_variables->getDeptTravelAgent($dept->row()->dept_code);
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

			foreach($page_one_modes->result() as $page_one_modes)
			{
				if($page_one_modes->mode == 1)
				{
					$data['plane'] = TRUE;
				} else if($page_one_modes->mode == 2)
				{
					$data['train'] = TRUE;
				} else if($page_one_modes->mode == 3)
				{
					$data['bus'] = TRUE;
				} else if($page_one_modes->mode == 4)
				{
					$data['ewu_motorpool'] = TRUE;
				} else if($page_one_modes->mode == 5)
				{
					$data['private_car'] = TRUE;
				} else if($page_one_modes->mode == 6)
				{
					$data['rental_car'] = TRUE;
				} else if($page_one_modes->mode == 7)
				{
					$data['charter'] = TRUE;
				} else if($page_one_modes->mode == 8)
				{
					$data['courtesy'] = TRUE;
				}
			}

			//Travel Quotes
			$page_two_quotes = $this->pretrip_model->travelQuotesDatabaseQuery($trip_id);
			// travel mode options:
			foreach($page_two_quotes->result() as $page_two_quotes)
			{
				if($page_two_quotes->mode == 1) //airfare
				{
					$data['airfare_artistic'] = $page_two_quotes->quote;
				}else if ($page_two_quotes->mode == 2) // train fare
				{
					$data['train_quote'] = $page_two_quotes->quote;
				}else if ($page_two_quotes->mode == 3) // bus fare
				{
					$data['bus_quote'] = $page_two_quotes->quote;
				}else if ($page_two_quotes->mode == 4) // motor pool
				{
					$data['mpool_quote'] = $page_two_quotes->quote;
				}else if ($page_two_quotes->mode == 7) // bus fare
				{
					$data['charter_quote'] = $page_two_quotes->quote;
				}else if ($page_two_quotes->mode == 8) // bus fare
				{
					$data['courtesy_quote'] = $page_two_quotes->quote;
				}else if($page_two_quotes->mode == 6) // rental car
				{
					$data['rental_car_enterprise'] = $page_two_quotes->quote;
					$rental_car_paytype = $this->pretrip_model->rentalCarPaytypeDatabaseQuery($trip_id);
					$rental_car_paytype->row()->paytype_id == 5 ? $data['rental_personal'] = TRUE : $data['rental_department'] = TRUE;
				}
			}

			//Registration
			$page_two_registration = $this->pretrip_model->registrationDatabaseQuery($trip_id);
			if(isset($page_two_registration->row()->amount))
			{
				$data['registration'] = $page_two_registration->row()->amount;
				$registration_paytype_id = $page_two_registration->row()->paytype_id;
				$registration_paytype_id == 4 ? $data['reg_department'] = TRUE : $data['reg_traveler'] = TRUE;
			}

			//Misc Expenses
			$page_two_misc_expenses = $this->pretrip_model->miscDatabaseQuery($trip_id);
			if(isset($page_two_misc_expenses->row()->amount))
			{
				$count = 0;
				$expense_total = 0;
				foreach($page_two_misc_expenses->result() as $page_two_misc_expenses)
				{
					$data['expense_'.$count] = $page_two_misc_expenses->expense;
					$data['amount_'.$count] = $page_two_misc_expenses->amount;
					$expense_total += $page_two_misc_expenses->amount;
					$count++;
				}
				$data['expense_total'] = $expense_total;
			}

			//Privately Owned Vehicle
			$page_two_pov_mileage = $this->pretrip_model->mileageDatabaseQuery($trip_id);
			if(isset($page_two_pov_mileage->row()->distance))
			{
				$count = 0;
				$private_car_total = 0;
				foreach($page_two_pov_mileage->result() as $page_two_pov_mileage)
				{
					$data['from_'.$count] = $page_two_pov_mileage->start_location;
					$data['to_'.$count] = $page_two_pov_mileage->destination;
					$data['miles_'.$count] = $page_two_pov_mileage->distance;
					$data['total_'.$count] = round(($page_two_pov_mileage->distance * $rate), 2);
					$private_car_total += $data['total_'.$count];
					$count++;
				}
				$data['private_car_total'] = round($private_car_total, 2);
			}

			//Per Deim
			$page_two_per_deim = $this->pretrip_model->perDeimDatabaseQuery($trip_id);
            $data['breakfast_rate'] = $this->pretrip_model->perDeimRatesDatabaseQuery()->row()->breakfast;
            $data['lunch_rate'] = $this->pretrip_model->perDeimRatesDatabaseQuery()->row()->lunch;
            $data['dinner_rate'] = $this->pretrip_model->perDeimRatesDatabaseQuery()->row()->dinner;
			if(isset($page_two_per_deim->row()->days))
			{
				$count = 0;
				$per_deim_total = 0;
				foreach($page_two_per_deim->result() as $page_two_per_deim)
				{
					$data['per_deim_date_'.$count] = $page_two_per_deim->trip_date;
					$data['per_deim_from_'.$count] = $page_two_per_deim->start_location;
					$data['per_deim_departure_'.$count] = $page_two_per_deim->time_start;
					$data['per_deim_to_'.$count] = $page_two_per_deim->destination;
					$data['per_deim_arrival_'.$count] = $page_two_per_deim->time_end;
					$data['per_deim_b_'.$count] = round($page_two_per_deim->breakfast, 2);
					$data['per_deim_l_'.$count] = round($page_two_per_deim->lunch, 2);
					$data['per_deim_d_'.$count] = round($page_two_per_deim->dinner, 2);
					$data['per_deim_hotel_'.$count] = round($page_two_per_deim->lodging, 2);
					$data['per_deim_rate_'.$count] = round($data['per_deim_b_'.$count] + $data['per_deim_l_'.$count] + $data['per_deim_d_'.$count], 2);
					$data['per_deim_days_'.$count] = $page_two_per_deim->days;
					$per_deim_total += $data['per_deim_rate_'.$count] + $data['per_deim_hotel_'.$count];
					$count++;
				}
				$data['per_deim_total'] = round($per_deim_total, 2);
			}
			$data['trip_owner'] = $page_one_data->row()->name;

			$this->load->view('pretrip2', $data);
            $this->load->view('templates/footer');
		} else if(element('action', $form_data) == 'submit' && ($status == 0 || $status == 4)) //SUBMIT FORM
		{
            $this->view_trips_model->submittedDatabaseUpdate($trip_id, 1);
            if($return_to == 1)
            {
                $this->view($page = 'Trip Listing');
            } else
            {
                $this->dtcview($page = 'DTC Trip Listing');
            }
            // *************SEND EMAIL FOR SUBMITTING*************
			$DTCemails = $this->pretrip_model->getDTCEmails();
			foreach($DTCemails->result() as $row)
			{
				$this->email->from('cstrav@csmail.cslabs.ewu.edu', 'Travel Voucher App');
				$this->email->to($row->email);
				$this->email->subject('Voucher form has been submitted!!!');
				$name = $this->pretrip_model->getName($this->cas->get_user());
				$message = '<p>'.$name.' has submitted a Voucher form for review. </p>
							<p> Trip id: '.element('trip_id', $form_data).'.</p>
							<p>Thank You</p>';
				$this->email->message($message);
				$this->email->send();
			}
		} else if(element('action', $form_data) == 'delete') //DELETE FORM
		{
			$this->confirmDeleteTrip($trip_id, $return_to);

		} else if(element('action', $form_data) == 'code') //ADD FORM NUMBER
		{
            $data['title'] = 'Travel Authorization Number';

            $this->load->view('templates/header', $data);
            $this->load->view('templates/dynamicnavbar');

            // Get trip info
			$page_one_data = $this->view_trips_model->pageOneDataDatabaseQuery($trip_id);

            $data['trip_id'] = $page_one_data->row()->trip_id;
			$data['trip_owner'] = $page_one_data->row()->name;
            $data['trip_name'] = $page_one_data->row()->trip_name;
            $data['return_to'] = $return_to;
            $data['trav_auth'] = $this->pretrip_model->travelAuthorizationNumberDatabaseQuery($data['trip_id'])->row()->authorization;

            $this->load->view('travelauthorizationnumber', $data);
            $this->load->view('templates/footer');
		} else if(element('action', $form_data) == 'accept' && ($status == 1 || $status == 2)) //ACCEPT A SUBMITTED TRIP
		{
            $this->view_trips_model->submittedDatabaseUpdate($trip_id, 3);
            if($return_to == 1)
            {
                $this->view($page = 'Trip Listing');
            } else
            {
                $this->dtcview($page = 'DTC Trip Listing');
            }
		} else if(element('action', $form_data) == 'reject' && ($status == 1 || $status == 2)) //REJECT A SUBMITTED TRIP
		{
            $data['title'] = 'Rejection Email';

            $this->load->view('templates/header', $data);
            $this->load->view('templates/dynamicnavbar');

            // Get trip info
			$q_result = $this->view_trips_model->pageOneDataDatabaseQuery($trip_id);

			$data['trip_id'] = $q_result->row()->trip_id;
            $data['trip_name'] = $q_result->row()->trip_name;
            $data['return_to'] = $return_to;
            $data['from_add'] = $this->view_trips_model->emailDatabaseQuery($this->cas->get_user())->row()->email;
            $data['to_add'] = $this->view_trips_model->facultyEmailDatabaseQuery($trip_id)->row()->email;

            $this->load->view('rejectionemail', $data);
            $this->load->view('templates/footer');

		} else if(element('action', $form_data) == 'print') //PRINT AN ACCEPTED TRIP
		{
			$trip_id = element('trip_id', $form_data);

			$data['trip_id'] = $trip_id;

			/*Print code!*/
			$data['title'] = 'Print Voucher Form';

			$this->print_form->deleteDBTripID();
			$this->print_form->setDBTripId($trip_id);
			$this->print_form->set_id($trip_id);

			$this->load->view('templates/header', $data);
			$this->load->view('templates/dynamicnavbar', $data);
			$this->load->view('printformjump', $data);

			$this->load->view('templates/footer');
		} else if(element('action', $form_data) == 'index' && ($return_to == 2 || ($return_to == 1 && $status == 0))) //EDIT THE INDEX CODES
        {
			$this->print_form->deleteDBTripID();
        	$this->print_form->setDBTripID($trip_id);
            $this->print_form->set_id($trip_id);
            $data['box_6_total'] = str_replace(",", "", $this->print_form->get_Total());

            $data['title'] = 'Modify Index Codes';

            $this->load->view('templates/header', $data);
            $this->load->view('templates/dynamicnavbar');

            // Get trip info
            $data['trip_id'] = $this->view_trips_model->pageOneDataDatabaseQuery($trip_id)->row()->trip_id;
            $data['trip_name'] = $this->view_trips_model->pageOneDataDatabaseQuery($trip_id)->row()->trip_name;
            $data['return_to'] = $return_to;

            $index_codes_data = $this->pretrip_model->indexCodeDatabaseQuery($trip_id);

            if($index_codes_data->num_rows() > 0)
            {
                $count = 0;
                $index_codes_data_total = 0;

                foreach($index_codes_data->result() as $index_codes_data)
                {
                    $data['index_code_'.$count] = $index_codes_data->index_code;
                    $data['percent_'.$count] = $index_codes_data->percentage;
                    $data['amount_'.$count] = $index_codes_data->amount;
                    $count++;
                }
				$index_codes_data_total = $this->print_form->get_IndexTotalAmount();
				$data['page_total'] = $index_codes_data_total;
            }

            $this->load->view('indexcodes', $data);
            $this->load->view('templates/footer');
        } else
        {
			$result = 0;
			// ignored input trapping trapping:
			if (element('action', $form_data) == 'reject') // trip not able to be rejected
			{
				$result = 6;
			}
			else if (element('action', $form_data) == 'accept') // trip not submitted
			{
				$result = 7;
			}
			else if (element('action', $form_data) == 'index') // trip submitted and user is not DTC
			{
				$result = 8;
			}

            if($return_to == 1)
            {
                $this->view($page = 'Trip Listing', $result);
            } else
            {
                $this->dtcview($page = 'DTC Trip Listing', $result);
            }
        }

	}

    public function postAction($page = 'Trip Listing')
    {
        $form_data = $this->input->post();
        $data['form_data'] = $form_data;
        $return_to = $form_data['return_to'];
        $data['return_to'] = $return_to;
		$data['accordion'] = $return_to - 1;
        $trip_id = $form_data['trip_id'];
        $data['trip_id'] = $form_data['trip_id'];
        $status = $this->view_trips_model->statusCodeDatabaseQuery($trip_id)->row()->status_code;

        if(element('action', $form_data) == 'posttrip') //EDIT POST TRIP
        {
            //Database pull
            $dept = $this->pretrip_model->deptDatabaseQuery();
            $data['dept'] = $dept;
            $profile = $this->profile_info->databaseQuery();
            $data['profile'] = $profile;
            $data['body_title'] = "Edit Post Trip";
            $data['title'] = "Edit Post Trip";

            $this->load->view('templates/header', $data);
            $this->load->view('templates/dynamicnavbar');

            $data['success'] = 0;

            $page_one_modes = $this->view_trips_model->pageOneModesDatabaseQuery($trip_id);
			$data['trip_owner'] = $this->view_trips_model->pageOneDataDatabaseQuery($trip_id)->row()->name;
            $data['modes'] = $page_one_modes;
            $rate = $this->pretrip_model->mileageRateDatabaseQuery()->row()->mileage_rate;
            $data['rate'] = $rate;

            foreach($page_one_modes->result() as $page_one_modes)
            {
                if($page_one_modes->mode == 6)
                {
                    $data['rental_car'] = TRUE;
                }
            }

            //Misc Expenses
            $post_misc_expenses = $this->posttrip_model->miscDatabaseQuery($trip_id);
            if(isset($post_misc_expenses->row()->amount))
            {
                $count = 0;
                $expense_total = 0;
                foreach($post_misc_expenses->result() as $post_misc_expenses)
                {
                    $data['misc_date_'.$count] = $post_misc_expenses->date;
                    $data['payee_'.$count] = $post_misc_expenses->payee;
                    $data['expense_'.$count] = $post_misc_expenses->expense;
                    $data['amount_'.$count] = $post_misc_expenses->amount;
                    $expense_total += $post_misc_expenses->amount;
                    $count++;
                }
                $data['expense_total'] = $expense_total;
            }

            //Privately Owned Vehicle
            $post_pov_mileage = $this->posttrip_model->mileageDatabaseQuery($trip_id);
            if(isset($post_pov_mileage->row()->distance))
            {
                $count = 0;
                $private_car_total = 0;
                foreach($post_pov_mileage->result() as $post_pov_mileage)
                {
                    $data['from_'.$count] = $post_pov_mileage->start_location;
                    $data['to_'.$count] = $post_pov_mileage->destination;
                    $data['miles_'.$count] = $post_pov_mileage->distance;
                    $data['total_'.$count] = round(($post_pov_mileage->distance * $rate), 2);
                    $private_car_total += $data['total_'.$count];
                    $count++;
                }
                $data['private_car_total'] = round($private_car_total, 2);
            }

            //Per Deim
            $post_per_deim = $this->posttrip_model->perDeimDatabaseQuery($trip_id);

			if($post_per_deim->num_rows() > 0)
            {
                $count = 0;
                $per_deim_total = 0;

				foreach($post_per_deim->result() as $post_per_deim)
                {
                    $data['per_deim_date_'.$count] = $post_per_deim->trip_date;
                    $data['per_deim_from_'.$count] = $post_per_deim->start_location;
                    $data['per_deim_departure_'.$count] = $post_per_deim->time_start;
                    $data['per_deim_to_'.$count] = $post_per_deim->destination;
                    $data['per_deim_arrival_'.$count] = $post_per_deim->time_end;
                    $data['per_deim_b_'.$count] = round($post_per_deim->breakfast, 2);
                    $data['per_deim_l_'.$count] = round($post_per_deim->lunch, 2);
                    $data['per_deim_d_'.$count] = round($post_per_deim->dinner, 2);
                    $data['per_deim_hotel_'.$count] = round($post_per_deim->lodging, 2);

					$per_deim_total += round($post_per_deim->breakfast, 2);
					$per_deim_total += round($post_per_deim->lunch, 2);
					$per_deim_total += round($post_per_deim->dinner, 2);
					$per_deim_total += round($post_per_deim->lodging, 2);

                    $count++;
                }
                $data['per_deim_total'] = round($per_deim_total, 2);
            }

            //Refunds
            $post_refunds = $this->posttrip_model->refundsDatabaseQuery($trip_id);
            if(isset($post_refunds->row()->amount))
            {
                $count = 0;
                foreach($post_refunds->result() as $post_refunds)
                {
                    $data['refund_date_'.$count] = $post_refunds->date;
                    $data['refund_payee_'.$count] = $post_refunds->payee;
                    $data['refund_amount_'.$count] = $post_refunds->amount;
                    $count++;
                }
            }

            //Comments
            $post_comments = $this->posttrip_model->commentsDatabaseQuery($trip_id);
            if(isset($post_comments->row()->trip_comment))
            {
                $data['comments'] = $post_comments->row()->trip_comment;
            }

            $this->load->view('posttrip', $data);
            $this->load->view('templates/footer');
        } else if(element('action', $form_data) == 'submit' && ($status == 5 || $status == 9)) //SUBMIT POST TRIP
        {
            $this->view_trips_model->submittedDatabaseUpdate($trip_id, 6);
            if($return_to == 1)
            {
                $this->view($page = 'Trip Listing');
            } else
            {
                $this->dtcview($page = 'DTC Trip Listing');
            }
            $DTCemails = $this->pretrip_model->getDTCEmails();
            foreach($DTCemails->result() as $row)
            {
                $this->email->from('cstrav@csmail.cslabs.ewu.edu', 'Travel Voucher App');
                $this->email->to($row->email);
                $this->email->subject('Voucher form has been submitted!!!');
                $name = $this->pretrip_model->getName($this->cas->get_user());
                $message = '<p>'.$name.' has submitted a Voucher form for review. </p>
							<p> Trip id: '.element('trip_id', $form_data).'.</p>
							<p>Thank You</p>';
                $this->email->message($message);
                $this->email->send();
            }


        } else if(element('action', $form_data) == 'delete') //DELETE FORM
        {
            $this->confirmDeleteTrip($trip_id, $return_to);

        } else if(element('action', $form_data) == 'reset') //RESET FORM
        {
            $this->confirmResetTrip($trip_id, $return_to);

        } else if(element('action', $form_data) == 'code') //ADD FORM NUMBER
        {
            $data['title'] = 'Travel Authorization Number';

            $this->load->view('templates/header', $data);
            $this->load->view('templates/dynamicnavbar');

            // Get trip info
            $data['trip_id'] = $this->view_trips_model->pageOneDataDatabaseQuery($trip_id)->row()->trip_id;
            $data['trip_name'] = $this->view_trips_model->pageOneDataDatabaseQuery($trip_id)->row()->trip_name;
            $data['return_to'] = $return_to;
            $data['trav_auth'] = $this->pretrip_model->travelAuthorizationNumberDatabaseQuery($data['trip_id'])->row()->authorization;

            $this->load->view('travelauthorizationnumber', $data);
            $this->load->view('templates/footer');
        } else if(element('action', $form_data) == 'accept' && ($status == 6 || $status == 7)) //ACCEPT A SUBMITTED POST TRIP
        {
            $this->view_trips_model->submittedDatabaseUpdate($trip_id, 8);
            if($return_to == 1)
            {
                $this->view($page = 'Trip Listing');
            } else
            {
                $this->dtcview($page = 'DTC Trip Listing');
            }
        } else if(element('action', $form_data) == 'reject' && ($status == 6 || $status == 7)) //REJECT A SUBMITTED POST TRIP
        {
            $data['title'] = 'Rejection Email';

            $this->load->view('templates/header', $data);
            $this->load->view('templates/dynamicnavbar');

            // Get trip info
            $data['trip_id'] = $this->view_trips_model->pageOneDataDatabaseQuery($trip_id)->row()->trip_id;
            $data['trip_name'] = $this->view_trips_model->pageOneDataDatabaseQuery($trip_id)->row()->trip_name;
            $data['return_to'] = $return_to;
            $data['from_add'] = $this->view_trips_model->emailDatabaseQuery($this->cas->get_user())->row()->email;
            $data['to_add'] = $this->view_trips_model->facultyEmailDatabaseQuery($trip_id)->row()->email;

            $this->load->view('rejectionemail', $data);
            $this->load->view('templates/footer');

        } else if(element('action', $form_data) == 'print') //PRINT AN ACCEPTED POST TRIP
        {
			$trip_id = element('trip_id', $form_data);

			$data['trip_id'] = $trip_id;
			$this->print_form->deleteDBTripID();
			$this->print_form->setDBTripId($trip_id);
			$this->print_form->set_id($trip_id);

			/*Print code!*/
			$data['title'] = 'Print Voucher Form';

			$this->load->view('templates/header', $data);
			$this->load->view('templates/dynamicnavbar', $data);
			$this->load->view('printformjump', $data);
			$this->load->view('templates/footer');
        } else if(element('action', $form_data) == 'index' && ($return_to == 2 || ($return_to == 1 && $status == 0))) //EDIT THE INDEX CODES
        {
			$this->print_form->deleteDBTripID();
        	$this->print_form->setDBTripID($trip_id);
            $this->print_form->set_id($trip_id);
            $data['box_6_total'] = str_replace(",", "", $this->print_form->get_Total());
 
            $data['title'] = 'Modify Index Codes';

            $this->load->view('templates/header', $data);
            $this->load->view('templates/dynamicnavbar');

            // Get trip info
            $data['trip_id'] = $this->view_trips_model->pageOneDataDatabaseQuery($trip_id)->row()->trip_id;
            $data['trip_name'] = $this->view_trips_model->pageOneDataDatabaseQuery($trip_id)->row()->trip_name;
            $data['return_to'] = $return_to;

            $index_codes_data = $this->pretrip_model->indexCodeDatabaseQuery($trip_id);

            if($index_codes_data->num_rows() > 0)
            {
                $count = 0;
                $index_codes_data_total = 0;

                foreach($index_codes_data->result() as $index_codes_data)
                {
                    $data['index_code_'.$count] = $index_codes_data->index_code;
                    $data['percent_'.$count] = $index_codes_data->percentage;
                    $data['amount_'.$count] = $index_codes_data->amount;
                    $count++;
                }
				$index_codes_data_total = $this->print_form->get_IndexTotalAmount();
				$data['page_total'] = $index_codes_data_total;
            }

            $this->load->view('indexcodes', $data);
            $this->load->view('templates/footer');
        } else
        {
			$result = 0;
			// ignored input trapping trapping:
			if (element('action', $form_data) == 'reject') // trip not able to be rejected
			{
				$result = 6;
			}
			else if (element('action', $form_data) == 'accept') // trip not submitted
			{
				$result = 7;
			}
			else if (element('action', $form_data) == 'index') // trip submitted and user is not DTC
			{
				$result = 8;
			}

            if($return_to == 1)
            {
                $this->view($page = 'Trip Listing', $result);
            } else
            {
                $this->dtcview($page = 'DTC Trip Listing', $result);
            }
        }
    }

	// this function will load the view for the user to confirm they wish to delete a
	// specific trip
	public function confirmDeleteTrip($trip_id = -1, $return_to)
	{
		$data['title'] = 'Confirm Trip Delete';

		$data['accordion'] = $return_to - 1;
        $data['return_to'] = $return_to;

		$this->load->view('templates/header', $data);
		$this->load->view('templates/dynamicnavbar', $data);

		// get trip info:
		$trip = $this->view_trips_model->pageOneDataDatabaseQuery($trip_id);
		$data['trip'] = $trip;

		$this->load->view('confirmDeleteTrip', $data);
		$this->load->view('templates/footer');
	}

	// this function will load the view for the user to confirm they wish to reset a
	// specific trip
	public function confirmResetTrip($trip_id = -1, $return_to)
	{
		$data['title'] = 'Confirm Trip Reset';

		$data['accordion'] = $return_to - 1;
        $data['return_to'] = $return_to;

		$this->load->view('templates/header', $data);
		$this->load->view('templates/dynamicnavbar', $data);

		// get trip info:
		$trip = $this->view_trips_model->pageOneDataDatabaseQuery($trip_id);
		$data['trip'] = $trip;

		$this->load->view('confirmResetTrip', $data);
		$this->load->view('templates/footer');
	}

	 // this function resets the selected trip and returns the user to the trip listing page
	public function resetTrip()
	{
		// pull trip id from form
		$form_data = $this->input->post();

		$trip_id = $form_data['trip_id'];
        $return_to = $form_data['return_to'];

		//delete comments:
		$this->posttrip_model->commentsDatabaseDelete(element('trip_id', $form_data));
		// delete mileage:
		$this->posttrip_model->mileageDatabaseDelete(element('trip_id', $form_data));
		// deete misc.
		$this->posttrip_model->miscDatabaseDelete(element('trip_id', $form_data));
		// delete per diem:
		$this->posttrip_model->perDeimDatabaseDelete(element('trip_id', $form_data));
		// delete refunds
		$this->posttrip_model->refundsDatabaseDelete(element('trip_id', $form_data));

		// update trip's status code:
		$this->view_trips_model->submittedDatabaseUpdate($trip_id, 0);

        if($return_to == 1)
        {
            $this->view($page = 'Trip Listing', 5);
        } else
        {
            $this->dtcview($page = 'DTC Trip Listing', 5);
        }
	}

	// this function deletes the selected trip and returns the user to the trip listing page
	public function deleteTrip()
	{
		// pull trip id from form
		$form_data = $this->input->post();

		$trip_id = $form_data['trip_id'];
        $return_to = $form_data['return_to'];

		$this->pretrip_model->tripDatabaseDelete($trip_id);

        if($return_to == 1)
        {
            $this->view($page = 'Trip Listing', 4);
        } else
        {
            $this->dtcview($page = 'DTC Trip Listing', 4);
        }
	}

    public function modifyTravAuthNum()
    {
        $form_data = $this->input->post();

        $trip_id = $form_data['trip_id'];
        $trav_auth = $form_data['trav_auth'];
        $return_to = $form_data['return_to'];

        $this->pretrip_model->travAuthNumUpdate($trip_id, $trav_auth);

        if($return_to == 1)
        {
            $this->view($page = 'Trip Listing');
        } else
        {
            $this->dtcview($page = 'DTC Trip Listing');
        }
    }

    public function rejectionEmail()
    {
        $form_data = $this->input->post();

        $trip_id = $form_data['trip_id'];
        $status_code = $this->view_trips_model->statusCodeDatabaseQuery($trip_id);
        if($status_code < 5)
        {
            $this->view_trips_model->submittedDatabaseUpdate($trip_id, 4);
        } else
        {
            $this->view_trips_model->submittedDatabaseUpdate($trip_id, 9);
        }
        $return_to = $form_data['return_to'];
        // *************SEND EMAIL FOR REJECTING*************
		$this->email->from(element('from_add',$form_data));
		$this->email->to(element('to_add', $form_data));

		$this->email->cc(element('from_add', $form_data));

		$this->email->subject(element('subject', $form_data));

		$this->email->message(element('message', $form_data));

		$this->email->send();

        if($return_to == 1)
        {
            $this->view($page = 'Trip Listing');
        } else
        {
            $this->dtcview($page = 'DTC Trip Listing');
        }
    }

	public function printaform()
	{
		$form_data = $this->input->post();
		$return_to = $form_data['return_to'];
		if($return_to == 1)
		{
			$this->view($page = 'Trip Listing');
		} else
		{
			$this->dtcview($page = 'DTC Trip Listing');
		}
	}

    public function modifyIndexCodes()
    {
        $form_data = $this->input->post();

        $trip_id = $form_data['trip_id'];
        $return_to = $form_data['return_to'];

        $this->pretrip_model->indexCodeDatabaseDelete($trip_id);
        for ($count = 0; $count < 3; $count++)
        {
            if($form_data['percent_'.$count] > 0)
            {
            	if(strlen($form_data['index_code_'.$count]) < 2) {
                	$data_array = array(element('trip_id', $form_data), 'temp'.($count + 1), element('percent_'.$count, $form_data), element('amount_'.$count, $form_data));
                	$this->pretrip_model->indexCodeDatabaseSave($data_array);
                } else {
                	$data_array = array(element('trip_id', $form_data), element('index_code_'.$count, $form_data), element('percent_'.$count, $form_data), element('amount_'.$count, $form_data));
                	$this->pretrip_model->indexCodeDatabaseSave($data_array);
                }
            }
        }

        if($return_to == 1)
        {
            $this->view($page = 'Trip Listing');
        } else
        {
            $this->dtcview($page = 'DTC Trip Listing');
        }
		$this->print_form->deleteDBTripID();
    }
}
