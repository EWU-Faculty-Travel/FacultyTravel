<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Model/user_roles
 *
 * Provides database access to determine a application user's 
 * role or roles in the system. Also returns all dept_codes 
 * and user's TA status. 
 *
 * User by the following controllers:
 * AddUsers
 *
 * Author: Reid Fortier, Jason Helms, Josh Smith
 *
 * Created: 2013-05
 * Last Edited: 2013-08-22
*/
class User_roles extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}
	
	function databaseQuery()
	{
		//Database pull
		$sql = "SELECT DISTINCT role_id FROM tbl_userRoles NATURAL JOIN tbl_users WHERE user_name = ? ORDER BY role_id ASC";
		$query = $this->db->query($sql, $this->cas->get_user());
		return $query;
	}
	
	/*
	 * Pulls the 'init_profile' flag 1 - filled out, 0 - not filled out
	 *
	 */
	 function profile($username)
	 {
		$sql = 'SELECT init_profile 
				FROM tbl_users
				WHERE user_name = ?;';
		$query = $this->db->query($sql, $username);
		return $query;
	 }

	/*
	 * Pulls all roles & departments for the user
	 *
	 */
	function fetchRoles()
	{
		//Get all roles for all depts for the user:
		$sql = "SELECT role_id, description FROM tbl_userRoles NATURAL JOIN tbl_users NATURAL JOIN tbl_departments WHERE user_name = ? AND dept_code != 'SYST' ORDER BY role_id";
		$query = $this->db->query($sql, $this->cas->get_user());
		return $query;
	}
	
	/*
	 * checks to see if the user is a TA in the system (has a user role of 3)
	 */
	function isTravelAdmin()
	{
		$sql = "SELECT role_id FROM tbl_userRoles NATURAL JOIN tbl_users WHERE user_name = ? AND role_id = 3";
		$query = $this->db->query($sql, $this->cas->get_user());
		
		$result = false;
		// if there is at least one record the user is a travel admin
		if ($query->num_rows() > 0)
		{
			$result = true;
		}
		
		return $result;
	}
	
	/*
	 * Return all the department codes in the system:
	 */
	function getAllDepartments()
	{
		// select all the dept codes from the db:
		$sql = "SELECT dept_code FROM tbl_departments WHERE dept_code != 'SYST'";
		$query = $this->db->query($sql); //, $this->cas->get_user());
		return $query;		
	}
	
	/*
	 * Returns all the department codes for which the user is a DTC
	 */
	function getDTCDepartments()
	{
		$sql = "SELECT dept_code FROM tbl_userRoles NATURAL JOIN tbl_users WHERE user_name = ? AND role_id = 2 ORDER BY dept_code";
		$query = $this->db->query($sql, $this->cas->get_user());
		return $query;
	}

	// from add_dtcs:
	
	//gets a list of faculty by dept with dtc permissions
	function getFacultyByDept($dept)
	{
		$sql = "SELECT DISTINCT name, user_id, user_name
				FROM tbl_users NATURAL JOIN tbl_userRoles
				where dept_code = ?
				and role_id = 2;";
		$query = $this->db->query($sql, $dept);
		return $query;
	}
	
	//gets a list of faculty by dept with dtc without permissions NP => Non Permission
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
	
	// deletes a user role for a specific department 
	function removeUserRole($user_id, $role_id, $dept)
	{
		$sql = "DELETE FROM tbl_userRoles WHERE user_id = ? AND role_id = ? AND dept_code = ?;";
		$query = $this->db->query($sql, array($user_id, $role_id, $dept));
	}
	
	// adds a user role for a specific department
	function addUserRole($user_id, $role_id, $dept)
	{
		$sql = "SELECT * FROM tbl_userRoles WHERE user_id = ? AND role_id = ? AND dept_code = ?;";
		$query = $this->db->query($sql, array($user_id, $role_id, $dept));
		
		if ($query->num_rows() > 0) // gracefully fail if the user has been given the role already
		{
			// user role already existed:
			return -1;
		}
		else
		{
			$sql = "INSERT INTO tbl_userRoles VALUES (?, ?, ?);";
			$query = $this->db->query($sql, array($user_id, $role_id, $dept));

		}
	}
	
	// returns all users in a dept.
	function getDeptUsers($dept)
	{
		$sql = "SELECT U.user_id, U.user_name, U.name, U.id_num, MAX(UR.role_id)
				FROM tbl_users U 
					NATURAL JOIN tbl_userRoles UR
				WHERE dept_code = ?
				GROUP BY U.user_id ;";
		$query = $this->db->query($sql, $dept);
		
		return $query;
	}
	
	// will delete the user with the passed in user_id from the system:
	function deleteUser($user_id)
	{
		$sql = "DELETE FROM tbl_users WHERE user_id = ? LIMIT 1;";
		$query = $this->db->query($sql, $user_id);
	}
}