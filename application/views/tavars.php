<?
/* Views/dtcvars
 *
 * View provides a specific form to display (and allow editing of)
 * system wide variables (currently mileage rate). Livevalidation
 * (http://http://livevalidation.com/) used for form field validation.
 *
 *
 * Author: Reid Fortier, Josh Smith
 *
 * Created: 2013-05 
 * Last Edited: 2013-08-29
*/
?>
<div class="content loadedContent" id="content">
<?
	echo "<font color=red>";
	
	if($success == 1) //Profile saved
	{
	echo "<center><h3> Changes Saved!</h3></center>";
	} 
	else if ($success == 2) //Profile not saved
	{
		echo "<center><h3>Error detected, fix and resubmit</h3></center>";
		echo validation_errors();
	}
	else if ($success == 3) // percentages did not = 100%
	{
		echo "<center><h3>Error detected, fix and resubmit</h3>";
		echo "The per diem splits do not add up to 100%.</center>";
	}
	
	echo "</font>";
	
	echo form_open('systemvariables/taUpdate');
	echo form_fieldset('System Variables');
	//Mileage Rate
	
?>
	<a class="tooltip" href="#">Mileage Rate:<span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" />
	<em>Mileage Rate: </em>Set the system wide reimbursement rate for mileage when useing one's personal vehicle.</span></a> $
<?
	$form_input = array('name' => 'mileageRate', 'id' => 'mileageRate', 'value' => $taquery->row()->mileage_rate, 'maxlength' => '8', 'size' => '8');
	echo form_input($form_input);
?>
	<br /><br /><a class="tooltip" href="#">Breakfast per diem Split:<span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" />
	<em>Breakfast per diem Split: </em>Set the percentage amount of the users daily per diem amount that is alloted for breakfast. Along with
	the lunch and dinner splits these numbers should total 100%.</span></a> 
<?
	$form_input = array('name' => 'breakfast', 'id' => 'breakfast', 'value' => $taquery->row()->breakfast, 'maxlength' => '2', 'size' => '2');
	echo form_input($form_input);
?>
	<br /><br /><a class="tooltip" href="#">Lunch per diem Split:<span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" />
	<em>Lunch per diem Split: </em>Set the percentage amount of the users daily per diem amount that is alloted for lunch. Along with
	the breakfast and dinner splits these numbers should total 100%.</span></a> 
<?
	$form_input = array('name' => 'lunch', 'id' => 'lunch', 'value' => $taquery->row()->lunch, 'maxlength' => '2', 'size' => '2');
	echo form_input($form_input);	
?>
	<br /><br /><a class="tooltip" href="#">Dinner per diem Split:<span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" />
	<em>Dinner per diem Split: </em>Set the percentage amount of the users daily per diem amount that is alloted for dinner. Along with
	the breakfast and lunch splits these numbers should total 100%.</span></a> 
<?
	$form_input = array('name' => 'dinner', 'id' => 'dinner', 'value' => $taquery->row()->dinner, 'maxlength' => '2', 'size' => '2');
	echo form_input($form_input);
?>
<script type="text/javascript">
    var mileageRate = new LiveValidation('mileageRate', { validMessage: '\u2713', wait: 500});
    mileageRate.add(Validate.Presence, {failureMessage: "We're going to pay them some mileage!"});
	mileageRate.add( Validate.Numericality, { minimum: 0 } );		

	var breakfast = new LiveValidation('breakfast', { validMessage: '\u2713', wait: 500});
	breakfast.add(Validate.Presence, {failureMessage: "They'll need some money for breakfast!"});
	breakfast.add( Validate.Numericality, { onlyInteger: true } );

	var lunch = new LiveValidation('lunch', { validMessage: '\u2713', wait: 500});
	lunch.add(Validate.Presence, {failureMessage: "They'll need some money for lunch!"});
	lunch.add( Validate.Numericality, { onlyInteger: true } );

	var dinner = new LiveValidation('dinner', { validMessage: '\u2713', wait: 500});
	dinner.add(Validate.Presence, {failureMessage: "They'll need some money for dinner!"});
	dinner.add( Validate.Numericality, { onlyInteger: true } );	
</script> 		
<?
	//Submit button
	echo "<br /><br />";
	echo form_submit('submit', 'Save Changes');
		
?>
	<input type="button" value="Cancel" onclick="location.href='<? echo base_url("index.php/dashboard/view"); ?>';" />
<?
	
	echo form_fieldset_close();
	echo form_close();
// close the form div:
?>
</div>