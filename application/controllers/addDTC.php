<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Controller/AddDTC
 *
 * Allows the user to manage Department Travel Coordinators 
 * 
 * Author: Jason Helms
 *
 * Created: 2013-07 
 * Last Edited: 2013-08-23
*/
class AddDTC extends MY_Controller
{
        function __construct()
        {
            parent::__construct();

            $this->validuser();

            //Models
            $this->load->model('add_dtcs');

            //Helpers
            $this->load->helper('form');
            $this->load->helper('array');

            //Libraries
            $this->load->library('form_validation');
        }

		//loads the view
        public function view($page = 'Edit DTCs')
        {
                if( ! file_exists('application/views/addDTC.php'))
                {
                        //Whoops, we don't have a page for that!
                        show_404();
                }
                $data['title'] = ucfirst($page); // Capitalize the first letter

                $this->load->view('templates/header', $data);
                
				// set accordion to open to dtc tools:
				$data['accordion'] = 1;
				$this->load->view('templates/dynamicnavbar', $data);

                //load model
                $this->load->model('add_dtcs');

                //load view
                $this->load->view('addDTC', $data);

                $this->load->view('templates/footer');

        }

		//demote a faculty from DTC
        public function demote1()
        {
            $count = $_POST['count'];
            for($i = 0; $i <= $count; $i++)
            {
                $box = isset($_POST[$i]) ? 1 : 0;
                if($box)
                {
                    $temp = $this->input->post('user_info'.$i);
                    $user_id = element('user_id', $temp);
                    $dept_code = element('dept_code', $temp);
                    $this->add_dtcs->removeUserRoles1($user_id, $dept_code);
                }
            }
            $this->view($page = 'addDTC');
        }

		//promote a faculty to DTC
        public function promote1()
        {
            $count = $_POST['countNP'];
            for($i = 0; $i <= $count; $i++)
            {
                $box = isset($_POST[$i]) ? 1 : 0;
                if($box)
                {
                    $temp = $this->input->post('user_infoNP'.$i);
                    $user_id = element('user_id', $temp);
                    $dept_code = element('dept_code', $temp);
                    $this->add_dtcs->updateUserRoles1($user_id, $dept_code);
                }
            }
            $this->view($page = 'addDTC');
        }
}