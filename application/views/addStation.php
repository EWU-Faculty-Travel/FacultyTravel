<?
/* View/addStation
 *
 * Allows the user to add stations 
 * 
 * LiveValidation (http://http://livevalidation.com/) javascript library is used for 
 * form field validation before submission but is loaded in the header template.
 *
 * Author: Jason Helms, Josh Smith
 *
 * Created: 2013-07 
 * Last Edited: 2013-08-29
*/
?>
<div class="content loadedContent" id="content">
		<?
			echo form_open('stationEdit/addStation');
			echo form_fieldset('Add A Station');
			//Id

		?><a class="tooltip" href="#">Station Name:<span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" /><em>Station Name: </em>The name of the station (example: EWU, Riverpoint etc.).</span></a>&nbsp;&nbsp;&nbsp;<?
		$form_input= array('name' => 'stationName', 'id' => 'stationName','maxlength' => '50', 'size' => '25',);
		echo form_input($form_input);
		?>
		<script type="text/javascript">
			var stationName = new LiveValidation('stationName', { validMessage: '\u2713', wait: 500});
			stationName.add(Validate.Presence, {failureMessage: "A station name is required!"});
		</script><?php		
		echo "<br /><br />";
		?><a class="tooltip" href="#">Station Location:<span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" /><em>Station Location: </em>The city and state code where the station is located (example: Cheney, WA).</span></a><?
		$form_input= array('name' => 'stationValue', 'id' => 'stationValue','maxlength' => '50', 'size' => '25',);
		echo form_input($form_input);
		echo "<br /><br />";
		?>
		<script type="text/javascript">
			var stationValue = new LiveValidation('stationValue', { validMessage: '\u2713', wait: 500});
			stationValue.add(Validate.Presence, {failureMessage: "You must entere a location for the station!"});
		</script>
		<?
		echo form_submit('submit', 'Add Station');
		?>
		<input type="button" value="Cancel" onclick="location.href='<? echo base_url("index.php/dashboard/view"); ?>';" />
		<?

		echo form_fieldset_close();
		echo form_close();
		?>
</div>