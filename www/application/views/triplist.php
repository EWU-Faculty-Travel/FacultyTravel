<?
/* View/triplist
 *
 * Displays all the trips created by the current user to that user.
 * As well as display all the trips in the system if that user is a DTC
 *
 * Author: Reid Fortier, Josh Smith
 *
 * Created: 2013-08-22
 * Last Edited: 2013-08-29
*/
?>
<div class="loadedContent content">
    <?
    echo "<center><h2>Saved Trips</h2></center>";

	echo "<font color=red>";
	if ($success > 0 && $success < 3) // user attempted to edit a submitted trip.
    {
        echo "<center><strong>Cannot edit a submitted trip!</strong></center>";
    } else if ($success == 4) // user deleted a trip
    {
        echo "<center><strong>Trip deleted!</strong></center>";
    }
	else if ($success == 5) // user reset a trip
	{
		echo "<center><strong>Trip reset!</strong></center>";
	}
	else if ($success == 8) // user whans to print a trip
	{
		echo "<center><strong>Cannot edit index codes after trip has been submitted. Please contact your DTC!</strong></center>";
	}
	else if ($success == 6)
	{
		echo "<center><strong>Trip not submitted, cannot be rejected!</strong></center>";
	}
	else if ($success == 7)
	{
		echo "<center><strong>Trip cannot be accepted, it has not been submitted!</strong></center>";
	}

	echo "</font>";
    //Pretrip
    echo form_open('triplist/action');
    echo form_fieldset('Before The Trip');
    echo form_hidden('return_to', $return_to);

	// table template to create alternating colored row backgrounds:
	$tmpl = array ('table_open'          => '<table border="0" cellpadding="4" cellspacing="0">',

					'heading_row_start'   => '<tr>',
					'heading_row_end'     => '</tr>',
					'heading_cell_start'  => '<th>',
					'heading_cell_end'    => '</th>',

					'row_start'           => '<tr bgcolor=F0F8FF>',
					'row_end'             => '</tr>',
					'cell_start'          => '<td>',
					'cell_end'            => '</td>',

					'row_alt_start'       => '<tr>',
					'row_alt_end'         => '</tr>',
					'cell_alt_start'      => '<td>',
					'cell_alt_end'        => '</td>',

					'table_close'         => '</table>'
    );

	$this->table->set_template($tmpl);


    if ($return_to == 1) //Faculty
    {
        $this->table->set_heading('Trip ID', 'Trip Name', 'Department', 'Destination', 'Purpose', 'Status');

        if ($triplist->num_rows() > 0) {
            foreach ($triplist->result() as $triplist)
            {
                $this->table->add_row($triplist->trip_id, $triplist->trip_name, $triplist->dept_code, $triplist->destination, $triplist->purpose, $triplist->description);
            }

            echo $this->table->generate();

            if ($trip_id->num_rows() > 0) { //Doesn't display options if there are no trips to choose from
                //Dropdown - Trip ID
                echo "<br />";

                $options = array();
                foreach ($trip_id->result_array() as $row) {
                    $options[$row['trip_id']] = $row['trip_id'];
                }
                echo form_dropdown('trip_id', $options);

                //Dropdown - Actions
                $options = array('page1' => 'Edit Pre-Trip Page 1', 'page2' => 'Edit Pre-Trip Page 2', 'index' => 'Modify Index Codes', 'submit' => 'Submit Trip', 'delete' => 'Delete Trip', 'print' => 'Print Form');

                echo form_dropdown('action', $options);
                echo form_submit('submit', 'Select Action');
            }
        } else {
            echo "<br /><center><strong>No saved trips.</strong></center>";
        }

        echo form_fieldset_close();
        echo form_close();
    } else {
        $this->table->set_heading('Trip ID', 'Authorization', 'Name', 'Trip Name', 'Department', 'Destination', 'Purpose', 'Status');

        if ($triplist->num_rows() > 0) {
            foreach ($triplist->result() as $triplist)
            {
                $this->table->add_row($triplist->trip_id, (strlen($triplist->authorization) > 1 ? $triplist->authorization : ''), $triplist->name, $triplist->trip_name, $triplist->dept_code, $triplist->destination, $triplist->purpose, $triplist->description);
            }

            echo $this->table->generate();

            if ($trip_id->num_rows() > 0) { //Doesn't display options if there are no trips to choose from
                //Dropdown - Trip ID
                echo "<br />";

                $options = array();
                foreach ($trip_id->result_array() as $row) {
                    $options[$row['trip_id']] = $row['trip_id'];
                }
                echo form_dropdown('trip_id', $options);

                //Dropdown - Actions
                $options = array('code' => 'Modify Travel Number', 'page1' => 'Edit Pre-Trip Page 1', 'page2' => 'Edit Pre-Trip Page 2', 'index' => 'Modify Index Codes', 'accept' => 'Accept Trip', 'reject' => 'Reject Trip', 'delete' => 'Delete Trip', 'print' => 'Print Form');

                echo form_dropdown('action', $options);
                echo form_submit('submit', 'Select Action');
            }
        } else {
            echo "<br /><center><strong>No saved trips.</strong></center>";
        }
        echo form_fieldset_close();
        echo form_close();
    }

    //Posttrip
    echo "<br />";
    echo form_open('triplist/postAction');
    echo form_fieldset('After The Trip');
    echo form_hidden('return_to', set_value('return_to', (isset($return_to) ? $return_to : 1)));


    if ($return_to == 1) //Faculty
    {
        $this->table->set_heading('Trip ID', 'Trip Name', 'Department', 'Destination', 'Purpose', 'Status');

        if ($post_triplist->num_rows() > 0) {
            foreach ($post_triplist->result() as $post_triplist) {
                $this->table->add_row($post_triplist->trip_id, $post_triplist->trip_name, $post_triplist->dept_code, $post_triplist->destination, $post_triplist->purpose, $post_triplist->description);
            }

            echo $this->table->generate();

            if ($post_trip_id->num_rows() > 0) { //Doesn't display options if there are no trips to choose from
                //Dropdown - Trip ID
                echo "<br />";

                $options = array();
                foreach ($post_trip_id->result_array() as $row) {
                    $options[$row['trip_id']] = $row['trip_id'];
                }
                echo form_dropdown('trip_id', $options);

                //Dropdown - Actions
                $options = array('posttrip' => 'Edit Post Trip', 'index' => 'Modify Index Codes', 'submit' => 'Submit Post Trip', 'delete' => 'Delete Trip', 'print' => 'Print Form', 'reset' => 'Reset Trip');

                echo form_dropdown('action', $options);
                echo form_submit('submit', 'Select Action');
            }
        } else {
            echo "<br /><center><strong>No saved trips.</strong></center>";
        }
        echo form_fieldset_close();
        echo form_close();
    } else {
        $this->table->set_heading('Trip ID', 'Authorization', 'Name', 'Trip Name', 'Department', 'Destination', 'Purpose', 'Status');

        if ($post_triplist->num_rows() > 0) {
            foreach ($post_triplist->result() as $post_triplist) {
                $this->table->add_row($post_triplist->trip_id, ($post_triplist->authorization > 0 ? $post_triplist->authorization : ''), $post_triplist->name, $post_triplist->trip_name, $post_triplist->dept_code, $post_triplist->destination, $post_triplist->purpose, $post_triplist->description);
            }

            echo $this->table->generate();

            if ($post_trip_id->num_rows() > 0) { //Doesn't display options if there are no trips to choose from
                //Dropdown - Trip ID
                echo "<br />";

                $options = array();
                foreach ($post_trip_id->result_array() as $row) {
                    $options[$row['trip_id']] = $row['trip_id'];
                }
                echo form_dropdown('trip_id', $options);

                //Dropdown - Actions
                $options = array('code' => 'Modify Travel Number', 'index' => 'Modify Index Codes', 'posttrip' => 'Edit Post Trip', 'accept' => 'Accept Post Trip', 'reject' => 'Reject Post Trip', 'delete' => 'Delete Trip', 'print' => 'Print Form');

                echo form_dropdown('action', $options);
                echo form_submit('submit', 'Select Action');
            }
        } else {
            echo "<br /><center><strong>No saved trips.</strong></center>";
        }
        echo form_fieldset_close();
        echo form_close();
    }
    ?>
</div>


