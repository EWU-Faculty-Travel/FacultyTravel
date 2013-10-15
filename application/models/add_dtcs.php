<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Model/Add_dtcs
 *
 * Provides the db connections for the user to manage Department Travel Coordinators 
 * 
 * Author: Jason Helms
 *
 * Created: 2013-07 
 * Last Edited: 2013-08-11
*/
class Add_dtcs extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	//get all dept that the current user is apart of
	function getDepts()
	{
		$sql = "SELECT DISTINCT dept_code
				FROM tbl_users NATURAL JOIN tbl_userRoles
				WHERE user_name = ? AND dept_code != 'SYST';";
		$query = $this->db->query($sql, $this->cas->get_user());
		return $query;
	}
	
	//get all faculty in current users dept with DTC permissions(current user has DTC permissions).
	function getFacultyByDept($dept)
	{
		$sql = "SELECT DISTINCT name, user_id, user_name
				FROM tbl_users NATURAL JOIN tbl_userRoles
				where dept_code = ?
				and role_id = 2;";
		$query = $this->db->query($sql, $dept);
		return $query;
	}
	
	//get all faculty in current users dept without DTC permissions(current user has DTC permissions).
	function getFacultyByDeptNP($dept)
	{
		$sql = "SELECT DISTINCT name, user_id, user_name
				FROM tbl_users NATURAL JOIN tbl_userRoles
				where dept_code = ?
				and role_id = 1
				and user_id not in 
				(SELECT DISTINCT user_id
				FROM tbl_users NATURAL JOIN tbl_userRoles
				where dept_code = ?
				and role_id = 2);";
		$query = $this->db->query($sql, array($dept, $dept));
		return $query;
	}
	
	//removes a users (not current) user role of DTC
	function removeUserRoles1($user_id, $dept)
	{
		$sql = "DELETE FROM tbl_userRoles
				WHERE user_id = ? AND role_id = ? AND dept_code = ?;";
		
		$query = $this->db->query($sql, array($user_id, 2, $dept));
	}
	
	//gives a user the role of DTC
	function updateUserRoles1($user_id, $dept)
	{
		$sql = "INSERT INTO tbl_userRoles VALUES (?, ?, ?);";
		
		$query = $this->db->query($sql, array($user_id, 2, $dept));
	}
}