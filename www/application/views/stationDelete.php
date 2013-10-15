<?
/* View/stationDelete
 *
 * Allows the user to delete stations 
 * 
 * LiveValidation (http://http://livevalidation.com/) javascript library is used for 
 * form field validation before submission but is loaded in the header template.
 *
 * Author: Jason Helms, Josh Smith
 *
 * Created: 2013-07 
 * Last Edited: 2013-08-28
*/
?>
<div class="content loadedContent" id="content">
<?
	echo form_open('stationEdit/setCurrent');
	echo form_fieldset('Delete A Station');

	$query = $this->station_edit->databaseQuery();
	$counter = 1;

	if ($query->num_rows() > 0)
	{
		$options = array();
		foreach ($query->result_array() as $row)
		{
			$options[$row['station_id']] = $row['station_name'];
		}
		
		?>
		Select a station to delete from the system (this cannot be undone):<br />
		<?
		echo form_dropdown('kill_station_id', $options);
		?>
		<br /><br />
		Select a default station for all users at the station you intend to delete:<br />
		<?
		echo form_dropdown('def_station_id', $options);
	}
	else
	{
		echo "No stations in system.";
	}
	
	
	echo "<br /><br />";
	echo form_hidden('counter', $counter);
	echo form_submit('submit', 'Delete');
?>
	<input type="button" value="Cancel" onclick="location.href='<? echo base_url("index.php/dashboard/view"); ?>';" />
<?
	echo form_close();
?>
</div>