<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?
		/* View/printforms
		 *
		 * Displays the final form for a user to print.
		 *
		 * Author: Jason Helms, Josh Smith
		 *
		 * Created: 2013-08-13
		 * Last Edited: 2013-08-22
		*/
	?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>EWU Travel Form</title>
</head>
<!-- style sheet for the form-->
<link href="/../assets/trav_form.css" rel="stylesheet" />

<body class="body">
<!-- START PRE TRIP -->
<div class="page">
<div class="main">
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" class="t2">
<tr>
	<!-- first cell contains everything up to the modes of travel (and note) -->
	<td colspan="2">
		<table cellpadding="0" cellspacing="0" width="100%">
        <tr>
        
     		<!-- handles the first two "rows" with group count and EWU ID -->
            <td valign="top" width="65%">
                <table width=100% border="0" cellpadding="0" cellspacing="0">
                <tr>
                	<!-- GROUP COUNT -->
                    <td width="40%" valign="top"><br />&nbsp;1. Group Count: &nbsp;&nbsp;
					<?php  
						$set_id = $this->print_form->getDBTripId();
						$this->print_form->set_id($set_id);
						$this->print_form->deleteDBTripId();
                        $groupCount = $this->print_form->group_count();
                        echo $groupCount;
                    ?>
						(if applicable)</td>
                    <td width="30%" rowspan="2" valign="top" align="center"><img src="/../assets/form_logo.jpg" width="110" height="31" /><br /><b>TRAVEL
                    AUTHORIZATION</b></td>
                  	<td width="30%" valign="top"><font class="small"><b>Send completed form to: <br />Travel Acctg 319 Showalter Hall</b></font></td>
                </tr>
                <tr>
                	<!-- EWU ID -->
                    <td valign="bottom">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EWU ID(8 Digits): 
						<?php
								$id = $this->print_form->get_id();
								echo $id;
								$test = $this->session->userdata('print_trip');
								echo $test;
						?>
						</td>
                    <td align="left" valign="bottom">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><font class="small">(Before Trip)</font></b></td>
                </tr>
                </table>
            </td>
            
            <!-- TRAVEL AUTH BOX (UPPER RIGHT HAND CORNER) -->
            <td width="35%" align="right" valign="top">
            	<table cellpadding="1" cellspacing="0" border="1" bordercolor="#000000" width="100%" height="100%" class="t1">
                <tr>
                	<td width="110" align="center" valign="bottom"><b>Travel Authorization No.</b><?php //echo $this->print_form->get_AuthorizationNumber();?></td>
                    <td width="90" align="center" bgcolor="#D6D5FF"><b>Encumbrance No.<br /><font class="small">(Travel use only)</font></b></td>
                </tr>
                <tr>
                	<td><font color="#FF0000"><b>T</b></font> 
					<?php
						echo $this->print_form->get_TAN();
					?>
					</td>
                    <td bgcolor="#D6D5FF"><b><font color="#FF0000">E<font class="small">00</font>2</font></b></td>
                </tr>
                </table>
            </td>
            
            <!-- END TRAVEL AUTH BOX -->
    	</tr>
		<tr>
			<td colspan="2">
            	<!-- TRAVELER NAME, OFFICE PHONE AND BLDG/ROOM #  -->
            	<table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td width="35%" align="left">&nbsp;&nbsp;&nbsp;&nbsp; Name: <?php
																			//size 29
																			$name = $this->print_form->get_name();
																			echo $name;
																		  ?>
					</td>
                    <td width="30%">Office Phone: <?php
													//size 26
													$office_phone = $this->print_form->get_office_phone();
													echo $office_phone;
												  ?>
					</td>
                    <td width="35%">Bldg. & Room.: <?php
													//size 29
													$bldg_rm = $this->print_form->get_bldg_rm();
													echo $bldg_rm;
												  ?>
					</td>
          		 </tr>
          		</table>
        	</td>
    	</tr>
        <tr>
        	<td colspan="2">
            	<!-- MAILING ADDRESS (LINE 1) & PREPARER'S NAME -->
            	<table width="100%" cellspacing="0" cellpadding="0">
                <tr>
                	<td width="55%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mailing Address: <?php
																				//length 54
																				$mail_addy_1 = $this->print_form->get_mail_1();
																				echo $mail_addy_1;
																			 ?>
																			 </td>
                    <td width="45%">Prepared by:&nbsp;&nbsp;&nbsp;<?php
																							//length 41
																							$prep_by = $this->print_form->get_preper();
																							echo $prep_by;
																						  ?>
																						</td>
                </tr>
                </table>
            </td>
        </tr>
        <tr>
        	<td colspan="2">
            
            	<!-- MAILING ADDRESS (LINE 2) & PHONE NO. -->
            	<table width="100%" cellspacing="0" cellpadding="0">
                <tr>
                	<td width="55%">&nbsp;&nbsp;&nbsp;&nbsp; <?php
																//length 69
																$mail_line_2 = $this->print_form->get_mail_2();
																echo $mail_line_2;
															 ?>
														    </td>
                    <td width="45%">Phone:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php
																													//length 42
																													$phone = $this->print_form->get_phone();
																													echo $phone;
																												  ?>
																												</td>
                </tr>
                </table>
            </td>
        </tr>
         <tr>
        	<td colspan="2">
            	<!-- TRAVEL FROM & TO -->
            	<table width="100%" cellspacing="0" cellpadding="0">
                <tr>
                	<td width="55%">&nbsp;2. Travel From: 
															<?php
																$from = $this->print_form->get_from();
																echo $from;
															?>
					</td>
                    <td width="45%">To: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																																			<?php
																																				$to = $this->print_form->get_to();
																																				echo $to;
																																			?>
					</td>
                </tr>
                </table>
            </td>
        </tr>
         <tr>
        	<td colspan="2">
            	<!-- TRIP PURPOSE -->
            	<table width="100%" cellspacing="0" cellpadding="0">
                <tr>
                	<td>&nbsp;3. Purpose of Trip:
													<?php
														$purp = $this->print_form->get_purpose();
														echo $purp;
													?>
					</td>
                </tr>
                </table>
            </td>
        </tr>
        <tr>
        	<td colspan="2">
            	<!-- SIDE TRIP CHECKBOX AND TEXT -->
            	<table width="100%" cellspacing="0" cellpadding="0">
                <tr>
                	<td>&nbsp;&nbsp;&nbsp;&nbsp;<?php 
													$form_data = array('name'	=> 	'sidetrip',
																	   'id'		=> 	'sidetrip',
																	   'disabled' => 'disabled',
																	   'checked'=>	$this->print_form->personal_checked());
													echo form_checkbox($form_data);
												?> 
												Personal side trip will be taken on (dates):
																							<?php
																								$side_trip = $this->print_form->get_side_trip();
																								echo $side_trip;
																							?>
					</td>
                </tr>
                </table>
            </td>
        </tr>
        <tr>
        	<td colspan="2">
            	<!-- TRAVEL DATES & TIMES-->
            	<table width="100%" cellspacing="0" cellpadding="0">
                <tr>
					<td width="25%">&nbsp;4. Date of Departure: <?php echo $this->print_form->get_dept_date()?></td>
                    <td width="25%" align="center">Est. Time: <?php echo $this->print_form->get_dept_time()?></td>
                    <td width="25%" align="center">Date of Return: <?php echo $this->print_form->get_ret_date()?></td>
                    <td width="25%" align="center">Est. time: <?php echo $this->print_form->get_ret_time()?></td>
                </tr>
                </table>
            </td>
        </tr>
        <tr>
        	<td colspan="2">
            	<!-- TRAVEL MODES -->
            	<table width="100%" cellspacing="0" cellpadding="0">
                <tr>
                	<td>&nbsp;5. Mode of Travel: <?php 
													$form_data = array('name'		=> 	'Air',
																	   'id'			=> 	'Air',
																	   'disabled' 	=> 'disabled',
																	   'checked'	=>	$this->print_form->Air_checked());
													echo form_checkbox($form_data);
												?> Air&nbsp;&nbsp;&nbsp;
                    							 <?php 
													$form_data = array('name'		=> 	'Train',
																	   'id'			=> 	'Train',
																	   'disabled' 	=> 'disabled',
																	   'checked'	=>	$this->print_form->Train_checked());
													echo form_checkbox($form_data);
												?> Train&nbsp;&nbsp;&nbsp;
                                                 <?php 
													$form_data = array('name'		=> 	'Bus',
																	   'id'			=> 	'Bus',
																	   'disabled' 	=> 'disabled',
																	   'checked'	=>	$this->print_form->Bus_checked());
													echo form_checkbox($form_data);
												?> Bus&nbsp;&nbsp;&nbsp;
                                                 <?php 
													$form_data = array('name'		=> 	'EMP',
																	   'id'			=> 	'EMP',
																	   'disabled' 	=> 'disabled',
																	   'checked'	=>	$this->print_form->EMP_checked());
													echo form_checkbox($form_data);
												?> EWU Motor Pool&nbsp;&nbsp;&nbsp;
                                                 <?php 
													$form_data = array('name'		=> 	'Privately_owned',
																	   'id'			=> 	'Privately_owned',
																	   'disabled' 	=> 'disabled',
																	   'checked'	=>	$this->print_form->Privately_owned_checked());
													echo form_checkbox($form_data);
												?> Privately-owned car&nbsp;&nbsp;&nbsp;
                                                 <?php 
													$form_data = array('name'		=> 	'RentalCar',
																	   'id'			=> 	'RentalCar',
																	   'disabled' 	=> 'disabled',
																	   'checked'	=>	$this->print_form->Rental_car_checked());
													echo form_checkbox($form_data);
												?> Rental Car*&nbsp;&nbsp;&nbsp;
                                                 <?php 
													$form_data = array('name'		=> 	'Charter',
																	   'id'			=> 	'Charter',
																	   'disabled' 	=> 'disabled',
																	   'checked'	=>	$this->print_form->Charter_checked());
													echo form_checkbox($form_data);
												?> Charter*&nbsp;&nbsp;&nbsp;
                                                 <?php 
													$form_data = array('name'		=> 	'Courtesy',
																	   'id'			=> 	'Courtesy',
																	   'disabled' 	=> 'disabled',
																	   'checked'	=>	$this->print_form->Courtesy_checked());
													echo form_checkbox($form_data);
												?> Courtesy*
                	</td>
                </tr>
                </table>
            </td>
         </tr>
         <tr>
        	<td colspan="2">
            	<table width="100%" cellspacing="0" cellpadding="0">
                <tr>
                	<td><font class="small" color="#FF0000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* All passengers via this mode (marked with asterix) must be authorized per SAAM 10.50.35c (attach the group roster prior to travel date).</font>
                    </td>
                </tr>
                </table>
            </td>
        </tr>
        </table>
     </td>
</tr>
<!-- END TRAVELER/TRAVEL INFORMATION -->
<tr>
	<!-- item 6 -->
	<td width="42%" valign="top">
    	<!-- MONEY CALCULATIONS: AIRFARE, RENTAL CAR, PER DIEM, REGISTRATION, MISC -->
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
        	<td colspan="2">&nbsp;6. Estimated Expenses:</td>
        </tr>
        <tr>
        	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Airfare (if corporate card was used, see Box 8)</td>
            <td align="right"><u><?php $airfare = $this->print_form->get_Airfare(); 
									   $airfare = number_format($airfare, 2);
									   echo '$'.$airfare; ?></td></u>
        </tr>
        <tr>
        	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rental Car (Enterprise is the contracted provider)</td>
            <td align="right"><u><?php $rentalCar = $this->print_form->get_RentalCar(); 
									   $rentalCar = number_format($rentalCar, 2);
									   echo '$'.$rentalCar; ?></u></td>
        </tr>
        <tr>
        	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Privately Owned Motor Vehicle</td>
            <td align="right"><u><?php $privateVehicle = $this->print_form->get_PrivVehicle();
									   $privateVehicle = number_format($privateVehicle, 2);
								       echo '$'.$privateVehicle; ?></u></td>
        </tr>
        <tr>
        	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Per diem (substistence & lodging)</td>
            <td align="right"><u><?php $perDiem = $this->print_form->get_PerDiem(); 
									   $perDiem = number_format($perDiem, 2);
									   echo '$'.$perDiem; ?></u></td>
        </tr>
        <tr>
        	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Registration:</td>
            <td align="right"><u><?php $registration = $this->print_form->get_Registration();
									   $registration = number_format($registration, 2);
									   echo '$'.$registration; ?></u></td>
        </tr>
        <tr>
        	<td colspan="2">
        		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        		<?php $data = array('name'		=> 	'PayTravAccount',
					  			 'id'			=> 	'PayTravAccount',
					  			 'disabled' 	=> 'disabled',
					  			 'checked'		=>	$this->print_form->PayTravAccount_checked());
					   echo form_checkbox($data); ?> Pay through Travel Accounting<br />
        		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        		<?php $data = array('name'		=> 	'PayDeptPCard',
					  			 'id'			=> 	'PayDeptPCard',
					  			 'disabled' 	=> 'disabled',
					  			 'checked'		=>	$this->print_form->DeptPCard_checked());
					  echo form_checkbox($data); ?> Pay by Departmental P-card<br />
        		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        		<?php $data = array('name'		=> 	'PayTravler',
					  			 'id'			=> 	'PayTravler',
					  			 'disabled' 	=> 'disabled',
					  			 'checked'		=>	$this->print_form->PayTravler_checked());
					  echo form_checkbox($data); ?> Traveler will pay (obtain receipt for reimbursement)
            </td>
        </tr>
        <tr>
        	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Other travel-related expenses</td>
            <td align="right"><u><?php $other = $this->print_form->get_Other(); 
									   $other = number_format($other, 2);
									   echo '$'.$other; ?></u></td>
        </tr>
        <tr>
        	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Estimated Expenses</td>
            <td align="right"><?php 
									$total = $this->print_form->get_PerDiem();
									$total += $this->print_form->get_Airfare();
								    $total += $this->print_form->get_PrivVehicle();
									$total += $this->print_form->get_Registration();
									$total += $this->print_form->get_Other();
									$total += $this->print_form->get_RentalCar();
									$total = number_format($total, 2);
									echo '$'.$total; ?></td>
        </tr>
		</table>
    
    </td>
<!-- !!!!!!!!!!!!!!!!!!!!!!!!!!There is no model/controller logic for any of the data in box 8!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!-->
    <!-- items 8/9 -->
    <td rowspan="4" width="58%" valign="top">
    	<table width="100%" cellpadding="0" cellspacing="0" border="0">
        	<tr>
            	<!-- TRAVEL ADVANCE REQUEST AMOUNT -->
            	<td valign="top" width="70%">8. <b>Travel Advance</b> is requested in the amount of</td>
                <td align="right">$_________________<br /><br /></td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                	<table width="95%" cellpadding="0" cellspacing="0">
                    <tr>
                    	<td><font color="#FF0000">Notice and acknowledgement</font>: This cash advance is subject to state travel policy set forth in SAAM 10.80.60 and 10.80.70. In the event of failure to complete a travel expense report or otherwise account for this advance <b>BY THE 10TH DAY OF THE FOLLOWING MONTH, I ACKNOWLEDGE THAT EWU WILL WITHHOLD FROM MY PAYROLL CHECK</b> the portion in default and understand that the unsubstantiated portion of the cash advance will be treated as taxable income and is subject to applicable federal taxes.<br /><br />
                        <!-- AIRFARE REIMBURSEMENT -->
    <b>Airfare reimbursement</b> is requested prior to trip&nbsp;&nbsp;&nbsp;&nbsp;$_________________<br  />
    I used my EWU corporate card to purchase the airline tickets. Itnerary and receipt is attached. Any unused portrion will be submitted to my department.<br /><br />
    					</td>
                    </tr>
                    <tr>
                    	<!-- MAIL CHECK OPTION SET HERE -->
						<td><?php	$data = array('name'		=> 	'LodgeRequest',
												  'id'			=> 	'LodgeRequest',
												  'disabled' 	=>  'disabled',
												  'checked'		=>	$this->print_form->LogExcep_checked());
									echo form_checkbox($data);?> Mail to above address
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    					<?php	$data = array('name'		=> 	'LodgeRequest',
												  'id'			=> 	'LodgeRequest',
												  'disabled' 	=>  'disabled',
												  'checked'		=>	$this->print_form->LogExcep_checked());
								echo form_checkbox($data);?> Pick up check from Cashier, 202 Sutton Hall<br /><br  />
    					</td>
                    </tr>
                    <tr>
                    	<td>Sign below for cash advance and/or early airfare reimbursement.</td>
    				</tr>
                    </table>
    			</td>
            </tr>
			
<!-- !!!!!!!!!!!!!!!!!!!!!!!!!!^^^^There is no model/controller logic for any of the data in box 8^^^^!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!-->
            <tr>
                <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;X_____________________________________________________________________________________
                </td>
        	</tr>
        	<tr>
        		<td>&nbsp;&nbsp;&nbsp;&nbsp;<font class="small">Traveler Signature</font></td>
        		<td align="right"><font class="small">Date</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        	</tr>
			</table>
                <hr width="100%" size="2" color="#000000" />
        	<table width="100%" cellpadding="0" cellspacing="0">
        	<tr>
        		<td colspan="2">9. Authorizations for estimated expenses in Box 6.</td>
        	</tr>
        	<tr>
                 <td colspan="2">
                    &nbsp;&nbsp;&nbsp;&nbsp;<font class="small">X</font>_____________________________________________________________________________________
                 </td>
        	</tr>
        	<tr>
        		 <td width="70%">&nbsp;&nbsp;&nbsp;&nbsp;<font class="small">Supervisor Signature</font></td>
        		 <td align="right"><font class="small">Date</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        	</tr>
        	<tr>
                 <td colspan="2">
                    &nbsp;&nbsp;&nbsp;&nbsp;<font class="small">X</font>_____________________________________________________________________________________
                 </td>
        	</tr>
        		 <td>&nbsp;&nbsp;&nbsp;&nbsp;<font class="small">Budget Authority Signature (signature must be on file in Purchasing Dept.)</font>	
                 </td>
        		 <td align="right"><font class="small">Date</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        	</tr>
            <tr>
                 <td colspan="2">
                    &nbsp;&nbsp;&nbsp;&nbsp;<font class="small">X</font>_____________________________________________________________________________________
                 </td>
        	</tr>
        		 <td>&nbsp;&nbsp;&nbsp;&nbsp;<font class="small">Vice President approval for international travel</font></td>
        	     <td align="right"><font class="small">Date</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        	</tr>
            <tr>
                   <td colspan="2">
                    &nbsp;&nbsp;&nbsp;&nbsp;<font class="small">X</font>_____________________________________________________________________________________
                 </td>
        	</tr>
        		 <td>&nbsp;&nbsp;&nbsp;&nbsp;<font class="small">Other approvals or acknowledgments (if applicable)</font></td>
        		 <td align="right"><font class="small">Date</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        	</tr>
            <tr>
                 <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;If index code begins with a 5, route TA Form to EWU Grants Office 210 SHW
                  </td>
        	</tr>
		</table>
    </td>
</tr>
<tr>
	<td>&nbsp;Lodging expense exception requested: <?php	$data = array('name'		=> 	'LodgeRequest',
																		 	'id'		=> 	'LodgeRequest',
																		 	'disabled'  =>  'disabled',
																		 	'checked'	=>	$this->print_form->LogExcep_checked());
															echo form_checkbox($data);?> Yes 
    	<font class="small">(enter reson below)</font><br/><br />
        <!-- LODGING EXCEPTION REASON HERE -->
	</td>
</tr>
<tr>
	<!-- TRANSPORTATION REQUESTS-->
	<td>&nbsp;7. A Transportation Request is needed for (select all that apply):<br />&nbsp;&nbsp;&nbsp;&nbsp;
    <?php	$data = array('name'		=> 	'AirRequest',
						 	'id'		=> 	'AirRequest',
						    'disabled'  =>  'disabled',
						 	'checked'	=>	$this->print_form->AirRequest_checked());
			echo form_checkbox($data);?> Air&nbsp;&nbsp;&nbsp;
    <?php	$data = array('name'		=> 	'RentalCarRequest',
						 	'id'		=> 	'RentalCarRequest',
						    'disabled'  =>  'disabled',
						 	'checked'	=>	$this->print_form->RentalCarRequest_checked());
			echo form_checkbox($data);?> Rental Car&nbsp;&nbsp;&nbsp;
    <?php	$data = array('name'		=> 	'TrainRequest',
						 	'id'		=> 	'TrainRequest',
						    'disabled'  =>  'disabled',
						 	'checked'	=>	$this->print_form->TrainRequest_checked());
			echo form_checkbox($data);?> Train&nbsp;&nbsp;&nbsp;<br />
    &nbsp;&nbsp;&nbsp;&nbsp;<font class="small">Travel agency where airline reservation is held: <?php $TravAgent = $this->print_form->get_TravAgent(); echo $TravAgent;?> </font><br />
    <!-- AIRLINE TRAVEL AGENCY -->
    &nbsp;&nbsp;&nbsp;&nbsp;Pay by
    <!-- AIRLINE PAY BY -->
     <?php	$data = array('name'		=> 	'PayByCentralCTAAirline',
						 	'id'		=> 	'PayByCentralCTAAirline',
						    'disabled'  =>  'disabled',
						 	'checked'	=>	$this->print_form->PayByCentralCTAAirline_checked());
			echo form_checkbox($data);?> Central CTA (Travel Acctg)&nbsp;&nbsp;&nbsp;
    <?php	$data = array('name'		=> 	'PayByDeptCTAAirline',
						 	'id'		=> 	'PayByDeptCTAAirline',
						    'disabled'  =>  'disabled',
						 	'checked'	=>	$this->print_form->PayByDeptCTAAirline_checked());
			echo form_checkbox($data);?> Department CTA<br />
    <!-- RENTAL CAR AGENCY-->
     &nbsp;&nbsp;&nbsp;&nbsp;<font class="small">Rental Car Agency/Phone:  <?php echo $this->print_form->get_RentalCarAgentPhone(); ?></font><br />
     &nbsp;&nbsp;&nbsp;&nbsp;Pay by 
     <!-- RENTAL CAR PAY BY-->
     <?php	$data = array('name'		=> 	'PayByCentralCTARentalCar',
						 	'id'		=> 	'PayByCentralCTARentalCar',
						    'disabled'  =>  'disabled',
						 	'checked'	=>	$this->print_form->PayByCentralCTARentalCar_checked());
			echo form_checkbox($data);?> Central CTA (Travel Acctg)&nbsp;&nbsp;&nbsp;
     <?php	$data = array('name'		=> 	'PayByDeptCTARentalCar',
						 	'id'		=> 	'PayByDeptCTAARentalCar',
						    'disabled'  =>  'disabled',
						 	'checked'	=>	$this->print_form->PayByDeptCTARentalCar_checked());
			echo form_checkbox($data);?> Department CTA<br />
    &nbsp;&nbsp;&nbsp;&nbsp; 
      <?php	$data = array('name'		=> 	'PayByPersonalRentalCar',
						 	'id'		=> 	'PayByPersonalRentalCar',
						    'disabled'  =>  'disabled',
						 	'checked'	=>	$this->print_form->PayByPersonalRentalCar_checked());
			echo form_checkbox($data);?> I will use my corporate or personal credit card for rental car<br />
     <center><font  class="small">See SAAM 10.50.35, 12.20.05 & 12.40 for Vehicle Use, Insurance & Restrictions</font></center>
	</td>
</tr>

<tr>
	<td valign="top">
    	<table border="1" bordercolor="#000000" width="100%" cellspacing="0" class="t1">
        	<tr>
        		<td colspan="3" align="center">To apply for an EWU corporate card, click here or call 359-2249
                </td>
            </tr>
            <tr>
            	<!-- INDEX CODES & AMOUNTS GO HERE -->
				
                <td align="center" widht="50%">Index Code</td>
                <td align="center" width="15%">Percent</td>
                <td align="center" width="35%">Amount</td> 
            </tr>
            <tr>
                <td align="center">&nbsp;<?php $indexCode1 = $this->print_form->get_IndexCode1(); echo $indexCode1;?></td>
                <td align="right"><?php $indexPercent1 = $this->print_form->get_IndexPercent1(); if($indexPercent1 > 0)echo $indexPercent1.'%';?></td>
                <td align="right"><?php $indexAmt1 = $this->print_form->get_IndexAmt1(); if($indexAmt1 > 0){echo '$'.$indexAmt1;}?></td> 
            </tr>
            <tr>
                <td align="center">&nbsp;<?php $indexCode2 = $this->print_form->get_IndexCode2(); echo $indexCode2;?></td>
                <td align="right"><?php $indexPercent2 = $this->print_form->get_IndexPercent2(); if($indexPercent2 > 0)echo $indexPercent2.'%';?></td>
                <td align="right"><?php $indexAmt2 = $this->print_form->get_IndexAmt2(); if($indexAmt2 > 0){echo '$'.$indexAmt2;}?></td> 
            </tr>
            <tr>
                <td align="center">&nbsp;<?php $indexCode3 = $this->print_form->get_IndexCode3(); echo $indexCode3;?></td>
                <td align="right"><?php $indexPercent3 = $this->print_form->get_IndexPercent3(); if($indexPercent3 > 0)echo $indexPercent3.'%';?></td>
                <td align="right"><?php $indexAmt3 = $this->print_form->get_IndexAmt3(); if($indexAmt3 > 0){echo '$'.$indexAmt3;}?></td> 
            </tr>
                    <tr>
                <td align="center" widht="35%">Totals <font class="small">(agree to total in box 6)</font></td>
                <td align="right" width="25%"><?php $totalPercent = $this->print_form->get_IndexTotalPercent(); 
													if($totalPercent > 0)
														echo $totalPercent.'%';?></td>
                <td align="right"><?php $totalAmount = $this->print_form->get_IndexTotalAmount(); 
										$totalAmount = number_format($totalAmount, 2);
										echo '$'.$totalAmount;?></td> 
            </tr>    
            <tr bgcolor="#D6D5FF">
                <td colspan="2"><b>Encumbrance Amt</b> <font class="small">(Travel Accounting use only)</font></td>
                <td align="right"></td> 
            </tr>
            <tr>
		</table>
	</td>
</tr>
</table>
<!-- END PRE TRIP-->
<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td align="center">
<b><font class="large">TRAVEL EXPENSE VOUCHER</font> (complete by 10th day of month that follows return from trip)</b>
</td></tr></table>

<!-- Stubbed model needs real life logic then yay! -->

<!-- BEGIN POST TRIP -->
<table cellspacing="0" cellpadding="0" width="100%" border="1" bordercolor="#000000" class="t2">
	<tr>
    	<!-- this cell holds TRAVEL INFORMATION -->
    	<td colspan="3">
        	<table width="100%" cellspacing="0" border="1" bordercolor="#000000" class="t1">
            <tr>
            	<td colspan="5"><b>Travel Information</b></td>
                <td colspan="6">Click Here for Per Diem Rates</td>
            </tr>
            <tr>
            	<td align="center" width="8%">Date</td>
                <td align="center" width="14%">From</td>
                <td align="center" width="8%">Actual<br />Depart Time</td>
                <td align="center" width="14%">To</td>
                <td align="center" width="8%">Actual<br />Arrival Time</td>
                <td align="center" width="7%">Brkfast<br />7-8 a</td>
                <td align="center" width="7%">Lunch<br />12-1 p</td>
                <td align="center" width="7%">Dinner<br />6-7 p</td>
                <td align="center" width="7%">Actual Lodging</td>
                <td align="center" width="7%">Daily Subtotal</td>
                <td align="center">Total Per Diem<br />and Lodging</td>
            </tr>
            <!-- PER DIEM RECORDS GO HERE (6 of them)-->
            <tr>
            	<td align="center" width="8%">&nbsp; <?php	$PDDateR1	= $this->print_form->get_PDDateR1(); 	echo $PDDateR1;?></td>
                <td align="center" width="14%">&nbsp;<?php	$PDFromR1 	= $this->print_form->get_PDFromR1(); 	echo $PDFromR1;?></td>
                <td align="center" width="8%">&nbsp; <?php	$PDActDeptR1= $this->print_form->get_PDActDeptR1(); echo $PDActDeptR1;?></td>
                <td align="center" width="14%">&nbsp;<?php	$PDToR1 	= $this->print_form->get_ToR1(); 		echo $PDToR1;?></td>
                <td align="center" width="8%">&nbsp; <?php	$PDArrR1 	= $this->print_form->get_PDArrR1(); 	echo $PDArrR1;?></td>
                <td align="center" width="7%">&nbsp; <?php	$PDBreakR1 	= $this->print_form->get_PDBreakR1(); 	if($PDBreakR1 > 0)echo '$'.$PDBreakR1;?></td>
                <td align="center" width="7%">&nbsp; <?php	$PDLunchR1 	= $this->print_form->get_PDLunchR1(); 	if($PDLunchR1 > 0)echo '$'.$PDLunchR1;?></td>
                <td align="center" width="7%">&nbsp; <?php	$PDDinnerR1 = $this->print_form->get_PDDinnerR1(); 	if($PDDinnerR1 > 0)echo '$'.$PDDinnerR1;?></td>
                <td align="center" width="7%">&nbsp; <?php	$PDLodgeR1 	= $this->print_form->get_PDLodgeR1(); 	if($PDLodgeR1 > 0)echo '$'.$PDLodgeR1;?></td>
                <td align="center" width="7%">&nbsp; <?php	$PDTotalR1 	= $this->print_form->get_PDTotalR1(); 	if($PDTotalR1 > 0)echo '$'.$PDTotalR1;?></td>
                <!-- PER DIEM TOTAL GOES IN THIS CELL: -->
                <td align="right" rowspan="6" valign="bottom">&nbsp;<?php 
																		$print = $this->print_form->get_PDTotalR1() + $this->print_form->get_PDTotalR2() + $this->print_form->get_PDTotalR3() + $this->print_form->get_PDTotalR4() + $this->print_form->get_PDTotalR5() + $this->print_form->get_PDTotalR6();
																		$print = number_format($print, 2); 
																		echo '$'.$print;;
																	?></td>
            </tr>
            <tr>
            	<td align="center" width="8%">&nbsp; <?php $PDDateR2 	= $this->print_form->get_PDDateR2();	echo $PDDateR2;?></td>
                <td align="center" width="14%">&nbsp;<?php $PDFromR2 	= $this->print_form->get_PDFromR2(); 	echo $PDFromR2;?></td>
                <td align="center" width="8%">&nbsp; <?php $PDActDeptR2 = $this->print_form->get_PDActDeptR2(); echo $PDActDeptR2;?></td>
                <td align="center" width="14%">&nbsp;<?php $PDToR2 		= $this->print_form->get_ToR2(); 		echo $PDToR2;?></td>
                <td align="center" width="8%">&nbsp; <?php $PDArrR2 	= $this->print_form->get_PDArrR2(); 	echo $PDArrR2;?></td>
                <td align="center" width="7%">&nbsp; <?php $PDBreakR2 	= $this->print_form->get_PDBreakR2(); 	if($PDBreakR2 > 0)echo '$'.$PDBreakR2;?></td>
                <td align="center" width="7%">&nbsp; <?php $PDLunchR2 	= $this->print_form->get_PDLunchR2(); 	if($PDLunchR2 > 0)echo '$'.$PDLunchR2?></td>
                <td align="center" width="7%">&nbsp; <?php $PDDinnerR2 	= $this->print_form->get_PDDinnerR2(); 	if($PDDinnerR2 > 0)echo '$'.$PDDinnerR2?></td>
                <td align="center" width="7%">&nbsp; <?php $PDLodgeR2 	= $this->print_form->get_PDLodgeR2(); 	if($PDLodgeR2 > 0)echo '$'.$PDLodgeR2?></td>
                <td align="center" width="7%">&nbsp; <?php $PDTotalR2 	= $this->print_form->get_PDTotalR2(); 	if($PDTotalR2 > 0)echo '$'.$PDTotalR2?></td>
            </tr>
            <tr>
            	<td align="center" width="8%">&nbsp; <?php $PDDateR3 	= $this->print_form->get_PDDateR3(); 	echo $PDDateR3;?></td>
                <td align="center" width="14%">&nbsp;<?php $PDFromR3 	= $this->print_form->get_PDFromR3(); 	echo $PDFromR3;?></td>
                <td align="center" width="8%">&nbsp; <?php $PDActDeptR3 = $this->print_form->get_PDActDeptR3(); echo $PDActDeptR3;?></td>
                <td align="center" width="14%">&nbsp;<?php $PDToR3 		= $this->print_form->get_ToR3(); 		echo $PDToR3;?></td>
                <td align="center" width="8%">&nbsp; <?php $PDArrR3 	= $this->print_form->get_PDArrR3(); 	echo $PDArrR3;?></td>
                <td align="center" width="7%">&nbsp; <?php $PDBreakR3 	= $this->print_form->get_PDBreakR3(); 	if($PDBreakR3 > 0)echo '$'.$PDBreakR3;?></td>
                <td align="center" width="7%">&nbsp; <?php $PDLunchR3 	= $this->print_form->get_PDLunchR3(); 	if($PDLunchR3 > 0)echo '$'.$PDLunchR3?></td>
                <td align="center" width="7%">&nbsp; <?php $PDDinnerR3 	= $this->print_form->get_PDDinnerR3(); 	if($PDDinnerR3 > 0)echo '$'.$PDDinnerR3?></td>
                <td align="center" width="7%">&nbsp; <?php $PDLodgeR3 	= $this->print_form->get_PDLodgeR3(); 	if($PDLodgeR3 > 0)echo '$'.$PDLodgeR3?></td>
                <td align="center" width="7%">&nbsp; <?php $PDTotalR3 	= $this->print_form->get_PDTotalR3(); 	if($PDTotalR3 > 0)echo '$'.$PDTotalR3?></td>
            </tr>
            <tr>
            	<td align="center" width="8%">&nbsp; <?php $PDDateR4 	= $this->print_form->get_PDDateR4(); 	echo $PDDateR4;?></td>
                <td align="center" width="14%">&nbsp;<?php $PDFromR4 	= $this->print_form->get_PDFromR4(); 	echo $PDFromR4;?></td>
                <td align="center" width="8%">&nbsp; <?php $PDActDeptR4 = $this->print_form->get_PDActDeptR4(); echo $PDActDeptR4;?></td>
                <td align="center" width="14%">&nbsp;<?php $PDToR4 		= $this->print_form->get_ToR4(); 		echo $PDToR4;?></td>
                <td align="center" width="8%">&nbsp; <?php $PDArrR4 	= $this->print_form->get_PDArrR4(); 	echo $PDArrR4;?></td>
                <td align="center" width="7%">&nbsp; <?php $PDBreakR4 	= $this->print_form->get_PDBreakR4(); 	if($PDBreakR4 > 0)echo '$'.$PDBreakR4;?></td>
                <td align="center" width="7%">&nbsp; <?php $PDLunchR4 	= $this->print_form->get_PDLunchR4(); 	if($PDLunchR4 > 0)echo '$'.$PDLunchR4?></td>
                <td align="center" width="7%">&nbsp; <?php $PDDinnerR4 	= $this->print_form->get_PDDinnerR4(); 	if($PDDinnerR4 > 0)echo '$'.$PDDinnerR4?></td>
                <td align="center" width="7%">&nbsp; <?php $PDLodgeR4 	= $this->print_form->get_PDLodgeR4(); 	if($PDLodgeR4 > 0)echo '$'.$PDLodgeR4?></td>
                <td align="center" width="7%">&nbsp; <?php $PDTotalR4 	= $this->print_form->get_PDTotalR4(); 	if($PDTotalR4 > 0)echo '$'.$PDTotalR4?></td>
            </tr><tr>
            	<td align="center" width="8%">&nbsp; <?php $PDDateR5 	= $this->print_form->get_PDDateR5(); 	echo $PDDateR5;?></td>
                <td align="center" width="14%">&nbsp;<?php $PDFromR5 	= $this->print_form->get_PDFromR5(); 	echo $PDFromR5;?></td>
                <td align="center" width="8%">&nbsp; <?php $PDActDeptR5 = $this->print_form->get_PDActDeptR5(); echo $PDActDeptR5;?></td>
                <td align="center" width="14%">&nbsp;<?php $PDToR5 		= $this->print_form->get_ToR5(); 		echo $PDToR5;?></td>
                <td align="center" width="8%">&nbsp; <?php $PDArrR5 	= $this->print_form->get_PDArrR5(); 	echo $PDArrR5;?></td>
                <td align="center" width="7%">&nbsp; <?php $PDBreakR5 	= $this->print_form->get_PDBreakR5(); 	if($PDBreakR5 > 0)echo '$'.$PDBreakR5;?></td>
                <td align="center" width="7%">&nbsp; <?php $PDLunchR5 	= $this->print_form->get_PDLunchR5(); 	if($PDLunchR5 > 0)echo '$'.$PDLunchR5?></td>
                <td align="center" width="7%">&nbsp; <?php $PDDinnerR5 	= $this->print_form->get_PDDinnerR5(); 	if($PDDinnerR5 > 0)echo '$'.$PDDinnerR5?></td>
                <td align="center" width="7%">&nbsp; <?php $PDLodgeR5 	= $this->print_form->get_PDLodgeR5(); 	if($PDLodgeR5 > 0)echo '$'.$PDLodgeR5?></td>
                <td align="center" width="7%">&nbsp; <?php $PDTotalR5 	= $this->print_form->get_PDTotalR5(); 	if($PDTotalR5 > 0)echo '$'.$PDTotalR5?></td>
            </tr>
            <tr>
            	<td align="center" width="8%">&nbsp; <?php $PDDateR6 	= $this->print_form->get_PDDateR6(); 	echo $PDDateR6;?></td>
                <td align="center" width="14%">&nbsp;<?php $PDFromR6 	= $this->print_form->get_PDFromR6(); 	echo $PDFromR6;?></td>
                <td align="center" width="8%">&nbsp; <?php $PDActDeptR6 = $this->print_form->get_PDActDeptR6(); echo $PDActDeptR6;?></td>
                <td align="center" width="14%">&nbsp;<?php $PDToR6 		= $this->print_form->get_ToR6(); 		echo $PDToR6;?></td>
                <td align="center" width="8%">&nbsp; <?php $PDArrR6 	= $this->print_form->get_PDArrR6(); 	echo $PDArrR6;?></td>
                <td align="center" width="7%">&nbsp; <?php $PDBreakR6 	= $this->print_form->get_PDBreakR6(); 	if($PDBreakR6 > 0)echo '$'.$PDBreakR6;?></td>
                <td align="center" width="7%">&nbsp; <?php $PDLunchR6 	= $this->print_form->get_PDLunchR6(); 	if($PDLunchR6 > 0)echo '$'.$PDLunchR6?></td>
                <td align="center" width="7%">&nbsp; <?php $PDDinnerR6 	= $this->print_form->get_PDDinnerR6(); 	if($PDDinnerR6 > 0)echo '$'.$PDDinnerR6?></td>
                <td align="center" width="7%">&nbsp; <?php $PDLodgeR6 	= $this->print_form->get_PDLodgeR6(); 	if($PDLodgeR6 > 0)echo '$'.$PDLodgeR6?></td>
                <td align="center" width="7%">&nbsp; <?php $PDTotalR6 	= $this->print_form->get_PDTotalR6(); 	if($PDTotalR6 > 0)echo '$'.$PDTotalR6?></td>
            </tr>
            

            </table>
        </td>
    </tr>
    <tr>
    	<!-- CERTIFICATION -->
    	<td width="30" rowspan="5" valign="top">
        	<table border="0" cellspacing="0" cellpadding="1" width="100%">
            	<tr>
                	<td colspan="2">
        <b>Certification:</b> I hereby certify under penalty of perjury that this is a true and correct claim for necessary expenses incurred by me and that no payment or refund has been recieved by me on account therof and that all travel claims meet state travel policy requirements found in:<br /><br />
        &nbsp;&nbsp;State Administrative and Accounting Manual Ch, 10<br />
        &nbsp;&nbsp;Official Residence: <u><?php echo $this->print_form->get_OfficialResidence();?></u><br />
        &nbsp;&nbsp;Official Station:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u><?php echo $this->print_form->get_OfficialStation();?></u><br />
        Note: Check will be sent to mailing address above.<br /><br />
        X ______________________________________<br />
        			</td>
               </tr>
            	<tr>
                	<td>&nbsp;&nbsp;<font class="small">Employee's Signature</font></td>
                    <td><font class="small">Date</font>&nbsp;&nbsp;</td> 
                </tr>
                <tr>
                	<td colspan="2"><font class="small">After signing, route to EWU Travel 319 SHW or to budget authority if actuals exceed estimate by $100 and/or if index code begins with a 5, to Grants 210 SHW.</font></td>
                </tr>
            </table>
            <hr width="100%" color="#000000" />
            <table border="0" cellspacing="0" cellpadding="1" width="100%">
            <tr>
            	<td><br />
                	X ______________________________________<br />
                    <font class="small">Budget Authority - Pmt Aprroved (sign only if $100 over estimate)<br /><br /></font>
                    X ______________________________________<br />
                    <font class="small">EWU Grants Office - Approved for Payment<br /><br /></font>
                    X ______________________________________<br />
                    <font class="small">Travel Accounting - Approved for Payment<br /><br /></font>
                    X ______________________________________<br />
                    <font class="small">Accounts Payable - Approved for Payment<br /><br /></font>
                </td>
            </tr>
            </table>
            
        </td>
        <td width="70%" valign="top" colspan="2">
        	<!-- PRIVATE CAR MILEAGE (3 ROWS) -->
        	<table border="1" cellspacing="0" cellspadding="0" width="100%" class="t1">
            <tr>
            	<td colspan="7" align="center"><b>Privately-owned Vehicle Allowance</b></td>
            </tr>
            <tr>
            	<td width="18%">From</td>
                <td width="18%">To</td>
                <td align="right" width="12%">Miles driven</td>
                <td align="center">Vincinity</td>
                <td align="center">Rate</td>
                <td align="right" width="10%">Allowance</td>
                <td align="right" width="15%">Total</td>
            </tr>
            <tr>
            	<td>&nbsp;		   <?php $PrivCarFromR1 	= $this->print_form->get_PrivCarFromR1(); 	echo $PrivCarFromR1;?></td>
                <td>	  		   <?php $PrivCarToR1 		= $this->print_form->get_PrivCarToR1(); 	echo $PrivCarToR1;?></td>
                <td align="right"> <?php $PrivCarMilesR1 	= $this->print_form->get_PrivCarMilesR1(); 	echo $PrivCarMilesR1;?></td>
                <td align="center"><?php $PrivCarVincR1 	= $this->print_form->get_PrivCarVincR1(); 	echo $PrivCarVincR1;?></td>
                <td align="center"><?php $PrivCarRateR1 	= $this->print_form->get_PrivCarRateR1(); 	if($PrivCarRateR1  > 0) echo '$'.$PrivCarRateR1;?></td>
                <td align="right"> <?php $PrivCarAllowR1 	= $this->print_form->get_PrivCarAllowR1(); 	if($PrivCarAllowR1 > 0) echo '$'.$PrivCarAllowR1;?></td>
                <td align="right" rowspan="3" valign="bottom">&nbsp;<?php
														$print = 0.00;
														$print = $this->print_form->get_PrivCarTotal();
														$print = number_format($print, 2); 
														echo '$'.$print;?>
				</td>
            </tr>
            <tr>
            	<td>&nbsp;		   <?php $PrivCarFromR2 	= $this->print_form->get_PrivCarFromR2(); 	echo $PrivCarFromR2;?></td>
                <td>	  		   <?php $PrivCarToR2 		= $this->print_form->get_PrivCarToR2(); 	echo $PrivCarToR2;?></td>
                <td align="right"> <?php $PrivCarMilesR2 	= $this->print_form->get_PrivCarMilesR2(); 	echo $PrivCarMilesR2;?></td>
                <td align="center"><?php $PrivCarVincR2 	= $this->print_form->get_PrivCarVincR2(); 	echo $PrivCarVincR2;?></td>
                <td align="center"><?php $PrivCarRateR2 	= $this->print_form->get_PrivCarRateR2(); 	if($PrivCarRateR2  > 0) echo '$'.$PrivCarRateR2;?></td>
                <td align="right"> <?php $PrivCarAllowR2 	= $this->print_form->get_PrivCarAllowR2(); 	if($PrivCarAllowR2 > 0) echo '$'.$PrivCarAllowR2;?></td>
            </tr>
            <tr>
            	<td>&nbsp;		   <?php $PrivCarFromR3 	= $this->print_form->get_PrivCarFromR3(); 	echo $PrivCarFromR3;?></td>
                <td>	  		   <?php $PrivCarToR3 		= $this->print_form->get_PrivCarToR3(); 	echo $PrivCarToR3;?></td>
                <td align="right"> <?php $PrivCarMilesR3 	= $this->print_form->get_PrivCarMilesR3(); 	echo $PrivCarMilesR3;?></td>
                <td align="center"><?php $PrivCarVincR3 	= $this->print_form->get_PrivCarVincR3(); 	echo $PrivCarVincR3;?></td>
                <td align="center"><?php $PrivCarRateR3 	= $this->print_form->get_PrivCarRateR3(); 	if($PrivCarRateR2  > 0) echo '$'.$PrivCarRateR3;?></td>
                <td align="right"> <?php $PrivCarAllowR3 	= $this->print_form->get_PrivCarAllowR3(); 	if($PrivCarAllowR3 > 0) echo '$'.$PrivCarAllowR3;?></td>
            </tr>
            </table>
        </td>
    </tr>
    <tr>
    	<td colspan="2">
        	<!-- OTHER MISC EXPENSE (5 ROWS) -->
        	<table border="1" cellspacing="0" cellspadding="0" width="100%" class="t1">
            <tr>
            	<td colspan="5" align="center"><b>Other Miscellaneous Travel-Related Expenses (receipts required if $50 or more)</b></td>
            </tr>
            <tr>
            	<td align="center" width="10%">Date</td>
                <td width="20%">Payee</td>
                <td width="45%">Purpose</td>
                <td align="right" width="10%">Amount</td>
                <td align="right" width="15%">Total</td>
            </tr>
            <tr>
            	<td align="center">&nbsp;<?php $OtherDateR1  = $this->print_form->get_OtherDateR1();  echo $OtherDateR1;?></td>
                <td>					 <?php $OtherPayeeR1 = $this->print_form->get_OtherPayeeR1(); echo $OtherPayeeR1;?></td>
                <td>					 <?php $OtherPurpR1  = $this->print_form->get_OtherPurpR1();  echo $OtherPurpR1;?></td>
                <td align="right">		 <?php $OtherAmtR1   = $this->print_form->get_OtherAmtR1();   if($OtherAmtR1 > 0) echo '$'.$OtherAmtR1;?></td>
                <td align="right" rowspan="5" valign="bottom">&nbsp;<?php 	$print = $this->print_form->get_OtherAmtR1() + $this->print_form->get_OtherAmtR2() + $this->print_form->get_OtherAmtR3() + $this->print_form->get_OtherAmtR4() + $this->print_form->get_OtherAmtR5(); 
															$print = number_format($print, 2); 
															echo '$'.$print; ?></td>
            </tr>
            <tr>
            	<td align="center">&nbsp;<?php $OtherDateR2  = $this->print_form->get_OtherDateR2();  echo $OtherDateR2;?></td>
                <td>					 <?php $OtherPayeeR2 = $this->print_form->get_OtherPayeeR2(); echo $OtherPayeeR2;?></td>
                <td>					 <?php $OtherPurpR2  = $this->print_form->get_OtherPurpR2();  echo $OtherPurpR2;?></td>
                <td align="right">		 <?php $OtherAmtR2   = $this->print_form->get_OtherAmtR2();   if($OtherAmtR2 > 0) echo '$'.$OtherAmtR2;?></td>
            </tr>
            <tr>
            	<td align="center">&nbsp;<?php $OtherDateR3  = $this->print_form->get_OtherDateR3();  echo $OtherDateR3;?></td>
                <td>					 <?php $OtherPayeeR3 = $this->print_form->get_OtherPayeeR3(); echo $OtherPayeeR3;?></td>
                <td>					 <?php $OtherPurpR3  = $this->print_form->get_OtherPurpR3();  echo $OtherPurpR3;?></td>
                <td align="right">		 <?php $OtherAmtR3   = $this->print_form->get_OtherAmtR3();   if($OtherAmtR3 > 0) echo '$'.$OtherAmtR3;?></td>
            </tr>
            <tr>
            	<td align="center">&nbsp;<?php $OtherDateR4  = $this->print_form->get_OtherDateR4();  echo $OtherDateR4;?></td>
                <td>					 <?php $OtherPayeeR4 = $this->print_form->get_OtherPayeeR4(); echo $OtherPayeeR4;?></td>
                <td>					 <?php $OtherPurpR4  = $this->print_form->get_OtherPurpR4();  echo $OtherPurpR4;?></td>
                <td align="right">		 <?php $OtherAmtR4   = $this->print_form->get_OtherAmtR4();   if($OtherAmtR4 > 0) echo '$'.$OtherAmtR4;?></td>
            </tr>
            <tr>
            	<td align="center">&nbsp;<?php $OtherDateR5  = $this->print_form->get_OtherDateR5();  echo $OtherDateR5;?></td>
                <td>					 <?php $OtherPayeeR5 = $this->print_form->get_OtherPayeeR5(); echo $OtherPayeeR5;?></td>
                <td>					 <?php $OtherPurpR5  = $this->print_form->get_OtherPurpR5();  echo $OtherPurpR5;?></td>
                <td align="right">		 <?php $OtherAmtR5   = $this->print_form->get_OtherAmtR5();   if($OtherAmtR5 > 0) echo '$'.$OtherAmtR5;?></td>
            </tr>
            </table>        
        </td>
    </tr>
    <tr>
    	<td width="45%">
        	<!-- REFUND INFO -->
        	<table width="100%" border="1" cellpadding="0" cellspacing="0" class="t1">
            <tr>
            	<td align="center" width="20%">Date</td>
                <td align="center" width="60%"><b>Refunds from (list payee)</b></td>
                <td align="center">Amount</td>
            </tr>
            <tr>
            	<td align="center" width="20%">&nbsp;<?php $RefundDateR1 = $this->print_form->get_RefundDateR1();   echo $RefundDateR1;?></td>
                <td align="left" width="60%">		 <?php $RefundFromR1 = $this->print_form->get_RefundFromR1();   echo $RefundFromR1;?></td>
                <td align="right">					 <?php $RefundAmtR1  = $this->print_form->get_RefundAmtR1();    if($RefundAmtR1 > 0)echo '$'.$RefundAmtR1; ?></td>
            </tr>
            <tr>
            	<td align="center" width="20%">&nbsp;<?php $RefundDateR2 = $this->print_form->get_RefundDateR2();   echo $RefundDateR2;?></td>
                <td align="left" width="60%">		 <?php $RefundFromR2 = $this->print_form->get_RefundFromR2();   echo $RefundFromR2;?></td>
                <td align="right">    				 <?php $RefundAmtR2  = $this->print_form->get_RefundAmtR2();    if($RefundAmtR2 > 0)echo '$'.$RefundAmtR2; ?></td>
            </tr>
            </table>
        </td>
        <td rowspan="2" valign="top">
        	<!-- POST TRIP TOTALS -->
        	<table width="100%" border="1" cellpadding="0" cellspacing="0" class="t1" height="100%">
            <tr>
            	<td width="40%">&nbsp;Subtotal</td>
                <td><?php $Subtotal  = $this->print_form->get_Subtotal();
						  $Subtotal = number_format($Subtotal, 2);
						  echo '$'.$Subtotal; ?></td>
            </tr>
            <tr>
            	<td width="40%">&nbsp;Less Advance</td>
                <td><?php echo '$0.00'; ?></td>
            </tr>
            <tr>
            	<td width="40%">&nbsp;Less Refunds</td>
                <td><?php $Refund  = $this->print_form->get_Refunds();
						  $Refund = number_format($Refund, 2);
						  echo '$'.$Refund; ?></td>
            </tr>
            <tr>
            	<td width="40%">&nbsp;Balance Due</td>
                <td><?php 
						  $BalanceDue  = $this->print_form->get_BalanceDue();
						  $BalanceDue = number_format($BalanceDue, 2);
						  echo '$'.$BalanceDue;?></td>
            </tr>
            <tr bgcolor="#D6D5FF">
            	<td width="40%">&nbsp;<b><font class="large">ENC</font> <font class="small">(Travel use only)</font></b></td>
                <td align="center"><font class="large"><b>D H I M R</b></font></td>
            </tr>
            </table>
        </td>
    </tr>
    <tr>
    	<td>
        	<table border="1" cellpadding="0" cellspacing="0" class="t1" width="100%">
            <tr>
            	<td>&nbsp;Comments:</td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
            </tr>
            </table>
        </td>
    </tr>
    <tr>
    	<td colspan="2">
        	<!-- POST TRIP INDEX CODES... -->
        	<table border="1" width="100%" class="t1" cellpadding="0" cellspacing="0">
            <tr>
            	<td align="center" width="20%">Index Code</td>
                <td align="center" width="20%">Account</td>
                <td align="center" width="20%">Due Date</td>
                <td align="center" width="20%">Amount</td>
                <td align="center" width="20%" bgcolor="#999999">Banner Invoice</td>
            </tr>
            <tr>
            	<td align="center" width="20%">&nbsp;</td>
                <td align="center" width="20%"></td>
                <td align="center" width="20%"></td>
                <td align="right" width="20%"></td>
                <td align="center" width="20%" bgcolor="#999999"></td>
            </tr>
            <tr>
            	<td align="center" width="20%">&nbsp;</td>
                <td align="center" width="20%"></td>
                <td align="center" width="20%"></td>
                <td align="right" width="20%"></td>
                <td align="center" width="20%" bgcolor="#999999"></td>
            </tr>
            <tr>
            	<td align="center" width="20%">&nbsp;</td>
                <td align="center" width="20%"></td>
                <td align="center" width="20%"></td>
                <td align="right" width="20%"></td>
                <td align="center" width="20%" bgcolor="#999999"></td>
            </tr>
            <tr>
            	<td align="center" width="20%">&nbsp;</td>
                <td align="center" width="20%"></td>
                <td align="center" width="20%"></td>
                <td align="right" width="20%"></td>
                <td align="center" width="20%" bgcolor="#999999"></td>
            </tr>
            <tr>
            	<td align="center" width="20%"></td>
                <td align="center" width="20%"></td>
                <td align="right" width="20%"><b>Total</b>&nbsp;</td>
                <td align="right" width="20%"></td>
                <td align="center" width="20%" bgcolor="#999999"><b>LIQ = F</b></td>
            </tr>
            </table>
        </td>
    </tr>
</table>

</div>
</div>
</body>
</html>



