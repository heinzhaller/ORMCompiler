<?php
#ä
/**
 * MailqueueMailtype AbstractionLayer [AL]
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class MailqueueMailtypeAbstractionLayer { 

	/**
	 * @return MailqueueMailtypeList
	 */
	protected static final function getMailqueueMailtypeListBySql($where,array $params = null,SQLLimit $limit = null){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('MailqueueMailtype'));
		return MailqueueMailtypeDAO::getMailqueueMailtypeListByQuery($where,$params,$limit);
	}

	/**
	 * @param MailqueueMailtype &$myObject
	 */
	public static final function saveOnly(MailqueueMailtype &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('MailqueueMailtype'));
		if( count($myObject->_getModified()) == 0 )
			return false; // return if no changes was made
		MailqueueMailtypeDAO::store($myObject);
	}

	/**
	 * @param MailqueueMailtype &$myObject
	 */
	public static function save(MailqueueMailtype &$myObject){
		self::saveOnly($myObject);

		// save Mailqueue
		foreach($myObject->getMailqueueList() as $sub){
			$sub->setMailtypename($myObject->getMailtypename());
			MailqueueManager::saveOnly($sub);
		}
	}

	/**
	 * @param MailqueueMailtype &$myObject
	 */
	public static function delete(MailqueueMailtype &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('MailqueueMailtype'));
		if($myObject->_getIsNew())
			return false; // return if object is new
		$myObject->_setIsDeleted(true);
		MailqueueMailtypeDAO::store($myObject);
	}

}
