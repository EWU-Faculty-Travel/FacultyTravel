<?
/* View/ConfirmDelete
 *
 * Allows the user to confirm they want to delete a specific user
 * from the system. 
 *
 * Author: Josh Smith
 *
 * Created: 2013-07-28
 * Last Edited: 2013-07-28
*/
?>
<div class="loadedContent content" id="content">
<?
	echo "<center><h2>Confirm Delete User</h2></center>";
	
	// pull the name and username out of the db result:
	foreach($profile->result_array() as $row)
	{
		$username = $row['user_name'];
		$name = $row['name'];
	}
	
	$hidden = array('accordion' => $accordion);
	
	echo form_open('deleteuser/deleteUser', '', $hidden);
	echo form_fieldset('Confirm Delete User');
	
	// populate read only hidden fields:
	?>
	<input type="hidden" name="dept" value="<?echo $dept;?>" id="dept" readonly  />
	<input type="hidden" name="username" value="<?echo $username?>" id="username" readonly  />	
	
	Do you really want to delete <strong><? echo $name;?></strong> from the system?<br />
	All of this user's trips and profile information will be permanently removed from
	the system.<br /><br />

	<input type="checkbox" name="confirm" id="confirm" value="Yes" /> <br />
	
	Yes, I truly want to remove <strong><? echo $name;?></strong> from the system.
	<script type="text/javascript">
		var confirm = new LiveValidation('confirm', { validMessage: '\u2713', wait: 500});
		confirm.add( Validate.Acceptance );
	</script>
	<?

	echo "<br /><br />";
	echo form_submit('submit', 'Submit');
?>
	<input type="button" value="Cancel" onclick="location.href='<? echo base_url("index.php/dashboard/view"); ?>';" />
<?
	echo form_fieldset_close();
	echo form_close();
	?>
</div>