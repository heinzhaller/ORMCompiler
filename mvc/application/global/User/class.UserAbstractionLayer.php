<?php
#ä
/**
 * User AbstractionLayer [AL]
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class UserAbstractionLayer { 

	/**
	 * @return UserList
	 */
	protected static final function getUserListBySql($where,array $params = null,SQLLimit $limit = null){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('User'));
		return UserDAO::getUserListByQuery($where,$params,$limit);
	}

	/**
	 * @param User &$myObject
	 */
	public static final function saveOnly(User &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('User'));
		if( count($myObject->_getModified()) == 0 )
			return false; // return if no changes was made
		UserDAO::store($myObject);
	}

	/**
	 * @param User &$myObject
	 */
	public static function save(User &$myObject){
		self::saveOnly($myObject);

		// save Game
		foreach($myObject->getGameList() as $sub){
			$sub->setUserid($myObject->getUserid());
			GameManager::saveOnly($sub);
		}

		// save GameHistory
		foreach($myObject->getHistoryList() as $sub){
			$sub->setUserid($myObject->getUserid());
			GameHistoryManager::saveOnly($sub);
		}

		// save Mailqueue
		foreach($myObject->getMailqueueList() as $sub){
			$sub->setUserid($myObject->getUserid());
			MailqueueManager::saveOnly($sub);
		}

		// save News
		foreach($myObject->getNewsList() as $sub){
			$sub->setUserid($myObject->getUserid());
			NewsManager::saveOnly($sub);
		}
	}

	/**
	 * @param User &$myObject
	 */
	public static function delete(User &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('User'));
		if($myObject->_getIsNew())
			return false; // return if object is new
		$myObject->_setIsDeleted(true);
		UserDAO::store($myObject);
	}

}
