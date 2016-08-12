<?php
require_once GLOBALCONFIG_GLOBALDIR.'/com.sfy.webglobal.database.ormbase/class.ShortlinksDAO.php';
require_once (GLOBALCONFIG_GLOBALDIR.'/com.sfy.modules/ShortLinks/class.ShortLinks.php');

abstract class ShortLinksManager{
	// Kurzen Link erzeugen der über goto.php wieder ausgelesen werden kann.
	public static final function createShortlink($url, $httphost = null) {
		$zufallstring = getRandomString(7);
	
		$myShortlink = new ShortlinksDAO();
		$myShortlink->setKuerzel($zufallstring);
		$myShortlink->setUrl(noSqlhack($url));
		$myShortlink->setClicks(0);
		$myShortlink->store();
		$myShortlink->setKuerzel($zufallstring . $myShortlink->getShortlinkid());
		$myShortlink->store();
	
		$protocol = 'http';
		if(!isset($httphost)) 
			$protocol = isset($_SERVER['HTTPS']) ? 'https' : 'http';
				
		return $protocol.'://'.(is_null($httphost) ? $_SERVER['HTTP_HOST'] : $httphost).'/goto.php?'.$myShortlink->getKuerzel();
		
	}
	
	public static final function updateClicksShortLink($kuerzel){
		$ret = null;
		$url = ShortlinksDAO::queryWithPreparedStatementWhereCondition('kuerzel = ?', array($kuerzel));
		if (count($url) == 1) {
			$url[0]->setClicks($url[0]->getClicks()+1);
			$url[0]->store();
			
			$ret = self::copyDAOToObj($url[0]);
		}
		return $ret;
	} 
	
	public static final function copyDAOToObj(ShortlinksDAO &$dao){
		$obj = new ShortLinks();
		$obj->setShortUrl($dao->getUrl());
		
		return $obj;
	}
}
?>