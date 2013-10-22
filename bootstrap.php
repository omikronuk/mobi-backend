<? session_start(); //Start the php session

error_reporting(E_ERROR | E_WARNING | E_PARSE);//hide errors used purposely for development
	
	
define('BASEPATH', TRUE); // This has been included to prevent direct access to certain files
define('ServicesDir', '/Services/');
define('UPLOADS_DIR', dirname(__FILE__) .'/uploads/');

/* LOAD CUSTOME LIBRARIES CONFIGURATION FILE
 ######################################################################################################## */

require_once dirname(__FILE__) . '/includes/conf.php';


/**/
require_once dirname(__FILE__) . '/php-activerecord/ActiveRecord.php';
 


// initialize ActiveRecord
ActiveRecord\Config::initialize(function($cfg)
{
    $cfg->set_model_directory(dirname(__FILE__) . '/Services');
    $cfg->set_connections(array('development' => 'mysql://root:@localhost/dodeccms',
                                'local' => 'mysql://root:@localhost/dodec_cms',
                                'production' => 'mysql://dodeccms_cms:Sun2Hot@localhost/dodeccms_cms',
                                'kawisoft' => 'mysql://web107-kawicms2:tarvig7y@localhost/web107-kawicms2'

                               )
						 );

    // you can change the default connection with the below
    $cfg->set_default_connection(ENVIRONMENT);
	
});


/* LOAD AMFPHP 2.0
######################################################################################################## */
require_once dirname(__FILE__) . '/Amfphp/ClassLoader.php';

/* CUSTOM AMF CONFIGURATION
######################################################################################################## */
require_once dirname(__FILE__) . '/includes/AppServiceConfig.php';








