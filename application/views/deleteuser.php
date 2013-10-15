<?
/* View/Deleteuser
 *
 * Displays a list of users that can be selected
 * for deletion from the travel application
 *
 * Author: Josh Smith
 *
 * Created: 2013-07-28
 * Last Edited: 2013-07-28
*/?>
<div class="loadedContent content" id="content">
<?
	echo "<center><h2>Delete User</h2></center>";
	
	echo "<font color=red>";
	if($success == 1) //user successfully removed
	{
		echo "<center><h3>User Removed!</h3></center>";
	} 
	echo "</font>";
	
	$hidden = array('accord' => $accordion);
	
	echo form_open('deleteuser/confirmDelete', '', $hidden);
	echo form_fieldset('Delete User');
	
	?>
	<input type="hidden" name="dept" id="dept" value="<?echo $dept;?>"readonly />
	
	Please select the user you wish to delete from the list below:<br /><br />
	<?

	// construct list of radio buttons:
	foreach($users->result_array() as $row)
	{
		$data = array('name' => 'user', 'id' => 'user', 'value' => $row['user_name']);
		echo form_radio($data);
		echo $row['name'];
		echo "<br />";
	}
		
	echo "<br />";
	echo form_submit('submit', 'Delete');
	?>
	<input type="button" value="Cancel" onclick="location.href='<? echo base_url("index.php/dashboard/view"); ?>';" />
	<?
	echo form_fieldset_close();
	echo form_close();
	?>
</div>