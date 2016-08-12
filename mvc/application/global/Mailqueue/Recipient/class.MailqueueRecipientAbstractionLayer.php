<?php
#ä
/**
 * MailqueueRecipient AbstractionLayer [AL]
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class MailqueueRecipientAbstractionLayer { 

	/**
	 * @return MailqueueRecipientList
	 */
	protected static final function getMailqueueRecipientListBySql($where,array $params = null,SQLLimit $limit = null){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('MailqueueRecipient'));
		return MailqueueRecipientDAO::getMailqueueRecipientListByQuery($where,$params,$limit);
	}

	/**
	 * @param MailqueueRecipient &$myObject
	 */
	public static final function saveOnly(MailqueueRecipient &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('MailqueueRecipient'));
		if( count($myObject->_getModified()) == 0 )
			return false; // return if no changes was made
		MailqueueRecipientDAO::store($myObject);
	}

	/**
	 * @param MailqueueRecipient &$myObject
	 */
	public static function save(MailqueueRecipient &$myObject){
		self::saveOnly($myObject);

		// save Mailqueue
		MailqueueManager::saveOnly($myObject->getMailqueue());
		$myObject->setMailqueueid($myObject->getMailqueue()->getMailqueueid());

		// save MailqueueRecipienttype
		MailqueueRecipienttypeManager::saveOnly($myObject->getRecipienttype());
		$myObject->setTypename($myObject->getRecipienttype()->getTypename());
	}

	/**
	 * @param MailqueueRecipient &$myObject
	 */
	public static function delete(MailqueueRecipient &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('MailqueueRecipient'));
		if($myObject->_getIsNew())
			return false; // return if object is new
		$myObject->_setIsDeleted(true);
		MailqueueRecipientDAO::store($myObject);
	}

}
