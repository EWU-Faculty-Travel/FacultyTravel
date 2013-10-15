<?
/* View/ConfirmDeleteTrip
 *
 * Allows the user to confirm they wish to delete a specific trip 
 *
 * Author: Josh Smith, Reid Fortier
 *
 * Created: 2013-08-18
 * Last Edited: 2013-08-20
*/?>
<div class="loadedContent content" id="content">
<?
	echo "<center><h2>Confirm Delete Trip</h2></center>";

	foreach ($trip->result_array() as $row)
	{
		$trip_id = $row['trip_id'];
		$trip_name = $row['trip_name'];
	}
	
	echo form_open('triplist/deleteTrip');
	echo form_fieldset('Confirm Delete Trip');
	?>
    <input type="hidden" name="return_to" id="return_to" value="<?echo set_value('return_to', (isset($return_to) ? $return_to : 1)); ?>" readonly />
	<input type="hidden" name="trip_id" id="trip_id" value="<?echo $trip_id;?>" readonly />
	
	Do you really want to delete <strong>Trip #<? echo $trip_id;?> (<?echo $trip_name;?>)
	</strong> from the system?<br /> This action cannot be undone.<br /><br />

	<input type="checkbox" name="confirm" id="confirm" value="Yes" />
	
	Yes, I truly want to remove <strong>Trip #<? echo $trip_id;?></strong> from the system.
	<script type="text/javascript">
		var confirm = new LiveValidation('confirm', { validMessage: '\u2713', wait: 500});
		confirm.add( Validate.Acceptance );
	</script>
	<?

	echo "<br /><br />";
	echo form_submit('submit', 'Delete Trip');
?>
	<input type="button" value="Cancel" onclick="location.href='<? echo ($return_to == 1 ? base_url("index.php/triplist/view") : base_url("index.php/triplist/dtcview")); ?>';" />
<?
	echo form_fieldset_close();
	echo form_close();
	?>
</div>