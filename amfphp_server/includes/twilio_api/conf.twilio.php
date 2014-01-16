<?
require_once 'Twilio.php';
#Set AccountSid and AuthToken
	define('AccountSid', 'AC5d6a28b4a64f497d8450c83159ab3cc8');
	define('AuthToken',  '0dd5e440c7f0489f95fe839e6e26a91c');
	define('TwilioNum',  '+442033221823');
	define('TwilioSandBoxNumber', '+442071838750');
	


 if(ENV === 'prod'){
 	
 	define('TwilioAccountNumber', TwilioNum );
 }
 else {
 	
 	define('TwilioAccountNumber', TwilioSandBoxNumber );
 }
?>