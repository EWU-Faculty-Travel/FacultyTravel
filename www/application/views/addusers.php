<?
/* View/addusers
 *
 * Displays the add user form to a system user. User LiveValidation
 * () for form field validation.
 *
 * Author: Josh Smith
 *
 * Created: 2013-07-24
 * Last Edited: 2013-08-29
*/?>
<div class="loadedContent content" id="content">
<?
	echo "<center><h2>Add User</h2></center>";
	
	// testing success return:
	//echo $success;
	
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
	else if ($success == -3) // user already was in dept/had role
	{
		echo "<center><h3>User already existed in department!</h3></center>";
	}
	else if ($success == -4) // user already was in dept/had role
	{
		echo "<center><h3>That email is attached to another user!</h3></center>";
	}
	else if ($success == -5) // user already was in dept/had role
	{
		echo "<center><h3>That EWU ID is attached to another user!</h3></center>";
	}
	echo "</font>";
	
	$hidden = array('accordion' => $accordion);
	echo form_open('addusers/update', '', $hidden);
	echo form_fieldset('Add New User');
	?>
	<br /><a class="tooltip" href="#">User Name:<span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" /><em>User Name: </em>The new user's EWU SSO login id.</span></a> 	
	<?
	// new user's username:
	$form_input = array('name' => 'user_name', 'id' => 'user_name', 'size' => '30', 'value' => set_value('user_name', ''));
	echo form_input($form_input);	
	?>
	<script type="text/javascript">
		var username = new LiveValidation('user_name', { validMessage: '\u2713', wait: 500});
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
		var ewu_id = new LiveValidation('ewu_id', { validMessage: '\u2713', wait: 500});
		ewu_id.add(Validate.Presence, {failureMessage: "User must have an EWU ID!"});
		ewu_id.add( Validate.Length, { is: 8 } );
		ewu_id.add( Validate.Numericality, { onlyInteger: true } );
	</script>
	
	<br /><br />
	<a class="tooltip" href="#">Department:<span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" /><em>Department: </em>Select the department you would like to add the user to.</span></a> 	
	<?

	// the new user's department:
	$user_dept = array();
	foreach ($depts->result_array() as $row)
	{
	   $user_dept[$row['dept_code']] = $row['dept_code'];
	}
		
	echo form_dropdown('dept_code', $user_dept);

	?>
	<br /><br />
	<a class="tooltip" href="#">Station:<span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" /><em>Station: </em>Select the location of the new user's office.</span></a> 	
	<?	
	$user_station = array();
	foreach ($stations->result_array() as $row)
	{
		$user_station[$row['station_id']] = $row['station_name'];
	}

	echo form_dropdown('station_id', $user_station);
	?>
	<br /><br />
	<a class="tooltip" href="#">Email: <span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" /><em>Email: </em>The email that you wish to recieve all responses to. Must be a valid email with a maximum length of 30 characters.</span></a>&nbsp;&nbsp;&nbsp;
	<? //Email
	$form_input = array('name' => 'email', 'id' => 'email', 'value' => "", 'maxlength' => '30', 'size' => '30', 'value' => set_value('email', ''));
	echo form_input($form_input);
	?>	
	<script type="text/javascript">
		var email = new LiveValidation('email', { validMessage: '\u2713', wait: 500});
		email.add(Validate.Presence, {failureMessage: "But I only know how to email!"});
		email.add( Validate.Email );
	</script>
	
	<br /><br />
	Confirm Email: 
	<? //Email
	$form_input = array('name' => 'email2', 'id' => 'email2', 'value' => "", 'maxlength' => '30', 'size' => '30', 'value' => set_value('email2', ''));
	echo form_input($form_input);
	echo "<br /><br />";
	?>	
	<script type="text/javascript">
		var email2 = new LiveValidation('email2', { validMessage: '\u2713', wait: 500});
		email2.add(Validate.Presence, {failureMessage: "Enter the email again to be sure!"});
		email2.add( Validate.Email );
		email2.add( Validate.Confirmation, { match: 'email' } );
	</script>
	<?
	echo form_submit('save', 'Add User'); //Will need validation here. ?> <? // <-- include space between buttons
	
	echo form_reset('reset', 'Reset');

	?>
	<input type="button" value="Cancel" onclick="location.href='<? echo base_url("index.php/dashboard/view"); ?>';" />
	<?
	
	echo form_fieldset_close();
	echo form_close();
	?>
</div>