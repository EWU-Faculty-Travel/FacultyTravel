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
 * Created: 2013-08-24
 * Last Edited: 2013-08-31
*/?>
<div class="loadedContent content" id="content">
    <?
    echo "<center><h2>Modify Index Codes</h2></center>";

    echo form_open('triplist/modifyIndexCodes');
    echo form_fieldset('Index Codes');
    ?>
    <input type="hidden" name="return_to" id="return_to" value="<? echo set_value('return_to', (isset($return_to) ? $return_to : 1)); ?>" readonly />
    <input type="hidden" name="trip_id" id="trip_id" value="<? echo set_value('trip_id', (isset($trip_id) ? $trip_id : ''));?>" readonly />
    <?

    echo "<strong>Trip Number ". $trip_id. "</strong> <br />";
    echo "<br /><strong>Estimated Trip Total</strong><br />$";
	
	$box_6 = 0;
	
	// initialize form values
	if (!isset($box_6_total))
		$box_6 = 0;
	else
		$box_6 = $box_6_total;
	
	if (!isset($percent_0))
		$percent_0  = 0;
		
	if (!isset($percent_1))
		$percent_1 = 0;
		
	if (!isset($percent_2))
		$percent_2 = 0;
	
	$p_total = $percent_0 + $percent_1 + $percent_2;
	
	if (!isset($amount_0))
		$amount_0 = 0;
		
	if (!isset($amount_1))
		$amount_1 = 0;
		
	if (!isset($amount_2))
		$amount_2 = 0;
		
	$a_total = $amount_0 + $amount_1 + $amount_2;
	
    $form_input = array('name' => 'box_6_total', 'id' => 'box_6_total', 'maxlength' => '8', 'size' => '8', 'readonly' => 'readonly', 'value' => number_format($box_6, 2));
    echo form_input($form_input);
    echo " <br/ ><br /><strong>Page Total</strong><br />$";
    $form_input = array('name' => 'page_total', 'id' => 'page_total', 'maxlength' => '8', 'size' => '8', 'readonly' => 'readonly', 'value' => set_value('page_total', (isset($page_total) ? $page_total : '0.00')));
    echo form_input($form_input);
	
	echo " Percentage discrepency: ";
	
	if ($box_6 == 0)
	{
		if ($a_total == 0) {
			$discrepency = 0;
		}
		else {
			$discrepency = $a_total;
		}
	}
	else {
		$discrepency = ($a_total/$box_6 * 100) - 100;
	}
	$form_input = array('name' => 'diff', 'id' => 'diff', 'maxlength' => '7', 'size' => '8', 'readonly' => 'readonly', 'value' => number_format($discrepency, 2));
	echo form_input($form_input);
	
	?>
	<br /><br />Ensure that your trip costs have been accounted for by entering the specific amount(s) covered by budget index code(s) or the percentage covered by index code(s).
	<?
	if ($a_total != $box_6)
	{
		echo "<font color=red><br /><br />There is a discepency between the estimated trip total and current amounts entered into the budget matrix. Please account for 100% of the estimated trip cost by ";
		echo "adjusting the matrix below.</font><br /><br />";
	}
	
    $this->table->set_heading('Index Codes:', 'Percent:', 'Amount:');
	
    $this->table->add_row('<input id = "index_code_0" name = "index_code_0" class = "index_code_0" type = "text" size = "8" maxlength = "6" value ="'.set_value('index_code_0', (isset($index_code_0) ? $index_code_0 : '')).'" />', '<input id = "percent_0" name = "percent_0" class = "percent_0" type = "text" size = "8" value ="'. number_format($percent_0, 2). '" />', '$<input id = "amount_0" name = "amount_0" class = "amount_0" type = "text" size = "8" value ="'. number_format($amount_0, 2). '" />');
    $this->table->add_row('<input id = "index_code_1" name = "index_code_1" class = "index_code_1" type = "text" size = "8" maxlength = "6" value ="'.set_value('index_code_1', (isset($index_code_1) ? $index_code_1 : '')).'" />', '<input id = "percent_1" name = "percent_1" class = "percent_1" type = "text" size = "8" value ="'. number_format($percent_1, 2). '" />', '$<input id = "amount_1" name = "amount_1" class = "amount_1" type = "text" size = "8" value ="'. number_format($amount_1, 2). '" />');
    $this->table->add_row('<input id = "index_code_2" name = "index_code_2" class = "index_code_2" type = "text" size = "8" maxlength = "6" value ="'.set_value('index_code_2', (isset($index_code_2) ? $index_code_2 : '')).'" />', '<input id = "percent_2" name = "percent_2" class = "percent_2" type = "text" size = "8" value ="'. number_format($percent_2, 2). '" />', '$<input id = "amount_2" name = "amount_2" class = "amount_2" type = "text" size = "8" value ="'. number_format($amount_2, 2). '" />');
    $this->table->add_row('<strong>Totals:</strong> ', '<input id = "percent_total" name = "percent_total" class = "percent_total" type = "text" size = "8" value ="'. number_format($p_total, 2). '" readonly />', '$<input id = "amount_total" name = "amount_total" class = "amount_total" type = "text" size = "8" value ="'. number_format($a_total, 2). '" readonly />');

    echo $this->table->generate();
    ?>
    <script type="text/javascript">
		
		var box6 = 0.0;
		var trip_total = 1;
		var page = 0.0;
		var diff = 0.0;
	
        $(document).on("change", "input[class = 'amount_0']", function() {

			box6 = parseFloat($("#box_6_total").val());
			trip_total = 1;
			
			if (box6 === 0)
			{
				box6 = 1;
				trip_total = 0;
            }
			
			if (trip_total != 0)
			{
				$("input[class = 'amount_0']").each(function(){
					$("#percent_0").val(parseFloat((+$("#amount_0").val() / box6) * 100).toFixed(2));
				});
			}
			else
			{
				$("#percent_0").val("0.00")
			}
            $("#page_total").val(parseFloat(+$("#amount_0").val() + +$("#amount_1").val() + +$("#amount_2").val()).toFixed(2));
            $("#amount_total").val(parseFloat(+$("#amount_0").val() + +$("#amount_1").val() + +$("#amount_2").val()).toFixed(2));
            $("#percent_total").val(parseFloat(+$("#percent_0").val() + +$("#percent_1").val() + +$("#percent_2").val()).toFixed(2));
						
			page = parseFloat($("#amount_total").val());
			diff = 0;
			
			// determine the percentage discrepancy between page total and trip cost total
			if (page === 0)
			{
				diff = 0;
			}
			else
			{
				if (trip_total === 1)
				{
					diff = (page/box6 * 100) - 100;
				}
				else
				{
					diff = page;
				}
			}

			$("#diff").val(diff.toFixed(0));
			$("#amount_0").val(parseFloat($("#amount_0").val()).toFixed(2));
			
        });

        $(document).on("change", "input[class = 'amount_1']", function() {
			
			box6 = parseFloat($("#box_6_total").val());
			trip_total = 1;
			
			if (box6 === 0)
			{
				box6 = 1;
				trip_total = 0;
            }
			
			if (trip_total != 0)
			{
				$("input[class = 'amount_1']").each(function(){
					$("#percent_1").val(parseFloat((+$("#amount_1").val() / +$("#box_6_total").val()) * 100).toFixed(2));
				});
			}
			else
			{
				$("#percent_1").val("0.00")
			}
			
            $("#page_total").val(parseFloat(+$("#amount_0").val() + +$("#amount_1").val() + +$("#amount_2").val()).toFixed(2));
            $("#amount_total").val(parseFloat(+$("#amount_0").val() + +$("#amount_1").val() + +$("#amount_2").val()).toFixed(2));
            $("#percent_total").val(parseFloat(+$("#percent_0").val() + +$("#percent_1").val() + +$("#percent_2").val()).toFixed(2));

			page = parseFloat($("#amount_total").val());
			diff = 0;
			
			// determine the percentage discrepancy between page total and trip cost total
			if (page === 0)
			{
				diff = 0;
			}
			else
			{
				if (trip_total === 1)
				{
					diff = (page/box6 * 100) - 100;
				}
				else
				{
					diff = page;
				}
			}

			$("#diff").val(diff.toFixed(0));
			$("#amount_1").val(parseFloat($("#amount_1").val()).toFixed(2));
        });

        $(document).on("change", "input[class = 'amount_2']", function() {

			box6 = parseFloat($("#box_6_total").val());
			trip_total = 1;
			
			if (box6 === 0)
			{
				box6 = 1;
				trip_total = 0;
            }
			
			if (trip_total != 0)
			{
				$("input[class = 'amount_2']").each(function(){
					$("#percent_2").val(parseFloat((+$("#amount_2").val() / +$("#box_6_total").val()) * 100).toFixed(2));
				});
			}
			else
			{
				$("#amount_2").val("0.00")
			}
            
			$("#page_total").val(parseFloat(+$("#amount_0").val() + +$("#amount_1").val() + +$("#amount_2").val()).toFixed(2));
            $("#amount_total").val(parseFloat(+$("#amount_0").val() + +$("#amount_1").val() + +$("#amount_2").val()).toFixed(2));
            $("#percent_total").val(parseFloat(+$("#percent_0").val() + +$("#percent_1").val() + +$("#percent_2").val()).toFixed(2));

			page = parseFloat($("#amount_total").val());
			diff = 0;
			
			// determine the percentage discrepancy between page total and trip cost total
			if (page === 0)
			{
				diff = 0;
			}
			else
			{
				if (trip_total === 1)
				{
					diff = (page/box6 * 100) - 100;
				}
				else
				{
					diff = page;
				}
			}

			$("#diff").val(diff.toFixed(0));
			$("#amount_2").val(parseFloat($("#amount_2").val()).toFixed(2));
			
        });

        $(document).on("change", "input[class = 'percent_0']", function() {

			box6 = parseFloat($("#box_6_total").val());
			trip_total = 1;
			
			if (box6 === 0)
			{
				box6 = 1;
				trip_total = 0;
            }
			
			$("input[class = 'percent_0']").each(function(){
				$("#amount_0").val(parseFloat((+$("#percent_0").val() / 100) * +$("#box_6_total").val()).toFixed(2));
			});
			
			$("#page_total").val(parseFloat(+$("#amount_0").val() + +$("#amount_1").val() + +$("#amount_2").val()).toFixed(2));
            $("#percent_total").val(parseFloat(+$("#percent_0").val() + +$("#percent_1").val() + +$("#percent_2").val()).toFixed(2));
            $("#amount_total").val(parseFloat(+$("#amount_0").val() + +$("#amount_1").val() + +$("#amount_2").val()).toFixed(2));
			
			page = parseFloat($("#amount_total").val());
			diff = 0;
			
			// determine the percentage discrepancy between page total and trip cost total
			if (page === 0)
			{
				diff = 0;
			}
			else
			{
				if (trip_total === 1)
				{
					diff = (page/box6 * 100) - 100;
				}
				else
				{
					diff = page;
				}
			}

			$("#diff").val(diff.toFixed(0));
			$("#percent_0").val(parseFloat($("#percent_0").val()).toFixed(2));
        });

        $(document).on("change", "input[class = 'percent_1']", function() {
		
			box6 = parseFloat($("#box_6_total").val());
			trip_total = 1;
			
			if (box6 === 0)
			{
				box6 = 1;
				trip_total = 0;
            }
			
			$("input[class = 'percent_0']").each(function(){
				$("#amount_0").val(parseFloat((+$("#percent_0").val() / 100) * +$("#box_6_total").val()).toFixed(2));
			});
			
            $("input[class = 'percent_1']").each(function(){
                $("#amount_1").val(parseFloat((+$("#percent_1").val() / 100) * +$("#box_6_total").val()).toFixed(2));
            });

			$("#page_total").val(parseFloat(+$("#amount_0").val() + +$("#amount_1").val() + +$("#amount_2").val()).toFixed(2));
            $("#percent_total").val(parseFloat(+$("#percent_0").val() + +$("#percent_1").val() + +$("#percent_2").val()).toFixed(2));
            $("#amount_total").val(parseFloat(+$("#amount_0").val() + +$("#amount_1").val() + +$("#amount_2").val()).toFixed(2));

			page = parseFloat($("#amount_total").val());
			diff = 0;
			
			// determine the percentage discrepancy between page total and trip cost total
			if (page === 0)
			{
				diff = 0;
			}
			else
			{
				if (trip_total === 1)
				{
					diff = (page/box6 * 100) - 100;
				}
				else
				{
					diff = page;
				}
			}

			$("#diff").val(diff.toFixed(0));
			$("#percent_1").val(parseFloat($("#percent_1").val()).toFixed(2));
			
        });

        $(document).on("change", "input[class = 'percent_2']", function() {
			
			box6 = parseFloat($("#box_6_total").val());
			trip_total = 1;
			
			if (box6 === 0)
			{
				box6 = 1;
				trip_total = 0;
            }
            $("input[class = 'percent_2']").each(function(){
                $("#amount_2").val(parseFloat((+$("#percent_2").val() / 100) * +$("#box_6_total").val()).toFixed(2));
            });

			$("#page_total").val(parseFloat(+$("#amount_0").val() + +$("#amount_1").val() + +$("#amount_2").val()).toFixed(2));
            $("#percent_total").val(parseFloat(+$("#percent_0").val() + +$("#percent_1").val() + +$("#percent_2").val()).toFixed(2));
            $("#amount_total").val(parseFloat(+$("#amount_0").val() + +$("#amount_1").val() + +$("#amount_2").val()).toFixed(2));

			page = parseFloat($("#amount_total").val());
			diff = 0;
			
			// determine the percentage discrepancy between page total and trip cost total
			if (page === 0)
			{
				diff = 0;
			}
			else
			{
				if (trip_total === 1)
				{
					diff = (page/box6 * 100) - 100;
				}
				else
				{
					diff = page;
				}
			}

			$("#diff").val(diff.toFixed(0));
			$("#percent_2").val(parseFloat($("#percent_2").val()).toFixed(2));
        });

		//live validation
		var d = new LiveValidation('diff', { validMessage: '\u2713', wait: 500});
		d.add( Validate.Numericality, { is: 0 } );

		var code0 = new LiveValidation('index_code_0', { validMessage: '\u2713', wait: 500});
		code0.add( Validate.Length, { maximum: 6 } );

		var code1 = new LiveValidation('index_code_1', { validMessage: '\u2713', wait: 500});
		code1.add( Validate.Length, { maximum: 6 } );

		var code2 = new LiveValidation('index_code_2', { validMessage: '\u2713', wait: 500});
		code2.add( Validate.Length, { maximum: 6 } );
		
	/*	var p0 = new LiveValidation('percent_0', {validMessage: '', wait: 500} );
		p0.add (Validate.Numericality, { minimum: 0} );

	/*	var p1 = new LiveValidation('percent_1', {} validMessage: '', wait: 500);
		p1.add (Validate.Numericality, { minimum: 0} );
		
		var p2 = new LiveValidation('percent_2', {} validMessage: '', wait: 500);
		p2.add (Validate.Numericality, { minimum: 0} );
		
		var a0 = new LiveValidation('amount_0', {} validMessage: '', wait: 500);
		a0.add (Validate.Numericality, { minimum: 0} );

		var a1 = new LiveValidation('amount_1', {} validMessage: '', wait: 500);
		a1.add (Validate.Numericality, { minimum: 0} );

		var a2 = new LiveValidation('amount_2', {} validMessage: '', wait: 500);
		a2.add (Validate.Numericality, { minimum: 0} );*/
</script>
    <?
    echo "<br /><br /><strong>Trip Name:</strong> ". $trip_name;

    echo "<br /><br />";
    echo form_submit('submit', 'Modify');
    ?>
	    <input type="button" value="Cancel" onclick="location.href='<? echo (isset($return_to) ? ($return_to == 1 ? base_url("index.php/triplist/view") : base_url("index.php/triplist/dtcview")) : base_url("index.php/triplist/view")); ?>';" />
    <?
    echo form_fieldset_close();
    echo form_close();
    ?>
</div>