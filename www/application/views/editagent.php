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
	echo "<center><h2>Edit Travel Agent</h2></center>";
	
	echo "<font color=red>";
	if($success == 1) //Profile saved
	{
		echo "<center><h3> Changes Saved!</h3></center>";
	} 
	else if ($success == 2) //Profile not saved
	{
		echo "<center><h3>Error detected, fix and resubmit.</h3>";
		echo validation_errors();
		echo "</center>";
	} 
	echo "</font>";

	echo form_open('editagent/update');
	
	// set form title:
	$f_name = "Edit Travel Agent (";
	$f_name .= $dept;
	$f_name .= ")";
	echo form_fieldset($f_name);

	?>
	<input type="hidden" name="dept" id="dept" value="<?echo $dept;?>"readonly />
	<br /><a class="tooltip" href="#">Agency Name:<span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" /><em>Agency Name: </em>The name of the travel agency used by the department.</span></a> 	
	<?
	// new user's username:
	$form_input = array('name' => 'agency_name', 'id' => 'agency_name', 'size' => '30', 'value' => $name);
	echo form_input($form_input);	
	?>
	<script type="text/javascript">
		var agency = new LiveValidation('agency_name', { validMessage: '\u2713', wait: 500});
		agency.add(Validate.Presence, {failureMessage: "What was the name of that fantastic travel agency?"});
		agency.add( Validate.Length, { minimum: 4 } );
		agency.add( Validate.Length, { maximum: 50 } );
	</script>
	
	<br /><br />
	<a class="tooltip" href="#">Agency Phone:<span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" /><em>Agency Phone: </em>The phone number for the travel agency.</span></a>
	<?
	$form_input = array('name' => 'phone', 'id' => 'phone', 'size' => '30', 'value' => $phone);
	echo form_input($form_input);
	?>
	<script type="text/javascript">
		var phone = new LiveValidation('phone', { validMessage: '\u2713', wait: 500});
		phone.add(Validate.Presence, {failureMessage: "Did you have their phone number?"});
		phone.add( Validate.Length, { is: 12 } );
		phone.add( Validate.Format, { pattern: /[0-9][0-9][0-9]-[0-9][0-9][0-9]-[0-9][0-9][0-9][0-9]/i, failureMessage: "Let's put in our phone as 509-867-5309 ok?" } );
	</script>
	
	<br /><br />
	<?
	echo form_submit('save', 'Save'); //Will need validation here. ?> <? // <-- include space between buttons
	echo form_reset('reset', 'Reset');

	?>
	<input type="button" value="Cancel" onclick="location.href='<? echo base_url("index.php/dashboard/view"); ?>';" />
	<?
	
	echo form_fieldset_close();
	echo form_close();
	?>
</div>