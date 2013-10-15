<div class="content loadedContent" id="content">		
        <?
		/* View/addDTC
		 *
		 * Displays the add DTC form to a DTC user.
		 *
		 * Author: Jason Helms
		 *
		 * Created: 2013-07
		 * Last Edited: 2013-08-29
		*/
	?>
	<?
            echo form_open('addDTC/demote1');
            echo form_fieldset('Users with DTC permissions');

            $query = $this->add_dtcs->getDepts();
            $count = 0;
            foreach($query->result() as $row)
            {
                if(!empty($row))
                {
                    echo "Department: ";
                    echo $row->dept_code;
                    echo "<br />";
                    $faculty = $this->add_dtcs->getFacultyByDept($row->dept_code);
                    foreach($faculty->result() as $row1)
                    {
                        if(!empty($row1))
                        {
                            $data = array('name'        => $count,
                                          'id'          => $count,
                                          'value'         => $row->dept_code,
                                          'checked'     => FALSE);
							$user_info = array('user_id' => $row1->user_id,
											   'dept_code' => $row->dept_code);
                            if($row1->user_name == $this->cas->get_user())//don't display a checkbox for yourself
                                echo "";
                            else
                                echo form_checkbox($data);
                            echo $row1->name;
                            echo "<br />";
                            echo form_hidden('user_info'.$count, $user_info);
                            $count++;
                        }//end !empty row each faculty member
                    }//end faculty for dept: x
                }//end !empty row dept
                echo "<br />";
            }//end depts lists

            echo form_hidden('count', $count);
            echo form_submit('submit', 'Demote');
	?>
	<input type="button" value="Cancel" onclick="location.href='<? echo base_url("index.php/dashboard/view"); ?>';" />
	<?
            echo form_close();
        ?>
</div>


<div class="content loadedContent" id="content">
    <?
            echo form_open('addDTC/promote1');
            echo form_fieldset('Users without DTC permissions');
        ?>

        <?php
            $depts = $this->add_dtcs->getDepts();
            $countNP = 0;
            foreach($depts->result() as $row)
            {
                if(!empty($row))
                {
                    echo "Department: ";
                    echo $row->dept_code;
                    echo "<br />";
                    $facultyNP = $this->add_dtcs->getFacultyByDeptNP($row->dept_code);

                    foreach($facultyNP->result() as $row1)
                    {
                        if(!empty($row1))
                        {
                            $data = array('name'        => $countNP,
                                          'id'          => $countNP,
                                          'value'         => $row->dept_code,
                                          'checked'     => FALSE);
							$user_infoNP = array('user_id' =>$row1->user_id,
												'dept_code' =>$row->dept_code);
                            echo form_checkbox($data);
                            echo $row1->name;
                            echo "<br />";
                            echo form_hidden('user_infoNP'.$countNP, $user_infoNP);
                            $countNP++;
                        }//end !empty row each faculty member
                    }//end faculty for dept: x

                    echo "<br />";
                }//end non empty dept query
            }

            echo form_hidden('countNP', $countNP);
            echo form_submit('submit', 'Promote');
	?>
	<input type="button" value="Cancel" onclick="location.href='<? echo base_url("index.php/dashboard/view"); ?>';" />
	<?
            echo form_close();
        ?>
</div>