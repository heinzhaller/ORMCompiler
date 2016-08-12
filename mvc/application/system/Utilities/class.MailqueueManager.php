<?php
require_once GLOBALCONFIG_GLOBALDIR.'/tools.php';

abstract class MailqueueManager {
	
	//public static $mailqueue_api_url = 'http://storeforme.dev.wks-mrimpler.sfyde.local/webglobal/com.sfy.modules/MailqueueModule/API/MailqueueAPI.php';
	public static $mailqueue_api_url = '/resources/mailapi/MailqueueAPI.php';	
	
	public static final function sendMailqueueWhitCurlSession( array $postfields, $option_transfer = false ){
		// Die Session initialisieren
		$ch = curl_init(); // send to Mailqueue API

		$poststring = 'mailbody='.$postfields['mailbody'];
		foreach ( $postfields['recipients'] as $key=>$item ){
			$poststring .= '&recipient[]='.$item;
		}

		// Session Optionen setzen
		curl_setopt($ch, CURLOPT_URL, 'http://'.$_SERVER['HTTP_HOST'].self::$mailqueue_api_url);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_FRESH_CONNECT, TRUE); // Erzwingt eine Explizite erneute Verbindung
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $poststring); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, $option_transfer); // TRUE - Daten als String wiedergeben || FALSE - Direkter Output hier
				
		// Ausführen der Aktionen
		curl_exec($ch); // Gibt durch den Befehl automatisch ein OUTPUT als PLAIN TEXT in den Browser
		
		//curl_close($ch);
		if( curl_errno($ch) > 0 ){
			var_dump(curl_errno($ch));
			var_dump(curl_error($ch));
			var_dump(curl_getinfo($ch));
		}
		
		curl_close($ch);
	}
		
}
?>