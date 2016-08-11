<?
#ä

// Error-Management
error_reporting ( E_ALL & ~E_STRICT & ~E_DEPRECATED );
define('GLOBALCONFIG_ERROR_SHOW_REALERROR', 1); // "Darf nur auf Entwickler-VMs auf 1 stehen!"
define('GLOBALCONFIG_ERROR_WRITE_LOGFILE', GLOBAL_DOCUMENT_ROOT . '/application/logs/'.date('Y-m-d', time()).'.log'); // "Falls Leerstring, kein Logging - ansonsten Pfad zur Logdatei"
ini_set('display_errors', 'on'); // php errors
ini_set('log_errors', 'off'); // save php erros to log file - use customer error-handler
#ini_set('error_log', '/var/log/phperrors/[path]/'.date('Y-m-d', time()).'.log');
set_exception_handler('exception_handler');
#set_error_handler('custom_error_handler');


// use library as default file-loader
require_once GLOBAL_INCLUDE_SYSTEMLAYER . 'Library/class.Library.php';
Library::requireLibrary(LibraryKeys::SYSTEM_EXCEPTIONHANDLER());

function custom_error_handler($number, $string, $file, $line, $context){
    // Determine if this error is one of the enabled ones in php config (php.ini, .htaccess, etc)
    $error_is_enabled = (bool)($number & error_reporting() );

    // -- FATAL ERROR
    // throw an Error Exception, to be handled by whatever Exception handling logic is available in this context
    if( in_array($number, array(E_USER_ERROR, E_RECOVERABLE_ERROR)) AND $error_is_enabled ) {
        throw new ErrorException($string, 0, $number, $file, $line);
    }

    // -- NON-FATAL ERROR/WARNING/NOTICE
    // Log the error if it's enabled, otherwise just ignore it
    else if( $error_is_enabled ) {
    	// send to php.ini => "error_log" path
      error_log( 'Type: '.$number.' | Message: '.$string.' | File: '.$file.' | Line: '.$line , 0 );
    }

    // nachfolgender code wird weiter ausgeführt
    // ...
}

function exception_handler(Exception &$myException) 
{
	if( $myException instanceof SQLException ){
		// sql fehler
		// ...
	}
	elseif( $myException instanceof ErrorException )
	{
		// php fehler
		// ...
	}
	elseif( $myException instanceof ExceptionObject )
	{
		// eigene exceptions
		// ...
	}
	elseif( $myException instanceof Exception ) 
	{
		// default - alles andere
		// ...
	}

	// in log datei scheiben
	$errorcode = null;
	if( strlen(GLOBALCONFIG_ERROR_WRITE_LOGFILE) > 0 )
		$errorcode = ExceptionHandler::writeExceptionToLogfile($myException, GLOBALCONFIG_ERROR_WRITE_LOGFILE);

	// text ausgeben wenn erlaubt
	IF( GLOBALCONFIG_ERROR_SHOW_REALERROR == 1 )
		ExceptionHandler::showException($myException);
	ELSE
		// show default message to user
		echo '<div class="msg_err">An error occurred! Errorcode: '.$errorcode.'</div>';

	// ... hier mit die() und DB::rollback() abrechen
	// ... oder => Seite weiterlaufen lassen und mittels "append"-Datei Transaktionbehandlung abschliessen.

	// rollback transaction and close connection
	if( class_exists('DBConnection')){
		DBConnection::rollback();
		DBConnection::disconnect();
	}
	die();
}