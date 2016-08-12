<?php
#ä
/**
 * GameRating AbstractionLayer [AL]
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class GameRatingAbstractionLayer { 

	/**
	 * @return GameRatingList
	 */
	protected static final function getGameRatingListBySql($where,array $params = null,SQLLimit $limit = null){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('GameRating'));
		return GameRatingDAO::getGameRatingListByQuery($where,$params,$limit);
	}

	/**
	 * @param GameRating &$myObject
	 */
	public static final function saveOnly(GameRating &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('GameRating'));
		if( count($myObject->_getModified()) == 0 )
			return false; // return if no changes was made
		GameRatingDAO::store($myObject);
	}

	/**
	 * @param GameRating &$myObject
	 */
	public static function save(GameRating &$myObject){
		self::saveOnly($myObject);

		// save Game
		GameManager::saveOnly($myObject->getGame());
		$myObject->setGameid($myObject->getGame()->getGameid());
	}

	/**
	 * @param GameRating &$myObject
	 */
	public static function delete(GameRating &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('GameRating'));
		if($myObject->_getIsNew())
			return false; // return if object is new
		$myObject->_setIsDeleted(true);
		GameRatingDAO::store($myObject);
	}

}
