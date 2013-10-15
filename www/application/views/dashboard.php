<?
/* View/dashboard
 *
 * Displays dashboard info to the user (which departmentes and roles
 * they currently have in the system). Also provides a java script check
 * to ensure the user has enabled javascript for the site.
 *
 * Author: Josh Smith
 *
 * Created: 2013-07-24
 * Last Edited: 2013-08-29
*/?>

<div class="loadedContent content" id="profile">

<script type="text/javascript">

<?// Javascript test:?>
<!--
document.write("Welcome <strong><? echo $profile->row()->name;?></strong> to the Travel Application!<br />")
//-->
</script>
<noscript>Please enable javascript to ensure the proper functioning of the Travel Application</noscript>

<?
echo "<br /><strong>You are a member of the following departments:</strong><br />";

$DTC = true;
$TA = true;

foreach($roles->result() as $row)
{
	if ($row->role_id == 2 && $DTC == true)
	{
		$DTC = false;
		echo "<br /><strong>You are  a Department Travel Coordinator in the following departments:</strong><br />";
	}
	
	echo $row->description;
	echo "<br />";
}

if ($isAdmin == true)
{
	echo "<br /><strong>You are a Travel Administrator.</strong><br />";
}

?>

<br /><br />
<font size=small>You are using the EWU Travel Application V1.0 written by Jason Helms, Reid Fortier and Josh Smith</font>

</div>

<? //close the body container opened up in the header ?>
</div>