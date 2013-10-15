<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Controller/cronjobs
 *
 * The controller containing all of the jobs that cron will run.
 * Sample command line: php index.php controller function "optionalParameter"
 *
 * List of commands:
 * php /var/www/index.php cronjobs postTripStatusUpdate
 * php /var/www/index.php cronjobs immediatePostTripReminder
 * php /var/www/index.php cronjobs delayedPostTripReminder
 *
 * Author: Reid Fortier
 *
 * Created: 2013-08-23
 * Last Edited: 2013-08-23
*/
class Cronjobs extends MY_Controller
{
    function __construct()
    {
        parent::__construct();

        //Library
        $this->load->library('email');

        //Helpers

        //Models
        $this->load->model('cron_model');

    }

    public function postTripStatusUpdate()
    {
        if($this->input->is_cli_request())
        $this->cron_model->cronSubmittedDatabaseUpdate();
    }

    public function immediatePostTripReminder()
    {
        //Sent immediately after trip ends
        $trip_info = $this->cron_model->cronImmediateReminderDatabaseQuery();
        foreach($trip_info->result() as $row)
        {
            $this->email->from('cstrav@csmail.compsci.ewu.edu', 'Travel Voucher App');
            $this->email->to($row->email);
            $this->email->subject('Post Trip Reminder');
            $message = '<p>'.$row->name.', you have a trip needing a post trip submission. </p>
                                <p> Trip id: '.$row->trip_id.', Trip name: '.$row->trip_name.'</p>
                                <p>Thank You</p>';
            $this->email->message($message);
            $this->email->send();
        }
    }

    //Sent after day 8
    public function delayedPostTripReminder()
    {
        $trip_info = $this->cron_model->cronDelayedReminderDatabaseQuery();
        foreach($trip_info->result() as $row)
        {
            $this->email->from('cstrav@csmail.compsci.ewu.edu', 'Travel Voucher App');
            $this->email->to($row->email);
            $this->email->subject('Post Trip Reminder');
            $message = '<p>'.$row->name.', you have a trip needing a post trip submission. </p>
                                <p> Trip id: '.$row->trip_id.', Trip name: '.$row->trip_name.'</p>
                                <p>Thank You</p>';
            $this->email->message($message);
            $this->email->send();
        }
    }
}
