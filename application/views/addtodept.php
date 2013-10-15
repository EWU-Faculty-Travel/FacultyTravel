<?
/* View/addusers
 *
 * Displays the add user to deparmtent form to a system user. 
 * Uses LiveValidation() for form field validation.
 *
 * Author: Josh Smith
 *
 * Created: 2013-07-24
 * Last Edited: 2013-08-29
*/?>
<div class="loadedContent content" id="content">
<?
	echo "<center><h2>Add User to Department</h2></center>";
	
	echo "<font color=red>";
	if($success == 1) //Profile saved
	{
		echo "<center><h3> User Added!</h3></center>";
	} 
	else if ($success == 2) //Profile not saved
	{
		echo "<center><h3>Error detected, fix and resubmit.</h3>";
		echo validation_errors();
		echo "</center>";
	} 
	echo "</font>";
	
	echo form_open('addusers/update_dept');
	echo form_fieldset('Add to Dept');
	
	?>
	<br /><a class="tooltip" href="#">User Name:<span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" /><em>User Name: </em>The new user's EWU SSO login id.</span></a> 	
	<?
	// new user's username:
	$form_input = array('name' => 'user_name1', 'id' => 'user_name', 'size' => '30', 'value' => set_value('user_name', ''));
	echo form_input($form_input);	
	?>
	<script type="text/javascript">
		var username = new LiveValidation('user_name1', { validMessage: '\u2713', wait: 500});
		username.add(Validate.Presence, {failureMessage: "Can't log in without a username!"});
		username.add( Validate.Length, { minimum: 2 } );
		username.add( Validate.Length, { maximum: 30 } );
		username.add( Validate.Format, { pattern: /^[\S]*$/i, failureMessage: "The user name is one word!" } );
	</script>
	
	<br /><br />
	<a class="tooltip" href="#">EWU ID:<span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" /><em>EWU ID: </em>The new user's EWU ID.</span></a> 	
	
	<?
	$form_input = array('name' => 'ewu_id', 'id' => 'ewu_id', 'size' => '8', 'value' => set_value('ewu_id', ''));
	echo form_input($form_input);
	?>
	<script type="text/javascript">
		var ewu_id = new LiveValidation('ewu_id1', { validMessage: '\u2713', wait: 500});
		ewu_id.add(Validate.Presence, {failureMessage: "User must have an EWU ID!"});
		ewu_id.add( Validate.Length, { is: 8 } );
		ewu_id.add( Validate.Numericality, { onlyInteger: true } );
	</script>
	
	<br /><br />
	<a class="tooltip" href="#">Department:<span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" /><em>Department: </em>Select the department you would like to add the user to.</span></a> 	
	<?

	// the new user's department:
	$options = array();
	foreach ($depts->result_array() as $row)
	{
	   $options[$row['dept_code']] = $row['dept_code'];
	}
		
	echo form_dropdown('dept_code1', $options);

	?>
	<br /><br />

<?
	echo form_submit('save', 'Save'); //Will need validation here.
	echo form_reset('reset', 'Reset');
	?>
	<input type="button" value="Cancel" onclick="location.href='<? echo base_url("index.php/dashboard/view"); ?>';" />
	<?
	echo form_fieldset_close();
	echo form_close();
?>
</div>