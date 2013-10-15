<div class="content loadedContent" id="content">
<?
/* View/travAdminAddTA
 *
 * Displays the add TA form to a TA user.
 *
 * Author: Jason Helms
 *
 * Created: 2013-07-22
 * Last Edited: 2013-08-28
*/

	echo form_open('travAdminAddTA/demote');
	echo form_fieldset('Users with TA permissions');
		
	$facultyTA = $this->trav_admin_add_tas->getFacultyTA();
	$TACount = 0;
	foreach($facultyTA->result() as $rowTA)
	{
		if(!empty($rowTA))
		{
			$box = array('name' 	=> $TACount,
						 'value' 	=> $TACount,
						 'checked' 	=> false);
			if($rowTA->user_name == $this->cas->get_user())//don't display a checkbox for yourself
				echo "";
			else
				echo form_checkbox($box);
			$user_info = array('user_id'	=> $rowTA->user_id,
							   'name'		=> $rowTA->name);
			echo $rowTA->name;
			echo "<br />";
			echo form_hidden('user'.$TACount, $user_info);
		}
		$TACount++;
	}
	echo "<br />";
	echo form_hidden('TACount', $TACount);
	echo form_submit('submit', 'Demote');
?>
	<input type="button" value="Cancel" onclick="location.href='<? echo base_url("index.php/dashboard/view"); ?>';" />
<?
	echo form_close();
?>
</div>

<div class="content loadedContent" id="content">
	<?php
		echo form_open('travAdminAddTA/promote');
		echo form_fieldset('Users without TA permissions');
		
		$depts = $this->user_roles->getAllDepartments();
		$countW = 0;//W->without TA permissions
		
		foreach($depts->result() as $rowD)
		{
			$faculty = $this->trav_admin_add_tas->getFaculty($rowD->dept_code);
			if($faculty->num_rows())
			{
				echo $rowD->dept_code;
				echo ":";
				echo "<br />";
			
				foreach($faculty->result() as $rowF)
				{
					$box = array('name' 	=> 	$countW,
								 'value' 	=>	$countW,
								 'checked' 	=> 	false);
					$user_info = array('user_id' => $rowF->user_id);
					echo form_checkbox($box);
					echo $rowF->name;
					echo "<br />";
					echo form_hidden('user_infoW'.$countW, $user_info);
					$countW++;
				}
				echo "<br />";
			}
		}
		echo form_hidden('countW', $countW);
		echo form_submit('submit', 'Promote');
	?>
		<input type="button" value="Cancel" onclick="location.href='<? echo base_url("index.php/dashboard/view"); ?>';" />
	<?
		echo form_close();
	?>
</div>