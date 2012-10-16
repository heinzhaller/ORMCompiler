<?
// close transaction - at this point no error was thrown
if( class_exists('DBConnection')){
	DBConnection::commit();
	DBConnection::disconnect();
}
die(); // "die die die my darling"
