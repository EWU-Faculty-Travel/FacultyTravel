<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Model/system_variables
 *
 * Provides access to various system & department settings
 *
 * Author: Reid Fortier, Jason Helms, Josh Smith
 *
 * Created: 2013-05
 * Last Edited: 2013-08-22
*/
class System_variables extends CI_Model {
	function __construct()
	{
		parent::__construct();
		
		//Helpers
		$this->load->helper('array');
	}

	function dtcDatabaseQuery()
	{
		//Database pull
		$sql = "SELECT dept_code, allow_personal_car, allow_box_8 FROM tbl_userRoles NATURAL JOIN tbl_users NATURAL JOIN tbl_departments WHERE user_name = ? AND role_id = 2";
		$query = $this->db->query($sql, $this->cas->get_user());
		return $query;
	}
	
	function taDatabaseQuery()
	{
		//Database pull, we only want 1 result all data can be ignored...
		$sql = "SELECT * FROM tbl_system LIMIT 1";
		$query = $this->db->query($sql);
		return $query;
	}

	function dtcDatabaseUpdate($form_data)
	{
		//Database push
		$sql = "UPDATE tbl_departments SET allow_personal_car = ?, allow_box_8 = ? WHERE dept_code = ?";
		$query = $this->db->query($sql, $form_data);
	}

	// updates the system variables stored in the database.
	function taDatabaseUpdate($form_data)
	{
		//Database push
		$sql = "UPDATE tbl_system SET mileage_rate = ?, breakfast = ?, lunch = ?, dinner = ?";
		$query = $this->db->query($sql, $form_data);
	}
	
	// returns the travel agent associated with a specific deptartment
	function getDeptTravelAgent($dept)
	{
		$sql = "SELECT * FROM tbl_travelAgents WHERE dept_code = ?";
		$query = $this->db->query($sql, $dept);
		
		return $query;
	}
	
	// updates a departents travel agent in the system
	function saveDeptTravelAgent($data)
	{
		$sql = "UPDATE tbl_travelAgents SET name = ?, phone = ? WHERE dept_code = ?";
		$query = $this->db->query($sql, $data);
	}
}