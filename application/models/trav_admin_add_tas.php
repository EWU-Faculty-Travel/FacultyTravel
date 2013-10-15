<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Model/trav_admin_add_tas
 *
 * Provides database access to do the following:
 *
 * Author: Jason Helms
 *
 * Created: 2013-07-22
 * Last Edited: 2013-07-30
*/

class Trav_admin_add_tas extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}
	
	//gets all faculty with TA permissions
	function getFacultyTA()
	{
		$sql = 'SELECT name, user_id, user_name
				FROM tbl_users NATURAL JOIN tbl_userRoles
				WHERE tbl_userRoles.dept_code = ?;';
		$query = $this->db->query($sql, 'SYST');
		return $query;
	}
	
	//gets all faculty from the specified dept without TA permissions
	function getFaculty($dept)
	{
		$sql = 'SELECT DISTINCT name, user_id, user_name
				FROM tbl_users NATURAL JOIN tbl_userRoles
				WHERE dept_code = ?
				AND name NOT IN 
				(SELECT name 
				FROM tbl_users NATURAL JOIN tbl_userRoles
				WHERE tbl_userRoles.dept_code = ?
				);';
		$query = $this->db->query($sql, array($dept, 'SYST'));
		return $query;
	}
	
	//remove the permissions of a user (Travel Admin Permissions). 
	function removeUserRoles($user_id, $dept)
    {
        $sql = "DELETE FROM tbl_userRoles
                WHERE user_id = ? AND role_id = ? AND dept_code = ?;";

        $query = $this->db->query($sql, array($user_id, 3, $dept));
    }
	
	//gives a faculty member Travel Admin Permissions
	function updateUserRoles($user_id, $dept)
    {
        $sql = "INSERT INTO tbl_userRoles VALUES (?, ?, ?);";

        $query = $this->db->query($sql, array($user_id, 3, $dept));
    }
}