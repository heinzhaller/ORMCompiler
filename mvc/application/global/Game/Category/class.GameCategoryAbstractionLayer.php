<?php
#ä
/**
 * GameCategory AbstractionLayer [AL]
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class GameCategoryAbstractionLayer { 

	/**
	 * @return GameCategoryList
	 */
	protected static final function getGameCategoryListBySql($where,array $params = null,SQLLimit $limit = null){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('GameCategory'));
		return GameCategoryDAO::getGameCategoryListByQuery($where,$params,$limit);
	}

	/**
	 * @param GameCategory &$myObject
	 */
	public static final function saveOnly(GameCategory &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('GameCategory'));
		if( count($myObject->_getModified()) == 0 )
			return false; // return if no changes was made
		GameCategoryDAO::store($myObject);
	}

	/**
	 * @param GameCategory &$myObject
	 */
	public static function save(GameCategory &$myObject){
		self::saveOnly($myObject);
	}

	/**
	 * @param GameCategory &$myObject
	 */
	public static function delete(GameCategory &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('GameCategory'));
		if($myObject->_getIsNew())
			return false; // return if object is new
		$myObject->_setIsDeleted(true);
		GameCategoryDAO::store($myObject);
	}

}
