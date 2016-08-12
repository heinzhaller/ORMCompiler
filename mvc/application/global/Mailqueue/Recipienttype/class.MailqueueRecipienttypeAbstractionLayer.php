<?php
#ä
/**
 * MailqueueRecipienttype AbstractionLayer [AL]
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class MailqueueRecipienttypeAbstractionLayer { 

	/**
	 * @return MailqueueRecipienttypeList
	 */
	protected static final function getMailqueueRecipienttypeListBySql($where,array $params = null,SQLLimit $limit = null){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('MailqueueRecipienttype'));
		return MailqueueRecipienttypeDAO::getMailqueueRecipienttypeListByQuery($where,$params,$limit);
	}

	/**
	 * @param MailqueueRecipienttype &$myObject
	 */
	public static final function saveOnly(MailqueueRecipienttype &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('MailqueueRecipienttype'));
		if( count($myObject->_getModified()) == 0 )
			return false; // return if no changes was made
		MailqueueRecipienttypeDAO::store($myObject);
	}

	/**
	 * @param MailqueueRecipienttype &$myObject
	 */
	public static function save(MailqueueRecipienttype &$myObject){
		self::saveOnly($myObject);

		// save MailqueueRecipient
		foreach($myObject->getRecipientList() as $sub){
			$sub->setTypename($myObject->getTypename());
			MailqueueRecipientManager::saveOnly($sub);
		}
	}

	/**
	 * @param MailqueueRecipienttype &$myObject
	 */
	public static function delete(MailqueueRecipienttype &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('MailqueueRecipienttype'));
		if($myObject->_getIsNew())
			return false; // return if object is new
		$myObject->_setIsDeleted(true);
		MailqueueRecipienttypeDAO::store($myObject);
	}

}
