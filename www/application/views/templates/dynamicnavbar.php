<?
/* View/DynamicNavBar
 *
 * Creates the actual navigation bar presented to the user.
 *
 * Author: Reid Fortier, Jason Helms, Josh Smith
 *
 * Created: 2013-05 
 * Last Edited: 2013-08-22
*/
?>

<div class="content menuLeft" id="menu"> 

<? /*NAVIAGATION IS LOADED INTO THIS DIV */

	// Every user gets faculty/staff user functionality:
	
	echo "<font size='4'><a href="; echo base_url("index.php/dashboard/view"); 		echo ">Home</a></font><br /><br />";

	// accordion object starts here:
	echo "<div id=\"accordion\">";
	
	echo "<h3><a href=\"#User\">User Tools</a></h3>";
	// start sublist:
	echo "<div>";
	
	echo "<a href="; echo base_url("index.php/pretrip/view"); 			echo ">New Trip</a><br />";
	echo "<a href="; echo base_url("index.php/triplist/view"); 			echo ">Saved Trips</a><br />";
	echo "<a href="; echo base_url("index.php/dynamicprofile/view");	echo ">Edit Profile</a><br />";
	echo "</div>";
	
	$query = $this->user_roles->databaseQuery();
	foreach($query->result() as $query)
		{
			// add DTC and TA links as appropriate:
            if($query->role_id == 2)
            {				
                echo "<h3><a href=\"#\">DTC Tools</a></h3>";
				
				echo "<div>";

                echo "<a href="; echo base_url("index.php/triplist/dtcview"); echo ">All Trips</a><br />";
				echo "<a href="; echo base_url("index.php/addusers/dtcview"); echo ">Add User</a><br />";
				echo "<a href="; echo base_url("index.php/deleteuser/dtcview"); echo ">Delete User</a><br />";
				
				
				// System variable option for DTC removed as the project currently will be for CSCD only
				// which does not use them. 2013-07-27 Josh Smith
				//echo "<a href="; echo base_url("index.php/systemvariables/view"); echo ">Edit Department Variables</a><br />";
				echo "<a href="; echo base_url("index.php/editagent/view"); echo ">Edit Travel Agent</a><br />";
				echo "<a href="; echo base_url("index.php/addDTC/view"); echo ">Edit DTCs</a><br />";				
				
				echo "</div>";
            }
            if($query->role_id == 3)
            {
				echo "<h3><a href=\"#\">TA Tools</a></h3>";
				echo "<div>";
				
				echo "<a href="; echo base_url("index.php/addusers/taview"); echo ">Add User</a><br />";
				echo "<a href="; echo base_url("index.php/deleteuser/taview"); echo ">Delete User</a><br />";
				echo "<a href="; echo base_url("index.php/travAdminAddDTC/view"); echo ">Edit DTCs</a><br />";
				echo "<a href="; echo base_url("index.php/systemvariables/view"); echo ">Edit System Variables</a><br />";
				echo "<a href="; echo base_url("index.php/stationEdit/view"); echo ">Edit Stations</a><br />";
				echo "<a href="; echo base_url("index.php/travAdminAddTA/view"); echo ">Edit Travel Admin.</a><br />";

				echo "</div>";
            }
		}
		
	// close the accordion div:
	echo "</div>";
?>
<br />
<font size='4'><a href="<? echo base_url("index.php/logout/view"); ?>">Log Out</a></font><br />
</div>

<script type="text/javascript">
	// set accordion attributes:
	//setter //heightStyle: "content"
	//$( ".selector" ).accordion({ collapsible: true,
	//							 active: 2 });//"option", "autoHeight", false );
$(document).ready(function(){
	
    // sets accordion to be collapsible
	 $("#accordion").accordion({active: <? echo $accordion; ?>, collapsible:true, animated: 'bounceslide'});
	
});
</script>