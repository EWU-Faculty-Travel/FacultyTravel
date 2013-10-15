<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Controller/travAdminAddDTC
 *
 * Controller provides access and logic for displaying
 * faculty with and without DTC permissions. This controller
 * also aids in promoting and demoting the faculty members
 * that the user chooses. (User is a Travel Administrator).
 *
 * Author: Jason Helms, Reid Fortier
 *
 * Created: 2013-06
 * Last Edited: 2013-07-29
*/

class TravAdminAddDTC extends MY_Controller
{
        //Constructor
        function __construct()
        {
            parent::__construct();

            $this->validuser();

            //Models
            $this->load->model('trav_admin_add_dtcs');
            $this->load->model('user_roles');
            $this->load->model('add_dtcs');

            //Helpers
            $this->load->helper('form');
            $this->load->helper('array');

            //Libraries
            $this->load->library('form_validation');
        }

        //view - duh
        public function view($page = 'Add DTC')
        {
                if( ! file_exists('application/views/travAdminAddDTC.php'))
                {
                        //Whoops, we don't have a page for that!
                        show_404();
                }
                $data['title'] = ucfirst($page); // Capitalize the first letter

                $this->load->view('templates/header', $data);

				// set TA accordion open
				$data['accordion'] = 2;
				
                $this->load->view('templates/dynamicnavbar', $data);

                $this->load->view('travAdminAddDTC');
                $this->load->view('templates/footer');
        }

        //promote a faculty member to DTC
        public function promote()
        {
            $count = $_POST['countNP'];
            for($i = 0; $i <= $count; $i++)
            {
                $box = isset($_POST[$i]) ? 1 : 0;
                if($box)
                {
                    $temp = $this->input->post('userNP'.$i);
                    $user_id = element('user_id', $temp);
                    $dept_code = element('dept_code', $temp);
                    $this->add_dtcs->updateUserRoles1($user_id, $dept_code);
                }
            }
            $this->view($page = 'travAdminAddDTC');
        }

        //demotes the a faculty member from DTC
        public function demote()
        {
            $count = $_POST['count'];
            for($i = 0; $i <= $count; $i++)
            {
                $box = isset($_POST[$i]) ? 1 : 0;
                if($box)
                {
                    $temp = $this->input->post('user'.$i);
                    $user_id = element('user_id', $temp);
                    $dept_code = element('dept_code', $temp);
                    $this->add_dtcs->removeUserRoles1($user_id, $dept_code);
                }
            }
            $this->view($page = 'travAdminAddDTC');
        }
}