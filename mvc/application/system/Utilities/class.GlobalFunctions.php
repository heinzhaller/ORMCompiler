<?php
//ä
abstract class GlobalFunctions {
	
	public static final function getTitleByLanguage($iso) {
		require_once GLOBALCONFIG_GLOBALDIR.'/com.sfy.webglobal.database.ormbase/class.TitleDAO.php';
		return TitleDAO::genericQuery('SELECT TITLEID, description FROM tbl_title WHERE language = ? ORDER BY description', array($iso));
	}
	
	public static final function getTitleByLanguageAndCobrandingid($iso, $cobrandingid) {
		require_once GLOBALCONFIG_GLOBALDIR.'/com.sfy.webglobal.database.ormbase/class.TitleDAO.php';
		return TitleDAO::genericQuery('SELECT TITLEID, description FROM tbl_title WHERE language = ? AND cobrandingid = ? ORDER BY description', array($iso, $cobrandingid));
	}
	
	public static final function getLicensepartnerById($licensepartnerId) {
		require_once GLOBALCONFIG_GLOBALDIR.'/com.sfy.webglobal.database.ormbase/class.CmUsersDAO.php';
		
		$licensepartner = CmUsersDAO::queryWithPreparedStatementWhereCondition("uid = ?", array($licensepartnerId));
		return (sizeof($licensepartner) == 1) ? $licensepartner[0] : null;
	}
	
	public static final function getCustomerById($customerId) {
		require_once GLOBALCONFIG_GLOBALDIR.'/com.sfy.webglobal.database.ormbase/class.KundenDAO.php';
		
		$customer = KundenDAO::queryWithPreparedStatementWhereCondition("kid = ?", array($customerId));
		return (sizeof($customer) == 1) ? $customer[0] : null;
	}
	
	public static final function checkCorrectGermanBlz($germanBlz) {
		//(select count(*) from tbl_blz where blz = a.blz) as anzahlblz
		require_once GLOBALCONFIG_GLOBALDIR.'/com.sfy.webglobal.database.ormbase/class.BlzDAO.php';
		return (sizeof( BlzDAO::queryWithPreparedStatementWhereCondition( "blz = ?", array($germanBlz) ) ) > 0);
	}
	
	public static final function checkCorrectGermanKtnr($germanKtnr) {
		return (preg_match("/^([[:digit:]]{1,10})$/", $germanKtnr) > 0);
	}
	
	public static final function getSqlLaender($country){
	$mySQL = 'select 
  new_laender.iso2, new_translation_inhalte.inhalt as land, bank_available
		from new_laender, new_translation_platzhalter, new_translation_inhalte
		where concat(\'COUNTRY_\', new_laender.iso2) = new_translation_platzhalter.platzhalter
		and new_translation_platzhalter.template_id = 147
		and new_translation_platzhalter.transplatzid = new_translation_inhalte.platzhalter_id
		and new_translation_inhalte.sprache_short = \''.strtoupper($country).'\'
		and new_translation_inhalte.template_id = 147
		order by new_translation_inhalte.inhalt';
		return $mySQL;
	}
	
	public static final function deleteAllHyphenAndSpaceCharacters($string) {
		$string = str_replace(' ', '', $string);
		$string = str_replace('-', '', $string);
		
		return $string;
	}
	
	public static final function formatValidVowelString($string) {
		$search = array('ß', 'Ä', 'Ö', 'Ü', 'ä', 'ö', 'ü',);
		$replace = array('ss', 'AE', 'OE', 'UE', 'ae', 'oe', 'ue');
		
		$string = str_replace($search, $replace, $string);
		
		return $string;
	}
	
	public static final function formatedVarDump($var) {
		echo "<pre>";
		var_dump($var);
		echo "</pre>";
	}
	
	public static final function getLpOrKdNumberById($id) {
		$nummer = null;
		
		$lpOrKd = self::getLicensepartnerById($id);
		if($lpOrKd != null) {
			$nummer = $lpOrKd->getBenutzerNummer();
		} else {
			$lpOrKd = self::getCustomerById($id);
			if($lpOrKd != null) {
				$nummer = $lpOrKd->getKundeNummer();
			}
		}
		
		return $nummer;
	}
	
	public static final function getLpOrKdIdByLpOrKdNumber($lpOrKdNumber) {
		require_once GLOBALCONFIG_GLOBALDIR.'/com.sfy.webglobal.database.ormbase/class.CmUsersDAO.php';
		
		$lpOrKd = CmUsersDAO::queryWithPreparedStatementWhereCondition("benutzer_nummer = ?", array($lpOrKdNumber));
		if(sizeof($lpOrKd) == 1) {
			return $lpOrKd[0]->getUid();
		} else {
			require_once GLOBALCONFIG_GLOBALDIR.'/com.sfy.webglobal.database.ormbase/class.KundenDAO.php';
			$lpOrKd = KundenDAO::queryWithPreparedStatementWhereCondition("kunde_nummer = ?", array($lpOrKdNumber));
			if(sizeof($lpOrKd) == 1) {
				return $lpOrKd[0]->getKid();
			} else {
				return null;
			}
		}
	}
	
	// Konvertiert von Währungs-String nach Float. Wenn Konvertieren nicht möglich
	// dann gibt die Funktion NULL zurück.
	public static final function parseFloat($ptString) {
		if (strlen($ptString) == 0) {
			return NULL;
		}
		 
		$pString = str_replace(" ", "", $ptString);
		 
		if (substr_count($pString, ",") > 1)
		$pString = str_replace(",", "", $pString);
		 
		if (substr_count($pString, ".") > 1)
		$pString = str_replace(".", "", $pString);
		 
		$pregResult = array();
		 
		$commaset = strpos($pString,',');
		if ($commaset === false) {$commaset = -1;}
		 
		$pointset = strpos($pString,'.');
		if ($pointset === false) {$pointset = -1;}
		 
		$pregResultA = array();
		$pregResultB = array();
		 
		if ($pointset < $commaset) {
			preg_match('#(([-]?[0-9]+(\.[0-9])?)+(,[0-9]+)?)#', $pString, $pregResultA);
		}
		preg_match('#(([-]?[0-9]+(,[0-9])?)+(\.[0-9]+)?)#', $pString, $pregResultB);
		if ((isset($pregResultA[0]) && (!isset($pregResultB[0])
		|| strstr($preResultA[0],$pregResultB[0]) == 0
		|| !$pointset))) {
			$numberString = $pregResultA[0];
			$numberString = str_replace('.','',$numberString);
			$numberString = str_replace(',','.',$numberString);
		}
		elseif (isset($pregResultB[0]) && (!isset($pregResultA[0])
		|| strstr($pregResultB[0],$preResultA[0]) == 0
		|| !$commaset)) {
			$numberString = $pregResultB[0];
			$numberString = str_replace(',','',$numberString);
		}
		else {
			return NULL;
		}
		$result = (float)$numberString;
		return $result;
	}
	
	/**
	 * Speichert den logtext in einer Logdatei ab und gibt deren Namen zurück.
	 * Der Name der Logdatei beginnt mit einem Unixtimestamp des aktuellen Datums.
	 * Sollte das Erstellen der Logdatei nicht möglich sein, wird eine Fehlermeldung ausgegeben 
	 *
	 * @param string $logtext
	 * @param string $filename
	 * @return string $filefullname
	 */
	public static final function createLogfileAndSaveIT($logtext, $filename, $pathname = '') {

		/**
		 * Relativer Speicherort für das Logfile ausgehend vom Dokumentrootverzeichnis
		 */
		if(empty($pathname)){
			$pathname = '/var/www/webglobal/0_datarepository/templogfiles/';
		}

		$filefullname = $pathname.$filename;
		
		if (!$handle = fopen($filefullname, "a+")) {
	        print "Kann die Datei $filefullname nicht öffnen".'</br>';
	        exit;
	    }
		
	    if (!fwrite($handle, $logtext)) {
	        print "Kann in die Datei $filefullname nicht schreiben".'</br>';
	        exit;
	    }
    
	    fclose($handle);
    	return $filefullname;
	}
}

?>