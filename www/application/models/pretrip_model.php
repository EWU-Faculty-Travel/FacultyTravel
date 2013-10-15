<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Model/Pretrip_model
 *
 * provides db access for pre-trip information
 *
 * Author: Reid Fortier, Josh Smith
 *
 * Created: 2013-08
 * Last Edited: 2013-08-28
*/
class Pretrip_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}

	function userIDDatabaseQuery()
	{
		//Database pull
		$sql = "SELECT user_id FROM tbl_users WHERE user_name = ?";
		$query = $this->db->query($sql, $this->cas->get_user());
		return $query;
	}

    function originalUserIDDatabaseQuery($trip_id)
    {
        //Database pull
        $sql = "SELECT user_id FROM tbl_trip WHERE trip_id = ?";
        $query = $this->db->query($sql, $trip_id);
        return $query;
    }

    function travelAuthorizationNumberDatabaseQuery($trip_id)
    {
        //Database pull
        $sql = "SELECT authorization FROM tbl_trip WHERE trip_id = ?";
        $query = $this->db->query($sql, $trip_id);
        return $query;
    }

	function deptDatabaseQuery()
	{
		//Database pull
		$sql = "SELECT dept_code FROM tbl_userRoles NATURAL JOIN tbl_users WHERE user_name = ? AND role_id = 1";
		$query = $this->db->query($sql, $this->cas->get_user());
		return $query;
	}

	function tripIDDatabaseQuery()
	{
		//Database pull
		$sql = "SELECT MAX(trip_id) AS trip_id FROM tbl_trip NATURAL JOIN tbl_users WHERE user_name = ?";
		$query = $this->db->query($sql, $this->cas->get_user());
		return $query;
	}

	function mileageRateDatabaseQuery()
	{
		//Database pull
		$sql = "SELECT mileage_rate FROM tbl_system";
		$query = $this->db->query($sql);
		return $query;
	}

	function modesDatabaseQuery($trip_id)
	{
		//Database pull
		$sql = "SELECT mode FROM tbl_tripModes WHERE trip_id = ?";
		$query = $this->db->query($sql, $trip_id);
		return $query;
	}

	function travelAgentsDatabaseQuery($name, $phone)
	{
		$sql_data = array($name, $phone);
		//Database pull
		$sql = "SELECT agency_id FROM tbl_travelAgents WHERE name = ? AND phone = ?";
		$query = $this->db->query($sql, $sql_data);
		return $query;
	}

	function travelQuotesDatabaseQuery($trip_id)
	{
		//Database pull
		$sql = "SELECT mode, quote FROM tbl_travelQuotes WHERE trip_id = ?";
		$query = $this->db->query($sql, $trip_id);
		return $query;
	}

	function registrationDatabaseQuery($trip_id)
	{
		//Database pull
		$sql = "SELECT amount, paytype_id FROM tbl_registration WHERE trip_id = ?";
		$query = $this->db->query($sql, $trip_id);
		return $query;
	}

	function rentalCarPaytypeDatabaseQuery($trip_id)
	{
		//Database pull
		$sql = "SELECT paytype_id FROM tbl_transRequests WHERE trip_id = ? AND trip_mode = 6";
		$query = $this->db->query($sql, $trip_id);
		return $query;
	}

	function mileageDatabaseQuery($trip_id)
	{
		//Database pull
		$sql = "SELECT start_location, destination, distance FROM tbl_preMileage WHERE trip_id = ?";
		$query = $this->db->query($sql, $trip_id);
		return $query;
	}

	function perDeimDatabaseQuery($trip_id)
	{
		//Database pull
		$sql = "SELECT trip_date, time_start, time_end, start_location, destination, breakfast, lunch, dinner, lodging, days FROM tbl_prePerDiem WHERE trip_id = ?";
		$query = $this->db->query($sql, $trip_id);
		return $query;
	}

	function perDeimRatesDatabaseQuery()
	{
		//Database pull
		$sql = "SELECT breakfast, lunch, dinner FROM tbl_system";
		$query = $this->db->query($sql);
		return $query;
	}

	function miscDatabaseQuery($trip_id)
	{
		//Database pull
		$sql = "SELECT expense, amount FROM tbl_preMisc WHERE trip_id = ?";
		$query = $this->db->query($sql, $trip_id);
		return $query;
	}

    function modesDatabaseSave($trip_id, $mode)
	{
		$sql_data = array($trip_id, $mode);
		//Database push
		$sql = "REPLACE INTO tbl_tripModes (trip_id, mode) VALUES (?, ?)";
		$query = $this->db->query($sql, $sql_data);
	}

	function modesDatabaseDelete($trip_id, $mode)
	{
		$sql_data = array($trip_id, $mode);
		//Database push
		$sql = "DELETE FROM tbl_tripModes WHERE trip_id = ? AND mode = ?";
		$query = $this->db->query($sql, $sql_data);

        $sql = "DELETE FROM tbl_travelQuotes WHERE trip_id = ? AND mode = ?";
        $query = $this->db->query($sql, $sql_data);
	}

	function sidetripDatabaseSave($trip_id, $trip_start, $trip_end)
	{
		$sql_data = array($trip_id, $trip_start, $trip_end);
		//Database push
		$sql = "REPLACE INTO tbl_personalTrips (trip_id, trip_start, trip_end) VALUES (?, ?, ?)";
		$query = $this->db->query($sql, $sql_data);
	}

	function sidetripDatabaseDelete($trip_id)
	{
		//Database push
		$sql = "DELETE FROM tbl_personalTrips WHERE trip_id = ?";
		$query = $this->db->query($sql, $trip_id);
	}

	function tripDatabaseDelete($trip_id)
	{
		//Database push
		$sql = "DELETE FROM tbl_trip WHERE trip_id = ?";
		$query = $this->db->query($sql, $trip_id);
	}

	function pageOneDatabaseSave($form_data)
	{
		//Database push
		$sql = "INSERT INTO tbl_trip (dept_code, trip_name, user_id, start_date, end_date, departure, destination, purpose, group_count) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$query = $this->db->query($sql, $form_data);
	}

    function pageOneDatabaseUpdate($form_data)
	{
		//Database push
		$sql = "UPDATE tbl_trip SET dept_code = ?, trip_name = ?, user_id = ?, start_date = ?, end_date = ?, departure = ?, destination = ?, purpose = ?, group_count = ? WHERE trip_id = ?";
		$query = $this->db->query($sql, $form_data);
	}

	function mileageDatabaseUpdate($form_data)
	{
		//Database push
		$sql = "INSERT INTO tbl_preMileage (trip_id, start_location, destination, distance) VALUES (?, ?, ?, ?)";
		$query = $this->db->query($sql, $form_data);
	}

	function mileageDatabaseDelete($trip_id)
	{
		//Database push
		$sql = "DELETE FROM tbl_preMileage WHERE trip_id = ?";
		$query = $this->db->query($sql, $trip_id);
	}

	function miscDatabaseUpdate($form_data)
	{
		//Database push
		$sql = "REPLACE INTO tbl_preMisc (trip_id, expense, amount) VALUES (?, ?, ?)";
		$query = $this->db->query($sql, $form_data);
	}

	function miscDatabaseDelete($trip_id)
	{
		//Database push
		$sql = "DELETE FROM tbl_preMisc WHERE trip_id = ?";
		$query = $this->db->query($sql, $trip_id);
	}

	function perDeimDatabaseUpdate($form_data)
	{
		//Database push
		$sql = "INSERT INTO tbl_prePerDiem (trip_id, trip_date, start_location, time_start, destination, time_end, breakfast, lunch, dinner, lodging, days) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$query = $this->db->query($sql, $form_data);
	}

	function perDeimDatabaseDelete($trip_id)
	{
		//Database push
		$sql = "DELETE FROM tbl_prePerDiem WHERE trip_id = ?";
		$query = $this->db->query($sql, $trip_id);
	}

    function travelQuotesDatabaseDelete($trip_id, $trip_mode)
    {
        $sql_data = array($trip_id, $trip_mode);
        //Database push
        $sql = "DELETE FROM tbl_travelQuotes WHERE trip_id = ? AND mode = ?";
        $query = $this->db->query($sql, $sql_data);
    }

    function registrationDatabaseDelete($trip_id)
    {
        //Database push
        $sql = "DELETE FROM tbl_registration WHERE trip_id = ?";
        $query = $this->db->query($sql, $trip_id);
    }

    function allTravelQuotesDatabaseDelete($trip_id)
    {
        //Database push
        $sql = "DELETE FROM tbl_travelQuotes WHERE trip_id = ?";
        $query = $this->db->query($sql, $trip_id);
    }

	function travelAgentsDatabaseUpdate($form_data)
	{
		//Database push
		$sql = "REPLACE INTO tbl_travelAgents (name, phone) VALUES (?, ?)";
		$query = $this->db->query($sql, $form_data);
	}

	function registrationDatabaseUpdate($form_data)
	{
		//Database push
		$sql = "REPLACE INTO tbl_registration (trip_id, amount, paytype_id) VALUES (?, ?, ?)";
		$query = $this->db->query($sql, $form_data);
	}

	function travelQuotesDatabaseUpdate($form_data)
	{
		//Database push
		$sql = "REPLACE INTO tbl_travelQuotes (trip_id, agency_id, mode, quote) VALUES (?, ?, ?, ?)";
		$query = $this->db->query($sql, $form_data);
	}

	function transferRequestsDatabaseUpdate($form_data)
	{
		//Database push
		$sql = "REPLACE INTO tbl_transRequests (trip_id, trip_mode, paytype_id, agency_id) VALUES (?, ?, ?, ?)";
		$query = $this->db->query($sql, $form_data);
	}

    function travAuthNumUpdate($trip_id, $trav_auth)
    {
        $sql_data = array($trav_auth, $trip_id);
        //Database push
        $sql = "UPDATE tbl_trip SET authorization = ? WHERE trip_id = ?";
        $query = $this->db->query($sql, $sql_data);
    }

	function getDTCEmails()
	{
		$sql = 'SELECT email
				FROM tbl_users NATURAL JOIN tbl_userRoles
				WHERE role_id = ?;';
		$query = $this->db->query($sql, 2);
		return $query;
	}

	function getName($user_name)
	{
		$sql = 'SELECT name
				FROM tbl_users
				WHERE user_name = ?;';
		$query = $this->db->query($sql, $user_name);
		$row = $query->row();
		return $row->name;
	}

	// returns the agency id of the travel agency associated with the department
	// associated with the passed in trip.
	function getAgencyID($trip_id)
	{
		$sql = 'SELECT agency_id
				FROM tbl_travelAgents NATURAL JOIN tbl_departments NATURAL JOIN tbl_trip
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, $trip_id);
		$row = $query->row();
		return $row->agency_id;
	}

    function indexCodeDatabaseDelete($trip_id)
    {
        //Database push
        $sql = "DELETE FROM tbl_tripIndexCodes WHERE trip_id = ?";
        $query = $this->db->query($sql, $trip_id);
    }

    function indexCodeDatabaseSave($sql_data)
    {
        //Database pull
        $sql = "REPLACE INTO tbl_tripIndexCodes (trip_id, index_code, percentage, amount) VALUES (?, ?, ?, ?)";
        $query = $this->db->query($sql, $sql_data);
    }

    function indexCodeDatabaseQuery($trip_id)
    {
        //Database push
        $sql = "SELECT * FROM tbl_tripIndexCodes WHERE trip_id = ?";
        $query = $this->db->query($sql, $trip_id);
        return $query;
    }
	
	function getTripName($trip_id)
	{
		$sql = "SELECT trip_name FROM tbl_trip WHERE trip_id = ?";
        $query = $this->db->query($sql, $trip_id);
        $row = $query->row(0);
		return $row->trip_name;
		 
	}
}