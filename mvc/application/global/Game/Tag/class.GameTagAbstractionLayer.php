<?php
#ä
/**
 * GameTag AbstractionLayer [AL]
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class GameTagAbstractionLayer { 

	/**
	 * @return GameTagList
	 */
	protected static final function getGameTagListBySql($where,array $params = null,SQLLimit $limit = null){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('GameTag'));
		return GameTagDAO::getGameTagListByQuery($where,$params,$limit);
	}

	/**
	 * @param GameTag &$myObject
	 */
	public static final function saveOnly(GameTag &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('GameTag'));
		if( count($myObject->_getModified()) == 0 )
			return false; // return if no changes was made
		GameTagDAO::store($myObject);
	}

	/**
	 * @param GameTag &$myObject
	 */
	public static function save(GameTag &$myObject){
		self::saveOnly($myObject);
	}

	/**
	 * @param GameTag &$myObject
	 */
	public static function delete(GameTag &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('GameTag'));
		if($myObject->_getIsNew())
			return false; // return if object is new
		$myObject->_setIsDeleted(true);
		GameTagDAO::store($myObject);
	}

}
