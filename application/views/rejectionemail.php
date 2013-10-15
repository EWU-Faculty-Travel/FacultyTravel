<?
/* View/rejectionemail
 *
 * Allows a DTC to send an email to a Faculty with the reason that the form they submitted was rejected
 *
 * Author: Reid Fortier
 *
 * Created: 2013-08-20
 * Last Edited: 2013-08-20
*/?>
<div class="loadedContent content" id="content">
    <?
    echo "<center><h2>Rejection Email Form</h2></center>";

    echo form_open('triplist/rejectionEmail');
    echo form_fieldset('Rejection Email');
    ?>
    <input type="hidden" name="return_to" id="return_to" value="<? echo set_value('return_to', (isset($return_to) ? $return_to : 1)); ?>" readonly />
    <input type="hidden" name="trip_id" id="trip_id" value="<? echo set_value('trip_id', (isset($trip_id) ? $trip_id : ''));?>" readonly />
    <?

    echo "Trip Number: ". $trip_id;
    echo "<br />Trip Name: ". $trip_name;
    echo "<br /> From Address: ";
    $form_input = array('name' => 'from_add', 'id' => 'from_add', 'maxlength' => '50', 'size' => '50', 'value' => set_value('from_add', (isset($from_add) ? $from_add : '')));
    echo form_input($form_input);

    echo "<br / >To Address: ";
    $form_input = array('name' => 'to_add', 'id' => 'to_add', 'maxlength' => '50', 'size' => '50', 'value' => set_value('to_add', (isset($to_add) ? $to_add : '')));
    echo form_input($form_input);

    echo "<br / >CC Address: ";
    $form_input = array('name' => 'cc_add', 'id' => 'cc_add', 'maxlength' => '200', 'size' => '50', 'value' => set_value('cc_add', (isset($cc_add) ? $cc_add : '')));
    echo form_input($form_input);

    echo "<br / >BCC Address: ";
    $form_input = array('name' => 'bcc_add', 'id' => 'bcc_add', 'maxlength' => '50', 'size' => '50', 'value' => set_value('bcc_add', (isset($bcc_add) ? $bcc_add : '')));
    echo form_input($form_input);

    echo "<br / >Subject: ";
    $form_input = array('name' => 'subject', 'id' => 'subject', 'maxlength' => '50', 'size' => '50', 'value' => set_value('subject', (isset($subject) ? $subject : '')));
    echo form_input($form_input);
    echo "<br / >Message: <br / >";
    ?>
    <textarea name = 'message' id = 'message' cols = '50' rows = '5' ><? echo set_value('message', (isset($message) ? $message : '')); ?></textarea>
    <script type="text/javascript">
        //var confirm = new LiveValidation('confirm', { validMessage: '\u2713', wait: 500});
        //confirm.add( Validate.Acceptance );
    </script>
    <?

    echo "<br /><br />";
    echo form_submit('submit', 'Send Email');
    ?>
    <input type="button" value="Cancel" onclick="location.href='<? echo base_url("index.php/triplist/dtcview"); ?>';" />
    <?
    echo form_fieldset_close();
    echo form_close();
    ?>
</div>