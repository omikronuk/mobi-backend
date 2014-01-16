<?php
/**
 *  This file is part of amfPHP
 *
 * LICENSE
 *
 * This source file is subject to the license that is bundled
 * with this package in the file license.txt.
 * @package Amfphp_Services
 */


/**
 * This is a test/example service. Remove it for production use
 *
 * @package Amfphp_Services
 * @author Ariel Sommeria-kleinextends ActiveRecord\Model
 */
class KawiComms extends ActiveRecord\Model {
	static $table = 'kw_posts';
	
	
	function sendText($data){
		// instantiate a new Twilio Rest Client
		$client = new Services_Twilio(AccountSid, AuthToken);
		
		$number = '+44'.$data['recipient'];
		$twilioNum = TwilioAccountNumber;
				
			// Send a new outgoing SMS */
			$body = $data['msg'] . '-- KawiPay --';
			try{
				$sms = $client->account->sms_messages->create($twilioNum, $number, $body);
			}
			catch(Exception $e){
				$err = $e->getMessage();
			}
			
			// Display a confirmation message on the screen
			return $sms->sid ? "Message Sent" : $err; 
		
			
		
	}
	
	
	
	function fetchSmsInQueue($status=2){
		
		
		$dtList = self::find_by_sql("SELECT * FROM kw_posts WHERE post_status=$status AND post_type = 'sms'");
		$rs = array();
		foreach($dtList as $key=>$val):
			 $rs[$key]['id'] = $val->{'id'}; 
			 $rs[$key]['to'] = $val->{'post_title'};
			 $rs[$key]['message'] = $val->{'post_content'};
			 
			
		endforeach;
		
		
		return $rs;
		
	}
        
	
	
	function call($data){
		
		$client = new Services_Twilio(AccountSid, AuthToken);
		 
		$call = $client->account->calls->create(TwilioAccountNumber, '+44'.$data['recipient'], "http://demo.twilio.com/docs/voice.xml?IfMachine=Hangup", array());
		echo $call->sid;
	}
   

}


?>
