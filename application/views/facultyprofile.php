<?
/* View/FacultyProfile
 *
 * Produces the actual form to display to a user enabling them to edit their basic 
 * user information. Currently loaded by the dynamicprofile controller. 
 * 
 * LiveValidation (http://http://livevalidation.com/) javascript library is used for 
 * form field validation before submission but is loaded in the header template.
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
	} else if ($success == 2) //Profile not saved
	{
		echo "<center><h3>Error detected, fix and resubmit</h3></center>";
		echo validation_errors();
	}
	echo "</font>";
	echo form_open('dynamicprofile/update');
	echo form_fieldset('Personal Information');


?>
<a class="tooltip" href="#">ID: <span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" /><em>ID: </em>This is your EWU ID Number. It must be 8 digits in length.</span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<? //Id
	$form_input = array('name' => 'id', 'id' => 'id', 'value' => $profile->row()->id_num, 'maxlength' => '8', 'size' => '8',);
	echo form_input($form_input);
?>
<br />
<script type="text/javascript">
var id = new LiveValidation('id', { validMessage: '\u2713', wait: 500});
id.add(Validate.Presence, {failureMessage: "EWU ID Number is required!"});
id.add( Validate.Format, { pattern: /[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]/i, failureMessage: "Your ID is 8 digits!" } );
</script> 

<br /><a class="tooltip" href="#">Name: <span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" /><em>Name: </em>Your full name, as you want it to appear on the form. Maximum length of 50 characters.</span></a>&nbsp;&nbsp;&nbsp;
<? //Name
	$form_input = array('name' => 'name', 'id' => 'name', 'value' => $profile->row()->name, 'maxlength' => '30', 'size' => '30',);
	echo form_input($form_input);
?>
<br />
<script type="text/javascript">
var name = new LiveValidation('name', { validMessage: 'Nice to meet you!', wait: 500});
name.add(Validate.Presence, {failureMessage: "Surely we haven't hired a ninja?"});		
</script> 

<br /><a class="tooltip" href="#">Email: <span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" /><em>Email: </em>The email that you wish to recieve all responses to. Must be a valid email with a maximum length of 30 characters.</span></a>&nbsp;&nbsp;&nbsp;
<? //Email
	$form_input = array('name' => 'email', 'id' => 'email', 'value' => $profile->row()->email, 'maxlength' => '30', 'size' => '30',);
	echo form_input($form_input);
?>
<br />
<script type="text/javascript">
var email = new LiveValidation('email', { validMessage: '\u2713', wait: 500});
email.add(Validate.Presence, {failureMessage: "But I only know how to email!"});
email.add( Validate.Email );
</script> 

<br /><a class="tooltip" href="#">Phone: <span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" /><em>Phone: </em>The phone number that you wish to have printed on the form. Enter it as '999-999-9999'. You can also add in an optional extension that is up to 6 digits in length.</span></a>&nbsp;&nbsp;
<? //Phone
	$form_input = array('name' => 'phone', 'id' => 'phone', 'value' => $profile->row()->phone, 'maxlength' => '12', 'size' => '15',);
	echo form_input($form_input);
	//Ext
	echo "<br /><br />Ext:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	if($profile->row()->phone_ext == 0)
	{
		$form_input = array('name' => 'ext', 'id' => 'ext', 'maxlength' => '6', 'size' => '6',);
	} else
	{
		$form_input = array('name' => 'ext', 'id' => 'ext', 'value' => $profile->row()->phone_ext, 'maxlength' => '6', 'size' => '6',);
	}
	echo form_input($form_input);
?>
<br />
<script type="text/javascript">
var phone = new LiveValidation('phone', { validMessage: 'Operators are standing by!', wait: 500});
phone.add(Validate.Presence, {failureMessage: "But a live person might want to call you!"});
phone.add( Validate.Format, { pattern: /[0-9][0-9][0-9]-[0-9][0-9][0-9]-[0-9][0-9][0-9][0-9]/i, failureMessage: "Let's put in our phone as 509-867-5309 ok?" } );

var ext = new LiveValidation('ext', { validMessage: '\u2713', wait: 500});
ext.add( Validate.Length, { maximum: 6 } );
ext.add( Validate.Numericality, { onlyInteger: true } );
</script> 

<br /><br />
<strong>Home Address:</strong><br /><br />
<a class="tooltip" href="#">Street: <span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" /><em>Street: </em>This is the address that you wish to appear on the form. It can be up to 30 characters in length.</span></a>&nbsp;&nbsp;&nbsp;
<? //Street
	$form_input = array('name' => 'street', 'id' => 'street', 'value' => $profile->row()->street, 'maxlength' => '30', 'size' => '30',);
	echo form_input($form_input);
?>
<br />
<script type="text/javascript">
var street = new LiveValidation('street', { validMessage: '\u2713', wait: 500});
street.add(Validate.Presence, {failureMessage: "Surely you live somewhere..."});
</script> 

<br /><a class="tooltip" href="#">City: <span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" /><em>City: </em>This is the city that you wish to appear on the form. It can be up to 20 characters in length.</span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<? //City
	$form_input = array('name' => 'city', 'id' => 'city', 'value' => $profile->row()->city, 'maxlength' => '20', 'size' => '20',);
	echo form_input($form_input);
?>
<br />
<script type="text/javascript">
var city = new LiveValidation('city', { validMessage: '\u2713', wait: 500});
city.add(Validate.Presence, {failureMessage: "Your home must be near some city..."});
</script> 

<br /><a class="tooltip" href="#">State: <span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" /><em>State: </em>This is the state that you wish to appear on the form. Use the 2 character postal form.</span></a>&nbsp;&nbsp;&nbsp;&nbsp;
<? //State
	$form_input = array('name' => 'state', 'id' => 'state', 'value' => $profile->row()->state, 'maxlength' => '2', 'size' => '2',);
	echo form_input($form_input);
?>
<br />
<script type="text/javascript">
var state = new LiveValidation('state', { validMessage: '\u2713', wait: 500});
state.add(Validate.Presence, {failureMessage: "I'm in a state of confusion!"});
state.add( Validate.Format, { pattern: /[A-Z|a-z][A-Z|a-z]/i, failureMessage: "I know you know your state!" } );
</script>

<br /><a class="tooltip" href="#">Zip: <span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" /><em>Zip: </em>This is the zip code that you wish to appear on the form. Use the 5 digit form.</span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<? //Zip
	$form_input = array('name' => 'zip', 'id' => 'zip', 'value' => $profile->row()->zip, 'maxlength' => '5', 'size' => '5',);
	echo form_input($form_input);
?>
<br />
<script type="text/javascript">
var zip = new LiveValidation('zip', { validMessage: '\u2713', wait: 500});
zip.add(Validate.Presence, {failureMessage: "I'm in a state of confusion!"});
zip.add( Validate.Format, { pattern: /[0-9][0-9][0-9][0-9][0-9]/i, failureMessage: "Zip codes are 5 digits!" } );
</script>
<br /><br />
<strong>Office Location/Campus Mail Address:</strong><br /><br />
<a class="tooltip" href="#">Station: <span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" /><em>Station: </em>This is the campus which houses your office.</span></a>
<? //Campus
	$options = array();
	foreach ($station->result_array() as $row)
	{
		$options[$row['station_id']] = $row['station_name'];
	}

	echo form_dropdown('station_id', $options);
?>
<br /><br /><a class="tooltip" href="#">Room: <span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" /><em>Room: </em>This is your office number. Please include building code as well.</span></a>
<? //Office Room
	$form_input = array('name' => 'bldg_rm', 'id' => 'bldg_rm', 'value' => $profile->row()->bldg_rm, 'maxlength' => '10', 'size' => '10',);
	echo form_input($form_input); //Needs JS validation still
?>
<br />
<script type="text/javascript">
var bldg_rm = new LiveValidation('bldg_rm', { validMessage: '\u2713', wait: 500});
bldg_rm.add(Validate.Presence, {failureMessage: "Where was your office again?"});
</script>

<? 
// The structure of the functionality to turn on the tool tips (the hover over hints for fields)
// will remain intact however the logic to turn them on/off is currently not going to be implemented
// [2013-07-27] Josh Smith

/*
<br /><a class="tooltip" href="#">Tool Tips: <span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" /><em>Tool Tips: </em>This will turn on or off the tools tips that appear on the form creation pages.</span></a>
<? //Tool tips
	if ($profile->row()->tooltips == 1) {
		$form_input = array('name' => 'tooltips', 'id' => 'tooltip', 'checked' => TRUE,);
	} else {
		$form_input = array('name' => 'tooltips', 'id' => 'tooltip', 'checked' => FALSE,);
	}
	echo form_checkbox($form_input); */

	//Submit button
	echo "<br /><br />";
	echo form_submit('submit', 'Save Changes');
	?>
	<input type="button" value="Cancel" onclick="location.href='<? echo base_url("index.php/dashboard/view"); ?>';" />
	<?
	echo form_fieldset_close();
	echo form_close();
	
?>
</div>