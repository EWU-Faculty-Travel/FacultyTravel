<?
/* View/logout
 *
 * Saves the post trip data to the database
 *
 * Author: Reid Fortier
 *
 * Created: 2013-08-22
 * Last Edited: 2013-08-22
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Posttrip extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->validuser();

        //Models
        $this->load->model('pretrip_model');
        $this->load->model('posttrip_model');
        $this->load->model('profile_info');
        $this->load->model('view_trips_model');

        //Helpers
        $this->load->helper('form');
        $this->load->helper('array');
        $this->load->helper('date');

        //Libraries
        $this->load->library('form_validation');
        $this->load->library('email');
	}

    public function save()
    {
        //Validation

        $this->form_validation->set_rules('trip_id', 'Trip ID', 'trim|required');

        if ($this->form_validation->run() != FALSE)
        {
            //Save to the database
            $form_data = $this->input->post();
            $data['form_data'] = $form_data;
            $return_to = $form_data['return_to'];

            $trip_id = element('trip_id', $form_data);

            //Privately Owned Vehicle Mileage
            $this->posttrip_model->mileageDatabaseDelete(element('trip_id', $form_data));
            for ($count = 0; $count < 5; $count++)
            {
                if(isset($form_data['miles_'.$count]) && $form_data['miles_'.$count] > 0)
                {
                    $data_array = array(element('trip_id', $form_data), element('from_'.$count, $form_data), element('to_'.$count, $form_data), element('miles_'.$count, $form_data), element('vicinity_'.$count, $form_data));
                    $this->posttrip_model->mileageDatabaseUpdate($data_array);
                }
            }

            //Misc Expenses
            $this->posttrip_model->miscDatabaseDelete(element('trip_id', $form_data));
            for ($count = 0; $count < 5; $count++)
            {
                if($form_data['amount_'.$count] > 0)
                {
                    $data_array = array(element('trip_id', $form_data), date('Y-m-d', strtotime($this->input->post('misc_date_'.$count))), element('payee_'.$count, $form_data), element('expense_'.$count, $form_data), element('amount_'.$count, $form_data));
                    $this->posttrip_model->miscDatabaseUpdate($data_array);
                }
            }

            //Per Deim
            $this->posttrip_model->perDeimDatabaseDelete(element('trip_id', $form_data));
			
			// check all the date fields:
			for ($count = 0; $count < 7; $count++)
            {

                if($this->input->post('per_deim_date_'.$count) > 0)
                {
                    $data_array = array(element('trip_id', $form_data), date('Y-m-d', strtotime($this->input->post('per_deim_date_'.$count))), element('per_deim_from_'.$count, $form_data), date('H:i:s', strtotime($this->input->post('per_deim_departure_'.$count))), element('per_deim_to_'.$count, $form_data), date('H:i:s', strtotime($this->input->post('per_deim_arrival_'.$count))), element('per_deim_b_'.$count, $form_data), element('per_deim_l_'.$count, $form_data), element('per_deim_d_'.$count, $form_data), element('per_deim_hotel_'.$count, $form_data), element('per_deim_days_'.$count, $form_data));
                    $this->posttrip_model->perDeimDatabaseUpdate($data_array);
                }
            }

            //Comments
            $this->posttrip_model->commentsDatabaseDelete(element('trip_id', $form_data));
            if(isset($form_data['comments']))
            {
				if (isset($form_data['comments']))
				{
					$comment = $form_data['comments'];
				}
				else
				{
					$comment = '';
				} 
				
				if ($comment != '')
				{
					$data_array = array(element('trip_id', $form_data),  comment => $comment);
					$this->posttrip_model->commentsDatabaseUpdate($data_array);
				}
			}

            //Refunds
            $this->posttrip_model->refundsDatabaseDelete(element('trip_id', $form_data));
            for ($count = 0; $count < 2; $count++)
            {
                if($form_data['refund_amount_'.$count] > 0)
                {
                    $data_array = array(element('trip_id', $form_data), date('Y-m-d', strtotime($this->input->post('refund_date_'.$count))), element('refund_payee_'.$count, $form_data), element('refund_amount_'.$count, $form_data));
                    $this->posttrip_model->refundsDatabaseUpdate($data_array);
                }
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
            } else if(isset($_POST["submit"])) // ******POST TRIP******
            {
                $this->view_trips_model->submittedDatabaseUpdate(element('trip_id', $form_data), 6);
                // *************SEND EMAIL FOR SUBMITTING*************
                $DTCemails = $this->pretrip_model->getDTCEmails();
                foreach($DTCemails->result() as $row)
                {
                    $this->email->from('cstrav@csmail.cslabs.ewu.edu', 'Travel Voucher App');
                    $this->email->to($row->email);
                    $this->email->subject('Post Trip form has been submitted');
                    $name = $this->pretrip_model->getName($this->cas->get_user());
                    $message = '<p>'.$name.' has submitted a post trip form for review. </p>
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
        }
    }
}