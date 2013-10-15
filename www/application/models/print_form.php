<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* Model/Print_form
 *
 * Provides the db connections for the user to print a form 
 * 
 * Author: Jason Helms, Josh Smith
 *
 * Created: 2013-08-13 
 * Last Edited: 2013-08-28
*/
class Print_form extends CI_Model 
{
	var $_trip_id;
	var $_user_name;
	var $_user_id;
	
	function __construct()
	{
		parent::__construct();
	}//end parent constructor - Thanks CodeIgniter!
	
	//sets the trip_id to be printed in db table
	function setDBTripID($trip_id)
	{
		$sql = "INSERT INTO tbl_print (trip_id, printed) VALUES (?, ?)";
        $query = $this->db->query($sql, array($trip_id, 0));
	}
	
	//gets the trip_id to be printed form the DB
	function getDBTripID()
	{
		$sql = "SELECT trip_id FROM tbl_print WHERE printed = ?";
        $query = $this->db->query($sql, 0);
		
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$ret = $row->trip_id;
			return $ret;
		}
	}
	
	//deletes all trip_id's from print table in DB, should only be one anyways. 
	function deleteDBTripID()
	{
		$sql = "DELETE  FROM tbl_print WHERE ?";
        $query = $this->db->query($sql, 1);
	}
	
	//sets the trip_id for all the other functions
	function set_id($tripid)
	{
		$this->_trip_id = $this->getDBTripID();
		$sql = "REPLACE INTO tbl_print (trip_id, printed) VALUES (?, ?)";
        $query = $this->db->query($sql, array($this->_trip_id, 1));
		
	}
	
	//get official city, state
	function get_OfficialResidence()
	{
		$sql = 'SELECT city, state
				FROM tbl_users
				WHERE user_id = ?;';
		$query = $this->db->query($sql, $this->_user_id);
		$row = $query->row();
		$ret = $row->city.', '.$row->state;
		return $ret;
	}
	
	//get station value
	function get_OfficialStation()
	{
		$sql = 'SELECT station_id
				FROM tbl_users
				WHERE user_id = ?;';
		$query = $this->db->query($sql, $this->_user_id);
		$row = $query->row();
		$next = $row->station_id;
		
		$sql_ret = 'SELECT station_value
					FROM tbl_station
					WHERE station_id = ?;';
		$query_ret = $this->db->query($sql_ret, $next);
		$row_ret = $query_ret->row();
		return $row_ret->station_value;
	}
	
	//get user id
	function get_id()
	{
		$user_name_retrive = 'SELECT user_name
							  FROM tbl_users NATURAL JOIN tbl_trip
							  WHERE trip_id = ?;';
		$user_name_query = $this->db->query($user_name_retrive, $this->_trip_id);
		$row = $user_name_query->row();
		$this->_user_name = $row->user_name;
		
		$user_id_retrive  = 'SELECT user_id
							 FROM tbl_users
							 WHERE user_name = ?;';
		$user_id_query = $this->db->query($user_id_retrive, $this->_user_name);
		
		$row1 = $user_id_query->row();
		$this->_user_id = $row1->user_id;
		$sql_id_retrive = 'SELECT id_num
						   FROM tbl_users
						   WHERE user_id = ?;';
		$query = $this->db->query($sql_id_retrive, $this->_user_id);
		$row = $query->row();
		return $row->id_num;
	}//end get_id()
	
	//get group count
	function group_count()
	{
		$sql = 'SELECT group_count
				FROM tbl_trip
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, $this->_trip_id);
		$row = $query->row_array(0);
		if($query->num_rows() > 0)
			$ret = $row['group_count'];
		else 
			$ret = ' ';
		return $ret;
	}
	
	//get Travel Authorization Number
	function get_TAN()
	{
		$sql = 'SELECT DISTINCT authorization
				FROM tbl_trip
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, $this->_trip_id);
		$row = $query->row_array(0);
		if($query->num_rows() > 0)
			$ret = $row['authorization'];
		else 
			$ret = '0';
		return $ret;
	}//end get_TAN => Travel Authorization Number
	
	//get users name
	function get_name()
	{
		$sql = 'SELECT name 
				FROM tbl_users
				WHERE user_id = ?;';
		$query = $this->db->query($sql, $this->_user_id);
		
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$name = $row->name;
		}
		else
		{
			$name = ' ';
		}
		return $name;
	}//end get_name
	
	//get office phone
	function get_office_phone()
	{
		$sql = 'SELECT phone, phone_ext
				FROM tbl_users
				WHERE user_id = ?;';
		$query = $this->db->query($sql, $this->_user_id);
		
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			if($row->phone_ext != 0)
				$phone = $row->phone.'x'.$row->phone_ext;
			else
				$phone = $row->phone;
		}
		else
		{
			$phone = '__________';
		}
		return $phone;
	}
	
	//get bldg and rm number
	function get_bldg_rm()
	{
		$sql = 'SELECT bldg_rm 
				FROM tbl_users
				WHERE user_id = ?;';
		$query = $this->db->query($sql, $this->_user_id);
		
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$bldg_rm = $row->bldg_rm;
		}
		else
		{
			$bldg_rm = ' ';
		}
		return $bldg_rm;
	}//end get_bldg_rm
	
	//get mail addy line 1
	function get_mail_1()
	{
		//get street and street number
		$sql = 'SELECT street 
				FROM tbl_users
				WHERE user_id = ?;';
		$query = $this->db->query($sql, $this->_user_id);
		
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$street = $row->street;
		}
		else
		{
			$street = ' ';
		}
		return $street;
	}//end get_mail_1 first line of mailing address
	
	//get the user printing the form
	function get_preper()
	{
		$sql = 'SELECT name 
				FROM tbl_users
				WHERE user_name = ?;';
		$query = $this->db->query($sql, $this->cas->get_user());
		
		if ($query->num_rows() > 0)
		{
		   $row = $query->row(); 
		   $name = $row->name;
		}
		else
		{
			$name = ' ';
		}
		return $name;
	}//end get_preper
	
	//get the second line of get mail
	function get_mail_2()
	{
		$sql = 'SELECT city, state, zip 
				FROM tbl_users
				WHERE user_id = ?;';
		$query = $this->db->query($sql, $this->_user_id);
		
		if ($query->num_rows() > 0)
		{
		   $row = $query->row(); 
		   $return = $row->city.', '.$row->state.' '.$row->zip;
		}
		else
		{
		   $return = '_______________________________';
		}
		return $return;
	}//end get_mail_2 gets the second line of the mailing addy (city, state, zip)
	
	//get voucher copys users phone number
	function get_phone()
	{
		$sql = 'SELECT phone 
				FROM tbl_users
				WHERE user_id= ?;';
		$query = $this->db->query($sql, $this->_user_id);
		
		if ($query->num_rows() > 0)
		{
		   $row = $query->row(); 
		   $phone = $row->phone;
		}
		else
		{
			$phone = ' ';
		}
		return $phone;
	}//end get_phone
	
	//get trip start location
	function get_from()
	{
		$sql = 'SELECT departure 
				FROM tbl_trip
				WHERE trip_id= ?;';
		$query = $this->db->query($sql, $this->_trip_id);
		
		if ($query->num_rows() > 0)
		{
		   $row = $query->row(); 
		   $dest = $row->departure;
		}
		else
		{
			$dest = ' ';
		}
		return $dest;
	}//end get_from
	
	//get trip destination
	function get_to()
	{
		$sql = 'SELECT destination 
				FROM tbl_trip
				WHERE trip_id= ?;';
		$query = $this->db->query($sql, $this->_trip_id);
		
		if ($query->num_rows() > 0)
		{
		   $row = $query->row(); 
		   $dest = $row->destination;
		}
		else
		{
			$dest = ' ';
		}
		return $dest;
	}//end get_to
	
	//get purpose of trip
	function get_purpose()
	{
		$sql = 'SELECT purpose 
				FROM tbl_trip
				WHERE trip_id= ?;';
		$query = $this->db->query($sql, $this->_trip_id);
		
		if ($query->num_rows() > 0)
		{
		   $row = $query->row(); 
		   $purp = $row->purpose;
		}
		else
		{
			$purp = ' ';
		}
		return $purp;
	}//end get_to
	
	//get side trip (if there is one)
	function get_side_trip()
	{
		$sql = 'SELECT trip_start, trip_end 
				FROM tbl_personalTrips
				WHERE trip_id= ?;';
		$query = $this->db->query($sql, $this->_trip_id);
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			$start = $row->trip_start;
			
			$dateStart = substr($start,0,10);
			$timeStart = substr($start,11,20);
			
			$time = strtotime($timeStart);
			$date = strtotime($dateStart);
			$timeStartConversion = date("h:i a", $time);
			$dateStartConversion = date("m/d/Y", $date);
			
			$end = $row->trip_end;
			
			$dateEnd = substr($end,0,10);
			$timeEnd = substr($end,11,20);
			
			$time = strtotime($timeEnd);
			$date = strtotime($dateEnd);
			$timeEndConversion = date("h:i a", $time);
			$dateEndConversion = date("m/d/Y", $date);

			$side_trip = $dateStartConversion.' '.$timeStartConversion.' - '.$dateEndConversion.' '.$timeEndConversion.'.';
			
	   }
		else
		{
			$side_trip = '  ';
		}
		return $side_trip;
	}//end get_to
	
	//get value of checkbox for personal trip
	function personal_checked()
	{
		$sql = 'SELECT trip_start, trip_end 
				FROM tbl_personalTrips
				WHERE trip_id= ?;';
		$query = $this->db->query($sql, $this->_trip_id);
		
		return !$query->num_rows() == 0;
	}//end personal_checked
	
	//get departure date
	function get_dept_date()
	{
		$sql = 'SELECT start_date
				FROM tbl_trip
				WHERE trip_id= ?;';
		$query = $this->db->query($sql, $this->_trip_id);
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			$dept_date = $row->start_date;
			$dept_date = substr($dept_date,0,10);
			$time = strtotime($dept_date);
			$converted = date("m/d/Y", $time);
			$dept_date = $converted;
	   }
		else
		{
			$dept_date = '  ';
		}
		return $dept_date;
	}//end get_dept_date
	
	//get departure time
	function get_dept_time()
	{
		$sql = 'SELECT start_date
				FROM tbl_trip
				WHERE trip_id= ?;';
		$query = $this->db->query($sql, $this->_trip_id);
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			$dept_time = $row->start_date;
			$dept_time = substr($dept_time,11,20);
			$time = strtotime($dept_time); 
			$dept_time= date("h:i a", $time);
	   }
		else
		{
			$dept_time = '  ';
		}
		return $dept_time;
	}//end get_dept_time
	
	//get return date
	function get_ret_date()
	{
		$sql = 'SELECT end_date
				FROM tbl_trip
				WHERE trip_id= ?;';
		$query = $this->db->query($sql, $this->_trip_id);
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			$ret_date = $row->end_date;
			$ret_date = substr($ret_date,0,10);
			$time = strtotime($ret_date);
			$converted = date("m/d/Y", $time);
			$ret_date = $converted;
	   }
		else
		{
			$ret_date = '  ';
		}
		return $ret_date;
	}//end get_ret_date
	
	//get return time
	function get_ret_time()
	{
		$sql = 'SELECT end_date
				FROM tbl_trip
				WHERE trip_id= ?;';
		$query = $this->db->query($sql, $this->_trip_id);
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			$ret_time = $row->end_date;
			$ret_time = substr($ret_time,11,20);
			$time = strtotime($ret_time); 
			$ret_time= date("h:i a", $time);
	   }
		else
		{
			$ret_time = '  ';
		}
		return $ret_time;
	}//end get_dept_date
	
	//get value of travel by air checkbox
	function Air_checked()
	{
		$sql = 'SELECT mode 
				FROM tbl_tripModes
				WHERE trip_id= ? and mode = ?;';
		$query = $this->db->query($sql, array($this->_trip_id, 1));
		
		return !$query->num_rows() == 0;
	}//end Air_checked
	
	//get value of travel by train checkbox
	function Train_checked()
	{
		$sql = 'SELECT mode 
				FROM tbl_tripModes
				WHERE trip_id= ? and mode = ?;';
		$query = $this->db->query($sql, array($this->_trip_id, 2));
		
		return !$query->num_rows() == 0;
	}//end Train_checked
	
	//get value of travel by bus checkbox
	function Bus_checked()
	{
		$sql = 'SELECT mode 
				FROM tbl_tripModes
				WHERE trip_id= ? and mode = ?;';
		$query = $this->db->query($sql, array($this->_trip_id, 3));
		
		return !$query->num_rows() == 0;
	}//end Bus_checked
	
	//get value of travel by motor pool checkbox
	function EMP_checked()
	{
		$sql = 'SELECT mode 
				FROM tbl_tripModes
				WHERE trip_id= ? and mode = ?;';
		$query = $this->db->query($sql, array($this->_trip_id, 4));
		
		return !$query->num_rows() == 0;
	}//end EMP_checked
	
	//get value of travel by POV checkbox
	function Privately_owned_checked()
	{
		$sql = 'SELECT mode 
				FROM tbl_tripModes
				WHERE trip_id= ? and mode = ?;';
		$query = $this->db->query($sql, array($this->_trip_id, 5));
		
		return !$query->num_rows() == 0;
	}//end Privately_owned_checked Rental_car
	
	//get value of travel by rental car checkbox
	function Rental_car_checked()
	{
		$sql = 'SELECT mode 
				FROM tbl_tripModes
				WHERE trip_id= ? and mode = ?;';
		$query = $this->db->query($sql, array($this->_trip_id, 6));
		
		return !$query->num_rows() == 0;
	}//end Rental_car_checked
	
	//get value of travel by charter checkbox
	function Charter_checked()
	{
		$sql = 'SELECT mode 
				FROM tbl_tripModes
				WHERE trip_id= ? and mode = ?;';
		$query = $this->db->query($sql, array($this->_trip_id, 7));
		
		return !$query->num_rows() == 0;
	}//end Charter_checked
	
	//get value of travel by courtesy checkbox
	function Courtesy_checked()
	{
		$sql = 'SELECT mode 
				FROM tbl_tripModes
				WHERE trip_id= ? and mode = ?;';
		$query = $this->db->query($sql, array($this->_trip_id, 8));
		
		return !$query->num_rows() == 0;
	}//end Courtesy_checked
	
	//no lodging exceptions
	function get_LogEx()
	{
		return '';
	}//get_LogEX
	
	function LogExcep_checked()
	{
		$sql = 'SELECT * 
				FROM tbl_users
				WHERE ?;';
		$query = $this->db->query($sql, 1);
		
		return $query->num_rows() == 0;
	}//end LogExcep_checked
	
	//get airfare quote
	function get_Airfare()
	{
		$sql = 'SELECT quote
				FROM tbl_travelQuotes
				WHERE trip_id= ? AND mode = ?;';
		$query = $this->db->query($sql, array($this->_trip_id, 1));
		
		$Airfare = 0;
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			$Airfare = $row->quote;
			
	    }
		return $Airfare;
	}//get_Airfare
	
	//get rental car quote
	function get_RentalCar()
	{
		$sql = 'SELECT quote
				FROM tbl_travelQuotes
				WHERE trip_id= ? AND mode = ?;';
		$query = $this->db->query($sql, array($this->_trip_id, 6));
		
		$RC = 0;
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			$RC = $row->quote;
			 
	    }
		return $RC;
	}//get_RentalCar
	
	//get POV quote
	function get_PrivVehicle()
	{
		$sql = 'SELECT distance
				FROM tbl_preMileage
				WHERE trip_id= ?;';
		$query = $this->db->query($sql, array($this->_trip_id));
		
		$mileageRate = $this->get_PrivCarRateR3();
		$total = 0;
		foreach($query->result() as $row)
		{
			$subTotal = $row->distance* $mileageRate;
			$total += $subTotal;
		}
		return $total;
	}//get_PrivVehicle
	
	//get Reg quote
	function get_Registration()
	{
		$sql = 'SELECT amount
				FROM tbl_registration
				WHERE trip_id= ?;';
		$query = $this->db->query($sql, array($this->_trip_id));
		
		$Reg = 0;
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			$Reg = $row->amount;
	    }
		return $Reg;
	}//get_Registration
	
	//get per diem quote
	function get_PerDiem()
	{
		$sql = 'SELECT breakfast, lunch, dinner, lodging, days
				FROM tbl_prePerDiem
				WHERE trip_id= ?;';
		$query = $this->db->query($sql, array($this->_trip_id));
		
		$total = 0;
		foreach($query->result() as $row)
		{	
			$daily = $row->breakfast + $row->lunch + $row->dinner + $row->lodging;
			$days = $row->days;
			$total += $daily * $days;
		}
		return $total;
	}//get_PerDiem
	
	//get other quote
	function get_Other()
	{
		$sql = 'SELECT  quote
				FROM tbl_travelQuotes
				WHERE trip_id= ? AND mode NOT IN (?, ?);';
		$query = $this->db->query($sql, array($this->_trip_id, 1, 6));
		
		$other = 0;
		if ($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$other += $row->quote;
			} 
	    }
		
		return $other;
	}//get_Other
	
	//get total estimated expenses
	function get_Total()
	{
		$total = 0.00;
		$total += $this->get_Airfare(); 
		$total += $this->get_PrivVehicle();
		$total += $this->get_Registration();
		$total += $this->get_PerDiem();
		$total += $this->get_Other();
		$total += $this->get_RentalCar();
		return $total;
	}//get_Total
	
	function PayTravAccount_checked()
	{
		$sql = 'SELECT paytype_id 
				FROM tbl_registration
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, $this->_trip_id);
		
		$row = $query->row();
		if($row != NULL)
			if($row->paytype_id == 2)
				return TRUE;
		return FALSE;
	}//end PayTravAccount_checked
	
	function DeptPCard_checked()
	{
		$sql = 'SELECT paytype_id 
				FROM tbl_registration
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, $this->_trip_id);
		
		$row = $query->row();
		if($row != NULL)
			if($row->paytype_id == 4)
				return TRUE;
		return FALSE;
	}//end DeptPCard_checked
	
	function PayTravler_checked()
	{
		$sql = 'SELECT paytype_id 
				FROM tbl_registration
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, $this->_trip_id);
		
		$row = $query->row();
		if($row != NULL)
			if($row->paytype_id == 3)
				return TRUE;
		return FALSE;
	}//end PayTravler_checked
	
	function AirRequest_checked()
	{
		$sql = 'SELECT trip_mode 
				FROM tbl_transRequests
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, array($this->_trip_id));
		
		foreach($query->result() as $row)
		{
			//if($row != NULL)
			if($row->trip_mode == 1)
				return TRUE;
		}
		return FALSE;
	}//end AirRequest_checked
	
	function RentalCarRequest_checked()
	{
		$sql = 'SELECT trip_mode 
				FROM tbl_transRequests
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, array($this->_trip_id));
		
		foreach($query->result() as $row)
		{
			//if($row != NULL)
			if($row->trip_mode == 6)
				return TRUE;
		}
		return FALSE;
	}//end RentalCarRequest_checked
	
	function TrainRequest_checked()
	{
		$sql = 'SELECT trip_mode 
				FROM tbl_transRequests
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, array($this->_trip_id));
		
		foreach($query->result() as $row)
		{
			//if($row != NULL)
			if($row->trip_mode == 2)
				return TRUE;
		}
		return FALSE;
	}//end TrainRequest_checked
	
	function get_TravAgent()
	{
		$sql = 'SELECT dept_code
				FROM tbl_users NATURAL JOIN tbl_userRoles
				WHERE user_id= ? AND role_id = ?;';
		$query = $this->db->query($sql, array($this->_user_id, 1));
		
		//if ($query->num_rows() > 0)
		//{
			$row = $query->row();
			$dept = $row->dept_code;
			
			$sql_ret = 'SELECT phone, name
						FROM tbl_travelAgents
						WHERE dept_code = ?;';
			$query_ret = $this->db->query($sql_ret, array($dept));
			$row_ret = $query_ret->row();
			$phone_ret = $row_ret->name.' '.$row_ret->phone;
			return $phone_ret;
	   //}
	}//get_TravAgentPhone
	
	function get_RentalCarAgentPhone()
	{
		return 'Enterprise Rent-A-Car';
	}//get_RentalCarAgentPhone
	
	function PayByCentralCTAAirline_checked()
	{
		if($this->AirRequest_checked())
		{
			$sql = 'SELECT paytype_id			
					FROM tbl_transRequests
					WHERE trip_id = ? AND trip_mode = ?;';
			$query = $this->db->query($sql, array($this->_trip_id, 1));
			$row = $query->row();
			$check = $row->paytype_id;
			
			return $check == 1;
		}
	}//end PayByCentralCTAAirline_checked
	
	function PayByDeptCTAAirline_checked()
	{
		if($this->AirRequest_checked())
		{
			$sql = 'SELECT paytype_id			
					FROM tbl_transRequests
					WHERE trip_id = ? AND trip_mode = ?;';
			$query = $this->db->query($sql, array($this->_trip_id, 1));
			$row = $query->row();
			$check = $row->paytype_id;
			
			return $check == 2;
		}
	}//end PayByDeptCTAAirline_checked
	
	function PayByCentralCTARentalCar_checked()
	{
		if($this->AirRequest_checked())
		{
			$sql = 'SELECT paytype_id			
					FROM tbl_transRequests
					WHERE trip_id = ? AND trip_mode = ?;';
			$query = $this->db->query($sql, array($this->_trip_id, 6));
			$row = $query->row();
			$check = $row->paytype_id;
			
			return $check == 1;
		}
	}//end PayByCentralCTARentalCar_checked
	
	function PayByDeptCTARentalCar_checked()
	{
		if($this->AirRequest_checked())
		{
			$sql = 'SELECT paytype_id			
					FROM tbl_transRequests
					WHERE trip_id = ? AND trip_mode = ?;';
			$query = $this->db->query($sql, array($this->_trip_id, 6));
			$row = $query->row();
			$check = $row->paytype_id;
			
			return $check == 2;
		}
	}//end PayByDeptCTARentalCar_checked
	
	function PayByPersonalRentalCar_checked()
	{
		if($this->AirRequest_checked())
		{
			$sql = 'SELECT paytype_id			
					FROM tbl_transRequests
					WHERE trip_id = ? AND trip_mode = ?;';
			$query = $this->db->query($sql, array($this->_trip_id, 6));
			$row = $query->row();
			$check = $row->paytype_id;
			
			return $check == 5;
		}
	}//end PayByPersonalRentalCar_checked
	
	
	/*********************Index Codes Table Begin*********************/
	/*XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX*/
	/*XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX*/
	/*********************Index Codes Row 1 Begin*********************/
	
	function get_IndexCode1()
	{
		$sql = 'SELECT index_code			
				FROM tbl_tripIndexCodes
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 0)
		{
			$row = $query->row(1);
			$ret = $row->index_code;
			return $ret;
		}
	}//end get_IndexCode1
	
	function get_IndexPercent1()
	{
		$sql = 'SELECT percentage			
				FROM tbl_tripIndexCodes
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 0)
		{
			$row = $query->row(1);
			$ret = $row->percentage;
			$ret = number_format($ret, 2);
			return $ret;
		}
	}//end get_IndexPercent1
	
	function get_IndexAmt1()
	{
		$sql = 'SELECT amount			
				FROM tbl_tripIndexCodes
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 0)
		{
			$row = $query->row(1);
			$ret = $row->amount;
			$ret = number_format($ret, 2);
			return $ret;
		}
	}//get_IndexAmt1
	
	
	/*XXXXXXXXXXX            ROW 2              XXXXXXXXXX*/
	
	function get_IndexCode2()
	{
		$sql = 'SELECT index_code			
				FROM tbl_tripIndexCodes
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 1)
		{
			$row = $query->row(2);
			$ret = $row->index_code;
			return $ret;
		}
	}//end get_IndexCode2
	
	function get_IndexPercent2()
	{
		$sql = 'SELECT percentage			
				FROM tbl_tripIndexCodes
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 1)
		{
			$row = $query->row(2);
			$ret = $row->percentage;
			$ret = number_format($ret, 2);
			return $ret;
		}
	}//end get_IndexPercent2
	
	function get_IndexAmt2()
	{
		$sql = 'SELECT amount			
				FROM tbl_tripIndexCodes
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 1)
		{
			$row = $query->row(2);
			$ret = $row->amount;
			$ret = number_format($ret, 2);
			return $ret;
		}
	}//get_IndexAmt2
	
	/*XXXXXXXXXXX            ROW 3              XXXXXXXXXX*/
	
	function get_IndexCode3()
	{
		$sql = 'SELECT index_code			
				FROM tbl_tripIndexCodes
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 2)
		{
			$row = $query->row(3);
			$ret = $row->index_code;
			return $ret;
		}
	}//end get_IndexCode3
	
	function get_IndexPercent3()
	{
		$sql = 'SELECT percentage			
				FROM tbl_tripIndexCodes
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 2)
		{
			$row = $query->row(3);
			$ret = $row->percentage;
			$ret = number_format($ret, 2);
			return $ret;
		}
	}//end get_IndexPercent3
	
	function get_IndexAmt3()
	{
		$sql = 'SELECT amount			
				FROM tbl_tripIndexCodes
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 2)
		{
			$row = $query->row(3);
			$ret = $row->amount;
			$ret = number_format($ret, 2);
			return $ret;
		}
	}//get_IndexAmt3
	
	/*********************Index Codes Table End***********************/
	/*XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX*/
	/*XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX*/
	/*****************************************************************/
	
	///////////////////////////////////////////////////////////////////////////
	
	function get_IndexTotalPercent()
	{
		$ret = 0;
		$ret += $this->get_IndexPercent1();
		$ret += $this->get_IndexPercent2();
		$ret += $this->get_IndexPercent3();
		if($ret > 0)
			return $ret;
	}//get_IndexTotalPercent
	
	function get_IndexTotalAmount()
	{
		$sql = 'SELECT amount			
				FROM tbl_tripIndexCodes
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, array($this->_trip_id));
		$ret = 0;
		foreach($query->result() as $row)
		{
			$ret += $row->amount;
		}
		return $ret;
	}//get_IndexTotalAmount
	
	/*********************Per Diem Table Begin*********************/
	/**************************************************************/
	/**************************************************************/
	/*********************Per Diem Row 1 Begin*********************/
	function get_PDDateR1()
	{
		$sql = 'SELECT trip_date			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 0)
		{
			$row = $query->row(0);
			$ret = $row->trip_date;
			$time = strtotime($ret);
			$converted = date("m/d/Y", $time);
			$ret = $converted;
			return $ret;
		}
	}//get_PDDateR1
	
	function get_PDFromR1()
	{
		$sql = 'SELECT start_location			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 0)
		{
			$row = $query->row(0);
			$ret = $row->start_location;
			return $ret;
		}
	}//get_PDFromR1
	
	function get_PDActDeptR1()
	{
		$sql = 'SELECT time_start			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 0)
		{
			$row = $query->row(0);
			$ret = $row->time_start;
			$time = strtotime($ret); 
			$ret = date("h:i a", $time);
			return $ret;
		}
	}//get_PDActDeptR1
	
	function get_ToR1()
	{
		$sql = 'SELECT destination			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 0)
		{
			$row = $query->row(0);
			$ret = $row->destination;
			return $ret;
		}
	}//get_ToR1
	
	function get_PDArrR1()
	{
		$sql = 'SELECT time_end			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 0)
		{
			$row = $query->row(0);
			$ret = $row->time_end;
			$time = strtotime($ret); 
			$ret = date("h:i a", $time);
			return $ret;
		}
	}//get_PDArrR1
	
	function get_PDBreakR1()
	{
		$sql = 'SELECT breakfast			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 0)
		{
			$row = $query->row(0);
			$ret = $row->breakfast;
			$ret = number_format($ret, 2);
			return $ret;
		}
	}//get_PDBreakR1

	
	function get_PDLunchR1()
	{
		$sql = 'SELECT lunch			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 0)
		{
			$row = $query->row(0);
			$ret = $row->lunch;
			$ret = number_format($ret, 2);
			return $ret;
		}
	}//get_PDLunchR1
	
	function get_PDDinnerR1()
	{
		$sql = 'SELECT dinner			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 0)
		{
			$row = $query->row(0);
			$ret = $row->dinner;
			$ret = number_format($ret, 2);
			return $ret;
		}
	}//get_PDDinnerR1
	
	function get_PDLodgeR1()
	{
		$sql = 'SELECT lodging			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 0)
		{
			$row = $query->row(0);
			$ret = $row->lodging;
			$ret = number_format($ret, 2);
			return $ret;
		}
	}//get_PDLodgeR1
	
	function get_PDTotalR1()
	{
		$print = 0.00;
		$print += $this->get_PDBreakR1();
		$print += $this->get_PDLunchR1();
		$print += $this->get_PDDinnerR1();
		$print += $this->get_PDLodgeR1();
		$print = number_format($print, 2);
		return $print;
	}//get_PDTotalR1
	
	/*********************Per Diem Row 1 End*********************/
	
	/*********************Per Diem Row 2 Begin*******************/
	
	function get_PDDateR2()
	{
		$sql = 'SELECT trip_date			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 1)
		{
			$row = $query->row(1);
			$ret = $row->trip_date;
			$time = strtotime($ret);
			$converted = date("m/d/Y", $time);
			$ret = $converted;
			return $ret;
		}
	}//get_PDDateR2
	
	function get_PDFromR2()
	{
		$sql = 'SELECT start_location			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 1)
		{
			$row = $query->row(1);
			$ret = $row->start_location;
			return $ret;
		}
	}//get_PDFromR2
	
	function get_PDActDeptR2()
	{
		$sql = 'SELECT time_start			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 1)
		{
			$row = $query->row(1);
			$ret = $row->time_start;
			$time = strtotime($ret); 
			$ret = date("h:i a", $time);
			return $ret;
		}
	}//get_PDActDeptR2
	
	function get_ToR2()
	{
		$sql = 'SELECT destination			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 1)
		{
			$row = $query->row(1);
			$ret = $row->destination;
			return $ret;
		}
	}//get_ToR2
	
	function get_PDArrR2()
	{
		$sql = 'SELECT time_end			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 1)
		{
			$row = $query->row(1);
			$ret = $row->time_end;
			$time = strtotime($ret); 
			$ret = date("h:i a", $time);
			return $ret;
		}
	}//get_PDArrR2
	
	function get_PDBreakR2()
	{
		$sql = 'SELECT breakfast			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 1)
		{
			$row = $query->row(1);
			$ret = $row->breakfast;
			$ret = number_format($ret, 2);
			return $ret;
		}
	}//get_PDBreakR2
	
	function get_PDLunchR2()
	{
		$sql = 'SELECT lunch			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 1)
		{
			$row = $query->row(1);
			$ret = $row->lunch;
			$ret = number_format($ret, 2);
			return $ret;
		}
	}//get_PDLunchR2
	
	function get_PDDinnerR2()
	{
		$sql = 'SELECT dinner			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 1)
		{
			$row = $query->row(1);
			$ret = $row->dinner;
			$ret = number_format($ret, 2);
			return $ret;
		}
	}//get_PDDinnerR2
	
	function get_PDLodgeR2()
	{
		$sql = 'SELECT lodging			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 1)
		{
			$row = $query->row(1);
			$ret = $row->lodging;
			$ret = number_format($ret, 2);
			return $ret;
		}
	}//get_PDLodgeR2
	
	function get_PDTotalR2()
	{
		$print = 0.00;
		$print += $this->get_PDBreakR2();
		$print += $this->get_PDLunchR2();
		$print += $this->get_PDDinnerR2();
		$print += $this->get_PDLodgeR2();
		$print = number_format($print, 2);
		return $print;
	}//get_PDTotalR2
	
	/*********************Per Diem Row 2 End***********************/
	
	/*********************Per Diem Row 3 Begin*******************/
	
	function get_PDDateR3()
	{
		$sql = 'SELECT trip_date			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 2)
		{
			$row = $query->row(2);
			$ret = $row->trip_date;
			$time = strtotime($ret);
			$converted = date("m/d/Y", $time);
			$ret = $converted;
			return $ret;
		}
	}//get_PDDateR3
	
	function get_PDFromR3()
	{
		$sql = 'SELECT start_location			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 2)
		{
			$row = $query->row(2);
			$ret = $row->start_location;
			return $ret;
		}
	}//get_PDFromR3
	
	function get_PDActDeptR3()
	{
		$sql = 'SELECT time_start			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 2)
		{
			$row = $query->row(2);
			$ret = $row->time_start;
			$time = strtotime($ret); 
			$ret = date("h:i a", $time);
			return $ret;
		}
	}//get_PDActDeptR3
	
	function get_ToR3()
	{
		$sql = 'SELECT destination			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 2)
		{
			$row = $query->row(2);
			$ret = $row->destination;
			return $ret;
		}
	}//get_ToR3
	
	function get_PDArrR3()
	{
		$sql = 'SELECT time_end			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 2)
		{
			$row = $query->row(2);
			$ret = $row->time_end;
			$time = strtotime($ret); 
			$ret = date("h:i a", $time);
			return $ret;
		}
	}//get_PDArrR3
	
	function get_PDBreakR3()
	{
		$sql = 'SELECT breakfast			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 2)
		{
			$row = $query->row(2);
			$ret = $row->breakfast;
			$ret = number_format($ret, 2);
			return $ret;
		}
	}//get_PDBreakR3
	
	function get_PDLunchR3()
	{
		$sql = 'SELECT lunch			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 2)
		{
			$row = $query->row(2);
			$ret = $row->lunch;
			$ret = number_format($ret, 2);
			return $ret;
		}
	}//get_PDLunchR3
	
	function get_PDDinnerR3()
	{
		$sql = 'SELECT dinner			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 2)
		{
			$row = $query->row(2);
			$ret = $row->dinner;
			$ret = number_format($ret, 2);
			return $ret;
		}
	}//get_PDDinnerR3
	
	function get_PDLodgeR3()
	{
		$sql = 'SELECT lodging			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 2)
		{
			$row = $query->row(2);
			$ret = $row->lodging;
			$ret = number_format($ret, 2);
			return $ret;
		}
	}//get_PDLodgeR3
	
	function get_PDTotalR3()
	{
		$print = 0.00;
		$print += $this->get_PDBreakR3();
		$print += $this->get_PDLunchR3();
		$print += $this->get_PDDinnerR3();
		$print += $this->get_PDLodgeR3();
		$print = number_format($print, 2);
		return $print;
	}//get_PDTotalR3
	
	/*********************Per Diem Row 3 End***********************/
	
	/*********************Per Diem Row 4 Begin*******************/
	
	function get_PDDateR4()
	{
		$sql = 'SELECT trip_date			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 3)
		{
			$row = $query->row(3);
			$ret = $row->trip_date;
			$time = strtotime($ret);
			$converted = date("m/d/Y", $time);
			$ret = $converted;
			return $ret;
		}
	}//get_PDDateR4
	
	function get_PDFromR4()
	{
		$sql = 'SELECT start_location			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 3)
		{
			$row = $query->row(3);
			$ret = $row->start_location;
			return $ret;
		}
	}//get_PDFromR4
	
	function get_PDActDeptR4()
	{
		$sql = 'SELECT time_start			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 3)
		{
			$row = $query->row(3);
			$ret = $row->time_start;
			$time = strtotime($ret); 
			$ret = date("h:i a", $time);
			return $ret;
		}
	}//get_PDActDeptR4
	
	function get_ToR4()
	{
		$sql = 'SELECT destination			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 3)
		{
			$row = $query->row(3);
			$ret = $row->destination;
			return $ret;
		}
	}//get_ToR4
	
	function get_PDArrR4()
	{
		$sql = 'SELECT time_end			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 3)
		{
			$row = $query->row(3);
			$ret = $row->time_end;
			$time = strtotime($ret); 
			$ret = date("h:i a", $time);
			return $ret;
		}
	}//get_PDArrR4
	
	function get_PDBreakR4()
	{
		$sql = 'SELECT breakfast			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 3)
		{
			$row = $query->row(3);
			$ret = $row->breakfast;
			$ret = number_format($ret, 2);
			return $ret;
		}
	}//get_PDBreakR4
	
	function get_PDLunchR4()
	{
		$sql = 'SELECT lunch			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 3)
		{
			$row = $query->row(3);
			$ret = $row->lunch;
			$ret = number_format($ret, 2);
			return $ret;
		}
	}//get_PDLunchR4
	
	function get_PDDinnerR4()
	{
		$sql = 'SELECT dinner			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 3)
		{
			$row = $query->row(3);
			$ret = $row->dinner;
			$ret = number_format($ret, 2);
			return $ret;
		}
	}//get_PDDinnerR4
	
	function get_PDLodgeR4()
	{
		$sql = 'SELECT lodging			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 3)
		{
			$row = $query->row(3);
			$ret = $row->lodging;
			$ret = number_format($ret, 2);
			return $ret;
		}
	}//get_PDLodgeR4
	
	function get_PDTotalR4()
	{
		$print = 0.00;
		$print += $this->get_PDBreakR4();
		$print += $this->get_PDLunchR4();
		$print += $this->get_PDDinnerR4();
		$print += $this->get_PDLodgeR4();
		$print = number_format($print, 2);
		return $print;
	}//get_PDTotalR4
	
	/*********************Per Diem Row 4 End***********************/
	
	/*********************Per Diem Row 5 Begin*******************/
	
	function get_PDDateR5()
	{
		$sql = 'SELECT trip_date			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 4)
		{
			$row = $query->row(4);
			$ret = $row->trip_date;
			$time = strtotime($ret);
			$converted = date("m/d/Y", $time);
			$ret = $converted;
			return $ret;
		}
	}//get_PDDateR5
	
	function get_PDFromR5()
	{
		$sql = 'SELECT start_location			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 4)
		{
			$row = $query->row(4);
			$ret = $row->start_location;
			return $ret;
		}
	}//get_PDFromR5
	
	function get_PDActDeptR5()
	{
		$sql = 'SELECT time_start			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 4)
		{
			$row = $query->row(4);
			$ret = $row->time_start;
			$time = strtotime($ret); 
			$ret = date("h:i a", $time);
			return $ret;
		}
	}//get_PDActDeptR5
	
	function get_ToR5()
	{
		$sql = 'SELECT destination			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 4)
		{
			$row = $query->row(4);
			$ret = $row->destination;
			return $ret;
		}
	}//get_ToR5
	
	function get_PDArrR5()
	{
		$sql = 'SELECT time_end			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 4)
		{
			$row = $query->row(4);
			$ret = $row->time_end;
			$time = strtotime($ret); 
			$ret = date("h:i a", $time);
			return $ret;
		}
	}//get_PDArrR5
	
	function get_PDBreakR5()
	{
		$sql = 'SELECT breakfast			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 4)
		{
			$row = $query->row(4);
			$ret = $row->breakfast;
			$ret = number_format($ret, 2);
			return $ret;
		}
	}//get_PDBreakR5
	
	function get_PDLunchR5()
	{
		$sql = 'SELECT lunch			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 4)
		{
			$row = $query->row(4);
			$ret = $row->lunch;
			$ret = number_format($ret, 2);
			return $ret;
		}
	}//get_PDLunchR5
	
	function get_PDDinnerR5()
	{
		$sql = 'SELECT dinner			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 4)
		{
			$row = $query->row(4);
			$ret = $row->dinner;
			$ret = number_format($ret, 2);
			return $ret;
		}
	}//get_PDDinnerR5
	
	function get_PDLodgeR5()
	{
		$sql = 'SELECT lodging			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 4)
		{
			$row = $query->row(4);
			$ret = $row->lodging;
			$ret = number_format($ret, 2);
			return $ret;
		}
	}//get_PDLodgeR5
	
	function get_PDTotalR5()
	{
		$print = 0.00;
		$print += $this->get_PDBreakR5();
		$print += $this->get_PDLunchR5();
		$print += $this->get_PDDinnerR5();
		$print += $this->get_PDLodgeR5();
		$print = number_format($print, 2);
		return $print;
	}//get_PDTotalR5
	
	/*********************Per Diem Row 5 End***********************/
	
	/*********************Per Diem Row 6 Begin*******************/
	
	function get_PDDateR6()
	{
		$sql = 'SELECT trip_date			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 5)
		{
			$row = $query->row(5);
			$ret = $row->trip_date;
			$time = strtotime($ret);
			$converted = date("m/d/Y", $time);
			$ret = $converted;
			return $ret;
		}
	}//get_PDDateR6
	
	function get_PDFromR6()
	{
		$sql = 'SELECT start_location			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 5)
		{
			$row = $query->row(5);
			$ret = $row->start_location;
			return $ret;
		}
	}//get_PDFromR6
	
	function get_PDActDeptR6()
	{
		$sql = 'SELECT time_start			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 5)
		{
			$row = $query->row(5);
			$ret = $row->time_start;
			$time = strtotime($ret); 
			$ret = date("h:i a", $time);
			return $ret;
		}
	}//get_PDActDeptR6
	
	function get_ToR6()
	{
		$sql = 'SELECT destination			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 5)
		{
			$row = $query->row(5);
			$ret = $row->destination;
			return $ret;
		}
	}//get_ToR6
	
	function get_PDArrR6()
	{
		$sql = 'SELECT time_end			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 5)
		{
			$row = $query->row(5);
			$ret = $row->time_end;
			$time = strtotime($ret); 
			$ret = date("h:i a", $time);
			return $ret;
		}
	}//get_PDArrR6
	
	function get_PDBreakR6()
	{
		$sql = 'SELECT breakfast			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 5)
		{
			$row = $query->row(5);
			$ret = $row->breakfast;
			$ret = number_format($ret, 2);
			return $ret;
		}
	}//get_PDBreakR6
	
	function get_PDLunchR6()
	{
		$sql = 'SELECT lunch			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 5)
		{
			$row = $query->row(5);
			$ret = $row->lunch;
			$ret = number_format($ret, 2);
			return $ret;
		}
	}//get_PDLunchR6
	
	function get_PDDinnerR6()
	{
		$sql = 'SELECT dinner			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 5)
		{
			$row = $query->row(5);
			$ret = $row->dinner;
			$ret = number_format($ret, 2);
			return $ret;
		}
	}//get_PDDinnerR6
	
	function get_PDLodgeR6()
	{
		$sql = 'SELECT lodging			
				FROM tbl_postPerDiem
				WHERE trip_id = ?
				ORDER BY trip_date;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 5)
		{
			$row = $query->row(5);
			$ret = $row->lodging;
			$ret = number_format($ret, 2);
			return $ret;
		}
	}//get_PDLodgeR6
	
	function get_PDTotalR6()
	{
		$print = 0;
		$print += $this->get_PDBreakR6();
		$print += $this->get_PDLunchR6();
		$print += $this->get_PDDinnerR6();
		$print += $this->get_PDLodgeR6();
		$print = number_format($print, 2);
		return $print;
	}//get_PDTotalR6
	
	//perdiem and lodging total
	
	/*********************Per Diem Row 6 End***********************/
	/**************************************************************/
	/**************************************************************/
	/*********************Per Diem Table End***********************/
	
	
	
	/*********************Priv Car Table Begin*********************/
	/*#############################################################/
	/*#############################################################/
	/*********************Priv Car Row 1 Begin*********************/
	
	function get_PrivCarFromR1()
	{
		$sql = 'SELECT start_location			
				FROM tbl_postMileage
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 0)
		{
			$row = $query->row(1);
			$ret = $row->start_location;
			return $ret;
		}
	}//get_PrivCarFromR1
	
	function get_PrivCarToR1()
	{
		$sql = 'SELECT destination			
				FROM tbl_postMileage
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 0)
		{
			$row = $query->row(1);
			$ret = $row->destination;
			return $ret;
		}
	}//get_PrivCarToR1
	
	function get_PrivCarMilesR1()
	{
		$sql = 'SELECT distance			
				FROM tbl_postMileage
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 0)
		{
			$row = $query->row(1);
			$ret = $row->distance;
			return $ret;
		}
	}//get_PrivCarMilesR1
	
	function get_PrivCarVincR1()
	{
		$sql = 'SELECT vicinity			
				FROM tbl_postMileage
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 0)
		{
			$row = $query->row(1);
			$ret = $row->vicinity;
			return $ret;
		}
	}//get_PrivCarVincR1
	
	function get_PrivCarRateR1()
	{
		return $this->get_PrivCarRateR3();
	}//get_PrivCarRateR1
	
	function get_PrivCarAllowR1()
	{
		$print = 0.00;
		$print += $this->get_PrivCarMilesR1();
		$print += $this->get_PrivCarVincR1();
		$temp = $print * $this->get_PrivCarRateR3();
		$decimal = number_format($temp, 2); 
		return $decimal;
	}//get_PrivCarAllowR1
	
	/*********************Priv Car Row 1 End*********************/
	
	/*********************Priv Car Row 2 Begin*******************/
	
	function get_PrivCarFromR2()
	{
		$sql = 'SELECT start_location			
				FROM tbl_postMileage
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 1)
		{
			$row = $query->row(2);
			$ret = $row->start_location;
			return $ret;
		}
	}//get_PrivCarFromR2
	
	function get_PrivCarToR2()
	{
		$sql = 'SELECT destination			
				FROM tbl_postMileage
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 1)
		{
			$row = $query->row(2);
			$ret = $row->destination;
			return $ret;
		}
	}//get_PrivCarToR2
	
	function get_PrivCarMilesR2()
	{
		$sql = 'SELECT distance			
				FROM tbl_postMileage
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 1)
		{
			$row = $query->row(2);
			$ret = $row->distance;
			return $ret;
		}
	}//get_PrivCarMilesR3
	
	function get_PrivCarVincR2()
	{
		$sql = 'SELECT vicinity			
				FROM tbl_postMileage
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 1)
		{
			$row = $query->row(2);
			$ret = $row->vicinity;
			return $ret;
		}
	}//get_PrivCarVincR2
	
	function get_PrivCarRateR2()
	{
		return $this->get_PrivCarRateR3();
	}//get_PrivCarRateR2
	
	function get_PrivCarAllowR2()
	{
		$print = 0.00;
		$print += $this->get_PrivCarMilesR2();
		$print += $this->get_PrivCarVincR2();
		$temp = $print * $this->get_PrivCarRateR3();
		$decimal = number_format($temp, 2);
		return $decimal;
	}//get_PrivCarAllowR2
	
	/*********************Priv Car Row 2 End*********************/
	
	/*********************Priv Car Row 3 Begin*******************/
	
	function get_PrivCarFromR3()
	{
		$sql = 'SELECT start_location			
				FROM tbl_postMileage
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 2)
		{
			$row = $query->row(3);
			$ret = $row->start_location;
			return $ret;
		}
	}//get_PrivCarFromR3
	
	function get_PrivCarToR3()
	{
		$sql = 'SELECT destination			
				FROM tbl_postMileage
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 2)
		{
			$row = $query->row(3);
			$ret = $row->destination;
			return $ret;
		}
	}//get_PrivCarToR3
	
	function get_PrivCarMilesR3()
	{
		$sql = 'SELECT distance			
				FROM tbl_postMileage
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 2)
		{
			$row = $query->row(3);
			$ret = $row->distance;
			return $ret;
		}
	}//get_PrivCarMilesR3
	
	function get_PrivCarVincR3()
	{
		$sql = 'SELECT vicinity			
				FROM tbl_postMileage
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 2)
		{
			$row = $query->row(3);
			$ret = $row->vicinity;
			return $ret;
		}
	}//get_PrivCarVincR3
	
	function get_PrivCarRateR3()
	{
		$sql = 'SELECT mileage_rate			
				FROM tbl_system
				WHERE ?;';
		$query = $this->db->query($sql, array(1));
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$ret = $row->mileage_rate;
			return $ret;
		}
	}//get_PrivCarRateR3
	
	function get_PrivCarAllowR3()
	{
		$print = 0.00;
		$print += $this->get_PrivCarMilesR3();
		$print += $this->get_PrivCarVincR3();
		$temp = $print * $this->get_PrivCarRateR3();
		$decimal = number_format($temp, 2);
		return $decimal;
	}//get_PrivCarAllowR3
	
	function get_PrivCarTotal()
	{
		$sql = 'SELECT distance, vicinity			
				FROM tbl_postMileage
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, array($this->_trip_id));
		$ret = 0.00;
		$dist = 0;
		$rate = $this->get_PrivCarRateR3();
		foreach($query->result() as $row)
		{
			$dist = $row->distance + $row->vicinity;
			$ret += $dist * $rate;
		}
		$ret = number_format($ret, 2);
		return $ret;
	}
	
	/*********************Priv Car 3 Row End***********************/
	/*############################################################*/
	/*############################################################*/
	/*********************Priv Car Table End***********************/
	
	/*********************Other Table Begin*********************/
	/*$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$*/
	/*$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$*/
	/*********************Other Row 1 Begin*********************/
	
	function get_OtherDateR1()
	{
		$sql = 'SELECT date			
				FROM tbl_postMisc
				WHERE trip_id = ?			
				ORDER BY date ASC;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 0)
		{
			$row = $query->row(0);
			$ret = $row->date;
			$time = strtotime($ret);
			$converted = date("m/d/Y", $time);
			$ret = $converted;
			return $ret;
		}
	}//get_OtherDateR1
	
	function get_OtherPayeeR1()
	{
		$sql = 'SELECT payee			
				FROM tbl_postMisc
				WHERE trip_id = ?			
				ORDER BY date ASC;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 0)
		{
			$row = $query->row(0);
			$ret = $row->payee;
			return $ret;
		}
	}//get_OtherPayeeR1
	
	function get_OtherPurpR1()
	{
		$sql = 'SELECT expense			
				FROM tbl_postMisc
				WHERE trip_id = ?			
				ORDER BY date ASC;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 0)
		{
			$row = $query->row(0);
			$ret = $row->expense;
			return $ret;
		}
	}//get_OtherPurpR1
	
	function get_OtherAmtR1()
	{
		$sql = 'SELECT amount			
				FROM tbl_postMisc
				WHERE trip_id = ?			
				ORDER BY date ASC;';
		$query = $this->db->query($sql, array($this->_trip_id));
		$ret = 0;
		if($query->num_rows() > 0)
		{
			$row = $query->row(0);
			$ret = $row->amount;
		}
		$ret = number_format($ret, 2);
		return $ret;
	}//get_OtherAmtR1
	
	/*********************Other Row 1 End*********************/
	
	/*********************Other Row 2 Begin*******************/
	
	function get_OtherDateR2()
	{
		$sql = 'SELECT date			
				FROM tbl_postMisc
				WHERE trip_id = ?			
				ORDER BY date ASC;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 1)
		{
			$row = $query->row(1);
			$ret = $row->date;
			$time = strtotime($ret);
			$converted = date("m/d/Y", $time);
			$ret = $converted;
			return $ret;
		}
	}//get_OtherDateR2
	
	function get_OtherPayeeR2()
	{
		$sql = 'SELECT payee			
				FROM tbl_postMisc
				WHERE trip_id = ?			
				ORDER BY date ASC;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 1)
		{
			$row = $query->row(1);
			$ret = $row->payee;
			return $ret;
		}
	}//get_OtherPayeeR2
	
	function get_OtherPurpR2()
	{
		$sql = 'SELECT expense			
				FROM tbl_postMisc
				WHERE trip_id = ?			
				ORDER BY date ASC;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 1)
		{
			$row = $query->row(1);
			$ret = $row->expense;
			return $ret;
		}
	}//get_OtherPurpR2
	
	function get_OtherAmtR2()
	{
		$sql = 'SELECT amount			
				FROM tbl_postMisc
				WHERE trip_id = ?			
				ORDER BY date ASC;';
		$query = $this->db->query($sql, array($this->_trip_id));
		$ret = 0;
		if($query->num_rows() > 1)
		{
			$row = $query->row(1);
			$ret = $row->amount;
		}
		$ret = number_format($ret, 2);
		return $ret;
	}//get_OtherAmtR2
	
	/*********************Other Row 2 End*********************/
	
	/*********************Other Row 3 Begin*******************/
	
	function get_OtherDateR3()
	{
		$sql = 'SELECT date			
				FROM tbl_postMisc
				WHERE trip_id = ?			
				ORDER BY date ASC;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 2)
		{
			$row = $query->row(2);
			$ret = $row->date;
			$time = strtotime($ret);
			$converted = date("m/d/Y", $time);
			$ret = $converted;
			return $ret;
		}
	}//get_OtherDateR3
	
	function get_OtherPayeeR3()
	{
		$sql = 'SELECT payee			
				FROM tbl_postMisc
				WHERE trip_id = ?			
				ORDER BY date ASC;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 2)
		{
			$row = $query->row(2);
			$ret = $row->payee;
			return $ret;
		}
	}//get_OtherPayeeR3
	
	function get_OtherPurpR3()
	{
		$sql = 'SELECT expense			
				FROM tbl_postMisc
				WHERE trip_id = ?			
				ORDER BY date ASC;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 2)
		{
			$row = $query->row(2);
			$ret = $row->expense;
			return $ret;
		}
	}//get_OtherPurpR3
	
	function get_OtherAmtR3()
	{
		$sql = 'SELECT amount			
				FROM tbl_postMisc
				WHERE trip_id = ?			
				ORDER BY date ASC;';
		$query = $this->db->query($sql, array($this->_trip_id));
		$ret = 0;
		if($query->num_rows() > 2)
		{
			$row = $query->row(2);
			$ret = $row->amount;
		}
		$ret = number_format($ret, 2);
		return $ret;
	}//get_OtherAmtR3
	
	/*********************Other Row 3 End*********************/
	
	/*********************Other Row 4 Begin*******************/
	
	function get_OtherDateR4()
	{
		$sql = 'SELECT date			
				FROM tbl_postMisc
				WHERE trip_id = ?			
				ORDER BY date ASC;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 3)
		{
			$row = $query->row(3);
			$ret = $row->date;
			$time = strtotime($ret);
			$converted = date("m/d/Y", $time);
			$ret = $converted;
			return $ret;
		}
	}//get_OtherDateR4
	
	function get_OtherPayeeR4()
	{
		$sql = 'SELECT payee			
				FROM tbl_postMisc
				WHERE trip_id = ?			
				ORDER BY date ASC;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 3)
		{
			$row = $query->row(3);
			$ret = $row->payee;
			return $ret;
		}
	}//get_OtherPayeeR4
	
	function get_OtherPurpR4()
	{
		$sql = 'SELECT expense			
				FROM tbl_postMisc
				WHERE trip_id = ?			
				ORDER BY date ASC;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 3)
		{
			$row = $query->row(3);
			$ret = $row->expense;
			return $ret;
		}
	}//get_OtherPurpR4
	
	function get_OtherAmtR4()
	{
		$sql = 'SELECT amount			
				FROM tbl_postMisc
				WHERE trip_id = ?			
				ORDER BY date ASC;';
		$query = $this->db->query($sql, array($this->_trip_id));
		$ret = 0;
		if($query->num_rows() > 3)
		{
			$row = $query->row(3);
			$ret = $row->amount;
		}
		$ret = number_format($ret, 2);
		return $ret;
	}//get_OtherAmtR4
	
	/*********************Other Row 4 End*********************/
	
	/*********************Other Row 5 Begin*******************/
	
	function get_OtherDateR5()
	{
		$sql = 'SELECT date			
				FROM tbl_postMisc
				WHERE trip_id = ?			
				ORDER BY date ASC;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 4)
		{
			$row = $query->row(4);
			$ret = $row->date;
			$time = strtotime($ret);
			$converted = date("m/d/Y", $time);
			$ret = $converted;
			return $ret;
		}
	}//get_OtherDateR5
	
	function get_OtherPayeeR5()
	{
		$sql = 'SELECT payee			
				FROM tbl_postMisc
				WHERE trip_id = ?			
				ORDER BY date ASC;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 4)
		{
			$row = $query->row(4);
			$ret = $row->payee;
			return $ret;
		}
	}//get_OtherPayeeR5
	
	function get_OtherPurpR5()
	{
		$sql = 'SELECT expense			
				FROM tbl_postMisc
				WHERE trip_id = ?			
				ORDER BY date ASC;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 4)
		{
			$row = $query->row(4);
			$ret = $row->expense;
			return $ret;
		}
	}//get_OtherPurpR5
	
	function get_OtherAmtR5()
	{
		$sql = 'SELECT amount			
				FROM tbl_postMisc
				WHERE trip_id = ?			
				ORDER BY date ASC;';
		$query = $this->db->query($sql, array($this->_trip_id));
		$ret = 0;
		if($query->num_rows() > 4)
		{
			$row = $query->row(4);
			$ret = $row->amount;
		}
		$ret = number_format($ret, 2);
		return $ret;
	}//get_OtherAmtR5
	
	/*********************Other Row 5 End***********************/
	/*$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$*/
	/*$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$*/
	/*********************Other Table End***********************/
	
	
	/*********************Refunds Table Begin*********************/
	/*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
	/*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
	/*********************Refunds Row 1 Begin*********************/
	
	function get_RefundDateR1()
	{
		$sql = 'SELECT date			
				FROM tbl_refunds
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 0)
		{
			$row = $query->row(1);
			$ret = $row->date;
			$time = strtotime($ret);
			$converted = date("m/d/Y", $time);
			$ret = $converted;
			return $ret;
		}
	}//get_RefundDateR1
	
	function get_RefundFromR1()
	{
		$sql = 'SELECT payee			
				FROM tbl_refunds
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 0)
		{
			$row = $query->row(1);
			$ret = $row->payee;
			return $ret;
		}
	}//get_RefundFromR1
	
	function get_RefundAmtR1()
	{
		$sql = 'SELECT amount			
				FROM tbl_refunds
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 0)
		{
			$row = $query->row(1);
			$ret = $row->amount;
			return $ret;
		}
	}//get_RefundAmtR1

	
	function get_RefundDateR2()
	{
		$sql = 'SELECT date			
				FROM tbl_refunds
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 1)
		{
			$row = $query->row(2);
			$ret = $row->date;
			$time = strtotime($ret);
			$converted = date("m/d/Y", $time);
			$ret = $converted;
			return $ret;
		}
	}//get_RefundDateR2
	
	function get_RefundFromR2()
	{
		$sql = 'SELECT payee			
				FROM tbl_refunds
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 1)
		{
			$row = $query->row(2);
			$ret = $row->payee;
			return $ret;
		}
	}//get_RefundFromR2
	
	function get_RefundAmtR2()
	{
		$sql = 'SELECT amount			
				FROM tbl_refunds
				WHERE trip_id = ?;';
		$query = $this->db->query($sql, array($this->_trip_id));
		if($query->num_rows() > 1)
		{
			$row = $query->row(2);
			$ret = $row->amount;
			return $ret;
		}
	}//get_RefundAmtR2
	
	/*********************Refunds Table End***********************/
	/*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
	/*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
	/*********************Refunds End*****************************/
	
	/*@@@@@@@@@@@@@			Totals Begin			@@@@@@@@@@@@@*/
	
	function get_Subtotal()
	{
		$print = 0;
		$print += $this->get_PDTotalR1();
		$print += $this->get_PDTotalR2();
		$print += $this->get_PDTotalR3();
		$print += $this->get_PDTotalR4();
		$print += $this->get_PDTotalR5();
		$print += $this->get_PDTotalR6();
		
		$print += $this->get_PrivCarAllowR1();
		$print += $this->get_PrivCarAllowR2();
		$print += $this->get_PrivCarAllowR3();
		
		$print += $this->get_OtherAmtR1();
		$print += $this->get_OtherAmtR2();
		$print += $this->get_OtherAmtR3();
		$print += $this->get_OtherAmtR4();
		$print += $this->get_OtherAmtR5();
	
		return $print;
	}//get_Subtotal
	
	function get_Refunds()
	{
		$print = 0;
		$print += $this->get_RefundAmtR1();
		$print += $this->get_RefundAmtR2();
		return $print;
	}//get_Refunds 
	
	function get_BalanceDue()
	{
		$print = 0.00;
		$print += $this->get_Subtotal();
		$print -= $this->get_Refunds();
		return $print;
	}//get_BalanceDue
	
	//   get_Balance_Due    
	
}//end print_form model class