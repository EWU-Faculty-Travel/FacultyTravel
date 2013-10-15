/*
 * Travel App specific javascript functions:
 * 
 * Author: Josh Smith
 *
 * Created: 2013-07-13
 *
 * Editied: 2013-08-18
 *	
 */
 
$(function() {
	$( "#accordion" ).accordion();
});
 
 // page load functions:
$(document).ready(function()
{	
    // sets accordion to be collaspible
	 $("#accordion").accordion({active: false, collapsible:true});
	
	// animation option (bounce slide) ?
	$( ".selector" ).accordion({ animated: 'bounceslide' });
	
	$( ".selector" ).accordion({ active: 1 });
	
	// initalialize jquery accordion
	$("#accordion").accordion();
	
	// disable enter key on forms.
	$('html').bind('keypress', function(e) {
		if(e.keyCode == 13)
		{
			return false;
		}
	});
});

