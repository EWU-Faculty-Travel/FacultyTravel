<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Model/Station_Edit
 *
 * Provides the db connections for the user to edit, delete and add stations 
 * 
 * Author: Jason Helms, Josh Smith
 *
 * Created: 2013-07 
 * Last Edited: 2013-08-11
*/
class Station_edit extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		
		// load helper:
		$this->load->helper('array');
	}
	
	//gets a list of all stations
	function databaseQuery()
	{
		$sql = "SELECT * FROM tbl_station;";
		$query = $this->db->query($sql);
		return $query;
	}
	
	//adds a station
	function addStation($name, $value)
	{
		$sqlCheck = "SELECT station_name FROM tbl_station WHERE 1;";
		$queryCheck = $this->db->query($sqlCheck);
		$valid = 0;
		foreach($queryCheck->result() as $row)
		{
			$equal = strcmp($row->station_name, $name);
			if($equal == 0)
				$valid = 1;
		}
		if($valid == 0)
		{
			$sql = "INSERT INTO tbl_station (`station_name`, `station_value`) VALUES (?, ?)";
			$query = $this->db->query($sql, array($name, $value));
		}
	}
	
	//delete a station
	function removeStation($default_id, $delete_id)
	{
		// update station to be deleted to new default before deleting:
		$sql = "UPDATE tbl_users SET station_id = ? WHERE station_id = ?";
		$data = array($default_id, $delete_id);
		$query = $this->db->query($sql, $data);
		
		// now we can delete the station:
		$sql = "DELETE FROM tbl_station WHERE station_id =  ?";
		$query = $this->db->query($sql, $delete_id);
	}
	
	//edit a station
	function updateStation($station_id, $station_name, $station_value)
	{
		$data = array($station_name, $station_value, $station_id);
		
		$sql = "UPDATE tbl_station SET station_name = ?, station_value = ? WHERE station_id = ?;";
		$query = $this->db->query($sql, $data);
	}
}//end class