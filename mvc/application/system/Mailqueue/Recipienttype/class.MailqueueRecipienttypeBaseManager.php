<?php
#ä
/**
 * MailqueueRecipienttype Base-Manager
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class MailqueueRecipienttypeBaseManager extends MailqueueRecipienttypeAbstractionLayer { 

	/**************************** ATTRIBUTES ****************************/
	const TYPENAME = 'typename';

	/**************************** SELECT METHODS ****************************/
	/**
	 * @param SQLLimit &$myLimit
	 * @return MailqueueRecipienttypeList
	 */
	public static final function getMailqueueRecipienttypeList(SQLLimit &$myLimit = null){
		return parent::getMailqueueRecipienttypeListBySql('1 = 1', null, $myLimit);
	}

	/**
	 * @param string $typename
	 * @param SQLLimit &$myLimit
	 * @return MailqueueRecipienttype or null
	 */
	public static final function getMailqueueRecipienttypeByTypename($typename, SQLLimit &$myLimit = null){
		$myObject = parent::getMailqueueRecipienttypeListBySql(self::TYPENAME.' = ?', array($typename), $myLimit);
		return ( $myObject->valid() ? $myObject->current() : null );
	}

	/**************************** REFERENCES ****************************/
	/**
	 * @param MailqueueRecipient &$myObject
	 * @return MailqueueRecipienttype
	 */
	public static final function getMailqueueRecipienttypeByMailqueueRecipient(MailqueueRecipient &$myObject){
		return self::getMailqueueRecipienttypeByTypename($myObject->getTypename());
	}

	/**
	 * @param MailqueueRecipienttype &$myMailqueueRecipienttype
	 * @return MailqueueRecipientList
	 */
	public static final function getMailqueueRecipientListByMailqueueRecipienttype(MailqueueRecipienttype &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_MAILQUEUE_RECIPIENT());
		return MailqueueRecipientManager::getMailqueueRecipientListByRecipienttype($myObject, $myLimit);
	}

}
?>