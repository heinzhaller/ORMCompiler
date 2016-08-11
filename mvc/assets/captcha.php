<?
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_CACHE());
Library::requireLibrary(LibraryKeys::SYSTEM_QUERY());
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_CURRENCY());
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_LIST());
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_DATE());
Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_BASE());

require_once GLOBAL_INCLUDE_SYSTEMLAYER.'Website/class.WebsiteManager.php';

// session aufbauen
WebsiteManager::initSession();

include_once $_SERVER['DOCUMENT_ROOT'].'/global/system/Captcha/captcha.php';
