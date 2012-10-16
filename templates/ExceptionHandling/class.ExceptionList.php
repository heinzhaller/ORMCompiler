<?php
#ä
/**
 * list of exception handlings
 * @author mrimpler 2010-01-08
 * @version 1.0
 */
abstract class ExceptionList {
	
	public static final function ERRORCODE_100(ExceptionObject &$myException){
		$myException->setMessage('Null-Wert übergeben.');
		$myException->setLayer(ExceptionLayer::ABSTRACTIONLAYER);
		$myException->setType(ExceptionTypes::ERROR);
	}
	
	public static final function ERRORCODE_101(ExceptionObject &$myException, array $params){
		$myException->setMessage('Falscher Typ übergeben. Erwartet: ['.$params[0].'] - Erhalten: ['.gettype($params[1]).'] ');
		$myException->setLayer(ExceptionLayer::ABSTRACTIONLAYER);
		$myException->setType(ExceptionTypes::ERROR);
	}
	
	public static final function ERRORCODE_201(ExceptionObject &$myException){
		$myException->setMessage('Sie haben keine Berechtigung diese Seite zu betrachten.');
		$myException->setLayer(ExceptionLayer::APPLICATIONLAYER);
		$myException->setType(ExceptionTypes::ERROR);
	}
	
	public static final function ERRORCODE_303(ExceptionObject &$myException){
		$myException->setMessage('Zeichensatz-Konvertierung fehlgeschlagen. Von: ['.$params[0].'] - Nach: ['.$params[1].']');
		$myException->setLayer(ExceptionLayer::APPLICATIONLAYER);
		$myException->setType(ExceptionTypes::ERROR);
	}
	
	public static final function ERRORCODE_350(ExceptionObject &$myException, array $params){
		$myException->setMessage('Curl-Fehler: ['.$params[0].']');
		$myException->setLayer(ExceptionLayer::APPLICATIONLAYER);
		$myException->setType(ExceptionTypes::ERROR);
	}
	
	public static final function ERRORCODE_404(ExceptionObject &$myException){
		$myException->setMessage('Die Seite konnte nicht aufgerufen werden.');
		$myException->setLayer(ExceptionLayer::APPLICATIONLAYER);
		$myException->setType(ExceptionTypes::ERROR);
	}
	
	public static final function ERRORCODE_405(ExceptionObject &$myException, array $params){
		$myException->setMessage('Die Datei konnte nicht geschrieben werden. Pfad: '.$params[0]);
		$myException->setLayer(ExceptionLayer::APPLICATIONLAYER);
		$myException->setType(ExceptionTypes::ERROR);
	}
	
	public static final function ERRORCODE_444(ExceptionObject &$myException, array $params){
		$myException->setMessage('Die Datei wurde nicht gefunden: ['.$params[0].']');
		$myException->setLayer(ExceptionLayer::APPLICATIONLAYER);
		$myException->setType(ExceptionTypes::ERROR);
	}
	
	public static final function ERRORCODE_740(ExceptionObject &$myException, array $params){
		$myException->setMessage('Server nicht verfügbar oder CSV-Datei konnte nicht abgerufen werden. URL: ['.$params[0].']');
		$myException->setLayer(ExceptionLayer::APPLICATIONLAYER);
		$myException->setType(ExceptionTypes::ERROR);
	}		
	
	public static final function ERRORCODE_741(ExceptionObject &$myException, array $params){
		$myException->setMessage('CSV-Zeilenumbruch entspricht nicht den Vorgaben! Zeichen: ['.implode(',',$params).']');
		$myException->setLayer(ExceptionLayer::APPLICATIONLAYER);
		$myException->setType(ExceptionTypes::ERROR);
	}
	
	public static final function ERRORCODE_750(ExceptionObject &$myException, array $params){
		$myException->setMessage('CSV-Header entspricht nicht den Vorgaben! Zeile ['.$params[0].']');
		$myException->setLayer(ExceptionLayer::APPLICATIONLAYER);
		$myException->setType(ExceptionTypes::ERROR);
	}
	
	public static final function ERRORCODE_751(ExceptionObject &$myException, array $params){
		$myException->setMessage('CSV-Zeile entspricht nicht den Vorgaben! Zeile ['.$params[0].']');
		$myException->setLayer(ExceptionLayer::APPLICATIONLAYER);
		$myException->setType(ExceptionTypes::ERROR);
	}
	
	public static final function ERRORCODE_760(ExceptionObject &$myException, array $params){
		$myException->setMessage('CSV Fehler. Spaltenwert [Datum] entspricht nicht den vorgaben. Wert: ['.$params[0].'] - Zeile: ['.$params[1].']');
		$myException->setLayer(ExceptionLayer::APPLICATIONLAYER);
		$myException->setType(ExceptionTypes::ERROR);
	}
	
	public static final function ERRORCODE_761(ExceptionObject &$myException, array $params){
		$myException->setMessage('CSV Fehler. Spaltenwert [Status] entspricht nicht den vorgaben. Wert: ['.$params[0].'] - Zeile: ['.$params[1].']');
		$myException->setLayer(ExceptionLayer::APPLICATIONLAYER);
		$myException->setType(ExceptionTypes::ERROR);
	}
	
	public static final function ERRORCODE_762(ExceptionObject &$myException, array $params){
		$myException->setMessage('CSV Fehler. Spaltenwert [Customerid] entspricht nicht den vorgaben. Wert: ['.$params[0].'] - Zeile: ['.$params[1].']');
		$myException->setLayer(ExceptionLayer::APPLICATIONLAYER);
		$myException->setType(ExceptionTypes::ERROR);
	}
	
	public static final function ERRORCODE_763(ExceptionObject &$myException, array $params){
		$myException->setMessage('CSV Fehler. Spaltenwert [Eventtyp] entspricht nicht den vorgaben. Wert: ['.$params[0].'] - Zeile: ['.$params[1].']');
		$myException->setLayer(ExceptionLayer::APPLICATIONLAYER);
		$myException->setType(ExceptionTypes::ERROR);
	}
	
	public static final function ERRORCODE_764(ExceptionObject &$myException, array $params){
		$myException->setMessage('CSV Fehler. Spaltenwert [Shopname] entspricht nicht den vorgaben. Wert: ['.$params[0].'] - Zeile: ['.$params[1].']');
		$myException->setLayer(ExceptionLayer::APPLICATIONLAYER);
		$myException->setType(ExceptionTypes::ERROR);
	}
	
	public static final function ERRORCODE_765(ExceptionObject &$myException, array $params){
		$myException->setMessage('CSV Fehler. Spaltenwert [Netto Konsum] entspricht nicht den vorgaben. Wert: ['.$params[0].'] - Zeile: ['.$params[1].']');
		$myException->setLayer(ExceptionLayer::APPLICATIONLAYER);
		$myException->setType(ExceptionTypes::ERROR);
	}
	
	public static final function ERRORCODE_766(ExceptionObject &$myException, array $params){
		$myException->setMessage('CSV Fehler. Spaltenwert [Netto Provision] entspricht nicht den vorgaben. Wert: ['.$params[0].'] - Zeile: ['.$params[1].']');
		$myException->setLayer(ExceptionLayer::APPLICATIONLAYER);
		$myException->setType(ExceptionTypes::ERROR);
	}
	
	public static final function ERRORCODE_767(ExceptionObject &$myException, array $params){
		$myException->setMessage('CSV Fehler. Spaltenwert [Affiliate Shopid] entspricht nicht den vorgaben. Wert: ['.$params[0].'] - Zeile: ['.$params[1].']');
		$myException->setLayer(ExceptionLayer::APPLICATIONLAYER);
		$myException->setType(ExceptionTypes::ERROR);
	}
	
	public static final function ERRORCODE_768(ExceptionObject &$myException, array $params){
		$myException->setMessage('CSV Fehler. Spaltenwert [Transactionid] entspricht nicht den vorgaben. Wert: ['.$params[0].'] - Zeile: ['.$params[1].']');
		$myException->setLayer(ExceptionLayer::APPLICATIONLAYER);
		$myException->setType(ExceptionTypes::ERROR);
	}
	
	public static final function ERRORCODE_769(ExceptionObject &$myException, array $params){
		$myException->setMessage('CSV Fehler. Spaltenwert [Währung] entspricht nicht den Vorgaben. Wert: ['.$params[0].'] - Zeile: ['.$params[1].']');
		$myException->setLayer(ExceptionLayer::APPLICATIONLAYER);
		$myException->setType(ExceptionTypes::ERROR);
	}
	
	public static final function ERRORCODE_790(ExceptionObject &$myException, array $params){
		$myException->setMessage('Falscher Zeichensatz gesendet. Erwartet: ['.$params[0].'] - Erhalten: ['.$params[1].'] - Zeile: '.$params[2]);
		$myException->setLayer(ExceptionLayer::APPLICATIONLAYER);
		$myException->setType(ExceptionTypes::ERROR);
	}

	public static final function ERRORCODE_791(ExceptionObject &$myException, array $params){
		$myException->setMessage('Zeichensatz konnte nicht richtig konvertiert werden. Quelle:['.$params[0].'] - Ziel: ['.$params[1].'] - Zeile: '.$params[2]);
		$myException->setLayer(ExceptionLayer::APPLICATIONLAYER);
		$myException->setType(ExceptionTypes::ERROR);
	}

	public static final function ERRORCODE_801(ExceptionObject &$myException, array $params){
		$myException->setMessage('Customerid konnte keinem System zugeordnet werden: ['.$params[0].']');
		$myException->setLayer(ExceptionLayer::APPLICATIONLAYER);
		$myException->setType(ExceptionTypes::ERROR);
	}

	public static final function ERRORCODE_802(ExceptionObject &$myException, array $params){
		$myException->setMessage('Transactionid entspricht nicht den vorgaben ['.$params[0].']');
		$myException->setLayer(ExceptionLayer::APPLICATIONLAYER);
		$myException->setType(ExceptionTypes::ERROR);
	}

	public static final function ERRORCODE_820(ExceptionObject &$myException, array $params){
		$myException->setMessage('Transaktion bereits importiert. Transactionid: ['.$params[0].']');
		$myException->setLayer(ExceptionLayer::APPLICATIONLAYER);
		$myException->setType(ExceptionTypes::ERROR);
	}
	
	public static final function ERRORCODE_840(ExceptionObject &$myException, array $params){
		$myException->setMessage('Transfer über die API war nicht erfolgreich. URL: ['.$params[0].'] - Grund: ['.$params[1].']');
		$myException->setLayer(ExceptionLayer::APPLICATIONLAYER);
		$myException->setType(ExceptionTypes::ERROR);
	}
	
	public static final function ERRORCODE_9999(ExceptionObject &$myException, array $params = null){
		$myException->setMessage('CUSTOM BREAK - Erzwungener Anhaltepunkt: ' . ( !empty($params) ? implode('<br>',$params) : null ) );
		$myException->setLayer(ExceptionLayer::APPLICATIONLAYER);
		$myException->setType(ExceptionTypes::ERROR);
	}
	
	public static final function ERRORCODE_8888(ExceptionObject &$myException, array $params = null){
		$myException->setMessage('CUSTOM ERROR - Erzwungener Fehler: ' . ( !empty($params) ? implode('<br> - ',$params) : null ) );
		$myException->setLayer(ExceptionLayer::APPLICATIONLAYER);
		$myException->setType(ExceptionTypes::ERROR);
	}
	
}
?>