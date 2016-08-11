<?
#ä

$DOCUMENT_ROOT = ( empty($_SERVER['DOCUMENT_ROOT']) ? '/var/www' : $_SERVER['DOCUMENT_ROOT'] );
global $DOCUMENT_ROOT;

define('GLOBAL_INCLUDE_ABSTRACTIONLAYER', $DOCUMENT_ROOT.'/application/global/[path]/');
define('GLOBAL_INCLUDE_APPLICATIONLAYER', $DOCUMENT_ROOT.'/application/global/[path]/');
define('GLOBAL_INCLUDE_SYSTEMLAYER', $DOCUMENT_ROOT.'/application/global/[path]/');

// MVC
define('GLOBAL_VIEWS', $DOCUMENT_ROOT.'/application/views/');
define('GLOBAL_CONTROLLER', $DOCUMENT_ROOT.'/application/controller/');
define('GLOBAL_CACHE', $DOCUMENT_ROOT.'/application/cache/');
define('GLOBAL_CONFIG', $DOCUMENT_ROOT.'/application/config/');

define('GLOBAL_DOCUMENT_ROOT', $DOCUMENT_ROOT);
define('GLOBAL_SYSTEM_DISABLED_FILE', GLOBAL_DOCUMENT_ROOT.'/GLOBAL_SYSTEM_DISABLED' );

// config
define('GLOBAL_WEBESITE_ISACTIVATED', 1);
define('GLOBAL_SYSTEM_DISABLED', file_exists(GLOBAL_SYSTEM_DISABLED_FILE) );
define('GLOBAL_REGISTER_DOUBLEOPTIN', false );

// unix
define('GLOBALCONFIG_UNIX_OWNER', 'www-data');
define('GLOBALCONFIG_UNIX_GROUP', 'www-data');

// website
define('GLOBAL_HOSTNAME', 'www.example.com');







// ---- DO NOT EDIT AFTER THIS LINE ---- //

// clear post
if(!empty($_POST))
{
	// clean post fields
	foreach ($_POST as $key => $value)
	{
		if( is_string($value) AND !is_array($value))
			$_POST[$key] = trim($value);
	}
}

// clear get
if(!empty($_GET))
{
	// clean post fields
	foreach ($_GET as $key => $value)
	{
		$_GET[$key] = trim($value);
	}
}