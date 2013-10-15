<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Model/add_dtcs
 *
 * Provides database access to do the following:
 * -databaseQuery():returns all depts that are not SYST
 *
 * Author: Jason Helms
 *
 * Created: 2013-07
 * Last Edited: 2013-07-27
*/
class Trav_admin_add_dtcs extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

	//gets a list of all departments. 
    function databaseQuery()
    {
        //Database pull
        $sql = "SELECT dept_code FROM tbl_departments
                WHERE dept_code != 'SYST'";
        $query = $this->db->query($sql);
        return $query;
    }
}