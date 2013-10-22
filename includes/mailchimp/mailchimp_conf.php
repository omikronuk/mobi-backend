<?php if( !defined('BASEPATH')) exit('No direct script access allowed');

/* MAILCHIMP SETTINGS 
##################################################################################################### */
require_once 'MCAPI.class.php'; //include the mailchimp class
//
 //API Key - see http://admin.mailchimp.com/account/api - 'YOUR MAILCHIMP APIKEY';
    define('MC_apikey',  'a18e4f902e37ba0003f07f12857d9205-us5');
	
    
    // A List Id to run examples against. use lists() to view all
    // Also, login to MC account, go to List, then List Tools, and look for the List ID entry
    $listId = 'YOUR MAILCHIMP LIST ID - see lists() method';
    define('MC_listID', 'fe8fce6bb5');
	
    // A Campaign Id to run examples against. use campaigns() to view all
    $campaignId = 'YOUR MAILCHIMP CAMPAIGN ID - see campaigns() method';
	define('MC_campaignID', '');
	
   	
	

    //just used in xml-rpc examples
    define('MC_apiUrl', 'http://api.mailchimp.com/1.3/');

########################################################################################################

