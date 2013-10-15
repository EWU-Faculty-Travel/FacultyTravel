<?
/* View/travelauthorizationnumber
 *
 * Allows a DTC to change the travel authorization number on a form
 *
 * LiveValidation (http://http://livevalidation.com/) javascript library is used for 
 * form field validation before submission but is loaded in the header template.
 *
 * Author: Reid Fortier, Josh Smith
 *
 * Created: 2013-08-19
 * Last Edited: 2013-08-29
*/?>
<div class="loadedContent content" id="content">
    <?
    echo "<center><h2>Modify Travel Authorization Number</h2></center>";

    echo form_open('triplist/modifyTravAuthNum');
    echo form_fieldset('Travel Authorization Number');
    ?>
    <input type="hidden" name="return_to" id="return_to" value="<? echo set_value('return_to', (isset($return_to) ? $return_to : 1)); ?>" readonly />
    <input type="hidden" name="trip_id" id="trip_id" value="<? echo set_value('trip_id', (isset($trip_id) ? $trip_id : ''));?>" readonly />
    <?

    echo "<strong>Trip Number ". $trip_id. ":</strong> ";
    $form_input = array('name' => 'trav_auth', 'id' => 'trav_auth', 'maxlength' => '8', 'size' => '10', 'value' => set_value('trav_auth', (isset($trav_auth) ? $trav_auth : '')));
    echo form_input($form_input);
	?>
	<script type="text/javascript">
		var trav_auth = new LiveValidation('trav_auth', { validMessage: '\u2713', wait: 500});
		trav_auth.add( Validate.Presence, {failureMessage: "Must add an Travel Authorization Number!"});
		tave_auth.add( Validate.Length, {minimum: 7, maximum: 8 });
		trav_auth.add( Validate.Format, { pattern: /\d*/i, failureMessage: "Travel Authorization is 8 numbers." });
	</script> 
	<?
    echo "<br /><br /><strong>Trip Name:</strong> ". $trip_name;

    echo "<br /><br />";
    echo form_submit('submit', 'Modify');
    ?>
    <input type="button" value="Cancel" onclick="location.href='<? echo base_url("index.php/triplist/dtcview"); ?>';" />
    <?
    echo form_fieldset_close();
    echo form_close();
    ?>
</div>