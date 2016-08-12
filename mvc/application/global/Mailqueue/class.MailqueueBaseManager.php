<?php
#ä
/**
 * Mailqueue Base-Manager
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class MailqueueBaseManager extends MailqueueAbstractionLayer { 

	/**************************** ATTRIBUTES ****************************/
	const MAILQUEUEID = 'mailqueueid';
	const USERID = 'userid';
	const CHARSET = 'charset';
	const SENDERADRESS = 'senderadress';
	const SENDERNAME = 'sendername';
	const MAILTYPENAME = 'mailtypename';
	const SUBJECT = 'subject';
	const CONTENT = 'content';
	const COMMENTARY = 'commentary';
	const FILEPATH = 'filepath';
	const FILENAME = 'filename';
	const SIGNATURE = 'signature';
	const TSTAMP_CREATED = 'tstamp_created';
	const TSTAMP_MODIFIED = 'tstamp_modified';

	/**************************** SELECT METHODS ****************************/
	/**
	 * @param SQLLimit &$myLimit
	 * @return MailqueueList
	 */
	public static final function getMailqueueList(SQLLimit &$myLimit = null){
		return parent::getMailqueueListBySql('1 = 1', null, $myLimit);
	}

	/**
	 * @param integer $mailqueueid
	 * @param SQLLimit &$myLimit
	 * @return Mailqueue or null
	 */
	public static final function getMailqueueByMailqueueid($mailqueueid, SQLLimit &$myLimit = null){
		$myObject = parent::getMailqueueListBySql(self::MAILQUEUEID.' = ?', array($mailqueueid), $myLimit);
		return ( $myObject->valid() ? $myObject->current() : null );
	}

	/**
	 * @param integer $userid
	 * @param SQLLimit &$myLimit
	 * @return MailqueueList
	 */
	public static final function getMailqueueListByUserid($userid, SQLLimit &$myLimit = null){
		return parent::getMailqueueListBySql(self::USERID.' = ?', array($userid), $myLimit);
	}

	/**
	 * @param string $charset
	 * @param SQLLimit &$myLimit
	 * @return MailqueueList
	 */
	public static final function getMailqueueListByCharset($charset, SQLLimit &$myLimit = null){
		return parent::getMailqueueListBySql(self::CHARSET.' = ?', array($charset), $myLimit);
	}

	/**
	 * @param string $senderadress
	 * @param SQLLimit &$myLimit
	 * @return MailqueueList
	 */
	public static final function getMailqueueListBySenderadress($senderadress, SQLLimit &$myLimit = null){
		return parent::getMailqueueListBySql(self::SENDERADRESS.' = ?', array($senderadress), $myLimit);
	}

	/**
	 * @param string $sendername
	 * @param SQLLimit &$myLimit
	 * @return MailqueueList
	 */
	public static final function getMailqueueListBySendername($sendername, SQLLimit &$myLimit = null){
		return parent::getMailqueueListBySql(self::SENDERNAME.' = ?', array($sendername), $myLimit);
	}

	/**
	 * @param string $mailtypename
	 * @param SQLLimit &$myLimit
	 * @return MailqueueList
	 */
	public static final function getMailqueueListByMailtypename($mailtypename, SQLLimit &$myLimit = null){
		return parent::getMailqueueListBySql(self::MAILTYPENAME.' = ?', array($mailtypename), $myLimit);
	}

	/**
	 * @param string $subject
	 * @param SQLLimit &$myLimit
	 * @return MailqueueList
	 */
	public static final function getMailqueueListBySubject($subject, SQLLimit &$myLimit = null){
		return parent::getMailqueueListBySql(self::SUBJECT.' = ?', array($subject), $myLimit);
	}

	/**
	 * @param string $content
	 * @param SQLLimit &$myLimit
	 * @return MailqueueList
	 */
	public static final function getMailqueueListByContent($content, SQLLimit &$myLimit = null){
		return parent::getMailqueueListBySql(self::CONTENT.' = ?', array($content), $myLimit);
	}

	/**
	 * @param string $commentary
	 * @param SQLLimit &$myLimit
	 * @return MailqueueList
	 */
	public static final function getMailqueueListByCommentary($commentary, SQLLimit &$myLimit = null){
		return parent::getMailqueueListBySql(self::COMMENTARY.' = ?', array($commentary), $myLimit);
	}

	/**
	 * @param string $filepath
	 * @param SQLLimit &$myLimit
	 * @return MailqueueList
	 */
	public static final function getMailqueueListByFilepath($filepath, SQLLimit &$myLimit = null){
		return parent::getMailqueueListBySql(self::FILEPATH.' = ?', array($filepath), $myLimit);
	}

	/**
	 * @param string $filename
	 * @param SQLLimit &$myLimit
	 * @return MailqueueList
	 */
	public static final function getMailqueueListByFilename($filename, SQLLimit &$myLimit = null){
		return parent::getMailqueueListBySql(self::FILENAME.' = ?', array($filename), $myLimit);
	}

	/**
	 * @param string $signature
	 * @param SQLLimit &$myLimit
	 * @return MailqueueList
	 */
	public static final function getMailqueueListBySignature($signature, SQLLimit &$myLimit = null){
		return parent::getMailqueueListBySql(self::SIGNATURE.' = ?', array($signature), $myLimit);
	}

	/**
	 * @param integer $tstamp_created
	 * @param SQLLimit &$myLimit
	 * @return MailqueueList
	 */
	public static final function getMailqueueListByTstampCreated($tstamp_created, SQLLimit &$myLimit = null){
		return parent::getMailqueueListBySql(self::TSTAMP_CREATED.' = ?', array($tstamp_created), $myLimit);
	}

	/**
	 * @param integer $tstamp_modified
	 * @param SQLLimit &$myLimit
	 * @return MailqueueList
	 */
	public static final function getMailqueueListByTstampModified($tstamp_modified, SQLLimit &$myLimit = null){
		return parent::getMailqueueListBySql(self::TSTAMP_MODIFIED.' = ?', array($tstamp_modified), $myLimit);
	}

	/**************************** REFERENCES ****************************/
	/**
	 * @param MailqueueMailtype &$myObject
	 * @return MailqueueList
	 */
	public static final function getMailqueueListByMailtype(MailqueueMailtype &$myObject, SQLLimit &$myLimit = null){
		return self::getMailqueueListByMailtypename($myObject->getMailtypename(), $myLimit);
	}

	/**
	 * @param Mailqueue &$myMailqueue
	 * @return MailqueueMailtype
	 */
	public static final function getMailtypeByMailqueue(Mailqueue &$myObject){
		Library::requireLibrary(LibraryKeys::APPLICATION_MAILQUEUE_MAILTYPE());
		return MailqueueMailtypeManager::getMailqueueMailtypeByMailqueue($myObject);
	}

	/**
	 * @param User &$myObject
	 * @return MailqueueList
	 */
	public static final function getMailqueueListByUser(User &$myObject, SQLLimit &$myLimit = null){
		return self::getMailqueueListByUserid($myObject->getUserid(), $myLimit);
	}

	/**
	 * @param Mailqueue &$myMailqueue
	 * @return User
	 */
	public static final function getUserByMailqueue(Mailqueue &$myObject){
		Library::requireLibrary(LibraryKeys::APPLICATION_USER());
		return UserManager::getUserByMailqueue($myObject);
	}

	/**
	 * @param MailqueueRecipient &$myObject
	 * @return Mailqueue
	 */
	public static final function getMailqueueByRecipient(MailqueueRecipient &$myObject){
		return self::getMailqueueByMailqueueid($myObject->getMailqueueid());  // blah
	}

	/**
	 * @param Mailqueue &$myMailqueue
	 * @return MailqueueRecipientList
	 */
	public static final function getRecipientListByMailqueue(Mailqueue &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_MAILQUEUE_RECIPIENT());
		return MailqueueRecipientManager::getMailqueueRecipientListByMailqueue($myObject, $myLimit);
	}

}
