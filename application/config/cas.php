<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Whether or not to use/force CAS authentication
$config['cas_enable'] = true;

// Full Hostname of your CAS Server
$config['cas_host'] = 'login.ewu.edu';

// Context of the CAS Server
$config['cas_context'] = '/cas';

// Port of your CAS server. Normally for an https server it's 443
$config['cas_port'] = 443;

// Path to CAS.php
$config['cas_path'] = APPPATH.'libraries/cassource/CAS.php';

/* End of file cas.php */
/* Location: ./application/config/cas.php */