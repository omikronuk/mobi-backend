<?php if( !defined('BASEPATH')) exit('No direct script access allowed');

/*
 * This serves as the bootstrap files to load custom libraries or packages
 * 
 */

define('Host', 'http://www.kawipay.com');
define('PassLen', 8);
define('SiteCopyrights', '&copy; 2012 KawiPay Ltd');
define('SiteName', 'KawiPay');
define('ENVIRONMENT', 'local');

if (ENVIRONMENT == 'local'){
	if(!defined('DB_HOST')) define('DB_HOST', 'localhost');
	if(!defined('DB_USERNAME')) define('DB_USERNAME', 'root');
	if(!defined('DB_PASSWORD')) define('DB_PASSWORD', ''); 
	if(!defined('DB_DATABASE')) define('DB_DATABASE', 'dodec_cms');

}
else{
	if(!defined('DB_HOST')) define('DB_HOST', 'localhost');
	if(!defined('DB_USERNAME')) define('DB_USERNAME', 'web107-kawicms2');
	if(!defined('DB_PASSWORD')) define('DB_PASSWORD', 'tarvig7y'); 
	if(!defined('DB_DATABASE')) define('DB_DATABASE', 'web107-kawicms2');
}

include 'Db.php';
DB::dbConn();

include 'kw_common.php'; 
include 'mailchimp/mailchimp_conf.php';
include 'aes/conf.aes.php';
include 'twilio_api/conf.twilio.php';
include 'codeigniter/conf.codeigniter.php';

?>

