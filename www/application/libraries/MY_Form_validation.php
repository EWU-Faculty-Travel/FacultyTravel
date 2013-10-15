<?php
 /* Helper/FormValidation
 *
 * Extends the CI form validator but adds the ability to unset 
 * field data (after a form is successfully submitted) 
 * 
 *
 * Author: Reid Fortier, Josh Smith
 *
 * Created: 2013-05 
 * Last Edited: 2013-07-27
*/
 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {
    
	// resets field data to be blank
    function unset_field_data()
    {    
        unset($this->_field_data);
		$this->_field_data = array();
        log_message('debug', "Form Validation Field Data Unset");
    }
}  