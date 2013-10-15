<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Model/Pretrip_model
 *
 * Provides all the database information needed for Post Trip functionality
 *
 * Author: Reid Fortier
 *
 * Created: 2013-08-21
 * Last Edited: 2013-08-25
*/
class Posttrip_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}

    function miscDatabaseQuery($trip_id)
    {
        //Database pull
        $sql = "SELECT * FROM tbl_postMisc WHERE trip_id = ?";
        $query = $this->db->query($sql, $trip_id);
        return $query;
    }

    function mileageDatabaseQuery($trip_id)
    {
        //Database pull
        $sql = "SELECT start_location, destination, distance FROM tbl_postMileage WHERE trip_id = ?";
        $query = $this->db->query($sql, $trip_id);
        return $query;
    }

    function perDeimDatabaseQuery($trip_id)
    {
        //Database pull
        $sql = "SELECT trip_date, time_start, time_end, start_location, destination, breakfast, lunch, dinner, lodging FROM tbl_postPerDiem WHERE trip_id = ?";
        $query = $this->db->query($sql, $trip_id);
        return $query;
    }

    function refundsDatabaseQuery($trip_id)
    {
        //Database pull
        $sql = "SELECT date, payee, amount FROM tbl_refunds WHERE trip_id = ?";
        $query = $this->db->query($sql, $trip_id);
        return $query;
    }

    function commentsDatabaseQuery($trip_id)
    {
        //Database pull
        $sql = "SELECT trip_comment FROM tbl_comment WHERE trip_id = ?";
        $query = $this->db->query($sql, $trip_id);
        return $query;
    }

    function mileageDatabaseDelete($trip_id)
    {
        //Database push
        $sql = "DELETE FROM tbl_postMileage WHERE trip_id = ?";
        $query = $this->db->query($sql, $trip_id);
    }

    function mileageDatabaseUpdate($form_data)
    {
        //Database push
        $sql = "INSERT INTO tbl_postMileage (trip_id, start_location, destination, distance, vicinity) VALUES (?, ?, ?, ?, ?)";
        $query = $this->db->query($sql, $form_data);
    }

    function miscDatabaseDelete($trip_id)
    {
        //Database push
        $sql = "DELETE FROM tbl_postMisc WHERE trip_id = ?";
        $query = $this->db->query($sql, $trip_id);
    }

    function miscDatabaseUpdate($form_data)
    {
        //Database push
        $sql = "REPLACE INTO tbl_postMisc (trip_id, date, payee, expense, amount) VALUES (?, ?, ?, ?, ?)";
        $query = $this->db->query($sql, $form_data);
    }

    function perDeimDatabaseDelete($trip_id)
    {
        //Database push
        $sql = "DELETE FROM tbl_postPerDiem WHERE trip_id = ?";
        $query = $this->db->query($sql, $trip_id);
    }

    function perDeimDatabaseUpdate($form_data)
    {
        //Database push
        $sql = "INSERT INTO tbl_postPerDiem (trip_id, trip_date, start_location, time_start, destination, time_end, breakfast, lunch, dinner, lodging) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $query = $this->db->query($sql, $form_data);
    }

    function commentsDatabaseDelete($trip_id)
    {
    //Database push
    $sql = "DELETE FROM tbl_comment WHERE trip_id = ?";
    $query = $this->db->query($sql, $trip_id);
    }

    function commentsDatabaseUpdate($form_data)
    {
        //Database push
        $sql = "INSERT INTO tbl_comment (trip_id, trip_comment) VALUES (?, ?)";
        $query = $this->db->query($sql, $form_data);
    }

    function refundsDatabaseDelete($trip_id)
    {
        //Database push
        $sql = "DELETE FROM tbl_refunds WHERE trip_id = ?";
        $query = $this->db->query($sql, $trip_id);
    }

    function refundsDatabaseUpdate($form_data)
    {
        //Database push
        $sql = "REPLACE INTO tbl_refunds (trip_id, date, payee, amount) VALUES (?, ?, ?, ?)";
        $query = $this->db->query($sql, $form_data);
    }
}