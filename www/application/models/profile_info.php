<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Model/profile_info
 *
 * Mode handles all queries related to users and 
 * user info.
 * 
 *
 * Author: Reid Fortier, Josh Smith
 *
 * Created: 2013-05 
 * Last Edited: 2013-08-22
*/
class Profile_info extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}

	// edited to take user of getUserInfo without breaking any
	// current system functionality
	function databaseQuery()
	{
		//Database pull
		
		$user = $this->cas->get_user();
		return $this->getUserInfo($user);
	}
	
	// returns user information for the passed in user name:
	function getUserInfo($username)
	{
		$sql = "SELECT * FROM tbl_users WHERE user_name = ?";
		$query = $this->db->query($sql, $username);
		
		return $query;
	}
	
	// pulls the user's station from the database
	function stationDatabaseQuery()
	{
		//Database pull
		$sql = "SELECT * FROM tbl_station";
		$query = $this->db->query($sql);
		return $query;
	}

	// updates the user's profile info in the database
	function databaseUpdate($form_data)
	{
		//Database push
		$sql = "UPDATE tbl_users SET name = ?, id_num = ?, email = ?, phone = ?, phone_ext = ?, city = ?, state = ?, zip = ?, street = ?, station_id = ?, bldg_rm = ?, tooltips = ? , init_profile = 1 WHERE user_name = ?";
		$query = $this->db->query($sql, $form_data);
	}
	
	// adds the user to the database and returns the new users user_id
	function addUser($username, $email, $ewu_id, $station)
	{
		$sql = "SELECT * from tbl_users WHERE email = ? AND user_name != ?";
		$query = $this->db->query($sql, array($email, $username));
		
		// email entered is already in the db (connected to a different user)
		if ($query->num_rows() > 0)
		{
			return -4;
		}

		$sql = "SELECT * from tbl_users WHERE id_num = ? AND user_name != ?";
		$query = $this->db->query($sql, array($ewu_id, $username));		
		
		// EWU ID exists in the db (connected to a different user)
		if ($query->num_rows() > 0)
		{
			return -5;
		}
		
		$insert['user_name'] = $username;
		$insert['name'] = $username;
		$insert['email'] = $email;
		$insert['ewu_id'] = $ewu_id;
		$insert['station'] = $station;
		
		$sql = "INSERT INTO tbl_users (name, user_name, email, id_num, station_id, init_profile) VALUES (?, ?, ?, ?, ?, 0)";
		$query = $this->db->query($sql, $insert);
		
		$sql = "SELECT user_id FROM tbl_users WHERE user_name = ? LIMIT 1 ";
		$query = $this->db->query($sql, $username);
		
		foreach($query->result() as $row)
		{
			$userid = $row->user_id;
		}
		
		return $userid;
	}
	
	// returns the user id for the user passed in:
	// returns -1 if not found
	function getUserID($username)
	{
		$sql = "SELECT user_id FROM tbl_users WHERE user_name = ? LIMIT 1;";
		$query = $this->db->query($sql, $username);
		
		// check if user found:
		if ($query->num_rows() < 1)
		{
			return -1;
		}
		
		foreach($query->result() as $row)
		{
			$userid = $row->user_id;
		}
		
		return $userid;
	}

	// deletes the user associated with the username from the system:
	function deleteUser($username)
	{
		$sql = "DELETE FROM tbl_users WHERE user_name = ? LIMIT 1;";
		$query = $this->db->query($sql, $username);
	}
}