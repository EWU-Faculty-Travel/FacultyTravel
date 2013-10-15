<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Controller/travAdminAddTA
 *
 * Controller provides access and logic for displaying
 * faculty with and without TA permissions for every department. 
 * This controller also aids in promoting and demoting the faculty 
 * members that the user chooses. (User is a Department Travel Coordinator).
 *
 * Author: Jason Helms
 *
 * Created: 2013-07-22
 * Last Edited: 2013-07-30
*/
class TravAdminAddTA extends MY_Controller
{		
		function __construct()
		{
			parent::__construct();
			
			$this->validuser();
			
			//Models
			$this->load->model('trav_admin_add_tas');
			$this->load->model('add_dtcs');
			$this->load->model('user_roles');
			
			//Helpers
			$this->load->helper('form');
			$this->load->helper('array');
			
			//Libraries
			$this->load->library('form_validation');
		}
		
        public function view($page = 'Edit Travel Administrators')
        {
                if( ! file_exists('application/views/travAdminAddTA.php'))
                {
                        //Whoops, we don't have a page for that!
                        show_404();
                }
				$data['title'] = ucfirst($page); // Capitalize the first letter

                $this->load->view('templates/header', $data);
				
				$data['accordion'] = 2;
				
				$this->load->view('templates/dynamicnavbar', $data);
                
				$this->load->view('travAdminAddTA');
                $this->load->view('templates/footer');
        }
	
		//take Travel Admin permissions away from a user
		public function demote()
		{
			$count = $_POST['TACount'];
            for($i = 0; $i <= $count; $i++)
            {
                $box = isset($_POST[$i]) ? 1 : 0;
                if($box)
                {
                    $temp = $this->input->post('user'.$i);
                    $user_id = element('user_id', $temp);
                    $dept_code = 'SYST';
                    $this->trav_admin_add_tas->removeUserRoles($user_id, $dept_code);
                }
            }
			$this->view('travAdminAddTA');
		}
		
		//give permissions to a faculty user. 
		public function promote()
		{
			$count = $_POST['countW'];
            for($i = 0; $i <= $count; $i++)
            {
                $box = isset($_POST[$i]) ? 1 : 0;
                if($box)
                {
                    $temp = $this->input->post('user_infoW'.$i);
                    $user_id = element('user_id', $temp);
                    $dept_code = 'SYST';
                    $this->trav_admin_add_tas->updateUserRoles($user_id, $dept_code);
                }
            }
			$this->view('travAdminAddTA');
		}
}