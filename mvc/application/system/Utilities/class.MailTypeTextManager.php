<?php
interface iMailTypeTextManager {
	public static function getMailTypeTextObject( $mailtype, $cobrandingid, $language );
	public static function getMailTypeObjectByName( $mailtypename );
}

/**
 * MailTypeText Object
 * 
 * @author Mario Rimpler 2009-03-17
 */
class MailTypeTextObject {
	
	private $mailtypetextid;
	private $tstamp;
	private $languageiso2;
	private $cobrandingid;
	private $defaultcharset;
	private $subjecttext;
	private $contenttext;
	private $mailtypeuid;

	public function setMailtypetextid( $integer ){
		$this->mailtypetextid = (integer) $integer;
	}

	public function getMailtypetextid(){
		return $this->mailtypetextid;
	}

	public function setTstamp( $string ){
		$this->tstamp = (string) $string;
	}

	public function getTstamp(){
		return $this->tstamp;
	}

	public function setLanguageiso2( $string ){
		$this->languageiso2 = (string) strtolower($string);
	}

	public function getLanguageiso2(){
		return $this->languageiso2;
	}

	public function setCobrandingid( $integer ){
		$this->cobrandingid = (integer) $integer;
	}

	public function getCobrandingid(){
		return $this->cobrandingid;
	}

	public function setDefaultcharset( $string ){
		$this->defaultcharset = (string) strtolower($string);
	}

	public function getDefaultcharset(){
		return $this->defaultcharset;
	}

	public function setSubjecttext( $string ){
		$this->subjecttext = (string) $string;
	}

	public function getSubjecttext(){
		return $this->subjecttext;
	}

	public function setContenttext( $string ){
		$this->contenttext = (string) $string;
	}

	public function getContenttext(){
		return $this->contenttext;
	}
	
	public function setMailtypeuid( $integer ){
		$this->mailtypeuid = (int) $integer;
	}

	public function getMailtypeuid(){
		return $this->mailtypeuid;
	}
		
}

/**
 * MailTypeTextManager Class
 *
 * @author Mario Rimpler 2009-03-17
 * @copyright storeforyou.de
 * @package MailTypeTextObject, iMailTypeTextManager
 */
abstract class MailTypeTextManager implements iMailTypeTextManager {

	/**
	 * get EmailContentDAOObject
	 * @author Mario Rimpler 2009-03-17
	 * @param string $mailtypeuid
	 * @param int $cobrandingid
	 * @param int $language
	 * @return EmailContentDAO
	 */
	private static function getMailTypenTextDAOObject( $mailtypeuid, $cobrandingid, $language ){
		$mailtypeuid = (int) $mailtypeuid;
		$cobrandingid = (int) $cobrandingid;
		$language = (string) strtoUpper($language);
		
		require_once GLOBALCONFIG_GLOBALDIR.'/com.sfy.webglobal.database.ormbase/class.MailTypenTextDAO.php';
		
		$myMailTypeTextObject = MailTypenTextDAO::queryWithPreparedStatementWhereCondition( 'mailtypeuid = ? AND cobrandingid = ? AND languageiso2 = ?', 
			array( $mailtypeuid, $cobrandingid, $language ));
		
		return $myMailTypeTextObject[0];
	}
	
	/**
	 * load data from database
	 * @author Mario Rimpler 2009-03-17
	 * @param MailTypenTextDAO $object
	 * @return MailTypeTextObject $myMailTypeTextObject
	 */
	private static function loadMailTypenTextObject( MailTypenTextDAO $myObject ){
		$myMailTypeTextObject = new MailTypeTextObject();
		$myMailTypeTextObject->setMailtypetextid( $myObject->getMailtypentextid() );
		$myMailTypeTextObject->setTstamp( $myObject->getTstampCreated() );
		$myMailTypeTextObject->setLanguageiso2( $myObject->getLanguageiso2() );
		$myMailTypeTextObject->setCobrandingid( $myObject->getCobrandingid() );
		$myMailTypeTextObject->setDefaultcharset( $myObject->getDefaultcharset() );
		$myMailTypeTextObject->setSubjecttext( $myObject->getSubjecttext() );
		$myMailTypeTextObject->setContenttext( $myObject->getContenttext() );
		$myMailTypeTextObject->setMailtypeuid( $myObject->getMailtypeuid() );
		return $myMailTypeTextObject;
	}
	
	/**
	 * load default mailtypetextobject
	 * @author Mario Rimpler 2009-03-17
	 * @return MailTypeTextObject
	 */
	private static function loadDefaultMailTypeTextObject(){
		$myMailTypeTextObject = new MailTypeTextObject();
		$myMailTypeTextObject->setDefaultcharset( 'iso-8859-1' );
		return $myMailTypeTextObject;
	}
	
	/**
	 * get MailTypeObject by name
	 * @author Mario Rimpler 2009-03-17
	 * @param string $mailtypename
	 * @return string mailtypetextid
	 */
	public static function getMailTypeObjectByName( $mailtypename ){
		$mailtypename = (string) $mailtypename;
		
		require_once GLOBALCONFIG_GLOBALDIR.'/com.sfy.webglobal.database.ormbase/class.MailTypenDAO.php';
		$myMailTypeObject = MailTypenDAO::queryWithPreparedStatementWhereCondition( 'beschreibung = ?', array( $mailtypename ));

		return $myMailTypeObject[0];
	}
	
	/**
	 * get mail content
	 * @author Sonja Stengel 2009-012-17
	 * @param int $mailtypeid
	 * @return MailTypeTextObject $myMailTypeTextObject
	 */
	public static function getMailTypeTextByMailTypeId( $mailtypeid ){
		$mailtypeid = (int) $mailtypeid;
		
		require_once GLOBALCONFIG_GLOBALDIR.'/com.sfy.webglobal.database.ormbase/class.MailTypenTextDAO.php';
		$myDAOObject = MailTypenTextDAO::queryWithPreparedStatementWhereCondition( 'mailtypeuid = ?', 
															array( $mailtypeid));

		if( $myDAOObject != NULL ){
			$myMailTypeTextObject = self::loadMailTypenTextObject( $myDAOObject[0] );
		}else{
			$myMailTypeTextObject = null;
		}
		return $myMailTypeTextObject;
	}
	
	/**
	 * get mail content
	 * @author Mario Rimpler 2009-03-17
	 * @param int $mailtype
	 * @param int $cobrandingid
	 * @param int $language
	 * @return MailTypeTextObject $myMailTypeTextObject
	 */
	public static function getMailTypeTextObject( $mailtype, $cobrandingid, $language ){
		$mailtype = (int) $mailtype;
		$cobrandingid = (int) $cobrandingid;
		$language = (string) $language;

		// get mailtypetextid from mailtypes
		//$mailtypetextid = self::getMailTypetextid( $mailtype );

		// get object from database
		$myDAOObject = ( $mailtype != null ? self::getMailTypenTextDAOObject( $mailtype, $cobrandingid, $language ) : null );
		
		if( $myDAOObject != NULL ){
			// get MailTypeText-Object from DAO-Object
			$myMailTypeTextObject = self::loadMailTypenTextObject( $myDAOObject );
		}else{
			// set object to null
			$myMailTypeTextObject = null;
		}
			// return generated $myMailTypeTextObject
		return $myMailTypeTextObject;
	}
		
		
	/**
	 * get mail content
	 * @author Mario Rimpler 2009-03-17
	 * @param int $mailtype
	 * @param int $cobrandingid
	 * @param int $language
	 * @return MailTypeTextObject $myMailTypeTextObject
	 */
	public static function getMailTypeTextByMailTypeLanguage( $mailtypeid, $language ){
		$mailtype = (int) $mailtypeid;
		$language = (string) $language;
		
		if( $mailtype != null){
			require_once GLOBALCONFIG_GLOBALDIR.'/com.sfy.webglobal.database.ormbase/class.MailTypenTextDAO.php';
			$myDAOObject = MailTypenTextDAO::queryWithPreparedStatementWhereCondition( 'mailtypeuid = ? AND languageiso2 = ?', 
					array( $mailtypeid, $language ));
		}
		
		if( $myDAOObject != NULL ){
			$myMailTypeTextObject = self::loadMailTypenTextObject( $myDAOObject[0] );
		}else{
			$myMailTypeTextObject = null;
		}

		return $myMailTypeTextObject;
	}
	
	/**
	 * save MailTypeText object into database
	 * @param MailTypeTextObject $myMailTypeText
	 */
	public static final function save(MailTypeTextObject &$myMailTypeText){
		$myMailTypeTextDAO = self::copyMailTypeTextObjectToDAO($myMailTypeText);
		$myMailTypeTextDAO->store();
		$myMailTypeText->setMailtypetextid($myMailTypeTextDAO->getMailtypentextid());
	}
	
	/**
	* erzeugt ein MailTypeText-Objekt
	* 
	* @param MailTypeTextObject $myMailTypeText
	* 
	* @return TarifeDAO $myDAO
	*/
	private static function copyMailTypeTextObjectToDAO(MailTypeTextObject &$myMailTypeText){
		require_once GLOBALCONFIG_GLOBALDIR.'/com.sfy.webglobal.database.ormbase/class.MailTypenTextDAO.php';
				
		if(is_null($myMailTypeText->getMailtypetextid())){
			$myDAO = new MailTypenTextDAO();
		}else{
			$myDAO = MailTypenTextDAO::queryWithPreparedStatementWhereCondition('mailtypeuid = ? AND languageiso2 = ?',array($myMailTypeText->getMailtypeuid(), strtoUpper($myMailTypeText->getLanguageiso2())));
			$myDAO = $myDAO[0];
		}
		
		$myDAO->setMailtypeuid($myMailTypeText->getMailtypeuid());
		$myDAO->setLanguageiso2(strtoUpper($myMailTypeText->getLanguageiso2()));
		$myDAO->setCobrandingid($myMailTypeText->getCobrandingid());
		$myDAO->setDefaultcharset($myMailTypeText->getDefaultcharset());
		$myDAO->setSubjecttext($myMailTypeText->getSubjecttext());
		$myDAO->setContenttext($myMailTypeText->getContenttext());
		return $myDAO;
	}	
	
}

?>