<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

class CAS
{
	//these variables set in application/config/cas.php
	var $CI;
	var $cas_enable = false;
	var $cas_host = '';
	var $cas_context = '';
	var $cas_port = '';
	var $cas_path = '';
	
	/**
	 * Constructor
	 */
	public function __construct($config = array())
	{
		$this->CI =& get_instance();
		
		
		if (count($config) > 0)
		{
			$this->initialize($config);
		}
			
		require_once $this->cas_path;

		phpCAS::setDebug(); //comment this out later
		phpCAS::client(CAS_VERSION_2_0, $this->cas_host, $this->cas_port, $this->cas_context);			
		phpCAS::setNoCasServerValidation(); // Must be set no matter what
		phpCAS::handleLogoutRequests();		
		phpCAS::setCacheTimesForAuthRecheck(0);
	}
	
	/**
	 * Initialize CodeIgniter variables. This allows the library to have access to them.
	 */
	public function initialize($config = array())
	{
		foreach ($config as $key => $val)
		{
			if (isset($this->$key))
			{
				$this->$key = $val;
			}
		}
	}
	
	/**
	 * Wrapper for CAS forceAuthentication (EWU SSO).
	 * Call this method from pages to force authentication.
	 */
	public function force_authenticate()
	{
		if ($this->cas_enable)
		{
			phpCAS::forceAuthentication();
		}
	}
	
	public function check_authentication()
	{
		return phpCAS::isAuthenticated();		
	}
	
	/**
	 * Global user validation. Checks if user is requesting a protected page.
	 * If they are, attempt to verify them with CAS.
	 * If verified but invalid user, show invalid user page.
	 * If not verified show login gateway.
	 */
	public function authenticate()
	{
		
		if($this->cas_enable)
		{			
				if(phpCAS::isAuthenticated() && !$this->CI->user->valid()) //checkAuthentication()???
				{
					redirect('/dashboard');
				}
				else if(!phpCAS::isAuthenticated())
				{
					// Save the page we are on now to redirect if the user successfully authenticates
					//$CI->session->set_userdata('redirect_to', $this->get_current_url());
				
					// Kick user to the login gateway
					redirect('/nothankyou');
				}
		
		}
		
	}

	/**
	 * Wrapper for CAS system logout (EWU SSO).
	 */
	public function logout()
	{
		if($this->cas_enable)
		{
			phpCAS::logout();
		}
	}
	
	/**
	 * Pull the user's CAS user id (EWU NetId). If not set, return NULL.
	 */
	public function get_user()
	{
		return ($this->cas_enable && phpCAS::isAuthenticated()) ? phpCAS::getUser() : NULL;
	}

	/**
	 * Utility to get the current page url. Used by this library in an attempt to save the users
	 * requested page. The user is then sent back to this page upon a successful login.
	 */
	private function get_current_url()
	{
		$pageURL = (@$_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://';

		if(@$_SERVER['SERVER_PORT'] != '80')
		{
			$pageURL .= @$_SERVER['SERVER_NAME'].':'.@$_SERVER['SERVER_PORT'].@$_SERVER['REQUEST_URI'];
		} 
		else 
		{
			$pageURL .= @$_SERVER['SERVER_NAME'].@$_SERVER['REQUEST_URI'];
		}
		return $pageURL;
	}
}

/* End of file cas.php */
/* Location: ./application/library/cas.php */