<?php
#header('Access-Control-Allow-Origin: *');
#header('Access-Control-Allow-Headers: content-type');
/**
 *  This file is part of amfPHP
 *
 * LICENSE
 *
 * This source file is subject to the license that is bundled
 * with this package in the file license.txt.
 * @package Amfphp_Examples
 */

/**
 * a gateway php script like the normal gateway except that it uses example services
 * @author Ariel Sommeria-klein
 */
require_once dirname(__FILE__) . '/bootstrap.php';
if(!defined('PRODUCTION_SERVER')) define('PRODUCTION_SERVER', false);
$config = new AppServiceConfig();
$config->serviceFolderPaths = array(dirname(__FILE__) . ServicesDir);

//Disable argument checking
$config->checkArgumentCount = FALSE;
//$config->pluginsConfig = '';
//$config->disabledPlugins[] = 'AmfphpJson';

//


$gateway = Amfphp_Core_HttpRequestGatewayFactory::createGateway($config);
if(PRODUCTION_SERVER) :
	$config->disabledPlugins[] = 'AmfphpServiceBrowser';
endif;
$gateway->service();
$gateway->output();





?>
