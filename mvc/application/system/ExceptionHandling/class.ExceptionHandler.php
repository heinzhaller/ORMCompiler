<?php
#ä
require_once 'class.ExceptionObject.php';
require_once 'class.ExceptionList.php';

/**
 * exception handler
 * @author Mario Kaufmann
 * @version 1.0
 * @see ExceptionList
 */
abstract class ExceptionHandler {
		
	/**
	 * get exception object
	 * @param ExceptionObject $myObject
	 * @param $code
	 * @param $params [Optional]
	 * @return ExceptionObject
	 */
	public static final function getExceptionByCode(ExceptionObject &$myObject, $code, array $params = null){
		call_user_func('ExceptionList::ERRORCODE_'.$code, $myObject, $params);
	}
	
	public static final function writeExceptionToLogfile(Exception &$myException, $logfile){
		
		if(strlen($logfile) > 0 AND !file_exists($logfile))
			touch($logfile);
		
		$mydate = date('Y-m-d H:i:s', time());
		// catch all output in buffer
		ob_start();
	  print_r($myException);
	  print "Aborted the transaction because: \n";
	  print "\nTime: " . $mydate;
		echo "\nCode: " . $myException->getCode();
		echo "\n\nMessage: " . $myException->getMessage();
		echo "\n\nFile: " . $myException->getFile();
		echo "\n\nLine: " . $myException->getLine();
		echo "\n\nTrace: \n" . $myException->getTraceAsString();
		echo "\n\nTrace: "; print_r($myException->getTrace())."\n\n";
		$error_report = ob_get_contents();
		ob_end_clean();
		
		$sp = chr(9); // seperator
		$errorcode = md5(time());
		
		$line = '###############################################'."\n";
		$line .= $errorcode.' - '.$mydate."\n";
		$line .= '###############################################'."\n";
		$line .= ' ('.$_SERVER['SERVER_NAME'].')'.$sp.'PARAMETER: '.( isset($_SERVER['argv'][0]) ?  $_SERVER['argv'][0] : null ).$sp.'IP: '.$_SERVER['REMOTE_ADDR'].$sp.( isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null )."\n\n";
		$line .= $error_report . "\n";
		$line .= '###############################################'."\n";
	
  	$handle = fopen($logfile, 'a+');
	  if (fwrite($handle, $line) === FALSE) {
	  	echo "<div class='msg_err'>Error!</div>";
	  }
	  fclose($handle);
	  return $errorcode;
	}
	
	public static final function showException(Exception &$myException){
		var_dump($myException);
	}
	
}

abstract class ExceptionKeys {
	const ERROR_VALUE_NULL = 100;
	const ERROR_VALUE_WRONGDATATYPE = 101;
	const ERROR_PERMISSION_DENIED = 201;
	
	const ERROR_FILE_WRITE = 405;
	const ERROR_FILE_NOT_FOUND = 404;
	const ERROR_FILE_NOT_EXISTS = 444;
	const ERROR_ENCODING = 333;
	const ERROR_CURL = 350;

	const ERROR_FILE_CSV_URL = 740;
	const ERROR_FILE_CSV_FAILURE_LN = 741;
	const ERROR_FILE_CSV_FAILURE_HEADER = 750;
	const ERROR_FILE_CSV_FAILURE_LINE = 751;
	const ERROR_FILE_CSV_VALUE_DATE = 760;
	const ERROR_FILE_CSV_VALUE_STATUS	 = 761;
	const ERROR_FILE_CSV_VALUE_CUSTOMERID = 762;
	const ERROR_FILE_CSV_VALUE_EVENTTYPE = 763;
	const ERROR_FILE_CSV_VALUE_SHOPNAME = 764;
	const ERROR_FILE_CSV_VALUE_NETTURNOVER = 765;
	const ERROR_FILE_CSV_VALUE_NETAMOUNT = 766;
	const ERROR_FILE_CSV_VALUE_AFFILIATE_SHOPID = 767;
	const ERROR_FILE_CSV_VALUE_TRANSACTIONID = 768;
	const ERROR_FILE_CSV_VALUE_CURRENCY = 769;
	const ERROR_FILE_CSV_ENCODING = 790;
	const ERROR_FILE_CSV_ENCODING_CONVERTED = 791;
	
	const ERROR_VEMA_IMPORT_CUSTOMER = 801;
	const ERROR_VEMA_IMPORT_TRANSACTIONID = 802;
	const ERROR_VEMA_IMPORT_ALREADY_IMPORTED = 820;
	const ERROR_VEMA_IMPORT_API = 840;
	
	const CUSTOM_BREAK = 9999;
	const CUSTOM_ERROR = 8888;
}

abstract class ExceptionTypes {
	const WARNING = 'warning';
	const NOTICE = 'notice';
	const ERROR = 'error';
}

abstract class ExceptionLayer {
	const ABSTRACTIONLAYER = 'abstractionlayer';
	const SYSTEMLAYER = 'systemlayer';
	const APPLICATIONLAYER = 'applicationlayer';
}
?>