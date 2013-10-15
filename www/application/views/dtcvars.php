<?
/* Views/dtcvars
 *
 * View provides a specific form to display (and allow editing of)
 * a particular departments variables. View is loaded once per
 * department that a user a DTC for.
 *
 * CURRENTLY DISABLED IN SYSTEM (2013-7-27 Josh Smith)
 *
 * Author: Reid Fortier, Josh Smith
 *
 * Created: 2013-05 
 * Last Edited: 2013-07-27
*/
?>	
<div class="content loadedContent" id="content">
<?
	echo form_open('systemvariables/dtcUpdate');
	echo form_fieldset();
	echo "<legend>Department Variables - "; echo $dept->dept_code; echo "</legend>";
	//Hidden form id: determines the dept updated when form is submitted from a collection of dept var forms
	echo form_hidden('form_id', $dept->dept_code);
	
	//Allow Personal Car
	echo "Allow Personal Car? ";
	if ($dept->allow_personal_car == 1) {
		$form_input = array('name' => 'personalcar', 'id' => 'personalcar', 'checked' => TRUE,);
	} 
	else 
	{
		$form_input = array('name' => 'personalcar', 'id' => 'personalcar', 'checked' => FALSE,);
	}
	echo form_checkbox($form_input);
	echo "<br />Allow Box 8? ";

	if ($dept->allow_box_8 == 1) 
	{
		$form_input = array('name' => 'boxeight', 'id' => 'boxeight', 'checked' => TRUE,);
	} 
	else 
	{
		$form_input = array('name' => 'boxeight', 'id' => 'boxeight', 'checked' => FALSE,);
	}
	
	echo form_checkbox($form_input);

	//Submit button
	echo "<br />";
	echo form_submit('submit', 'Save Changes');
	?>
	<input type="button" value="Cancel" onclick="location.href='<? echo base_url("index.php/dashboard/view"); ?>';" />
	<?
	echo form_fieldset_close();
	echo form_close();

	if($success == 3) //Profile saved
	{
		echo "<center><h3> Changes Saved!</h3></center>";
	}
//Close the div for the view:
?>
</div>