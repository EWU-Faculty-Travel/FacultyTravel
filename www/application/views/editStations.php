<?php
/* View/editStations
 *
 * Allows the user to edit stations and their values. 
 * 
 * LiveValidation (http://http://livevalidation.com/) javascript library is used for 
 * form field validation before submission but is loaded in the header template.
 *
 * Author: Josh Smith
 *
 * Created: 2013-08-08
 * Last Edited: 2013-08-29
*/
?>
<div class="content loadedContent" id="content">
<?
	echo form_open('stationEdit/saveStations');
	echo form_fieldset('Edit Stations');
	
	echo "<font color=red>";
	
	if ($success == 1)
	{
		echo "<h2><center>Station could not be deleted!</center></h2>";
	}

	echo "</font>";
	
	$query = $this->station_edit->databaseQuery();
	$counter = 1;
			
	// display all entry boxes:
	foreach($query->result() as $row)
	{
		if(!empty($row))
		{
			if ($counter != 1)
			{
				echo "<br />";
			}
						
			?>
			<input type="hidden" name="station_id<?echo $counter;?>" id="station_id<?echo $counter;?>" value="<?echo $row->station_id;?>"readonly />
			
			<?
			$station_name = 'station'.$counter;
			$form_input = array('name' => $station_name, 'id' => $station_name, 'value' => $row->station_name, 'size' => '35', 'maxlength' =>'50');
			?>
			Name: 
			<?
			echo form_input($form_input);
			
			$station_value = 'value'.$counter;
			$form_input = array('name' => $station_value, 'id' => $station_value, 'value' => $row->station_value, 'size' => '25', 'maxlength' =>'30');
								
			?>
			<script type="text/javascript">
				var <? echo $station_name; ?> = new LiveValidation('<? echo $station_name; ?>', { validMessage: '\u2713', wait: 500});
				<? echo $station_name; ?>.add(Validate.Presence, {failureMessage: "A station name is required!"});
			</script>
			Value: 
			<?
			echo form_input($form_input);
			?>
			<script type="text/javascript">
				var <? echo $station_value; ?> = new LiveValidation('<? echo $station_value; ?>', { validMessage: '\u2713', wait: 500});
				<? echo $station_value; ?>.add(Validate.Presence, {failureMessage: "A station location is required!"});
			</script>
			<?
			echo "<br />";
		}
		else
		{
			echo "NO STATIONS.";
		}			
		$counter++;
	}

	echo "<br />";
	//echo form_hidden('counter', $counter);
	?>
	<input type="hidden" name="counter" id="counter" value="<?echo $counter;?>" readonly />
	<?
	echo form_submit('submit', 'Modify Stations');
	?>
	<input type="button" value="Cancel" onclick="location.href='<? echo base_url("index.php/dashboard/view"); ?>';" />
	<?

	echo form_close();
	
	?>
</div>