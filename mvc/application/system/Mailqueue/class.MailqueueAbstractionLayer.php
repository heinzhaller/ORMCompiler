<?php
#ä
/**
 * Mailqueue AbstractionLayer [AL]
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class MailqueueAbstractionLayer { 

	/**
	 * @return MailqueueList
	 */
	protected static final function getMailqueueListBySql($where,array $params = null,SQLLimit $limit = null){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('Mailqueue'));
		return MailqueueDAO::getMailqueueListByQuery($where,$params,$limit);
	}

	/**
	 * @param Mailqueue &$myObject
	 */
	public static final function saveOnly(Mailqueue &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('Mailqueue'));
		if( count($myObject->_getModified()) == 0 )
			return false; // return if no changes was made
		MailqueueDAO::store($myObject);
	}

	/**
	 * @param Mailqueue &$myObject
	 */
	public static function save(Mailqueue &$myObject){
		self::saveOnly($myObject);

		// save MailqueueMailtype
		MailqueueMailtypeManager::saveOnly($myObject->getMailtype());
		$myObject->setMailtypename($myObject->getMailtype()->getMailtypename());

		// save MailqueueRecipient
		foreach($myObject->getRecipientList() as $sub){
			$sub->setMailqueueid($myObject->getMailqueueid());
			MailqueueRecipientManager::saveOnly($sub);
		}
	}

	/**
	 * @param Mailqueue &$myObject
	 */
	public static function delete(Mailqueue &$myObject){
		if($myObject->_getIsNew())
			return false; // return if object is new
		$$myObject->_setIsDeleted(true);
		MailqueueDAO::store($myObject);
	}

}
?>