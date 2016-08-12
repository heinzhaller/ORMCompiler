<?php
#ä
/**
 * MailqueueMailtype Base-Manager
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class MailqueueMailtypeBaseManager extends MailqueueMailtypeAbstractionLayer { 

	/**************************** ATTRIBUTES ****************************/
	const MAILTYPENAME = 'mailtypename';

	/**************************** SELECT METHODS ****************************/
	/**
	 * @param SQLLimit &$myLimit
	 * @return MailqueueMailtypeList
	 */
	public static final function getMailqueueMailtypeList(SQLLimit &$myLimit = null){
		return parent::getMailqueueMailtypeListBySql('1 = 1', null, $myLimit);
	}

	/**
	 * @param string $mailtypename
	 * @param SQLLimit &$myLimit
	 * @return MailqueueMailtype or null
	 */
	public static final function getMailqueueMailtypeByMailtypename($mailtypename, SQLLimit &$myLimit = null){
		$myObject = parent::getMailqueueMailtypeListBySql(self::MAILTYPENAME.' = ?', array($mailtypename), $myLimit);
		return ( $myObject->valid() ? $myObject->current() : null );
	}

	/**************************** REFERENCES ****************************/
	/**
	 * @param Mailqueue &$myObject
	 * @return MailqueueMailtype
	 */
	public static final function getMailqueueMailtypeByMailqueue(Mailqueue &$myObject){
		return self::getMailqueueMailtypeByMailtypename($myObject->getMailtypename());
	}

	/**
	 * @param MailqueueMailtype &$myMailqueueMailtype
	 * @return MailqueueList
	 */
	public static final function getMailqueueListByMailqueueMailtype(MailqueueMailtype &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_MAILQUEUE());
		return MailqueueManager::getMailqueueListByMailtype($myObject, $myLimit);
	}

}
?>