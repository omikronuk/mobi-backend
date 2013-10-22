<?php


	global $data;

	define('PAYPAL_URL', 'https://www.paypal.com/cgi-bin/webscr');
	define('PAYPAL_BUSINESS', 'KawiPay Ltd');
	
	/*
	define('PassAtt', $siteInfo['pass_attempt']);
	define('CurrSize', $siteInfo['curr_size']);
	define('DateFormat', $siteInfo['date_format']);
	
	define('UseTuringNumber', $siteInfo['use_turing']);
	define('TuringNumbers', $siteInfo['use_numbers']);
	define('TuringSize', $siteInfo['turing_size']);
	define('TuringQuality', $siteInfo['turing_quality']);
	define('TuringBgfile', $siteInfo['turing_bgfile']); 
	define('UseExtRegForm' , $siteInfo['use_extreg']);
	
	define('SignupUse', $siteInfo['signup_use']);
	define('SignupBonus', $siteInfo['signup_bonus']);
	define('MaxEmails', $siteInfo['maxemails']);
	*/


###############################################################################

###############################################################################


$data['PassAtt'] = 8;
$data['IMTVerifyThreshhold'] = 900; // this is the limit at which a member is verified to be able to send funds beyond this
###############################################################################
$data['DateFormat'] = array( 'International' => 'M d Y h:iA', 'Europe'=>	'd/m/Y h:iA', 'America'=> 'm/d/Y h:iA' );

$data['CurrencySymbol'] = array('GBP' => '&pound;', 'USD'=>'$', 'GHC'=> '&cent' );



define('DateFormat', $data['DateFormat']['International']);
###############################################################################

###############################################################################

###############################################################################
 $data['SendCurrencyList'] = array(
									  'GBP' => 'GBP - British Pound',
									  'EUR' => 'EUR - EURO',
									  );
/*									  
 $data['CurrencyList'] = COUNTRY::getCurrencyList();  array(
	'0' =>'Select a Country',
	'GHC'=>'Ghana',
	'NGN'=>'Nigeria',
	'XAF'=>'Cameroon',
	'GMD'=>'Gambia',
	'GNF'=>'Guinea',
	'XOF'=>'Senegal',
	'SLL'=>'Sierra Leone',
	'UGX'=>'Uganda',
	'GBP' => 'British Pound'
							  );


 $data['CountryAndCurrencyList'] = COUNTRY::getCountriesAndCurrencies();
*/
 $data['ListOnlyCurrency'] = array(
	'0' =>'',
	'GHC'=>'GHC',
	'NGN'=>'NGN',
	'XAF'=>'XAF',
	'GMD'=>'GMD',
	'GNF'=>'GNF',
	'XOF'=>'XOF',
	'SLL'=>'SLL',
	'UGX'=>'UGX',
	'GBP' => 'GBP'
 );


$data['MemberStatus']=array(
	0=>array(
		'action'=>'verify',
		'status'=>'UNVERIFIED',
		'button'=>'VERIFY NOW'
	),
	1=>array(
		'action'=>'certify',
		'status'=>'VERIFIED',
		'button'=>'CERTIFY NOW'
	),
	2=>array(
		'action'=>'',
		'status'=>'CERTIFIED',
		'button'=>''
	)
);


$data['IMTTransactionType']=array(
	0=>'Payment',
	1=>'Deposit',
	2=>'Withdraw',
	3=>'Escrow',
	4=>'Signup',
	5=>'Commission',
	6=>'Refund',
	7=>'Pick Up',
	8=>'Bank Transfer',
	9=>'Archive',
	10=>'Trash'
);


$data['IMTTransactionStatus']=array(
	0=>'Pending',
	1=>'Completed',
	2=>'Cancelled',
	3=>'Refunded',
	4=>'Authorized',
	5=>'Verify',
	6=>'Recalled',
	7=>'Rejected',
	8=>'Suspended',
	9=>'Amended',
	10=>'Awaiting Cancellation',
	11=>'Undelivered',
	12=>'Delivered',
	13=>'Out for Delivery',
	14=>'Picked Up',
	15=>'Credited',
	16=>'SenderPays',
	17=>'Awaiting Payment',
	18=>'MTO-Pending',
	19=>'Paid',
	20=>'On Hold',
	21=>'Held',
	22=>'Archive',
	23=>'AgentCredited',
	24=>'Sent Payment Reminder'
);




###############################################################################

###############################################################################
$data['BankAccountType']=array(
	'0' =>'--',
	'PCA'=>'Personal Current Account',
	'PS'=>'Personal Saving',
	'BC'=>'Business Checking',
	'BS'=>'Business Saving',
	'CA'=>'Current Account'
);


$data['IMTTransactionPurpose'] = array(
	'--' =>'Select your Transaction purpose',
	'Business'=>'Business',
	'Family Assistant'=>'Family Assistant',
	'Help'=>'Help'

);

$data['SecreteQuestion'] = array(
	'--' =>'Please Select a Secrete Question',
	'0'=>'What is your mother\'s maiden name? ',
	'1'=>'What is your favourite sports? ',
	'2'=>'What is the name of your first school? '

);

$data['MediumOfPayment'] = array(

	'--' =>'Select One',
	'By Cash'=>'By Cash',
	'By Cheque'=>'By Cheque',
	'By Bank Transfer'=>'By Bank Transfer',
	'By Credit Card' => 'By Credit/Debit Card'

);

$data['FundSources'] = array(
	'-' => 'Select one',
	'Salary' => 'Salary',
	'Savings' => 'Savings',
	'Loan' => 'Loan'
);


$data['PaymentMethod'] = array(
	0=>'UK Cheque',
	1=>'Postal Order',
	2=>'Bank Transfer',
	3=>'Paypal Cheque',
	4=>'Google Checkout',
	5=>'Stripe'

);

###############################################################################

$data['Titles'] = array(''=>'--', 'Mr.'=>'Mr', 'Mrs.'=>'Mrs', 'Ms.'=>'Ms', 'Miss.'=>'Miss', 'Dr.'=>'Dr', 'Other'=>'Other');

$data['MemberType'] = array(
	0=>'Basic Personal',
	1=>'Premium Personal',
	2=>'Business Standard',
	3=>'Business Premium',
	4=>'Recipient'

);



