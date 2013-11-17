<?
/* View/PostTrip
 *
 * Saves the post trip data to the database
 *
 * Author: Reid Fortier, Josh Smith
 *
 * Created: 2013-08-22
 * Last Edited: 2013-08-29
*/
?>
<div class="loadedContent content">
<?
	echo "<font color=red>";
    if($success == 1) //Trip saved
    {
        echo "<center><h3> Trip Saved!</h3></center>";
    } else if ($success == 2) //Trip not saved
    {
        echo "<center><h3>Error detected, fix and resubmit</h3></center>";
        echo validation_errors();
    }

	echo "</font>";

    $b_hr = FALSE;

    echo "<center><h2>", $body_title, "</h2></center>";

	if(isset($return_to))
	{
		if ($return_to == 2)
		{
			echo "<font color=red><center><h3> Trip for ";
			echo $trip_owner.'<br/>
			with Trip ID: '.$trip_id.'<br/>';
			$trip_name = $this->pretrip_model->getTripName($trip_id);
			echo 'Trip Name: '.$trip_name.'<br/>'; 
			$authorization_number_query = $this->pretrip_model->travelAuthorizationNumberDatabaseQuery($trip_id);
			echo 'Trip Authorization: '.$authorization_number_query->row(0)->authorization;
			echo "</h3></center></font>";
		}
	}

    echo form_open('posttrip/save');
    echo form_fieldset('Required Fields');

    ?>
    <input type="hidden" name="return_to" id="return_to" value="<? echo $return_to; ?>" readonly />
    <input type="hidden" name="trip_id" id="trip_id" value="<? echo $trip_id; ?>" readonly />
    <?

    //Per Deim
    ?>
    <script type="text/javascript">
    $(function() {
        $('#per_deim_date_0').datepicker();
        var perDeimDate0 = $('#per_deim_date_0');
        var perDeimDeparture0 = $('#per_deim_departure_0');
        var perDeimArrival0 = $('#per_deim_arrival_0');

            perDeimDeparture0.timepicker({
                timeFormat: 'hh:mm tt',
                stepMinute: 15,
                addSliderAcces: true,
                sliderAccessArgs: {touchonly: false},
                onClose: function(dateText, inst) {
                    if (perDeimArrival0.val() != '') {
                        var testStartDate = perDeimDeparture0.timepicker('getDate');
                        var testEndDate = perDeimArrival0.timepicker('getDate');
                        if (testStartDate > testEndDate)
                            perDeimArrival0.timepicker('setDate', testStartDate);
                    }
                    else {
                        perDeimArrival0.val(dateText);
                    }
                }
            });
            perDeimArrival0.timepicker({
                timeFormat: 'hh:mm tt',
                stepMinute: 15,
                addSliderAcces: true,
                sliderAccessArgs: {touchonly: false},
                onClose: function(dateText, inst) {
                    if (perDeimDeparture0.val() != '') {
                        var testStartDate = perDeimDeparture0.timepicker('getDate');
                        var testEndDate = perDeimArrival0.timepicker('getDate');
                        if (testStartDate > testEndDate)
                            perDeimDeparture0.timepicker('setDate', testEndDate);
                    }
                    else {
                        perDeimDeparture0.val(dateText);
                    }
                }
            });

            $('#per_deim_date_1').datepicker();
            var perDeimDeparture1 = $('#per_deim_departure_1');
            var perDeimArrival1 = $('#per_deim_arrival_1');

            perDeimDeparture1.timepicker({
                timeFormat: 'hh:mm tt',
                stepMinute: 15,
                addSliderAcces: true,
                sliderAccessArgs: {touchonly: false},
                onClose: function(dateText, inst) {
                    if (perDeimArrival1.val() != '') {
                        var testStartDate = perDeimDeparture1.timepicker('getDate');
                        var testEndDate = perDeimArrival1.timepicker('getDate');
                        if (testStartDate > testEndDate)
                            perDeimArrival1.timepicker('setDate', testStartDate);
                    }
                    else {
                        perDeimArrival1.val(dateText);
                    }
                }
            });
            perDeimArrival1.timepicker({
                timeFormat: 'hh:mm tt',
                stepMinute: 15,
                addSliderAcces: true,
                sliderAccessArgs: {touchonly: false},
                onClose: function(dateText, inst) {
                    if (perDeimDeparture1.val() != '') {
                        var testStartDate = perDeimDeparture1.timepicker('getDate');
                        var testEndDate = perDeimArrival1.timepicker('getDate');
                        if (testStartDate > testEndDate)
                            perDeimDeparture1.timepicker('setDate', testEndDate);
                    }
                    else {
                        perDeimDeparture1.val(dateText);
                    }
                }
            });

            $('#per_deim_date_2').datepicker();
            var perDeimDeparture2 = $('#per_deim_departure_2');
            var perDeimArrival2 = $('#per_deim_arrival_2');

            perDeimDeparture2.timepicker({
                timeFormat: 'hh:mm tt',
                stepMinute: 15,
                addSliderAcces: true,
                sliderAccessArgs: {touchonly: false},
                onClose: function(dateText, inst) {
                    if (perDeimArrival2.val() != '') {
                        var testStartDate = perDeimDeparture2.timepicker('getDate');
                        var testEndDate = perDeimArrival2.timepicker('getDate');
                        if (testStartDate > testEndDate)
                            perDeimArrival2.timepicker('setDate', testStartDate);
                    }
                    else {
                        perDeimArrival2.val(dateText);
                    }
                }
            });
            perDeimArrival2.timepicker({
                timeFormat: 'hh:mm tt',
                stepMinute: 15,
                addSliderAcces: true,
                sliderAccessArgs: {touchonly: false},
                onClose: function(dateText, inst) {
                    if (perDeimDeparture2.val() != '') {
                        var testStartDate = perDeimDeparture2.timepicker('getDate');
                        var testEndDate = perDeimArrival2.timepicker('getDate');
                        if (testStartDate > testEndDate)
                            perDeimDeparture2.timepicker('setDate', testEndDate);
                    }
                    else {
                        perDeimDeparture2.val(dateText);
                    }
                }
            });

            $('#per_deim_date_3').datepicker();
            var perDeimDeparture3 = $('#per_deim_departure_3');
            var perDeimArrival3 = $('#per_deim_arrival_3');

            perDeimDeparture3.timepicker({
                timeFormat: 'hh:mm tt',
                stepMinute: 15,
                addSliderAcces: true,
                sliderAccessArgs: {touchonly: false},
                onClose: function(dateText, inst) {
                    if (perDeimArrival3.val() != '') {
                        var testStartDate = perDeimDeparture3.timepicker('getDate');
                        var testEndDate = perDeimArrival3.timepicker('getDate');
                        if (testStartDate > testEndDate)
                            perDeimArrival3.timepicker('setDate', testStartDate);
                    }
                    else {
                        perDeimArrival3.val(dateText);
                    }
                }
            });
            perDeimArrival3.timepicker({
                timeFormat: 'hh:mm tt',
                stepMinute: 15,
                addSliderAcces: true,
                sliderAccessArgs: {touchonly: false},
                onClose: function(dateText, inst) {
                    if (perDeimDeparture3.val() != '') {
                        var testStartDate = perDeimDeparture3.timepicker('getDate');
                        var testEndDate = perDeimArrival3.timepicker('getDate');
                        if (testStartDate > testEndDate)
                            perDeimDeparture3.timepicker('setDate', testEndDate);
                    }
                    else {
                        perDeimDeparture3.val(dateText);
                    }
                }
            });

            $('#per_deim_date_4').datepicker();
            var perDeimDeparture4 = $('#per_deim_departure_4');
            var perDeimArrival4 = $('#per_deim_arrival_4');

            perDeimDeparture4.timepicker({
                timeFormat: 'hh:mm tt',
                stepMinute: 15,
                addSliderAcces: true,
                sliderAccessArgs: {touchonly: false},
                onClose: function(dateText, inst) {
                    if (perDeimArrival4.val() != '') {
                        var testStartDate = perDeimDeparture4.timepicker('getDate');
                        var testEndDate = perDeimArrival4.timepicker('getDate');
                        if (testStartDate > testEndDate)
                            perDeimArrival4.timepicker('setDate', testStartDate);
                    }
                    else {
                        perDeimArrival4.val(dateText);
                    }
                }
            });
            perDeimArrival4.timepicker({
                timeFormat: 'hh:mm tt',
                stepMinute: 15,
                addSliderAcces: true,
                sliderAccessArgs: {touchonly: false},
                onClose: function(dateText, inst) {
                    if (perDeimDeparture4.val() != '') {
                        var testStartDate = perDeimDeparture4.timepicker('getDate');
                        var testEndDate = perDeimArrival4.timepicker('getDate');
                        if (testStartDate > testEndDate)
                            perDeimDeparture4.timepicker('setDate', testEndDate);
                    }
                    else {
                        perDeimDeparture4.val(dateText);
                    }
                }
            });

            $('#per_deim_date_5').datepicker();
            var perDeimDeparture5 = $('#per_deim_departure_5');
            var perDeimArrival5 = $('#per_deim_arrival_5');

            perDeimDeparture5.timepicker({
                timeFormat: 'hh:mm tt',
                stepMinute: 15,
                addSliderAcces: true,
                sliderAccessArgs: {touchonly: false},
                onClose: function(dateText, inst) {
                    if (perDeimArrival5.val() != '') {
                        var testStartDate = perDeimDeparture5.timepicker('getDate');
                        var testEndDate = perDeimArrival5.timepicker('getDate');
                        if (testStartDate > testEndDate)
                            perDeimArrival5.timepicker('setDate', testStartDate);
                    }
                    else {
                        perDeimArrival5.val(dateText);
                    }
                }
            });
            perDeimArrival5.timepicker({
                timeFormat: 'hh:mm tt',
                stepMinute: 15,
                addSliderAcces: true,
                sliderAccessArgs: {touchonly: false},
                onClose: function(dateText, inst) {
                    if (perDeimDeparture5.val() != '') {
                        var testStartDate = perDeimDeparture5.timepicker('getDate');
                        var testEndDate = perDeimArrival5.timepicker('getDate');
                        if (testStartDate > testEndDate)
                            perDeimDeparture5.timepicker('setDate', testEndDate);
                    }
                    else {
                        perDeimDeparture5.val(dateText);
                    }
                }
            });

            $('#per_deim_date_6').datepicker();
            var perDeimDeparture6 = $('#per_deim_departure_6');
            var perDeimArrival6 = $('#per_deim_arrival_6');

            perDeimDeparture6.timepicker({
                timeFormat: 'hh:mm tt',
                stepMinute: 15,
                addSliderAcces: true,
                sliderAccessArgs: {touchonly: false},
                onClose: function(dateText, inst) {
                    if (perDeimArrival6.val() != '') {
                        var testStartDate = perDeimDeparture6.timepicker('getDate');
                        var testEndDate = perDeimArrival6.timepicker('getDate');
                        if (testStartDate > testEndDate)
                            perDeimArrival6.timepicker('setDate', testStartDate);
                    }
                    else {
                        perDeimArrival6.val(dateText);
                    }
                }
            });
            perDeimArrival6.timepicker({
                timeFormat: 'hh:mm tt',
                stepMinute: 15,
                addSliderAcces: true,
                sliderAccessArgs: {touchonly: false},
                onClose: function(dateText, inst) {
                    if (perDeimDeparture6.val() != '') {
                        var testStartDate = perDeimDeparture6.timepicker('getDate');
                        var testEndDate = perDeimArrival6.timepicker('getDate');
                        if (testStartDate > testEndDate)
                            perDeimDeparture6.timepicker('setDate', testEndDate);
                    }
                    else {
                        perDeimDeparture6.val(dateText);
                    }
                }
            });

        });
        </script>
        <strong>Per Diem</strong><br /><br /><a class="tooltip" href="#">Per Diem Total:<span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" /><em>Per Diem</em>
            Enter your daily costs for breakfast, lunch, dinner and hotel in the table below. Also enter the start and end of your travel day. If your travel
            day begins after the breakfast period do not enter an estimate for the breakfast cost.</span></a> $
        <?
        $form_input = array('name' => 'pd_total', 'id' => 'pd_total', 'maxlength' => '8', 'size' => '8', 'readonly' => 'readonly', 'value' => set_value('per_deim_total', (isset($per_deim_total) ? $per_deim_total : '0.00')));
        echo form_input($form_input); //Needs to be filled

        $date = array('data' => 'Date:');
        $from = array('data' => 'From:');
        $departure = array('data' => 'Departure<br />Time:');
        $to = array('data' => 'To:');
        $arrival = array('data' => 'Arrival<br />Time:');
        $breakfast = array('data' => 'B');
        $lunch = array('data' => 'L');
        $dinner = array('data' => 'D');
        $hotel = array('data' => 'Hotel');
        $this->table->set_heading($date, $from, $departure, $to, $arrival, $breakfast, $lunch, $dinner, $hotel);

        if(isset($per_deim_date_0))
        {
            $time = strtotime($per_deim_date_0);
            $converted_per_deim_date_0 = date("m/d/Y", $time);
        }
        if(isset($per_deim_departure_0))
        {
            $time = strtotime($per_deim_dbamboo
pineapple
monkey
            		eparture_0);
            $converted_per_deim_departure_0 = date("h:i a", $time);
        }
        if(isset($per_deim_arrival_0))
        {
            $time = strtotime($per_deim_arrival_0);
            $converted_per_deim_arrival_0 = date("h:i a", $time);
        }
        $date = array('data' => "<input id='per_deim_date_0' name='per_deim_date_0' type='text' size = '11' value ='".set_value('per_deim_date_0', (isset($converted_per_deim_date_0) ? $converted_per_deim_date_0 : ''))."' />");
        $from = array('data' => "<input id='per_deim_from_0' name='per_deim_from_0' type='text' size = '15' value ='".set_value('per_deim_from_0', (isset($per_deim_from_0) ? $per_deim_from_0 : ''))."' />");
        $departure = array('data' => "<input id='per_deim_departure_0' name='per_deim_departure_0' type='text' size = '7' value ='".set_value('per_deim_departure_0', (isset($converted_per_deim_departure_0) ? $converted_per_deim_departure_0 : ''))."' />");
        $to = array('data' => "<input id='per_deim_to_0' name='per_deim_to_0' type='text' size = '15' value ='".set_value('per_deim_to_0', (isset($per_deim_to_0) ? $per_deim_to_0 : ''))."' />");
        $arrival = array('data' => "<input id='per_deim_arrival_0' name='per_deim_arrival_0' type='text' size = '7' value ='".set_value('per_deim_arrival_0', (isset($converted_per_deim_arrival_0) ? $converted_per_deim_arrival_0 : ''))."' />");
        $breakfast = array('data' => "<input id='per_deim_b_0' name='per_deim_b_0' type='text' size = '3' value ='".set_value('per_deim_b_0', (isset($per_deim_b_0) ? $per_deim_b_0 : ''))."' />");
        $lunch = array('data' => "<input id='per_deim_l_0' name='per_deim_l_0' type='text' size = '3' value ='".set_value('per_deim_l_0', (isset($per_deim_l_0) ? $per_deim_l_0 : ''))."' />");
        $dinner = array('data' => "<input id='per_deim_d_0' name='per_deim_d_0' type='text' size = '3' value ='".set_value('per_deim_d_0', (isset($per_deim_d_0) ? $per_deim_d_0 : ''))."' />");
        $hotel = array('data' => "<input id='per_deim_hotel_0' name='per_deim_hotel_0' type='text' size = '4' value ='".set_value('per_deim_hotel_0', (isset($per_deim_hotel_0) ? $per_deim_hotel_0 : ''))."' />");
        $this->table->add_row($date, $from, $departure, $to, $arrival, $breakfast, $lunch, $dinner, $hotel);

        if(isset($per_deim_date_1))
        {
            $time = strtotime($per_deim_date_1);
            $converted_per_deim_date_1 = date("m/d/Y", $time);
        }
        if(isset($per_deim_departure_1))
        {
            $time = strtotime($per_deim_departure_1);
            $converted_per_deim_departure_1 = date("h:i a", $time);
        }
        if(isset($per_deim_arrival_1))
        {
            $time = strtotime($per_deim_arrival_1);
            $converted_per_deim_arrival_1 = date("h:i a", $time);
        }
        $date = array('data' => "<input id='per_deim_date_1' name='per_deim_date_1' type='text' size = '11' value ='".set_value('per_deim_date_1', (isset($converted_per_deim_date_1) ? $converted_per_deim_date_1 : ''))."' />");
        $from = array('data' => "<input id='per_deim_from_1' name='per_deim_from_1' type='text' size = '15' value ='".set_value('per_deim_from_1', (isset($per_deim_from_1) ? $per_deim_from_1 : ''))."' />");
        $departure = array('data' => "<input id='per_deim_departure_1' name='per_deim_departure_1' type='text' size = '7' value ='".set_value('per_deim_departure_1', (isset($converted_per_deim_departure_1) ? $converted_per_deim_departure_1 : ''))."' />");
        $to = array('data' => "<input id='per_deim_to_1' name='per_deim_to_1' type='text' size = '15' value ='".set_value('per_deim_to_1', (isset($per_deim_to_1) ? $per_deim_to_1 : ''))."' />");
        $arrival = array('data' => "<input id='per_deim_arrival_1' name='per_deim_arrival_1' type='text' size = '7' value ='".set_value('per_deim_arrival_1', (isset($converted_per_deim_arrival_1) ? $converted_per_deim_arrival_1 : ''))."' />");
        $breakfast = array('data' => "<input id='per_deim_b_1' name='per_deim_b_1' type='text' size = '3' value ='".set_value('per_deim_b_1', (isset($per_deim_b_1) ? $per_deim_b_1 : ''))."' />");
        $lunch = array('data' => "<input id='per_deim_l_1' name='per_deim_l_1' type='text' size = '3' value ='".set_value('per_deim_l_1', (isset($per_deim_l_1) ? $per_deim_l_1 : ''))."' />");
        $dinner = array('data' => "<input id='per_deim_d_1' name='per_deim_d_1' type='text' size = '3' value ='".set_value('per_deim_d_1', (isset($per_deim_d_1) ? $per_deim_d_1 : ''))."' />");
        $hotel = array('data' => "<input id='per_deim_hotel_1' name='per_deim_hotel_1' type='text' size = '4' value ='".set_value('per_deim_hotel_1', (isset($per_deim_hotel_1) ? $per_deim_hotel_1 : ''))."' />");
        $this->table->add_row($date, $from, $departure, $to, $arrival, $breakfast, $lunch, $dinner, $hotel);

        if(isset($per_deim_date_2))
        {
            $time = strtotime($per_deim_date_2);
            $converted_per_deim_date_2 = date("m/d/Y", $time);
        }
        if(isset($per_deim_departure_2))
        {
            $time = strtotime($per_deim_departure_2);
            $converted_per_deim_departure_2 = date("h:i a", $time);
        }
        if(isset($per_deim_arrival_2))
        {
            $time = strtotime($per_deim_arrival_2);
            $converted_per_deim_arrival_2 = date("h:i a", $time);
        }
        $date = array('data' => "<input id='per_deim_date_2' name='per_deim_date_2' type='text' size = '11' value ='".set_value('per_deim_date_2', (isset($converted_per_deim_date_2) ? $converted_per_deim_date_2 : ''))."' />");
        $from = array('data' => "<input id='per_deim_from_2' name='per_deim_from_2' type='text' size = '15' value ='".set_value('per_deim_from_2', (isset($per_deim_from_2) ? $per_deim_from_2 : ''))."' />");
        $departure = array('data' => "<input id='per_deim_departure_2' name='per_deim_departure_2' type='text' size = '7' value ='".set_value('per_deim_departure_2', (isset($converted_per_deim_departure_2) ? $converted_per_deim_departure_2 : ''))."' />");
        $to = array('data' => "<input id='per_deim_to_2' name='per_deim_to_2' type='text' size = '15' value ='".set_value('per_deim_to_2', (isset($per_deim_to_2) ? $per_deim_to_2 : ''))."' />");
        $arrival = array('data' => "<input id='per_deim_arrival_2' name='per_deim_arrival_2' type='text' size = '7' value ='".set_value('per_deim_arrival_2', (isset($converted_per_deim_arrival_2) ? $converted_per_deim_arrival_2 : ''))."' />");
        $breakfast = array('data' => "<input id='per_deim_b_2' name='per_deim_b_2' type='text' size = '3' value ='".set_value('per_deim_b_2', (isset($per_deim_b_2) ? $per_deim_b_2 : ''))."' />");
        $lunch = array('data' => "<input id='per_deim_l_2' name='per_deim_l_2' type='text' size = '3' value ='".set_value('per_deim_l_2', (isset($per_deim_l_2) ? $per_deim_l_2 : ''))."' />");
        $dinner = array('data' => "<input id='per_deim_d_2' name='per_deim_d_2' type='text' size = '3' value ='".set_value('per_deim_d_2', (isset($per_deim_d_2) ? $per_deim_d_2 : ''))."' />");
        $hotel = array('data' => "<input id='per_deim_hotel_2' name='per_deim_hotel_2' type='text' size = '4' value ='".set_value('per_deim_hotel_2', (isset($per_deim_hotel_2) ? $per_deim_hotel_2 : ''))."' />");
		$this->table->add_row($date, $from, $departure, $to, $arrival, $breakfast, $lunch, $dinner, $hotel);

        if(isset($per_deim_date_3))
        {
            $time = strtotime($per_deim_date_3);
            $converted_per_deim_date_3 = date("m/d/Y", $time);
        }
        if(isset($per_deim_departure_3))
        {
            $time = strtotime($per_deim_departure_3);
            $converted_per_deim_departure_3 = date("h:i a", $time);
        }
        if(isset($per_deim_arrival_3))
        {
            $time = strtotime($per_deim_arrival_3);
            $converted_per_deim_arrival_3 = date("h:i a", $time);
        }
        $date = array('data' => "<input id='per_deim_date_3' name='per_deim_date_3' type='text' size = '11' value ='".set_value('per_deim_date_3', (isset($converted_per_deim_date_3) ? $converted_per_deim_date_3 : ''))."' />");
        $from = array('data' => "<input id='per_deim_from_3' name='per_deim_from_3' type='text' size = '15' value ='".set_value('per_deim_from_3', (isset($per_deim_from_3) ? $per_deim_from_3 : ''))."' />");
        $departure = array('data' => "<input id='per_deim_departure_3' name='per_deim_departure_3' type='text' size = '7' value ='".set_value('per_deim_departure_3', (isset($converted_per_deim_departure_3) ? $converted_per_deim_departure_3 : ''))."' />");
        $to = array('data' => "<input id='per_deim_to_3' name='per_deim_to_3' type='text' size = '15' value ='".set_value('per_deim_to_3', (isset($per_deim_to_3) ? $per_deim_to_3 : ''))."' />");
        $arrival = array('data' => "<input id='per_deim_arrival_3' name='per_deim_arrival_3' type='text' size = '7' value ='".set_value('per_deim_arrival_3', (isset($converted_per_deim_arrival_3) ? $converted_per_deim_arrival_3 : ''))."' />");
        $breakfast = array('data' => "<input id='per_deim_b_3' name='per_deim_b_3' type='text' size = '3' value ='".set_value('per_deim_b_3', (isset($per_deim_b_3) ? $per_deim_b_3 : ''))."' />");
        $lunch = array('data' => "<input id='per_deim_l_3' name='per_deim_l_3' type='text' size = '3' value ='".set_value('per_deim_l_3', (isset($per_deim_l_3) ? $per_deim_l_3 : ''))."' />");
        $dinner = array('data' => "<input id='per_deim_d_3' name='per_deim_d_3' type='text' size = '3' value ='".set_value('per_deim_d_3', (isset($per_deim_d_3) ? $per_deim_d_3 : ''))."' />");
        $hotel = array('data' => "<input id='per_deim_hotel_3' name='per_deim_hotel_3' type='text' size = '4' value ='".set_value('per_deim_hotel_3', (isset($per_deim_hotel_3) ? $per_deim_hotel_3 : ''))."' />");
        $this->table->add_row($date, $from, $departure, $to, $arrival, $breakfast, $lunch, $dinner, $hotel);

        if(isset($per_deim_date_4))
        {
            $time = strtotime($per_deim_date_4);
            $converted_per_deim_date_4 = date("m/d/Y", $time);
        }
        if(isset($per_deim_departure_4))
        {
            $time = strtotime($per_deim_departure_4);
            $converted_per_deim_departure_4 = date("h:i a", $time);
        }
        if(isset($per_deim_arrival_4))
        {
            $time = strtotime($per_deim_arrival_4);
            $converted_per_deim_arrival_4 = date("h:i a", $time);
        }
        $date = array('data' => "<input id='per_deim_date_4' name='per_deim_date_4' type='text' size = '11' value ='".set_value('per_deim_date_4', (isset($converted_per_deim_date_4) ? $converted_per_deim_date_4 : ''))."' />");
        $from = array('data' => "<input id='per_deim_from_4' name='per_deim_from_4' type='text' size = '15' value ='".set_value('per_deim_from_4', (isset($per_deim_from_4) ? $per_deim_from_4 : ''))."' />");
        $departure = array('data' => "<input id='per_deim_departure_4' name='per_deim_departure_4' type='text' size = '7' value ='".set_value('per_deim_departure_4', (isset($converted_per_deim_departure_4) ? $converted_per_deim_departure_4 : ''))."' />");
        $to = array('data' => "<input id='per_deim_to_4' name='per_deim_to_4' type='text' size = '15' value ='".set_value('per_deim_to_4', (isset($per_deim_to_4) ? $per_deim_to_4 : ''))."' />");
        $arrival = array('data' => "<input id='per_deim_arrival_4' name='per_deim_arrival_4' type='text' size = '7' value ='".set_value('per_deim_arrival_4', (isset($converted_per_deim_arrival_4) ? $converted_per_deim_arrival_4 : ''))."' />");
        $breakfast = array('data' => "<input id='per_deim_b_4' name='per_deim_b_4' type='text' size = '3' value ='".set_value('per_deim_b_4', (isset($per_deim_b_4) ? $per_deim_b_4 : ''))."' />");
        $lunch = array('data' => "<input id='per_deim_l_4' name='per_deim_l_4' type='text' size = '3' value ='".set_value('per_deim_l_4', (isset($per_deim_l_4) ? $per_deim_l_4 : ''))."' />");
        $dinner = array('data' => "<input id='per_deim_d_4' name='per_deim_d_4' type='text' size = '3' value ='".set_value('per_deim_d_4', (isset($per_deim_d_4) ? $per_deim_d_4 : ''))."' />");
        $hotel = array('data' => "<input id='per_deim_hotel_4' name='per_deim_hotel_4' type='text' size = '4' value ='".set_value('per_deim_hotel_4', (isset($per_deim_hotel_4) ? $per_deim_hotel_4 : ''))."' />");
        $this->table->add_row($date, $from, $departure, $to, $arrival, $breakfast, $lunch, $dinner, $hotel);

        if(isset($per_deim_date_5))
        {
            $time = strtotime($per_deim_date_5);
            $converted_per_deim_date_5 = date("m/d/Y", $time);
        }
        if(isset($per_deim_departure_5))
        {
            $time = strtotime($per_deim_departure_5);
            $converted_per_deim_departure_5 = date("h:i a", $time);
        }
        if(isset($per_deim_arrival_5))
        {
            $time = strtotime($per_deim_arrival_5);
            $converted_per_deim_arrival_5 = date("h:i a", $time);
        }
        $date = array('data' => "<input id='per_deim_date_5' name='per_deim_date_5' type='text' size = '11' value ='".set_value('per_deim_date_5', (isset($converted_per_deim_date_5) ? $converted_per_deim_date_5 : ''))."' />");
        $from = array('data' => "<input id='per_deim_from_5' name='per_deim_from_5' type='text' size = '15' value ='".set_value('per_deim_from_5', (isset($per_deim_from_5) ? $per_deim_from_5 : ''))."' />");
        $departure = array('data' => "<input id='per_deim_departure_5' name='per_deim_departure_5' type='text' size = '7' value ='".set_value('per_deim_departure_5', (isset($converted_per_deim_departure_5) ? $converted_per_deim_departure_5 : ''))."' />");
        $to = array('data' => "<input id='per_deim_to_5' name='per_deim_to_5' type='text' size = '15' value ='".set_value('per_deim_to_5', (isset($per_deim_to_5) ? $per_deim_to_5 : ''))."' />");
        $arrival = array('data' => "<input id='per_deim_arrival_5' name='per_deim_arrival_5' type='text' size = '7' value ='".set_value('per_deim_arrival_5', (isset($converted_per_deim_arrival_5) ? $converted_per_deim_arrival_5 : ''))."' />");
        $breakfast = array('data' => "<input id='per_deim_b_5' name='per_deim_b_5' type='text' size = '3' value ='".set_value('per_deim_b_5', (isset($per_deim_b_5) ? $per_deim_b_5 : ''))."' />");
        $lunch = array('data' => "<input id='per_deim_l_5' name='per_deim_l_5' type='text' size = '3' value ='".set_value('per_deim_l_5', (isset($per_deim_l_5) ? $per_deim_l_5 : ''))."' />");
        $dinner = array('data' => "<input id='per_deim_d_5' name='per_deim_d_5' type='text' size = '3' value ='".set_value('per_deim_d_5', (isset($per_deim_d_5) ? $per_deim_d_5 : ''))."' />");
        $hotel = array('data' => "<input id='per_deim_hotel_5' name='per_deim_hotel_5' type='text' size = '4' value ='".set_value('per_deim_hotel_5', (isset($per_deim_hotel_5) ? $per_deim_hotel_5 : ''))."' />");
        $this->table->add_row($date, $from, $departure, $to, $arrival, $breakfast, $lunch, $dinner, $hotel);

        if(isset($per_deim_date_6))
        {
            $time = strtotime($per_deim_date_6);
            $converted_per_deim_date_6 = date("m/d/Y", $time);
        }
        if(isset($per_deim_departure_6))
        {
            $time = strtotime($per_deim_departure_6);
            $converted_per_deim_departure_6 = date("h:i a", $time);
        }
        /*if(isset($per_deim_arrival_6))
        {
            $time = strtotime($per_deim_arrival_6);
            $converted_per_deim_arrival_6 = date("h:i a", $time);
        }
        $date = array('data' => "<input id='per_deim_date_6' name='per_deim_date_6' type='text' size = '11' value ='".set_value('per_deim_date_6', (isset($converted_per_deim_date_6) ? $converted_per_deim_date_6 : ''))."' />");
        $from = array('data' => "<input id='per_deim_from_6' name='per_deim_from_6' type='text' size = '15' value ='".set_value('per_deim_from_6', (isset($per_deim_from_6) ? $per_deim_from_6 : ''))."' />");
        $departure = array('data' => "<input id='per_deim_departure_6' name='per_deim_departure_6' type='text' size = '7' value ='".set_value('per_deim_departure_6', (isset($converted_per_deim_departure_6) ? $converted_per_deim_departure_6 : ''))."' />");
        $to = array('data' => "<input id='per_deim_to_6' name='per_deim_to_6' type='text' size = '15' value ='".set_value('per_deim_to_6', (isset($per_deim_to_6) ? $per_deim_to_6 : ''))."' />");
        $arrival = array('data' => "<input id='per_deim_arrival_6' name='per_deim_arrival_6' type='text' size = '7' value ='".set_value('per_deim_arrival_6', (isset($converted_per_deim_arrival_6) ? $converted_per_deim_arrival_6 : ''))."' />");
        $breakfast = array('data' => "<input id='per_deim_b_6' name='per_deim_b_6' type='text' size = '3' value ='".set_value('per_deim_b_6', (isset($per_deim_b_6) ? $per_deim_b_6 : ''))."' />");
        $lunch = array('data' => "<input id='per_deim_l_6' name='per_deim_l_6' type='text' size = '3' value ='".set_value('per_deim_l_6', (isset($per_deim_l_6) ? $per_deim_l_6 : ''))."' />");
        $dinner = array('data' => "<input id='per_deim_d_6' name='per_deim_d_6' type='text' size = '3' value ='".set_value('per_deim_d_6', (isset($per_deim_d_6) ? $per_deim_d_6 : ''))."' />");
        $hotel = array('data' => "<input id='per_deim_hotel_6' name='per_deim_hotel_6' type='text' size = '4' value ='".set_value('per_deim_hotel_6', (isset($per_deim_hotel_6) ? $per_deim_hotel_6 : ''))."' />");
        $this->table->add_row($date, $from, $departure, $to, $arrival, $breakfast, $lunch, $dinner, $hotel);*/

        echo $this->table->generate();
        ?>
        <script type="text/javascript">
        var perDeimSum = 0;
        $(document).on("change", "input[name *= 'per_deim_b_']", function() {

            perDeimSum = (parseFloat($("#per_deim_b_0").val()) || 0) + (parseFloat($("#per_deim_l_0").val()) || 0) + (parseFloat($("#per_deim_d_0").val()) || 0) + (parseFloat($("#per_deim_hotel_0").val()) || 0) +
						 (parseFloat($("#per_deim_b_1").val()) || 0) + (parseFloat($("#per_deim_l_1").val()) || 0) + (parseFloat($("#per_deim_d_1").val()) || 0) + (parseFloat($("#per_deim_hotel_1").val()) || 0) +
						 (parseFloat($("#per_deim_b_2").val()) || 0) + (parseFloat($("#per_deim_l_2").val()) || 0) + (parseFloat($("#per_deim_d_2").val()) || 0) + (parseFloat($("#per_deim_hotel_2").val()) || 0) +
						 (parseFloat($("#per_deim_b_3").val()) || 0) + (parseFloat($("#per_deim_l_3").val()) || 0) + (parseFloat($("#per_deim_d_3").val()) || 0) + (parseFloat($("#per_deim_hotel_3").val()) || 0) +
						 (parseFloat($("#per_deim_b_4").val()) || 0) + (parseFloat($("#per_deim_l_4").val()) || 0) + (parseFloat($("#per_deim_d_4").val()) || 0) + (parseFloat($("#per_deim_hotel_4").val()) || 0) +
						 (parseFloat($("#per_deim_b_5").val()) || 0) + (parseFloat($("#per_deim_l_5").val()) || 0) + (parseFloat($("#per_deim_d_5").val()) || 0) + (parseFloat($("#per_deim_hotel_5").val()) || 0) +
						 (parseFloat($("#per_deim_b_6").val()) || 0) + (parseFloat($("#per_deim_l_6").val()) || 0) + (parseFloat($("#per_deim_d_6").val()) || 0) + (parseFloat($("#per_deim_hotel_6").val()) || 0);

            $("#pd_total").val(parseFloat(perDeimSum).toFixed(2));
        });

        $(document).on("change", "input[name *= 'per_deim_l_']", function() {

            perDeimSum = (parseFloat($("#per_deim_b_0").val()) || 0) + (parseFloat($("#per_deim_l_0").val()) || 0) + (parseFloat($("#per_deim_d_0").val()) || 0) + (parseFloat($("#per_deim_hotel_0").val()) || 0) +
						 (parseFloat($("#per_deim_b_1").val()) || 0) + (parseFloat($("#per_deim_l_1").val()) || 0) + (parseFloat($("#per_deim_d_1").val()) || 0) + (parseFloat($("#per_deim_hotel_1").val()) || 0) +
						 (parseFloat($("#per_deim_b_2").val()) || 0) + (parseFloat($("#per_deim_l_2").val()) || 0) + (parseFloat($("#per_deim_d_2").val()) || 0) + (parseFloat($("#per_deim_hotel_2").val()) || 0) +
						 (parseFloat($("#per_deim_b_3").val()) || 0) + (parseFloat($("#per_deim_l_3").val()) || 0) + (parseFloat($("#per_deim_d_3").val()) || 0) + (parseFloat($("#per_deim_hotel_3").val()) || 0) +
						 (parseFloat($("#per_deim_b_4").val()) || 0) + (parseFloat($("#per_deim_l_4").val()) || 0) + (parseFloat($("#per_deim_d_4").val()) || 0) + (parseFloat($("#per_deim_hotel_4").val()) || 0) +
						 (parseFloat($("#per_deim_b_5").val()) || 0) + (parseFloat($("#per_deim_l_5").val()) || 0) + (parseFloat($("#per_deim_d_5").val()) || 0) + (parseFloat($("#per_deim_hotel_5").val()) || 0) +
						 (parseFloat($("#per_deim_b_6").val()) || 0) + (parseFloat($("#per_deim_l_6").val()) || 0) + (parseFloat($("#per_deim_d_6").val()) || 0) + (parseFloat($("#per_deim_hotel_6").val()) || 0);

            $("#pd_total").val(parseFloat(perDeimSum).toFixed(2));
        });

        $(document).on("change", "input[name *= 'per_deim_d_']", function() {

            perDeimSum = (parseFloat($("#per_deim_b_0").val()) || 0) + (parseFloat($("#per_deim_l_0").val()) || 0) + (parseFloat($("#per_deim_d_0").val()) || 0) + (parseFloat($("#per_deim_hotel_0").val()) || 0) +
						 (parseFloat($("#per_deim_b_1").val()) || 0) + (parseFloat($("#per_deim_l_1").val()) || 0) + (parseFloat($("#per_deim_d_1").val()) || 0) + (parseFloat($("#per_deim_hotel_1").val()) || 0) +
						 (parseFloat($("#per_deim_b_2").val()) || 0) + (parseFloat($("#per_deim_l_2").val()) || 0) + (parseFloat($("#per_deim_d_2").val()) || 0) + (parseFloat($("#per_deim_hotel_2").val()) || 0) +
						 (parseFloat($("#per_deim_b_3").val()) || 0) + (parseFloat($("#per_deim_l_3").val()) || 0) + (parseFloat($("#per_deim_d_3").val()) || 0) + (parseFloat($("#per_deim_hotel_3").val()) || 0) +
						 (parseFloat($("#per_deim_b_4").val()) || 0) + (parseFloat($("#per_deim_l_4").val()) || 0) + (parseFloat($("#per_deim_d_4").val()) || 0) + (parseFloat($("#per_deim_hotel_4").val()) || 0) +
						 (parseFloat($("#per_deim_b_5").val()) || 0) + (parseFloat($("#per_deim_l_5").val()) || 0) + (parseFloat($("#per_deim_d_5").val()) || 0) + (parseFloat($("#per_deim_hotel_5").val()) || 0) +
						 (parseFloat($("#per_deim_b_6").val()) || 0) + (parseFloat($("#per_deim_l_6").val()) || 0) + (parseFloat($("#per_deim_d_6").val()) || 0) + (parseFloat($("#per_deim_hotel_6").val()) || 0);

            $("#pd_total").val(parseFloat(perDeimSum).toFixed(2));
        });

        $(document).on("change", "input[name *= 'per_deim_hotel_']", function() {

            perDeimSum = (parseFloat($("#per_deim_b_0").val()) || 0) + (parseFloat($("#per_deim_l_0").val()) || 0) + (parseFloat($("#per_deim_d_0").val()) || 0) + (parseFloat($("#per_deim_hotel_0").val()) || 0) +
						 (parseFloat($("#per_deim_b_1").val()) || 0) + (parseFloat($("#per_deim_l_1").val()) || 0) + (parseFloat($("#per_deim_d_1").val()) || 0) + (parseFloat($("#per_deim_hotel_1").val()) || 0) +
						 (parseFloat($("#per_deim_b_2").val()) || 0) + (parseFloat($("#per_deim_l_2").val()) || 0) + (parseFloat($("#per_deim_d_2").val()) || 0) + (parseFloat($("#per_deim_hotel_2").val()) || 0) +
						 (parseFloat($("#per_deim_b_3").val()) || 0) + (parseFloat($("#per_deim_l_3").val()) || 0) + (parseFloat($("#per_deim_d_3").val()) || 0) + (parseFloat($("#per_deim_hotel_3").val()) || 0) +
						 (parseFloat($("#per_deim_b_4").val()) || 0) + (parseFloat($("#per_deim_l_4").val()) || 0) + (parseFloat($("#per_deim_d_4").val()) || 0) + (parseFloat($("#per_deim_hotel_4").val()) || 0) +
						 (parseFloat($("#per_deim_b_5").val()) || 0) + (parseFloat($("#per_deim_l_5").val()) || 0) + (parseFloat($("#per_deim_d_5").val()) || 0) + (parseFloat($("#per_deim_hotel_5").val()) || 0) +
						 (parseFloat($("#per_deim_b_6").val()) || 0) + (parseFloat($("#per_deim_l_6").val()) || 0) + (parseFloat($("#per_deim_d_6").val()) || 0) + (parseFloat($("#per_deim_hotel_6").val()) || 0);

            $("#pd_total").val(parseFloat(perDeimSum).toFixed(2));
        });

		// ensure dates are not duplicated on form:
         $(document).on("change", "input[name *= 'per_deim_date_']", function() {

			var dates = new Array();

            dates[0] = $("#per_deim_date_0").val();
			dates[1] = $("#per_deim_date_1").val();
			dates[2] = $("#per_deim_date_2").val();
			dates[3] = $("#per_deim_date_3").val();
			dates[4] = $("#per_deim_date_4").val();
			dates[5] = $("#per_deim_date_5").val();
			dates[6] = $("#per_deim_date_6").val();

			for (var i = 0; i < 7; i++)
			{
				for (var j = i + 1; j < 7; j++)
				{
					if (dates[i] === dates[j] && dates[i] != "a" && dates[i] != "")
					{
						if (j == 1)
						{
							$("#per_deim_date_1").val("0");
						}
						else if (j == 2)
						{
							$("#per_deim_date_2").val("0");
						}
						else if (j == 3)
						{
							$("#per_deim_date_3").val("0");
						}
						if (j == 4)
						{
							$("#per_deim_date_4").val("0");
						}
						if (j == 5)
						{
							$("#per_deim_date_5").val("0");
						}
						if (j == 6)
						{
							$("#per_deim_date_6").val("0");
						}
					}
				}
			}


        });

	   var pd_date0 = new LiveValidation('per_deim_date_0', { validMessage: '\u2713', wait: 500});
        pd_date0.add(Validate.Format, { pattern: /((((0[13578]|1[02])[/](0([1-9])|[12][0-9]|3[01]))|(0[469]|11)[/](0[1-9]|[12][0-9]|30)|(02[/](0[1-9]|[1][0-9]|2[0-9])))[/](20[1-9][0-9]))/i, failureMessage: "Please format your date as mm/dd/yyyy" } );

        var pd_dtime0 = new LiveValidation ('per_deim_departure_0', { validMessage: '\u2713', wait: 500});
        pd_dtime0.add(Validate.Format, { pattern: /(((0[1-9])|(1[012]))[:][0-6][0-9][ ][Aa|Pp][Mm])/i, failureMessage: "Please format your time as hh:mm AM/PM" } );

        var pd_atime0 = new LiveValidation ('per_deim_arrival_0', { validMessage: '\u2713', wait: 500});
        pd_atime0.add(Validate.Format, { pattern: /(((0[1-9])|(1[012]))[:][0-6][0-9][ ][Aa|Pp][Mm])/i, failureMessage: "Please format your time as hh:mm AM/PM" } );

        var pd_b_0 = new LiveValidation('per_deim_b_0', { validMessage: '\u2713', wait: 500});
        pd_b_0.add( Validate.Numericality );

        var per_deim_l_0 = new LiveValidation('per_deim_l_0', { validMessage: '\u2713', wait: 500});
        per_deim_l_0.add( Validate.Numericality );

        var per_deim_d_0 = new LiveValidation('per_deim_d_0', { validMessage: '\u2713', wait: 500});
        per_deim_d_0.add( Validate.Numericality );

        var per_deim_hotel_0 = new LiveValidation('per_deim_hotel_0', { validMessage: '\u2713', wait: 500});
        per_deim_hotel_0.add( Validate.Numericality );

        var pd_date1 = new LiveValidation('per_deim_date_1', { validMessage: '\u2713', wait: 500});
        pd_date1.add(Validate.Format, { pattern: /(((0[13578]|1[02])[/](0([1-9])|[12][0-9]|3[01]))|(0[469]|11)[/](0[1-9]|[12][0-9]|30)|(02[/](0[1-9]|[1][0-9]|2[0-9])))[/](20[1-9][0-9])/i, failureMessage: "Please format your date as mm/dd/yyyy" } );

        var pd_dtime1 = new LiveValidation ('per_deim_departure_1', { validMessage: '\u2713', wait: 500});
        pd_dtime1.add(Validate.Format, { pattern: /(((0[1-9])|(1[012]))[:][0-6][0-9][ ][Aa|Pp][Mm])/i, failureMessage: "Please format your time as hh:mm AM/PM" } );

        var pd_atime1 = new LiveValidation ('per_deim_arrival_1', { validMessage: '\u2713', wait: 500});
        pd_atime1.add(Validate.Format, { pattern: /(((0[1-9])|(1[012]))[:][0-6][0-9][ ][Aa|Pp][Mm])/i, failureMessage: "Please format your time as hh:mm AM/PM" } );

        var per_deim_b_1 = new LiveValidation('per_deim_b_1', { validMessage: '\u2713', wait: 500});
        per_deim_b_1.add( Validate.Numericality );

        var per_deim_l_1 = new LiveValidation('per_deim_l_1', { validMessage: '\u2713', wait: 500});
        per_deim_l_1.add( Validate.Numericality );

        var per_deim_d_1 = new LiveValidation('per_deim_d_1', { validMessage: '\u2713', wait: 500});
        per_deim_d_1.add( Validate.Numericality );

        var per_deim_hotel_1 = new LiveValidation('per_deim_hotel_1', { validMessage: '\u2713', wait: 500});
        per_deim_hotel_1.add( Validate.Numericality );

        var pd_date2 = new LiveValidation('per_deim_date_2', { validMessage: '\u2713', wait: 500});
        pd_date2.add(Validate.Format, { pattern: /((((0[13578]|1[02])[/](0([1-9])|[12][0-9]|3[01]))|(0[469]|11)[/](0[1-9]|[12][0-9]|30)|(02[/](0[1-9]|[1][0-9]|2[0-9])))[/](20[1-9][0-9]))/i, failureMessage: "Please format your date as mm/dd/yyyy" } );

        var pd_dtime2 = new LiveValidation ('per_deim_departure_2', { validMessage: '\u2713', wait: 500});
        pd_dtime2.add(Validate.Format, { pattern: /(((0[1-9])|(1[012]))[:][0-6][0-9][ ][Aa|Pp][Mm])/i, failureMessage: "Please format your time as hh:mm AM/PM" } );

        var pd_atime2 = new LiveValidation ('per_deim_arrival_2', { validMessage: '\u2713', wait: 500});
        pd_atime2.add(Validate.Format, { pattern: /(((0[1-9])|(1[012]))[:][0-6][0-9][ ][Aa|Pp][Mm])/i, failureMessage: "Please format your time as hh:mm AM/PM" } );

        var pd_b_2 = new LiveValidation('per_deim_b_2', { validMessage: '\u2713', wait: 500});
        pd_b_2.add( Validate.Numericality );

        var per_deim_l_2 = new LiveValidation('per_deim_l_2', { validMessage: '\u2713', wait: 500});
        per_deim_l_2.add( Validate.Numericality );

        var per_deim_d_2 = new LiveValidation('per_deim_d_2', { validMessage: '\u2713', wait: 500});
        per_deim_d_2.add( Validate.Numericality );

        var per_deim_hotel_2 = new LiveValidation('per_deim_hotel_2', { validMessage: '\u2713', wait: 500});
        per_deim_hotel_2.add( Validate.Numericality );

        var pd_date3 = new LiveValidation('per_deim_date_3', { validMessage: '\u2713', wait: 500});
        pd_date3.add(Validate.Format, { pattern: /((((0[13578]|1[02])[/](0([1-9])|[12][0-9]|3[01]))|(0[469]|11)[/](0[1-9]|[12][0-9]|30)|(02[/](0[1-9]|[1][0-9]|2[0-9])))[/](20[1-9][0-9]))/i, failureMessage: "Please format your date as mm/dd/yyyy" } );

        var pd_dtime3 = new LiveValidation ('per_deim_departure_3', { validMessage: '\u2713', wait: 500});
        pd_dtime3.add(Validate.Format, { pattern: /(((0[1-9])|(1[012]))[:][0-6][0-9][ ][Aa|Pp][Mm])/i, failureMessage: "Please format your time as hh:mm AM/PM" } );

        var pd_atime3 = new LiveValidation ('per_deim_arrival_3', { validMessage: '\u2713', wait: 500});
        pd_atime3.add(Validate.Format, { pattern: /(((0[1-9])|(1[012]))[:][0-6][0-9][ ][Aa|Pp][Mm])/i, failureMessage: "Please format your time as hh:mm AM/PM" } );

        var pd_b_3 = new LiveValidation('per_deim_b_3', { validMessage: '\u2713', wait: 500});
        pd_b_3.add( Validate.Numericality );

        var per_deim_l_3 = new LiveValidation('per_deim_l_3', { validMessage: '\u2713', wait: 500});
        per_deim_l_3.add( Validate.Numericality );

        var per_deim_d_3 = new LiveValidation('per_deim_d_3', { validMessage: '\u2713', wait: 500});
        per_deim_d_3.add( Validate.Numericality );

        var per_deim_hotel_3 = new LiveValidation('per_deim_hotel_3', { validMessage: '\u2713', wait: 500});
        per_deim_hotel_3.add( Validate.Numericality );

        var pd_date4 = new LiveValidation('per_deim_date_4', { validMessage: '\u2713', wait: 500});
        pd_date4.add(Validate.Format, { pattern: /((((0[13578]|1[02])[/](0([1-9])|[12][0-9]|3[01]))|(0[469]|11)[/](0[1-9]|[12][0-9]|30)|(02[/](0[1-9]|[1][0-9]|2[0-9])))[/](20[1-9][0-9]))/i, failureMessage: "Please format your date as mm/dd/yyyy" } );

        var pd_dtime4 = new LiveValidation ('per_deim_departure_4', { validMessage: '\u2713', wait: 500});
        pd_dtime4.add(Validate.Format, { pattern: /(((0[1-9])|(1[012]))[:][0-6][0-9][ ][Aa|Pp][Mm])/i, failureMessage: "Please format your time as hh:mm AM/PM" } );

        var pd_atime4 = new LiveValidation ('per_deim_arrival_4', { validMessage: '\u2713', wait: 500});
        pd_atime4.add(Validate.Format, { pattern: /(((0[1-9])|(1[012]))[:][0-6][0-9][ ][Aa|Pp][Mm])/i, failureMessage: "Please format your time as hh:mm AM/PM" } );

        var pd_b_4 = new LiveValidation('per_deim_b_4', { validMessage: '\u2713', wait: 500});
        pd_b_4.add( Validate.Numericality );

        var per_deim_l_4 = new LiveValidation('per_deim_l_4', { validMessage: '\u2713', wait: 500});
        per_deim_l_4.add( Validate.Numericality );

        var per_deim_d_4 = new LiveValidation('per_deim_d_4', { validMessage: '\u2713', wait: 500});
        per_deim_d_4.add( Validate.Numericality );

        var per_deim_hotel_4 = new LiveValidation('per_deim_hotel_4', { validMessage: '\u2713', wait: 500});
        per_deim_hotel_4.add( Validate.Numericality );

        var pd_date5 = new LiveValidation('per_deim_date_5', { validMessage: '\u2713', wait: 500});
        pd_date5.add(Validate.Format, { pattern: /((((0[13578]|1[02])[/](0([1-9])|[12][0-9]|3[01]))|(0[469]|11)[/](0[1-9]|[12][0-9]|30)|(02[/](0[1-9]|[1][0-9]|2[0-9])))[/](20[1-9][0-9]))/i, failureMessage: "Please format your date as mm/dd/yyyy" } );

        var pd_dtime5 = new LiveValidation ('per_deim_departure_5', { validMessage: '\u2713', wait: 500});
        pd_dtime5.add(Validate.Format, { pattern: /(((0[1-9])|(1[012]))[:][0-6][0-9][ ][Aa|Pp][Mm])/i, failureMessage: "Please format your time as hh:mm AM/PM" } );

        var pd_atime5 = new LiveValidation ('per_deim_arrival_5', { validMessage: '\u2713', wait: 500});
        pd_atime5.add(Validate.Format, { pattern: /(((0[1-9])|(1[012]))[:][0-6][0-9][ ][Aa|Pp][Mm])/i, failureMessage: "Please format your time as hh:mm AM/PM" } );

        var pd_b_5 = new LiveValidation('per_deim_b_5', { validMessage: '\u2713', wait: 500});
        pd_b_5.add( Validate.Numericality );

        var per_deim_l_5 = new LiveValidation('per_deim_l_5', { validMessage: '\u2713', wait: 500});
        per_deim_l_5.add( Validate.Numericality );

        var per_deim_d_5 = new LiveValidation('per_deim_d_5', { validMessage: '\u2713', wait: 500});
        per_deim_d_5.add( Validate.Numericality );

        var per_deim_hotel_5 = new LiveValidation('per_deim_hotel_5', { validMessage: '\u2713', wait: 500});
        per_deim_hotel_5.add( Validate.Numericality );

        var pd_date6 = new LiveValidation('per_deim_date_6', { validMessage: '\u2713', wait: 500});
        pd_date6.add(Validate.Format, { pattern: /((((0[13578]|1[02])[/](0([1-9])|[12][0-9]|3[01]))|(0[469]|11)[/](0[1-9]|[12][0-9]|30)|(02[/](0[1-9]|[1][0-9]|2[0-9])))[/](20[1-9][0-9]))/i, failureMessage: "Please format your date as mm/dd/yyyy" } );

        var pd_dtime6 = new LiveValidation ('per_deim_departure_6', { validMessage: '\u2713', wait: 500});
        pd_dtime6.add(Validate.Format, { pattern: /(((0[1-9])|(1[012]))[:][0-6][0-9][ ][Aa|Pp][Mm])/i, failureMessage: "Please format your time as hh:mm AM/PM" } );

        var pd_atime6 = new LiveValidation ('per_deim_arrival_6', { validMessage: '\u2713', wait: 500});
        pd_atime6.add(Validate.Format, { pattern: /(((0[1-9])|(1[012]))[:][0-6][0-9][ ][Aa|Pp][Mm])/i, failureMessage: "Please format your time as hh:mm AM/PM" } );

        var pd_b_6 = new LiveValidation('per_deim_b_6', { validMessage: '\u2713', wait: 500});
        pd_b_6.add( Validate.Numericality );

        var per_deim_l_6 = new LiveValidation('per_deim_l_6', { validMessage: '\u2713', wait: 500});
        per_deim_l_6.add( Validate.Numericality );

        var per_deim_d_6 = new LiveValidation('per_deim_d_6', { validMessage: '\u2713', wait: 500});
        per_deim_d_6.add( Validate.Numericality );

        var per_deim_hotel_6 = new LiveValidation('per_deim_hotel_6', { validMessage: '\u2713', wait: 500});
        per_deim_hotel_6.add( Validate.Numericality );

        </script>

        <br /><hr />

        <?
        foreach($modes->result() as $modes)
        {
            if($modes->mode == 5)
            {
                //Private Car
                if ($b_hr)
                {
                    echo "<br /><hr>";
                }
                else
                {
                    $b_hr = TRUE;
                }
                ?>
                <strong>Personal Car</strong><br /><br /><a class="tooltip" href="#">Private Vehicle Mileage Reimbursement:<span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" /><em>Mileage: </em>Enter your daily mileage from your personal car in the table below.</span></a> $
            <?
            $form_input = array('name' => 'private_car_total', 'id' => 'private_car_total', 'maxlength' => '8', 'size' => '8', 'readonly' => 'readonly', 'value' => set_value('private_car_total', (isset($private_car_total) ? $private_car_total : '0.00')));
            echo form_input($form_input);

            $this->table->set_heading('Mileage From:', 'Mileage To:', 'Miles:', 'Vicinity', 'Rate:', 'Total:');

            $this->table->add_row('<input id = "from_0" name = "from_0" class = "from_0" type = "text" size = "15" value ="'.set_value('from_0', (isset($from_0) ? $from_0 : '')).'" />', '<input id = "to_0" name = "to_0" class = "to_0" type = "text" size = "15" value ="'.set_value('to_0', (isset($to_0) ? $to_0 : '')).'" />', '<input id = "miles_0" name = "miles_0" class = "miles_0" type = "text" size = "4" value ="'.set_value('miles_0', (isset($miles_0) ? $miles_0 : '')).'" />', '<input id = "vicinity_0" name = "vicinity_0" class = "vicinity_0" type = "text" size = "4" value ="'.set_value('vicinity_0', (isset($vicinity_0) ? $vicinity_0 : '')).'" />', '<input id = "rate_0" name = "rate_0" class = "rate_0" type = "text" readonly = "readonly" size = "5" value='. $rate. ' />', '<input id = "total_0" name = "total_0" class = "total_0" type = "text" readonly size = "5" value ="'.set_value('total_0', (isset($total_0) ? $total_0 : '0.00')).'" />');
            $this->table->add_row('<input id = "from_1" name = "from_1" class = "from_1" type = "text" size = "15" value ="'.set_value('from_1', (isset($from_1) ? $from_1 : '')).'" />', '<input id = "to_1" name = "to_1" class = "to_1" type = "text" size = "15" value ="'.set_value('to_1', (isset($to_1) ? $to_1 : '')).'" />', '<input id = "miles_1" name = "miles_1" class = "miles_1" type = "text" size = "4" value ="'.set_value('miles_1', (isset($miles_1) ? $miles_1 : '')).'" />', '<input id = "vicinity_1" name = "vicinity_1" class = "vicinity_1" type = "text" size = "4" value ="'.set_value('vicinity_1', (isset($vicinity_1) ? $vicinity_1 : '')).'" />', '<input id = "rate_1" name = "rate_1" class = "rate_1" type = "text" readonly = "readonly" size = "5" value='. $rate. ' />', '<input id = "total_1" name = "total_1" class = "total_1" type = "text" readonly size = "5" value ="'.set_value('total_1', (isset($total_1) ? $total_1 : '0.00')).'" />');
            $this->table->add_row('<input id = "from_2" name = "from_2" class = "from_2" type = "text" size = "15" value ="'.set_value('from_2', (isset($from_2) ? $from_2 : '')).'" />', '<input id = "to_2" name = "to_2" class = "to_2" type = "text" size = "15" value ="'.set_value('to_2', (isset($to_2) ? $to_2 : '')).'" />', '<input id = "miles_2" name = "miles_2" class = "miles_2" type = "text" size = "4" value ="'.set_value('miles_2', (isset($miles_2) ? $miles_2 : '')).'" />', '<input id = "vicinity_2" name = "vicinity_2" class = "vicinity_2" type = "text" size = "4" value ="'.set_value('vicinity_2', (isset($vicinity_2) ? $vicinity_2 : '')).'" />', '<input id = "rate_2" name = "rate_2" class = "rate_2" type = "text" readonly = "readonly" size = "5" value='. $rate. ' />', '<input id = "total_2" name = "total_2" class = "total_2" type = "text" readonly size = "5" value ="'.set_value('total_2', (isset($total_2) ? $total_2 : '0.00')).'" />');
            /*$this->table->add_row('<input id = "from_3" name = "from_3" class = "from_3" type = "text" size = "15" value ="'.set_value('from_3', (isset($from_3) ? $from_3 : '')).'" />', '<input id = "to_3" class = "to_3" name = "to_3" type = "text" size = "15" value ="'.set_value('to_3', (isset($to_3) ? $to_3 : '')).'" />', '<input id = "miles_3" name = "miles_3" class = "miles_3" type = "text" size = "4" value ="'.set_value('miles_3', (isset($miles_3) ? $miles_3 : '')).'" />', '<input id = "vicinity_3" name = "vicinity_3" class = "vicinity_3" type = "text" size = "4" value ="'.set_value('vicinity_3', (isset($vicinity_3) ? $vicinity_3 : '')).'" />', '<input id = "rate_3" name = "rate_3" class = "rate_3" type = "text" readonly = "readonly" size = "5" value='. $rate. ' />', '<input id = "total_3" name = "total_3" class = "total_3" type = "text" readonly size = "5" value ="'.set_value('total_3', (isset($total_3) ? $total_3 : '0.00')).'" />');
            $this->table->add_row('<input id = "from_4" name = "from_4" class = "from_4" type = "text" size = "15" value ="'.set_value('from_4', (isset($from_4) ? $from_4 : '')).'" />', '<input id = "to_4" class = "to_4" name = "to_4" type = "text" size = "15" value ="'.set_value('to_4', (isset($to_4) ? $to_4 : '')).'" />', '<input id = "miles_4" name = "miles_4" class = "miles_4" type = "text" size = "4" value ="'.set_value('miles_4', (isset($miles_4) ? $miles_4 : '')).'" />', '<input id = "vicinity_4" name = "vicinity_4" class = "vicinity_4" type = "text" size = "4" value ="'.set_value('vicinity_4', (isset($vicinity_4) ? $vicinity_4 : '')).'" />', '<input id = "rate_4" name = "rate_4" class = "rate_4" type = "text" readonly = "readonly" size = "5" value='. $rate. ' />', '<input id = "total_4" name = "total_4" class = "total_4" type = "text" readonly size = "5" value ="'.set_value('total_4', (isset($total_4) ? $total_4 : '0.00')).'" />');
*/
            echo $this->table->generate();
            ?>
                <script type="text/javascript">
                    $(document).on("change", "input[class *= 'miles_']", function() {
                        var povSum = 0;

                        $("input[class *= 'miles_']").each(function(){
                            povSum += (+$(this).val() * +$("#rate_0").val());
                            $("#total_0").val(parseFloat(+$("#miles_0").val() * +$("#rate_0").val()).toFixed(2));
                            $("#total_1").val(parseFloat(+$("#miles_1").val() * +$("#rate_0").val()).toFixed(2));
                            $("#total_2").val(parseFloat(+$("#miles_2").val() * +$("#rate_0").val()).toFixed(2));
                            $("#total_3").val(parseFloat(+$("#miles_3").val() * +$("#rate_0").val()).toFixed(2));
                            $("#total_4").val(parseFloat(+$("#miles_4").val() * +$("#rate_0").val()).toFixed(2));
                        });

                        $("#private_car_total").val(parseFloat(povSum).toFixed(2));
                    });

                    var miles_0 = new LiveValidation('miles_0', { validMessage: '\u2713', wait: 500});
                    miles_0.add( Validate.Numericality, { onlyInteger: true } );

                    var miles_1 = new LiveValidation('miles_1', { validMessage: '\u2713', wait: 500});
                    miles_1.add( Validate.Numericality, { onlyInteger: true } );

                    var miles_2 = new LiveValidation('miles_2', { validMessage: '\u2713', wait: 500});
                    miles_2.add( Validate.Numericality, { onlyInteger: true } );

                    var miles_3 = new LiveValidation('miles_3', { validMessage: '\u2713', wait: 500});
                    miles_3.add( Validate.Numericality, { onlyInteger: true } );

                    var miles_4 = new LiveValidation('miles_4', { validMessage: '\u2713', wait: 500});
                    miles_4.add( Validate.Numericality, { onlyInteger: true } );
                </script>
            <?
            }
        } //End loop

        //Other expenses
        ?>
        <br />
        <strong>Other Miscellaneous Travel-Related Expenses</strong><br /><br /><a class="tooltip" href="#">Total:<span class="custom help"><img src="/../../assets/images/Help.png" alt="Help" height="48" width="48" /><em>Other Expenses</em>
        Enter any other costs you may incurred on your trip in the table below. Receipts required if total is greater than $50.</span></a> $
        <?
        $form_input = array('name' => 'expense_total', 'id' => 'expense_total', 'maxlength' => '8', 'size' => '8', 'readonly' => 'readonly', 'value' => set_value('expense_total', (isset($expense_total) ? $expense_total : '0.00')));
        echo form_input($form_input);

        $this->table->set_heading('Date:', 'Payee:', 'Expense:', 'Amount:');

        if(isset($misc_date_0))
        {
            $time = strtotime($misc_date_0);
            $converted_misc_date_0 = date("m/d/Y", $time);
        }
        $date = array('data' => "<input id='misc_date_0' name='misc_date_0' type='text' size = '11' value ='".set_value('misc_date_0', (isset($converted_misc_date_0) ? $converted_misc_date_0 : ''))."' />");
        $this->table->add_row($date, '<input id="payee_0" name="payee_0" type = "text" maxlength = "30" size = "15" value ="'.set_value('payee_0', (isset($payee_0) ? $payee_0 : '')).'" />', '<input id="expense_0" name="expense_0" type = "text" maxlength = "30" size = "15" value ="'.set_value('expense_0', (isset($expense_0) ? $expense_0 : '')).'" />', '<input id = "amount_0" class="amount_0" name= "amount_0" type = "text" size = "5" value ="'.set_value('amount_0', (isset($amount_0) ? $amount_0 : '')).'" />');
        if(isset($misc_date_1))
        {
            $time = strtotime($misc_date_1);
            $converted_misc_date_1 = date("m/d/Y", $time);
        }
        $date = array('data' => "<input id='misc_date_1' name='misc_date_1' type='text' size = '11' value ='".set_value('misc_date_1', (isset($converted_misc_date_1) ? $converted_misc_date_1 : ''))."' />");
        $this->table->add_row($date, '<input id="payee_1" name="payee_1" type = "text" maxlength = "30" size = "15" value ="'.set_value('payee_1', (isset($payee_1) ? $payee_1 : '')).'" />', '<input id="expense_1" name="expense_1" type = "text" maxlength = "31" size = "15" value ="'.set_value('expense_1', (isset($expense_1) ? $expense_1 : '')).'" />', '<input id = "amount_1" class="amount_1" name= "amount_1" type = "text" size = "5" value ="'.set_value('amount_1', (isset($amount_1) ? $amount_1 : '')).'" />');
        if(isset($misc_date_2))
        {
            $time = strtotime($misc_date_2);
            $converted_misc_date_2 = date("m/d/Y", $time);
        }
        $date = array('data' => "<input id='misc_date_2' name='misc_date_2' type='text' size = '11' value ='".set_value('misc_date_2', (isset($converted_misc_date_2) ? $converted_misc_date_2 : ''))."' />");
        $this->table->add_row($date, '<input id="payee_2" name="payee_2" type = "text" maxlength = "30" size = "15" value ="'.set_value('payee_2', (isset($payee_2) ? $payee_2 : '')).'" />', '<input id="expense_2" name="expense_2" type = "text" maxlength = "32" size = "15" value ="'.set_value('expense_2', (isset($expense_2) ? $expense_2 : '')).'" />', '<input id = "amount_2" class="amount_2" name= "amount_2" type = "text" size = "5" value ="'.set_value('amount_2', (isset($amount_2) ? $amount_2 : '')).'" />');
        if(isset($misc_date_3))
        {
            $time = strtotime($misc_date_3);
            $converted_misc_date_3 = date("m/d/Y", $time);
        }
        $date = array('data' => "<input id='misc_date_3' name='misc_date_3' type='text' size = '11' value ='".set_value('misc_date_3', (isset($converted_misc_date_3) ? $converted_misc_date_3 : ''))."' />");
        $this->table->add_row($date, '<input id="payee_3" name="payee_3" type = "text" maxlength = "30" size = "15" value ="'.set_value('payee_3', (isset($payee_3) ? $payee_3 : '')).'" />', '<input id="expense_3" name="expense_3" type = "text" maxlength = "33" size = "15" value ="'.set_value('expense_3', (isset($expense_3) ? $expense_3 : '')).'" />', '<input id = "amount_3" class="amount_3" name= "amount_3" type = "text" size = "5" value ="'.set_value('amount_3', (isset($amount_3) ? $amount_3 : '')).'" />');
        if(isset($misc_date_4))
        {
            $time = strtotime($misc_date_4);
            $converted_misc_date_4 = date("m/d/Y", $time);
        }
        $date = array('data' => "<input id='misc_date_4' name='misc_date_4' type='text' size = '11' value ='".set_value('misc_date_4', (isset($converted_misc_date_4) ? $converted_misc_date_4 : ''))."' />");
        $this->table->add_row($date, '<input id="payee_4" name="payee_4" type = "text" maxlength = "30" size = "15" value ="'.set_value('payee_4', (isset($payee_4) ? $payee_4 : '')).'" />', '<input id="expense_4" name="expense_4" type = "text" maxlength = "30" size = "15" value ="'.set_value('expense_4', (isset($expense_4) ? $expense_4 : '')).'" />', '<input id = "amount_4" class="amount_4" name= "amount_4" type = "text" size = "5" value ="'.set_value('amount_4', (isset($amount_4) ? $amount_4 : '')).'" />');

        echo $this->table->generate();
        ?>
        <script type="text/javascript">
            $(document).on("change", "input[class *= 'amount_']", function() {
                var miscSum = 0;

                $("input[class *= 'amount_']").each(function(){
                    miscSum += +$(this).val();
                });

                $("#expense_total").val(parseFloat(miscSum).toFixed(2));
            });

            $('#misc_date_0').datepicker();
            $('#misc_date_1').datepicker();
            $('#misc_date_2').datepicker();
            $('#misc_date_3').datepicker();
            $('#misc_date_4').datepicker();

			var misc_date0 = new LiveValidation('misc_date_0', { validMessage: '\u2713', wait: 500});
			misc_date0.add(Validate.Format, { pattern: /((((0[13578]|1[02])[/](0([1-9])|[12][0-9]|3[01]))|(0[469]|11)[/](0[1-9]|[12][0-9]|30)|(02[/](0[1-9]|[1][0-9]|2[0-9])))[/](20[1-9][0-9]))/i, failureMessage: "Please format your date as mm/dd/yyyy" } );

            var misc0 = new LiveValidation('amount_0', { validMessage: '\u2713', wait: 500});
            misc0.add( Validate.Numericality );
            misc0.add( Validate.Format, { pattern: /((\d*)|((\d*)[\.][d][d]))/i, failureMessage: "Please enter your the amount as 800 or 800.00" } );

			var misc_date1 = new LiveValidation('misc_date_1', { validMessage: '\u2713', wait: 500});
			misc_date1.add(Validate.Format, { pattern: /((((0[13578]|1[02])[/](0([1-9])|[12][0-9]|3[01]))|(0[469]|11)[/](0[1-9]|[12][0-9]|30)|(02[/](0[1-9]|[1][0-9]|2[0-9])))[/](20[1-9][0-9]))/i, failureMessage: "Please format your date as mm/dd/yyyy" } );

            var misc1 = new LiveValidation('amount_1', { validMessage: '\u2713', wait: 500});
            misc1.add( Validate.Numericality );
            misc1.add( Validate.Format, { pattern: /((\d*)|((\d*)[\.][d][d]))/i, failureMessage: "Please enter your the amount as 800 or 800.00" } );

			var misc_date2 = new LiveValidation('misc_date_2', { validMessage: '\u2713', wait: 500});
			misc_date2.add(Validate.Format, { pattern: /((((0[13578]|1[02])[/](0([1-9])|[12][0-9]|3[01]))|(0[469]|11)[/](0[1-9]|[12][0-9]|30)|(02[/](0[1-9]|[1][0-9]|2[0-9])))[/](20[1-9][0-9]))/i, failureMessage: "Please format your date as mm/dd/yyyy" } );

            var misc2 = new LiveValidation('amount_2', { validMessage: '\u2713', wait: 500});
            misc2.add( Validate.Numericality );
            misc2.add( Validate.Format, { pattern: /((\d*)|((\d*)[\.][d][d]))/i, failureMessage: "Please enter your the amount as 800 or 800.00" } );

			var misc_date3 = new LiveValidation('misc_date_3', { validMessage: '\u2713', wait: 500});
			misc_date3.add(Validate.Format, { pattern: /((((0[13578]|1[02])[/](0([1-9])|[12][0-9]|3[01]))|(0[469]|11)[/](0[1-9]|[12][0-9]|30)|(02[/](0[1-9]|[1][0-9]|2[0-9])))[/](20[1-9][0-9]))/i, failureMessage: "Please format your date as mm/dd/yyyy" } );

            var misc3 = new LiveValidation('amount_3', { validMessage: '\u2713', wait: 500});
            misc3.add( Validate.Numericality );
            misc3.add( Validate.Format, { pattern: /((\d*)|((\d*)[\.][d][d]))/i, failureMessage: "Please enter your the amount as 800 or 800.00" } );

			var misc_date4 = new LiveValidation('misc_date_4', { validMessage: '\u2713', wait: 500});
			misc_date4.add(Validate.Format, { pattern: /((((0[13578]|1[02])[/](0([1-9])|[12][0-9]|3[01]))|(0[469]|11)[/](0[1-9]|[12][0-9]|30)|(02[/](0[1-9]|[1][0-9]|2[0-9])))[/](20[1-9][0-9]))/i, failureMessage: "Please format your date as mm/dd/yyyy" } );

            var misc4 = new LiveValidation('amount_4', { validMessage: '\u2713', wait: 500});
            misc4.add( Validate.Numericality );
            misc4.add( Validate.Format, { pattern: /((\d*)|((\d*)[\.][d][d]))/i, failureMessage: "Please enter your the amount as 800 or 800.00" } );

            $('#refund_date_0').datepicker();
            $('#refund_date_1').datepicker();
        </script>
    <br /><hr />

    <br />
    <strong>Refunds</strong><br /><br />
    <?
    $this->table->set_heading('Date:', 'Refunds From (Payee):', 'Amount:');

    if(isset($refund_date_0))
    {
    $time = strtotime($refund_date_0);
    $converted_refund_date_0 = date("m/d/Y", $time);
    }
    $date = array('data' => "<input id='refund_date_0' name='refund_date_0' type='text' size = '11' value ='".set_value('refund_date_0', (isset($converted_refund_date_0) ? $converted_refund_date_0 : ''))."' />");
    $this->table->add_row($date, '<input id="refund_payee_0" name="refund_payee_0" type = "text" maxlength = "30" size = "15" value ="'.set_value('refund_payee_0', (isset($refund_payee_0) ? $refund_payee_0 : '')).'" />', '<input id = "refund_amount_0" class="refund_amount_0" name= "refund_amount_0" type = "text" size = "5" value ="'.set_value('refund_amount_0', (isset($refund_amount_0) ? $refund_amount_0 : '')).'" />');

    if(isset($refund_date_1))
    {
        $time = strtotime($refund_date_1);
        $converted_refund_date_1 = date("m/d/Y", $time);
    }
    $date = array('data' => "<input id='refund_date_1' name='refund_date_1' type='text' size = '11' value ='".set_value('refund_date_1', (isset($converted_refund_date_1) ? $converted_refund_date_1 : ''))."' />");
    $this->table->add_row($date, '<input id="refund_payee_1" name="refund_payee_1" type = "text" maxlength = "30" size = "15" value ="'.set_value('refund_payee_1', (isset($refund_payee_1) ? $refund_payee_1 : '')).'" />', '<input id = "refund_amount_1" class="refund_amount_1" name= "refund_amount_1" type = "text" size = "5" value ="'.set_value('refund_amount_1', (isset($refund_amount_1) ? $refund_amount_1 : '')).'" />');
    echo $this->table->generate();
    ?>
    <script type="text/javascript">
        $('#refund_date_0').datepicker();
        $('#refund_date_1').datepicker();

		var refund_date0 = new LiveValidation('refund_date_0', { validMessage: '\u2713', wait: 500});
		refund_date0.add(Validate.Format, { pattern: /((((0[13578]|1[02])[/](0([1-9])|[12][0-9]|3[01]))|(0[469]|11)[/](0[1-9]|[12][0-9]|30)|(02[/](0[1-9]|[1][0-9]|2[0-9])))[/](20[1-9][0-9]))/i, failureMessage: "Please format your date as mm/dd/yyyy" } );

        var misc_amount0 = new LiveValidation('refund_amount_0', { validMessage: '\u2713', wait: 500});
        misc_amount0.add( Validate.Numericality );
        misc_amount0.add( Validate.Format, { pattern: /((\d*)|((\d*)[\.][d][d]))/i, failureMessage: "Please enter your the amount as 800 or 800.00" } );

		var refund_date1 = new LiveValidation('refund_date_1', { validMessage: '\u2713', wait: 500});
		refund_date1.add(Validate.Format, { pattern: /((((0[13578]|1[02])[/](0([1-9])|[12][0-9]|3[01]))|(0[469]|11)[/](0[1-9]|[12][0-9]|30)|(02[/](0[1-9]|[1][0-9]|2[0-9])))[/](20[1-9][0-9]))/i, failureMessage: "Please format your date as mm/dd/yyyy" } );

        var misc_amount1 = new LiveValidation('refund_amount_1', { validMessage: '\u2713', wait: 500});
        misc_amount1.add( Validate.Numericality );
        misc_amount1.add( Validate.Format, { pattern: /((\d*)|((\d*)[\.][d][d]))/i, failureMessage: "Please enter your the amount as 800 or 800.00" } );

	</script>
    <br /><hr />

    <strong>Comments</strong><br /><br />
    <textarea name = 'comments' id = 'comments' cols = '50' rows = '5' ><? echo set_value('comments', (isset($comments) ? $comments : '')); ?></textarea>

	<script type="text/javascript">
		var comments = new LiveValidation('comments', { validMessage: '\u2713', wait: 500});
		comments.add( Validate.Length, { maximum: 250 } );
    </script>
	<?
    //Submit button
    echo "<br /><br />";
    echo ($return_to < 2 ? form_submit('submit', 'Submit') : ''). " "; //Will need validation here
    echo form_submit('save', 'Save'). " "; //Will need validation here.
    echo form_reset('reset', 'Reset'). " ";
    ?>
    <input type="button" value="Cancel" onclick="location.href='<? echo (isset($return_to) ? ($return_to == 1 ? base_url("index.php/triplist/view") : base_url("index.php/triplist/dtcview")) : base_url("index.php/triplist/view")); ?>';" />
    <?

    echo form_fieldset_close();
    echo form_close();
?>
</div>