<?php
#ä
/**
 * GamePlattform AbstractionLayer [AL]
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class GamePlattformAbstractionLayer { 

	/**
	 * @return GamePlattformList
	 */
	protected static final function getGamePlattformListBySql($where,array $params = null,SQLLimit $limit = null){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('GamePlattform'));
		return GamePlattformDAO::getGamePlattformListByQuery($where,$params,$limit);
	}

	/**
	 * @param GamePlattform &$myObject
	 */
	public static final function saveOnly(GamePlattform &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('GamePlattform'));
		if( count($myObject->_getModified()) == 0 )
			return false; // return if no changes was made
		GamePlattformDAO::store($myObject);
	}

	/**
	 * @param GamePlattform &$myObject
	 */
	public static function save(GamePlattform &$myObject){
		self::saveOnly($myObject);
	}

	/**
	 * @param GamePlattform &$myObject
	 */
	public static function delete(GamePlattform &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('GamePlattform'));
		if($myObject->_getIsNew())
			return false; // return if object is new
		$myObject->_setIsDeleted(true);
		GamePlattformDAO::store($myObject);
	}

}
