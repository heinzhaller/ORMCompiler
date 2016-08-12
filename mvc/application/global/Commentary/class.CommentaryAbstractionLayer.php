<?php
#ä
/**
 * Commentary AbstractionLayer [AL]
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class CommentaryAbstractionLayer { 

	/**
	 * @return CommentaryList
	 */
	protected static final function getCommentaryListBySql($where,array $params = null,SQLLimit $limit = null){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('Commentary'));
		return CommentaryDAO::getCommentaryListByQuery($where,$params,$limit);
	}

	/**
	 * @param Commentary &$myObject
	 */
	public static final function saveOnly(Commentary &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('Commentary'));
		if( count($myObject->_getModified()) == 0 )
			return false; // return if no changes was made
		CommentaryDAO::store($myObject);
	}

	/**
	 * @param Commentary &$myObject
	 */
	public static function save(Commentary &$myObject){
		self::saveOnly($myObject);

		// save Game
		GameManager::saveOnly($myObject->getGame());
		$myObject->setGameid($myObject->getGame()->getGameid());
	}

	/**
	 * @param Commentary &$myObject
	 */
	public static function delete(Commentary &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('Commentary'));
		if($myObject->_getIsNew())
			return false; // return if object is new
		$myObject->_setIsDeleted(true);
		CommentaryDAO::store($myObject);
	}

}
