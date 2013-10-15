<div class="content loadedContent" id="content">
    <?php
/* View/travAdminAddDTC
 *
 * Displays the add DTC form to a TA user.
 *
 * Author: Jason Helms
 *
 * Created: 2013-07
 * Last Edited: 2013-08-28
*/
        echo form_open('travAdminAddDTC/demote');
        echo form_fieldset('Users with DTC permissions');
        $query = $this->user_roles->getAllDepartments();
        $count = 0;
        foreach($query->result() as $row)
        {
            if(!empty($row))
            {
				$dept = $row->dept_code;
				$faculty = $this->add_dtcs->getFacultyByDept($dept);
				if($faculty->num_rows())
				{
					echo $dept;
					echo ": ";
					echo "<br />";
					foreach($faculty->result() as $rowI)//rowInner
					{
						$display_box = array('name'        => $count,
											 'id'         => $count,
											 'checked'    => false);
						$save = array('user_id'     => $rowI->user_id,
									  'dept_code'    => $dept);
						//if($rowI->user_name == $this->cas->get_user())//don't display a checkbox for yourself
							//echo "";
						//else
							echo form_checkbox($display_box);
						echo $rowI->name;
						echo "<br />";
						echo form_hidden('user'.$count, $save);
						$count++;
					}
				}
            }//end !empty row each faculty member
            echo "<br />";
        }//end faculty for dept: x

        echo form_hidden('count', $count);
        echo form_submit('submit', 'Demote');
	?>
	<input type="button" value="Cancel" onclick="location.href='<? echo base_url("index.php/dashboard/view"); ?>';" />
	<?
        echo form_close();
    ?>
</div>


<div class="content loadedContent" id="content">
<?php
        echo form_open('travAdminAddDTC/promote');
        echo form_fieldset('Users without DTC permissions');
        $queryNP = $this->user_roles->getAllDepartments();
        $countNP = 0;
        foreach($queryNP->result() as $row)
        {
            if(!empty($row))
            {
                $deptNP = $row->dept_code;
                $facultyNP = $this->add_dtcs->getFacultyByDeptNP($deptNP);
				if($facultyNP->num_rows())
				{
					echo $deptNP;
					echo ": ";
					echo "<br />";
					foreach($facultyNP->result() as $rowI)//rowInner
					{
						$display_boxNP = array('name'    => $countNP,
											 'id'         => $countNP,
											 'checked'    => false);
						$saveNP = array('user_id'     => $rowI->user_id,
										'dept_code'    => $deptNP);
						echo form_checkbox($display_boxNP);
						echo $rowI->name;
						echo "<br />";
						echo form_hidden('userNP'.$countNP, $saveNP);
						$countNP++;
					}
				}
            }//end !empty row each faculty member
            //echo "<br />";
        }//end faculty for dept: x

		echo "<br />";
        echo form_hidden('countNP', $countNP);
        echo form_submit('submit', 'Promote');
	?>
	<input type="button" value="Cancel" onclick="location.href='<? echo base_url("index.php/dashboard/view"); ?>';" />
	<?
        echo form_close();
    ?>
</div>