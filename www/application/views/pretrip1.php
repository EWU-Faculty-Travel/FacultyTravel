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
 * Last Edited: 2013-08-22
*/
?>
<div class="content loadedContent" id="content">
<?
	echo "<font color=red>";
    
	if(isset($success))
    {
    	if($success == 1) //Trip saved
    	{
    		echo "<center><h3> Trip Saved!</h3></center>";
    	} else if ($success == 2) //Trip not saved
    	{
    		echo "<center><h3>Error detected, fix and resubmit</h3></center>";
    		echo validation_errors();
    	}
	}
	
	echo "</font>";
	echo "<center><h2>", $body_title, "</h2></center>";
	
	if(isset($return_to))
	{
		if ($return_to == 2)
		{
			echo "<font color=red><center><h3> Trip for: ";
			echo $trip_owner.'<br/>
			with Trip ID: '.$trip_id.'<br/>';
			$trip_name = $this->pretrip_model->getTripName($trip_id);
			echo 'Trip Name: '.$trip_name.'<br/>'; 
			$authorization_number_query = $this->pretrip_model->travelAuthorizationNumberDatabaseQuery($trip_id);
			echo 'Trip Authorization: '.$authorization_number_query->row(0)->authorization;
			echo "</h3></center></font>";
		}
	}	
	echo form_open('pretrip/save');
	echo form_fieldset('Required Fields');
    ?>
    <input type="hidden" name="return_to" id="return_to" value="<? echo set_value('return_to', (isset($return_to) ? $return_to : 1)); ?>" readonly />
	<input type="hidden" name="trip_id" id="trip_id" value="<? echo set_value('trip_id', (isset($trip_id) ? $trip_id : '0'));?>" readonly />
    
	<? //Trip Name ?>
	<br /><a class="tooltip" href="#">Trip Name:<span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" /><em>Trip Name: </em>This trip name should help you identify a specific trip and must be at least 5 characters long.</span></a> 
	<?
	$form_input = array('name' => 'trip_name', 'id' => 'trip_name', 'maxlength' => '50', 'size' => '20', 'value' => set_value('trip_name', (isset($trip_name) ? $trip_name : '')));
	echo form_input($form_input);
	echo "<br />";
	?>
	<script type="text/javascript">
		var trip_name = new LiveValidation('trip_name', { validMessage: '\u2713', wait: 500});
		trip_name.add(Validate.Presence, {failureMessage: "Just a short name to identify this trip ok?"});
		trip_name.add( Validate.Length, { minimum: 4 } );
		trip_name.add( Validate.Length, { maximum: 50 } );
	</script>
	<?
	
	//Department Selection
	?>
	<br /><a class="tooltip" href="#">Department:<span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" /><em>Department: </em>This is the department that is sponsoring this specific trip.</span></a> 
	<?
	$options = array();
	foreach ($dept->result_array() as $row)
	{
	   $options[$row['dept_code']] = $row['dept_code'];
	}
		
	echo form_dropdown('dept_code', $options);
	echo "<br />";

	//Travel From
	?>
	<br/><a class="tooltip" href="#">Departure From:<span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" /><em>Depature From: </em>The city and state of your departure.</span></a> 
	<?
	$form_input = array('name' => 'departure', 'id' => 'departure', 'maxlength' => '50', 'size' => '20', 'value' => set_value('departure', (isset($departure) ? $departure : '')));
	echo form_input($form_input);
	?>
	<br />
	<script type="text/javascript">
		var departure = new LiveValidation('departure', { validMessage: '\u2713', wait: 500});
		departure.add(Validate.Presence, {failureMessage: "Where are you leaving from?"});
		departure.add( Validate.Length, { minimum: 5 } );
		departure.add( Validate.Length, { maximum: 50 } );
	</script>
	<?		
	//Travel To
	?>
	<br /><a class="tooltip" href="#">Travel To:<span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" /><em>Travel To: </em>The trip destination.</span></a> 
	<?
	$form_input = array('name' => 'destination', 'id' => 'destination', 'maxlength' => '50', 'size' => '20', 'value' => set_value('destination', (isset($destination) ? $destination : '')));
	echo form_input($form_input);
	echo "<br />";
	?>
	<script type="text/javascript">
		var destination = new LiveValidation('destination', { validMessage: '\u2713', wait: 500});
		destination.add(Validate.Presence, {failureMessage: "Where are you going?"});
		destination.add( Validate.Length, { minimum: 5 } );
		destination.add( Validate.Length, { maximum: 50 } );
		departure.add( Validate.Format, { pattern: /\w{1,}[,][ ][A-z][A-z]/i, failureMessage: "Please enter a \"city, state/country\"" } );
	</script>
	<?	
	//Purpose of trip
	?>
	<br /><a class="tooltip" href="#">Purpose of the Trip:<span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" /><em>Purpose Trip: </em>The reason for the trip.</span></a><br />
	<textarea name = 'purpose' id = 'purpose' cols = '50' rows = '5' ><? echo set_value('purpose', (isset($purpose) ? $purpose : '')); ?></textarea>
	
	<script type="text/javascript">
		var purpose = new LiveValidation('purpose', { validMessage: '\u2713', wait: 500});
		purpose.add(Validate.Presence, {failureMessage: "Could you remind me why you'd ever want to leave me?"});
		purpose.add( Validate.Length, { minimum: 4 } );
		purpose.add( Validate.Length, { maximum: 250 } );
	
		$(function()
        {   
            var startDateTextBox = $('#start_date');
            var endDateTextBox = $('#end_date');
            
            startDateTextBox.datetimepicker({ 
            	timeFormat: 'hh:mm tt',
                stepMinute: 15,
                addSliderAcces: true,
                sliderAccessArgs: {touchonly: false},
            	onClose: function(dateText, inst) {
            		if (endDateTextBox.val() != '') {
            			var testStartDate = startDateTextBox.datetimepicker('getDate');
            			var testEndDate = endDateTextBox.datetimepicker('getDate');
            			if (testStartDate > testEndDate)
            				endDateTextBox.datetimepicker('setDate', testStartDate);
            		}
            		else {
            			endDateTextBox.val(dateText);
            		}
            	},
            	onSelect: function (selectedDateTime){
            		endDateTextBox.datetimepicker('option', 'minDate', startDateTextBox.datetimepicker('getDate') );
            	}
            });
            endDateTextBox.datetimepicker({ 
            	timeFormat: 'hh:mm tt',
                stepMinute: 15,
                addSliderAcces: true,
                sliderAccessArgs: {touchonly: false},
            	onClose: function(dateText, inst) {
            		if (startDateTextBox.val() != '') {
            			var testStartDate = startDateTextBox.datetimepicker('getDate');
            			var testEndDate = endDateTextBox.datetimepicker('getDate');
            			if (testStartDate > testEndDate)
            				startDateTextBox.datetimepicker('setDate', testEndDate);
            		}
            		else {
            			startDateTextBox.val(dateText);
            		}
            	},
            	onSelect: function (selectedDateTime){
            		startDateTextBox.datetimepicker('option', 'maxDate', endDateTextBox.datetimepicker('getDate') );
            	}
            });
        });
        </script>
	<?
	echo "<br />";
	
	//Date of Departure
	?>
	<br /><a class="tooltip" href="#">Departure Date:<span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" /><em>Departure Date: </em>Use the date & time picker to select the date and time of your departure.</span></a> 
	<?
	if(isset($start_date))
	{
		$time = strtotime($start_date);
		$converted_start_date = date("m/d/Y h:i a", $time);
	}
	$form_input = array('name' => 'start_date', 'id' => 'start_date', 'maxlength' => '25', 'size' => '25', 'value' => set_value('start_date', (isset($converted_start_date) ? $converted_start_date : '')));
	echo form_input($form_input);
	?>
	<script type="text/javascript">
		var dep_date = new LiveValidation('start_date', { validMessage: '\u2713', wait: 500});
		dep_date.add(Validate.Presence, {failureMessage: "When are you leaving?"});
		dep_date.add(Validate.Format, { pattern: /(((0[13578]|1[02])[/](0([1-9])|[12][0-9]|3[01]))|(0[469]|11)[/](0[1-9]|[12][0-9]|30)|(02[/](0[1-9]|[1][0-9]|2[0-9])))[/](20[1-9][0-9])[ ]((0[1-9])|(1[012]))[:][0-6][0-9][ ][Aa|Pp][Mm]/i, failureMessage: "Please format your date as mm/dd/yyyy hh:mm AM/PM" } );
	</script>
	<?
	//Date of Return
	?>
	<br /><br /><a class="tooltip" href="#">Return Date:<span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" /><em>Return Date: </em>Use the date & time picker to select the time of your return.</span></a> 
	<?
	if(isset($end_date))
	{
		$time = strtotime($end_date);
		$converted_end_date = date("m/d/Y h:i a", $time);
	}
	$form_input = array('name' => 'end_date', 'id' => 'end_date', 'maxlength' => '25', 'size' => '25', 'value' => set_value('end_date', (isset($converted_end_date) ? $converted_end_date : '')));
	echo form_input($form_input);
	echo "<br /><br />";
	?>
	<script type="text/javascript">
		var ret_date = new LiveValidation('end_date', { validMessage: '\u2713', wait: 500});
		ret_date.add(Validate.Presence, {failureMessage: "When are you coming back?"});
		ret_date.add(Validate.Format, { pattern: /(((0[13578]|1[02])[/](0([1-9])|[12][0-9]|3[01]))|(0[469]|11)[/](0[1-9]|[12][0-9]|30)|(02[/](0[1-9]|[1][0-9]|2[0-9])))[/](20[1-9][0-9])[ ]((0[1-9])|(1[012]))[:][0-6][0-9][ ][Aa|Pp][Mm]/i, failureMessage: "Please format your date as mm/dd/yyyy hh:mm AM/PM" } );
	</script>
	<?
	//Side Trip
	echo "<input type = 'checkbox' name = 'sidetrip' id = 'sidetrip' ", (isset($sidetrip)) ? 'checked' : '', set_checkbox('sidetrip', 1), "/>Personal Side Trip<br />";
	?>
    <script type="text/javascript">
        $(function()
        {   
            var startDateTextBox = $('#start_side');
            var endDateTextBox = $('#end_side');
            
            startDateTextBox.datetimepicker({ 
            	timeFormat: 'hh:mm tt',
                stepMinute: 15,
                addSliderAcces: true,
                sliderAccessArgs: {touchonly: false},
            	onClose: function(dateText, inst) {
            		if (endDateTextBox.val() != '') {
            			var testStartDate = startDateTextBox.datetimepicker('getDate');
            			var testEndDate = endDateTextBox.datetimepicker('getDate');
            			if (testStartDate > testEndDate)
            				endDateTextBox.datetimepicker('setDate', testStartDate);
            		}
            		else {
            			endDateTextBox.val(dateText);
            		}
            	},
            	onSelect: function (selectedDateTime){
            		endDateTextBox.datetimepicker('option', 'minDate', startDateTextBox.datetimepicker('getDate') );
            	}
            });
            endDateTextBox.datetimepicker({ 
            	timeFormat: 'hh:mm tt',
                stepMinute: 15,
                addSliderAcces: true,
                sliderAccessArgs: {touchonly: false},
            	onClose: function(dateText, inst) {
            		if (startDateTextBox.val() != '') {
            			var testStartDate = startDateTextBox.datetimepicker('getDate');
            			var testEndDate = endDateTextBox.datetimepicker('getDate');
            			if (testStartDate > testEndDate)
            				startDateTextBox.datetimepicker('setDate', testEndDate);
            		}
            		else {
            			startDateTextBox.val(dateText);
            		}
            	},
            	onSelect: function (selectedDateTime){
            		startDateTextBox.datetimepicker('option', 'maxDate', endDateTextBox.datetimepicker('getDate') );
            	}
            });
        });
	</script>
	<a class="tooltip" href="#">Start Date:<span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" /><em>Side Trip Start Date: </em>If you are taking a personal side trip during your trip enter the starting date and time of the side trip.</span></a> 
	<?
	if(isset($start_side))
	{
		$time = strtotime($start_side);
		$converted_start_side = date("m/d/Y h:i a", $time);
	}
    $form_input = array('name' => 'start_side', 'id' => 'start_side', 'maxlength' => '25', 'size' => '25', 'value' => set_value('start_side', (isset($converted_start_side) ? $converted_start_side : '')));
	echo form_input($form_input);
	?>
	<script type="text/javascript">
		var start_sidetrip = new LiveValidation('start_side', { validMessage: '\u2713', wait: 500});
		start_sidetrip.add(Validate.Format, { pattern: /(((0[13578]|1[02])[/](0([1-9])|[12][0-9]|3[01]))|(0[469]|11)[/](0[1-9]|[12][0-9]|30)|(02[/](0[1-9]|[1][0-9]|2[0-9])))[/](20[1-9][0-9])[ ]((0[1-9])|(1[012]))[:][0-6][0-9][ ][Aa|Pp][Mm]/i, failureMessage: "Please format your date as mm/dd/yyyy hh:mm AM/PM" } );
	</script>
	<br /><br /><a class="tooltip" href="#">End Date:<span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" /><em>Side Trip End Date: </em>If you are taking a personal side trip during your trip enter the ending date and time of the side trip.</span></a> 
	<?
	if(isset($end_side))
	{
		$time = strtotime($end_side);
		$converted_end_side = date("m/d/Y h:i a", $time);
	}
	$form_input = array('name' => 'end_side', 'id' => 'end_side', 'maxlength' => '25', 'size' => '25', 'value' => set_value('end_side', (isset($converted_end_side) ? $converted_end_side : '')));
	echo form_input($form_input);
	?>
	<script type="text/javascript">
		var end_sidetrip = new LiveValidation('end_side', { validMessage: '\u2713', wait: 500});
		end_sidetrip.add(Validate.Format, { pattern: /(((0[13578]|1[02])[/](0([1-9])|[12][0-9]|3[01]))|(0[469]|11)[/](0[1-9]|[12][0-9]|30)|(02[/](0[1-9]|[1][0-9]|2[0-9])))[/](20[1-9][0-9])[ ]((0[1-9])|(1[012]))[:][0-6][0-9][ ][Aa|Pp][Mm]/i, failureMessage: "Please format your date as mm/dd/yyyy hh:mm AM/PM" } );
	</script>
	<br /><br /><a class="tooltip" href="#">Modes of Travel:<span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" /><em>Travel Modes: </em>Select all the modes of travel that you will use on this trip.</span></a><br /> 
	<?	
	echo "<input type = 'checkbox' name = 'plane' id = 'plane' value = 1 ", (isset($plane)) ? 'checked' : '', set_checkbox('plane', 1), "/>Air<br />";
	echo "<input type = 'checkbox' name = 'train' id = 'train' value = 2 ", (isset($train)) ? 'checked' : '', set_checkbox('train', 2), "/>Train<br />";
	echo "<input type = 'checkbox' name = 'bus' id = 'bus' value = 3 ", (isset($bus)) ? 'checked' : '', set_checkbox('bus', 3), "/>Bus<br />";
	echo "<input type = 'checkbox' name = 'ewu_motorpool' id = 'ewu_motorpool' value = 4 ", (isset($ewu_motorpool)) ? 'checked' : '', set_checkbox('ewu_motorpool', 4), "/>EWU Motorpool<br />";
	echo "<input type = 'checkbox' name = 'private_car' id = 'private_car' value = 5 ", (isset($private_car)) ? 'checked' : '', set_checkbox('private_car', 5), "/>Private Car<br />";
	echo "<input type = 'checkbox' name = 'rental_car' id = 'rental_car' value = 6 ", (isset($rental_car)) ? 'checked' : '', set_checkbox('rental_car', 6), "/>Rental Car<br />";
	echo "<input type = 'checkbox' name = 'charter' id = 'charter' value = 7 ", (isset($charter)) ? 'checked' : '', set_checkbox('charter', 7), "/>Charter<br />";
	echo "<input type = 'checkbox' name = 'courtesy' id = 'courtesy' value = 8 ", (isset($courtesy)) ? 'checked' : '', set_checkbox('courtesy', 8), "/>Courtesy<br />";
	
	?>
	<br /><a class="tooltip" href="#">How many students are traveling with you:<span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" /><em>Group Count: </em>If you are travel with students how many are accompanying you.</span></a> 
	<?
	$form_input = array('name' => 'group_count', 'id' => 'group_count', 'maxlength' => '2', 'size' => '2', 'value' => set_value('group_count', (isset($group_count) ? $group_count : 0)));
		echo form_input($form_input);
	?>
	<script type="text/javascript">
	    var group_count = new LiveValidation('group_count', { validMessage: '\u2713', wait: 500});
		group_count.add(Validate.Presence, {failureMessage: "Even if no one is coming put 0."});
		group_count.add( Validate.Numericality, { minimum: 0 } );
		group_count.add( Validate.Numericality, { onlyInteger: true } );		
	</script> 	
	<?
	//Submit button
	echo "<br /><br />";
	echo (isset($trip_id) ? '' : form_submit('submit', 'Next')); //Will need validation here ?> <? // <-- include space between buttons
	echo form_submit('save', 'Save'); //Will need validation here. ?> <? // <-- include space between buttons
	echo form_reset('reset', 'Reset');
    ?>
    <input type="button" value="Cancel" onclick="location.href='<? echo (isset($return_to) ? ($return_to == 1 ? base_url("index.php/triplist/view") : base_url("index.php/triplist/dtcview")) : base_url("index.php/triplist/view")); ?>';" />
    <?

	echo form_fieldset_close();
	echo form_close();
	
    ?>
</div>
