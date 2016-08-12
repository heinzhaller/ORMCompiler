<?php
#ä
/**
 * GameIn AbstractionLayer [AL]
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class GameInAbstractionLayer { 

	/**
	 * @return GameInList
	 */
	protected static final function getGameInListBySql($where,array $params = null,SQLLimit $limit = null){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('GameIn'));
		return GameInDAO::getGameInListByQuery($where,$params,$limit);
	}

	/**
	 * @param GameIn &$myObject
	 */
	public static final function saveOnly(GameIn &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('GameIn'));
		if( count($myObject->_getModified()) == 0 )
			return false; // return if no changes was made
		GameInDAO::store($myObject);
	}

	/**
	 * @param GameIn &$myObject
	 */
	public static function save(GameIn &$myObject){
		self::saveOnly($myObject);

		// save Game
		GameManager::saveOnly($myObject->getGame());
		$myObject->setGameid($myObject->getGame()->getGameid());
	}

	/**
	 * @param GameIn &$myObject
	 */
	public static function delete(GameIn &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('GameIn'));
		if($myObject->_getIsNew())
			return false; // return if object is new
		$myObject->_setIsDeleted(true);
		GameInDAO::store($myObject);
	}

}
