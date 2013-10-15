<?php
/* Model\View_Trips_Model
 *
 * Provides the information needed to populate and display the list of trips to users
 *
 * Author: Reid Fortier, Josh Smith
 *
 * Created: 2013-08-24
 * Last Edited: 2013-08-31
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class View_trips_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}

	function pretripListDatabaseQuery()
    {
    //Database pull
    $sql = "SELECT trip_id, trip_name, dept_code, destination, purpose, description 
			FROM tbl_trip NATURAL JOIN tbl_users NATURAL JOIN tbl_status 
			WHERE user_name = ? AND trip_id NOT IN (SELECT trip_id
													FROM tbl_trip
													WHERE end_date <= NOW() 
													AND status_code IN (3,5,6,7,8,9))
			ORDER BY name, trip_id";
    $query = $this->db->query($sql, $this->cas->get_user());
    return $query;
    }

    function allPretripIDDatabaseQuery()
    {
        //Database pull
        //$sql = "SELECT trip_id FROM tbl_trip NATURAL JOIN tbl_users WHERE user_name = ? ORDER BY trip_id DESC";
        $sql = "SELECT trip_id 
				FROM tbl_trip NATURAL JOIN tbl_users 
				WHERE user_name = ? 
					AND trip_id NOT IN (SELECT trip_id
										FROM tbl_trip
										WHERE end_date <= NOW() 
											AND status_code IN (3,5,6,7,8,9))
				ORDER BY trip_id";
        $query = $this->db->query($sql, $this->cas->get_user());
        return $query;
    }

    function pretripListDTCDatabaseQuery()
    {
        //Hard coded department
        //Database pull
        $sql = "SELECT trip_id, trip_name, dept_code, authorization, name, destination, purpose, description 
			FROM tbl_trip NATURAL JOIN tbl_users NATURAL JOIN tbl_status 
			WHERE dept_code = ? 
				AND trip_id NOT IN (SELECT trip_id
									FROM tbl_trip
									WHERE end_date <= NOW() 
										AND status_code IN (3,5,6,7,8,9))
			ORDER BY name, trip_id";
        $query = $this->db->query($sql, "CSCD");
        return $query;
    }

    function allPretripIDDTCDatabaseQuery()
    {
        //Hard coded department
        //Database pull
        //$sql = "SELECT trip_id FROM tbl_trip NATURAL JOIN tbl_users WHERE dept_code = ? ORDER BY trip_id DESC";
        $sql = "SELECT trip_id 
				FROM tbl_trip  
				WHERE dept_code = ? 
					AND trip_id NOT IN (SELECT trip_id
										FROM tbl_trip
										WHERE end_date <= NOW() 
											AND status_code IN (3,5,6,7,8,9))
				ORDER BY trip_id";
				
        $query = $this->db->query($sql, "CSCD");
        return $query;
    }

    function posttripListDatabaseQuery()
    {
        //Database pull
        $sql = "SELECT trip_id, trip_name, dept_code, destination, purpose, description 
				FROM tbl_trip NATURAL JOIN tbl_users NATURAL JOIN tbl_status 
				WHERE user_name = ? 
					AND end_date <= NOW() 
					AND status_code IN (3,5,6,7,8,9)
				ORDER BY name, trip_id";
        $query = $this->db->query($sql, $this->cas->get_user());
        return $query;
    }

    function allPosttripIDDatabaseQuery()
    {
        //Database pull
        //$sql = "SELECT trip_id FROM tbl_trip NATURAL JOIN tbl_users WHERE user_name = ? ORDER BY trip_id DESC";
          $sql = "SELECT trip_id  FROM tbl_trip NATURAL JOIN tbl_users WHERE user_name = ? AND end_date <= NOW() AND status_code IN (3,5,6,7,8,9) ORDER BY trip_id";
        $query = $this->db->query($sql, $this->cas->get_user());
        return $query;
    }

    function posttripListDTCDatabaseQuery()
    {
        //Hard coded department
        //Database pull
        $sql = "SELECT trip_id, trip_name, dept_code, authorization, name, destination, purpose, description 
				FROM tbl_trip NATURAL JOIN tbl_users NATURAL JOIN tbl_status 
				WHERE dept_code = ? 
					AND end_date <= NOW()
					AND status_code IN (3,5,6,7,8,9)
				ORDER BY name, trip_id";
        $query = $this->db->query($sql, "CSCD");
        return $query;
    }

    function allPosttripIDDTCDatabaseQuery()
    {
        //Hard coded department
        //Database pull
		$sql = "SELECT trip_id 
				FROM tbl_trip NATURAL JOIN tbl_users 
				WHERE dept_code = ?
					AND end_date <= NOW() 
					AND status_code IN (3,5,6,7,8,9)
				ORDER BY trip_id";
        $query = $this->db->query($sql, "CSCD");
        return $query;
    }

    function emailDatabaseQuery($user_name)
    {
        $sql = "SELECT email FROM tbl_users WHERE user_name = ?";
        $query = $this->db->query($sql, $user_name);
        return $query;
    }

    function facultyEmailDatabaseQuery($trip_id)
    {
        $sql = "SELECT email FROM tbl_users NATURAL JOIN tbl_trip WHERE trip_id = ?";
        $query = $this->db->query($sql, $trip_id);
        return $query;
    }

	function pageOneDataDatabaseQuery($trip_id)
	{
		//Database pull
		$sql = "SELECT * FROM tbl_trip NATURAL JOIN tbl_users WHERE trip_id = ?";
		$query = $this->db->query($sql, $trip_id);
		return $query;
	}
	
	function pageOneModesDatabaseQuery($trip_id)
	{
		//Database pull
		$sql = "SELECT mode FROM tbl_tripModes WHERE trip_id = ?";
		$query = $this->db->query($sql, $trip_id);
		return $query;
	}
	
	function pageOneSideTripsDatabaseQuery($trip_id)
	{
		//Database pull
		$sql = "SELECT trip_start, trip_end FROM tbl_personalTrips WHERE trip_id = ?";
		$query = $this->db->query($sql, $trip_id);
		return $query;
	}
	
	function submittedDatabaseQuery($status_code)
	{
		//Database push
		$sql = "SELECT description FROM tbl_status WHERE status_code = ?";
		$query = $this->db->query($sql, $status_code);
		return $query;
	}

    function statusCodeDatabaseQuery($trip_id)
    {
        //Database push
        $sql = "SELECT status_code FROM tbl_trip WHERE trip_id = ?";
        $query = $this->db->query($sql, $trip_id);
        return $query;
    }
	
	function submittedDatabaseUpdate($trip_id, $status_code)
	{
		$sql_data = array($status_code, $trip_id);
		//Database push
		$sql = "UPDATE tbl_trip SET status_code = ? WHERE trip_id = ?";
		$query = $this->db->query($sql, $sql_data);
	}

	//gets the name of the faculty member who wants the $$$$
	function getFacultyName($trip_id)
	{
		$sql = 'SELECT name
				FROM tbl_users NATURAL JOIN tbl_trip
				WHERE tbl_trip.trip_id = ?;';
		$query = $this->db->query($sql, $trip_id);
		$row = $query->row();
		return $row['name'];
	}
}