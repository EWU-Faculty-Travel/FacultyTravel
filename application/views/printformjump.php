<?
/* View/printformsjump
 *
 * 
 *
 * Author: Jason Helms, Josh Smith
 *
 * Created: 08/13/13
 * Last Edited: 08/28/13
*/?>
<div class="loadedContent content" id="content">
    <?
    echo "<center><h2>Print a form!</h2></center>";

    echo form_open('triplist/printaform');
	echo form_fieldset('Print Form');
    ?>
    <input type="hidden" name="return_to" id="return_to" value="<? echo $return_to; ?>" readonly />
	<input type="hidden" name="trip_id" id="trip_id" value="<? echo set_value('trip_id', (isset($trip_id) ? $trip_id : ''));?>" readonly />
    <?
    echo "<a href=".base_URL()."index.php/printforms/view target=\"_blank\">Print Friendly Form</a>";
	echo "<br />";
	$this->print_form->setDBTripID($trip_id);
	$indexTotal = $this->print_form->get_IndexTotalAmount();
	$boxSix = $this->print_form->get_Total();

	echo "<br />";
	if(($indexTotal != $boxSix) && ($return_to == 1))
	{
		echo "<font color=red><br /><br />There is a discepency between the estimated trip total and current amounts entered into the budget matrix. Please account for 100% of the estimated trip cost by ";
		echo "selecting 'Modify Index Codes' from the 'Saved Trips' option. </font><br /><br />";
	}
	else if(($indexTotal != $boxSix) && ($return_to == 2))
	{
		echo "<font color=red><br /><br />There is a discepency between the estimated trip total and current amounts entered into the budget matrix. Please account for 100% of the estimated trip cost by ";
		echo "selecting 'Modify Index Codes' from the 'All Trips' option. </font><br /><br />";
	}
	echo "<br />";
    ?>
    <input type="button" value="Back" onclick="location.href='<? if ($return_to == 1)
																	{
																		echo base_url("index.php/triplist/view");
																	}
																	else
																	{
																		echo base_url("index.php/triplist/dtcview"); 
																	}?>';" />
    <?
	echo form_fieldset_close();
    echo form_close();
    ?>
</div>