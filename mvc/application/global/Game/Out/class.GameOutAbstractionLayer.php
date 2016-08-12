<?php
#ä
/**
 * GameOut AbstractionLayer [AL]
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class GameOutAbstractionLayer { 

	/**
	 * @return GameOutList
	 */
	protected static final function getGameOutListBySql($where,array $params = null,SQLLimit $limit = null){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('GameOut'));
		return GameOutDAO::getGameOutListByQuery($where,$params,$limit);
	}

	/**
	 * @param GameOut &$myObject
	 */
	public static final function saveOnly(GameOut &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('GameOut'));
		if( count($myObject->_getModified()) == 0 )
			return false; // return if no changes was made
		GameOutDAO::store($myObject);
	}

	/**
	 * @param GameOut &$myObject
	 */
	public static function save(GameOut &$myObject){
		self::saveOnly($myObject);

		// save Game
		GameManager::saveOnly($myObject->getGame());
		$myObject->setGameid($myObject->getGame()->getGameid());
	}

	/**
	 * @param GameOut &$myObject
	 */
	public static function delete(GameOut &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('GameOut'));
		if($myObject->_getIsNew())
			return false; // return if object is new
		$myObject->_setIsDeleted(true);
		GameOutDAO::store($myObject);
	}

}
