<?
/* View/header
 *
 * Creates the page header displayed to the user. All javascript libraries are
 * loaded in this view.
 *
 * Author: Reid Fortier, Jason Helms, Josh Smith
 *
 * Created: 2013-05 
 * Last Edited: 2013-07-27
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $title ?> - Eastern Washington University Travel Application</title>
	
	<!-- style sheets -->
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
	<link rel="stylesheet" href="/../../assets/travelstyle.css" type="text/css" />
	
	<!-- script files -->
	<script type="text/javascript" src="/../../assets/jquery-1.10.2.js"></script>
	<script type="text/javascript" src="/../../assets/jquery-ui-1.10.3/ui/jquery-ui.js"></script>	
	<script type="text/javascript" src="/../../assets/travelapp.js"></script>
	<script type="text/javascript" src="/../../assets/livevalidation_standalone.js"></script>
    <script type="text/javascript" src="/../../assets/jquery-ui-timepicker-addon.js"></script>
    
    <!-- script files -->
    <link rel="icon" href="/../../assets/images/favicon.jpg" type="image/gif" />	

</head>

<body>
	<div class="mainContainer">
    	<div class="banner">
        	<img src="/../../assets/images/EasternLogo.gif" height="100" alt="Eastern Washington University: Start Something Big!" align="left" vspace="center">
    		<h2>Department Travel Application</h2>
        </div>
        <div class="bodyContainer">