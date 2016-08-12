<?php
#ä
/**
 * Video AbstractionLayer [AL]
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class VideoAbstractionLayer { 

	/**
	 * @return VideoList
	 */
	protected static final function getVideoListBySql($where,array $params = null,SQLLimit $limit = null){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('Video'));
		return VideoDAO::getVideoListByQuery($where,$params,$limit);
	}

	/**
	 * @param Video &$myObject
	 */
	public static final function saveOnly(Video &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('Video'));
		if( count($myObject->_getModified()) == 0 )
			return false; // return if no changes was made
		VideoDAO::store($myObject);
	}

	/**
	 * @param Video &$myObject
	 */
	public static function save(Video &$myObject){
		self::saveOnly($myObject);

		// save Game
		GameManager::saveOnly($myObject->getGame());
		$myObject->setGameid($myObject->getGame()->getGameid());
	}

	/**
	 * @param Video &$myObject
	 */
	public static function delete(Video &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('Video'));
		if($myObject->_getIsNew())
			return false; // return if object is new
		$myObject->_setIsDeleted(true);
		VideoDAO::store($myObject);
	}

}
