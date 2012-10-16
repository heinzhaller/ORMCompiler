<?php
#ä
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ //
// +++++++++++++++++++++++++++++ GLOBAL INCLUDEFILE FOR YOUR FRONTEND +++++++++++++++++++++++++++++++ //
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ //

// libs
require_once GLOBAL_INCLUDE_SYSTEMLAYER.'Database/class.DBConnection.php';
Library::requireLibrary(LibraryKeys::APPLICATION_WEBSITE());
Library::requireLibrary(LibraryKeys::SYSTEM_QUERY());
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_LIST());
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_DATE());
Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_BASE());

// additionaly
define ('GLOBAL_EMAIL_SENDERNAME', 'mydomain.de');
define ('GLOBAL_EMAIL_SENDERADRESS', 'email@mydomain.de');

// define your textblock's here
$textlib = array();
$textlib['TEXT_WELCOME'] = 'Welcome!';
foreach($textlib as $key => $text){
	define($key,$text);
}

// initialise php-session
WebsiteManager::initSession();

// set header to utf8
header("Content-Type: text/html; charset=utf-8");

// debugmod
if(isset($_GET['debugmode']))
	WebsiteManager::setDebugMode(true);
	
// clear post
if(!empty($_POST)){
	// clean post fields
	foreach ($_POST as $key => $value){
		if( is_string($value) AND !is_array($value))
			$_POST[$key] = trim($value);
	}
}

// clear get
if(!empty($_GET)){
	// clean post fields
	foreach ($_GET as $key => $value){
		$_GET[$key] = trim($value);
	}
}
