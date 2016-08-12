<?php
#ä
/**
 * GameView AbstractionLayer [AL]
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class GameViewAbstractionLayer { 

	/**
	 * @return GameViewList
	 */
	protected static final function getGameViewListBySql($where,array $params = null,SQLLimit $limit = null){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('GameView'));
		return GameViewDAO::getGameViewListByQuery($where,$params,$limit);
	}

	/**
	 * @param GameView &$myObject
	 */
	public static final function saveOnly(GameView &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('GameView'));
		if( count($myObject->_getModified()) == 0 )
			return false; // return if no changes was made
		GameViewDAO::store($myObject);
	}

	/**
	 * @param GameView &$myObject
	 */
	public static function save(GameView &$myObject){
		self::saveOnly($myObject);

		// save Game
		GameManager::saveOnly($myObject->getGame());
		$myObject->setGameid($myObject->getGame()->getGameid());
	}

	/**
	 * @param GameView &$myObject
	 */
	public static function delete(GameView &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('GameView'));
		if($myObject->_getIsNew())
			return false; // return if object is new
		$myObject->_setIsDeleted(true);
		GameViewDAO::store($myObject);
	}

}
