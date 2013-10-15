<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Model/cron_model
 *
 * The necessary database functions needed for all the jobs run by cron
 *
 * Author: Reid Fortier
 *
 * Created: 2013-08-23
 * Last Edited: 2013-08-23
*/
class Cron_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }

    function cronSubmittedDatabaseUpdate()
    {
        //Database push
        $sql = "UPDATE tbl_trip SET status_code = 5 WHERE status_code = 3 AND end_date < SYSDATE()";
        $query = $this->db->query($sql);
    }

    function cronImmediateReminderDatabaseQuery()
    {
        //Database pull
        $sql = "SELECT trip_id, trip_name, name, email FROM tbl_users NATURAL JOIN tbl_trip WHERE (status_code = 5 OR status_code = 9) AND end_date < SYSDATE() AND SYSDATE() < DATE_ADD(end_date, INTERVAL 13 HOUR)";
        $query = $this->db->query($sql);
        return $query;
    }

    function cronDelayedReminderDatabaseQuery()
    {
        //Database pull
        $sql = "SELECT trip_id, trip_name, name, email FROM tbl_users NATURAL JOIN tbl_trip WHERE (status_code = 5 OR status_code = 9) AND DATE_ADD(end_date, INTERVAL 7 DAY) < SYSDATE() AND SYSDATE() < DATE_ADD(end_date, INTERVAL 10 DAY)";
        $query = $this->db->query($sql);
        return $query;
    }
}