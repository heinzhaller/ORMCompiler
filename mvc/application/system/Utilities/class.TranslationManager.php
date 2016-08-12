<?php
abstract class TranslationManager {
	
	/**
	 * Platzhalter aus der Datenbank in PHP-Konstanten laden
	 *
	 * @param array $path Dateiname
	 * @param string $translation_sprache Iso2Sprache
	 * @param string $system System
	 * @param string $layout Cobranding
	 */
	public static final function loadPlaceholderByArray( array $path, $translation_sprache, $system, $layout ){
		require_once GLOBALCONFIG_GLOBALDIR.'/com.sfy.webglobal.database.ormbase/class.BasicDAO.php';
		
		// variablen setzen
		$translation_sprache = (string) $translation_sprache;
		$system = (string) $system;
		$layout = (string) $layout;
		$layout = ($layout == '' ? 0 : $layout);
		
		// Die √ñsterreicher und die Schweizer bedienen sich auch der deutschen Sprachdatei.
		if ($translation_sprache == 'AT') $translation_sprache = 'DE';
		if ($translation_sprache == 'CH') $translation_sprache = 'DE';
		
		// Platzhalter mit den dazugeh√∂rigen Inhalten laden, wenn kein default inhalt vorhanden ist wird null geladen, damit alle konstanten gef¸llt sind
		$param = array($translation_sprache);
		$queryplaceholder = 'SELECT new_translation_platzhalter.platzhalter, new_translation_inhalte.inhalt
		FROM 
			new_translation_templates JOIN new_translation_platzhalter ON new_translation_templates.transtempid = new_translation_platzhalter.template_id 
			LEFT OUTER JOIN new_translation_inhalte ON new_translation_platzhalter.transplatzid = new_translation_inhalte.platzhalter_id AND 
				(new_translation_inhalte.sprache_short = ? OR 
				new_translation_inhalte.sprache_short IS NULL) ';
		
		$param[] = $system;
		$queryplaceholderWhere = ' WHERE ( 
					( new_translation_templates.dateiname = \'DEFAULT\' AND new_translation_templates.system in (\'default\', ? ) )';
			
		// Platzhalterdateien zusammenbauen		
		foreach ( $path as $item ){
			$queryplaceholderWhere .= '
			OR
				( new_translation_templates.dateiname = ? AND new_translation_templates.system = ? )';
			$param[] = $item;
			$param[] = $system;
		}
		$queryplaceholderWhere .= ')';
		
		// default cobranding laden
		$query = $queryplaceholder . ' 
		AND
		(
			new_translation_inhalte.cobrandingid = 1 OR 
			new_translation_inhalte.cobrandingid IS NULL
		) ' . $queryplaceholderWhere;
		
		$rs = BasicDAO::genericQuery( $query, $param);
		
		$placeholderarray = array();
		while ( $rs->next() ) {
			$placeholderArray[ $rs->getString('PLATZHALTER') ] = $rs->getString('INHALT');
		}
		
		// Bei der Internetstadt kann es benutzerdefinierte Texte geben.
		// wenn kein cobranding inhalt vorhanden ist wird nichts geladen, damit die defaults nicht ¸berschrieben werden
		// wenn eine ¸bersetzung ¸berschrieben werden soll muss ein leerer datensatz angelegt werden
		if ( $system == 'sfy' ) {
			$query = $queryplaceholder . $queryplaceholderWhere . ' and new_translation_inhalte.cobrandingid = ?';
			
			$param[] = $layout;
			$rs = BasicDAO::genericQuery($query, $param);
			while ( $rs->next() ) {
				$placeholderArray[ $rs->getString('platzhalter') ] = $rs->getString('inhalt');
			}
		}
		
		// Aus dem PlaceholderArray die Konstanten erstellen die unten genutzt werden. 
		foreach ( $placeholderArray as $key => $item ){
			// Todo
			// - downline-vererbung IMMER untersten benutzen (letzter in der reihe) 
			// - Replace-Regel f√ºr einen INHALT z.b. ein Wort austauschen.	
		
			// Wenn im Platzhalter das K√ºrzel _MAIL_ vorkommt dann werden die Zeilenumbr√ºche nicht durch <br/> ersetzt 
			// weil das dann z.B. in Text-E-Mails verwendet wird und dort wird das nicht gebraucht... 
			if ( strpos($key, '_MAIL_') > 0 OR strpos($key, '_EMAIL_') > 0 ) {
				define($key, $item); 
			} else { 
				define($key, nl2br($item));
			} 
		}
	}
}

?>