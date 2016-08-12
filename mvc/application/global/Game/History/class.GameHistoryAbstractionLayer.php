<?php
#ä
/**
 * GameHistory AbstractionLayer [AL]
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class GameHistoryAbstractionLayer { 

	/**
	 * @return GameHistoryList
	 */
	protected static final function getGameHistoryListBySql($where,array $params = null,SQLLimit $limit = null){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('GameHistory'));
		return GameHistoryDAO::getGameHistoryListByQuery($where,$params,$limit);
	}

	/**
	 * @param GameHistory &$myObject
	 */
	public static final function saveOnly(GameHistory &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('GameHistory'));
		if( count($myObject->_getModified()) == 0 )
			return false; // return if no changes was made
		GameHistoryDAO::store($myObject);
	}

	/**
	 * @param GameHistory &$myObject
	 */
	public static function save(GameHistory &$myObject){
		self::saveOnly($myObject);

		// save Game
		GameManager::saveOnly($myObject->getGame());
		$myObject->setGameid($myObject->getGame()->getGameid());

		// save User
		UserManager::saveOnly($myObject->getUser());
		$myObject->setUserid($myObject->getUser()->getUserid());
	}

	/**
	 * @param GameHistory &$myObject
	 */
	public static function delete(GameHistory &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('GameHistory'));
		if($myObject->_getIsNew())
			return false; // return if object is new
		$myObject->_setIsDeleted(true);
		GameHistoryDAO::store($myObject);
	}

}
