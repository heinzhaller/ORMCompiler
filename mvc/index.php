<?php
#ä
require_once GLOBAL_DOCUMENT_ROOT . '/application/config/global.php';
require_once GLOBAL_DOCUMENT_ROOT . '/application/config/database.php';
require_once GLOBAL_DOCUMENT_ROOT . '/application/config/email.php';
require_once GLOBAL_DOCUMENT_ROOT . '/application/config/error.php';

// set zone and time
date_default_timezone_set('Europe/Berlin');
setlocale(LC_TIME, 'de_DE.UTF8');

// default libs
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_CACHE());
Library::requireLibrary(LibraryKeys::SYSTEM_QUERY());
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_LIST());
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_DATE());
Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_BASE());
Library::requireLibrary(LibraryKeys::ABSTRACTION_DATABASE_CONNECTION());
Library::requireLibrary(LibraryKeys::APPLICATION_CONTROLLER());
Library::requireLibrary(LibraryKeys::APPLICATION_LAYOUT());
Library::requireLibrary(LibraryKeys::APPLICATION_WEBSITE());

// translations
Library::requireLibrary(LibraryKeys::APPLICATION_LANGUAGE());
Library::requireLibrary(LibraryKeys::APPLICATION_TRANSLATION_TEMPLATE());
Library::requireLibrary(LibraryKeys::APPLICATION_TRANSLATION_TEMPLATE_PLACEHOLDER());
Library::requireLibrary(LibraryKeys::APPLICATION_TRANSLATION_PLACEHOLDER());
Library::requireLibrary(LibraryKeys::APPLICATION_TRANSLATION_PLACEHOLDER_CONTENT());

// init session
WebsiteManager::initSession();

// set header
header("Content-Type: text/html; charset=utf-8");

// todo: move to website manager
function isValidEmail($email)
{
	$domain = substr($email, strpos($email, '@')+1);
	$domain = gethostbyname($domain);
	return preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/', $domain);
}

// Load Translations - DEFAULT templates
WebsiteManager::loadTranslation('_default');
WebsiteManager::loadTranslation('_navigation');
WebsiteManager::loadTranslation('_meta');

// default page => 404
$controller = 'start';
$action = 'error_404';
$class = ucwords($controller) . 'Controller';

// get Params
if( !empty($_GET['controller']) AND !empty($_GET['action']) )
{
	$class = ucwords($_GET['controller']) . 'Controller';
	$action = $_GET['action'];
	$controller = ucwords($_GET['controller']);
}

// check route
include_once GLOBAL_DOCUMENT_ROOT . '/application/config/route.php';
if( !empty($_GET['controller']) )
	foreach( $routelist as $route => $mapping )
	{
		if( strtolower($_GET['controller']) === strtolower(trim(getTrans($route))) )
		{
			$explode = explode('/', $mapping);
			$controller = ucwords($explode[0]);
			$action = $explode[1];
			$class = ucwords($explode[0]) . 'Controller';
			break;
		}
	}

// main
if( empty($_GET['controller']) )
	$action = 'index';

// default controller
if( !file_exists(GLOBAL_CONTROLLER . '/' . ucwords($controller) . '.php') )
{
	$action = 'error_404';
	$controller = 'start';
	$class = 'StartController';
}

// set current page
WebsiteManager::$page = strtolower($controller . '/' . $action);

// exec
try
{
	// load controller
	include_once GLOBAL_CONTROLLER . '/' . ucwords($controller) . '.php';
	$myController = new $class();
	$myController->$action();
	
	// close transaction - at this point no error was thrown
	if( class_exists('DBConnection'))
	{
		DBConnection::commit();
		DBConnection::disconnect();
	}	
} 
catch( Exception $e)
{
	// close transaction & rollback
	if( class_exists('DBConnection'))
	{
		DBConnection::rollback();
		DBConnection::disconnect();
	}	
	
	// todo: show error
}

die(); // "die die die my darling"