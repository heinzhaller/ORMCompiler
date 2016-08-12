<?php
#ä
/**
 * MailqueueRecipient Base-Manager
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class MailqueueRecipientBaseManager extends MailqueueRecipientAbstractionLayer { 

	/**************************** ATTRIBUTES ****************************/
	const MAILQUEUERECIPIENTID = 'mailqueuerecipientid';
	const MAILQUEUEID = 'mailqueueid';
	const RECIPIENTADRESS = 'recipientadress';
	const RECIPIENTNAME = 'recipientname';
	const TYPENAME = 'typename';
	const STATUS = 'status';
	const LASTTRY = 'lasttry';
	const TRYS = 'trys';
	const STATUSTEXT = 'statustext';
	const TSTAMP_CREATED = 'tstamp_created';
	const TSTAMP_MODIFIED = 'tstamp_modified';

	/**************************** SELECT METHODS ****************************/
	/**
	 * @param SQLLimit &$myLimit
	 * @return MailqueueRecipientList
	 */
	public static final function getMailqueueRecipientList(SQLLimit &$myLimit = null){
		return parent::getMailqueueRecipientListBySql('1 = 1', null, $myLimit);
	}

	/**
	 * @param integer $mailqueuerecipientid
	 * @param SQLLimit &$myLimit
	 * @return MailqueueRecipient or null
	 */
	public static final function getMailqueueRecipientByMailqueuerecipientid($mailqueuerecipientid, SQLLimit &$myLimit = null){
		$myObject = parent::getMailqueueRecipientListBySql(self::MAILQUEUERECIPIENTID.' = ?', array($mailqueuerecipientid), $myLimit);
		return ( $myObject->valid() ? $myObject->current() : null );
	}

	/**
	 * @param integer $mailqueueid
	 * @param SQLLimit &$myLimit
	 * @return MailqueueRecipientList
	 */
	public static final function getMailqueueRecipientListByMailqueueid($mailqueueid, SQLLimit &$myLimit = null){
		return parent::getMailqueueRecipientListBySql(self::MAILQUEUEID.' = ?', array($mailqueueid), $myLimit);
	}

	/**
	 * @param string $recipientadress
	 * @param SQLLimit &$myLimit
	 * @return MailqueueRecipientList
	 */
	public static final function getMailqueueRecipientListByRecipientadress($recipientadress, SQLLimit &$myLimit = null){
		return parent::getMailqueueRecipientListBySql(self::RECIPIENTADRESS.' = ?', array($recipientadress), $myLimit);
	}

	/**
	 * @param string $recipientname
	 * @param SQLLimit &$myLimit
	 * @return MailqueueRecipientList
	 */
	public static final function getMailqueueRecipientListByRecipientname($recipientname, SQLLimit &$myLimit = null){
		return parent::getMailqueueRecipientListBySql(self::RECIPIENTNAME.' = ?', array($recipientname), $myLimit);
	}

	/**
	 * @param string $typename
	 * @param SQLLimit &$myLimit
	 * @return MailqueueRecipientList
	 */
	public static final function getMailqueueRecipientListByTypename($typename, SQLLimit &$myLimit = null){
		return parent::getMailqueueRecipientListBySql(self::TYPENAME.' = ?', array($typename), $myLimit);
	}

	/**
	 * @param integer $status
	 * @param SQLLimit &$myLimit
	 * @return MailqueueRecipientList
	 */
	public static final function getMailqueueRecipientListByStatus($status, SQLLimit &$myLimit = null){
		return parent::getMailqueueRecipientListBySql(self::STATUS.' = ?', array($status), $myLimit);
	}

	/**
	 * @param integer $lasttry
	 * @param SQLLimit &$myLimit
	 * @return MailqueueRecipientList
	 */
	public static final function getMailqueueRecipientListByLasttry($lasttry, SQLLimit &$myLimit = null){
		return parent::getMailqueueRecipientListBySql(self::LASTTRY.' = ?', array($lasttry), $myLimit);
	}

	/**
	 * @param integer $trys
	 * @param SQLLimit &$myLimit
	 * @return MailqueueRecipientList
	 */
	public static final function getMailqueueRecipientListByTrys($trys, SQLLimit &$myLimit = null){
		return parent::getMailqueueRecipientListBySql(self::TRYS.' = ?', array($trys), $myLimit);
	}

	/**
	 * @param string $statustext
	 * @param SQLLimit &$myLimit
	 * @return MailqueueRecipientList
	 */
	public static final function getMailqueueRecipientListByStatustext($statustext, SQLLimit &$myLimit = null){
		return parent::getMailqueueRecipientListBySql(self::STATUSTEXT.' = ?', array($statustext), $myLimit);
	}

	/**
	 * @param integer $tstamp_created
	 * @param SQLLimit &$myLimit
	 * @return MailqueueRecipientList
	 */
	public static final function getMailqueueRecipientListByTstampCreated($tstamp_created, SQLLimit &$myLimit = null){
		return parent::getMailqueueRecipientListBySql(self::TSTAMP_CREATED.' = ?', array($tstamp_created), $myLimit);
	}

	/**
	 * @param integer $tstamp_modified
	 * @param SQLLimit &$myLimit
	 * @return MailqueueRecipientList
	 */
	public static final function getMailqueueRecipientListByTstampModified($tstamp_modified, SQLLimit &$myLimit = null){
		return parent::getMailqueueRecipientListBySql(self::TSTAMP_MODIFIED.' = ?', array($tstamp_modified), $myLimit);
	}

	/**************************** REFERENCES ****************************/
	/**
	 * @param Mailqueue &$myObject
	 * @return MailqueueRecipientList
	 */
	public static final function getMailqueueRecipientListByMailqueue(Mailqueue &$myObject, SQLLimit &$myLimit = null){
		return self::getMailqueueRecipientListByMailqueueid($myObject->getMailqueueid(), $myLimit);
	}

	/**
	 * @param MailqueueRecipient &$myMailqueueRecipient
	 * @return Mailqueue
	 */
	public static final function getMailqueueByMailqueueRecipient(MailqueueRecipient &$myObject){
		Library::requireLibrary(LibraryKeys::APPLICATION_MAILQUEUE());
		return MailqueueManager::getMailqueueByRecipient($myObject);
	}

	/**
	 * @param MailqueueRecipienttype &$myObject
	 * @return MailqueueRecipientList
	 */
	public static final function getMailqueueRecipientListByRecipienttype(MailqueueRecipienttype &$myObject, SQLLimit &$myLimit = null){
		return self::getMailqueueRecipientListByTypename($myObject->getTypename(), $myLimit);
	}

	/**
	 * @param MailqueueRecipient &$myMailqueueRecipient
	 * @return MailqueueRecipienttype
	 */
	public static final function getRecipienttypeByMailqueueRecipient(MailqueueRecipient &$myObject){
		Library::requireLibrary(LibraryKeys::APPLICATION_MAILQUEUE_RECIPIENTTYPE());
		return MailqueueRecipienttypeManager::getMailqueueRecipienttypeByRecipient($myObject);
	}

}
