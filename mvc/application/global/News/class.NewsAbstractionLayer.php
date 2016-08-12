<?php
#ä
/**
 * News AbstractionLayer [AL]
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class NewsAbstractionLayer { 

	/**
	 * @return NewsList
	 */
	protected static final function getNewsListBySql($where,array $params = null,SQLLimit $limit = null){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('News'));
		return NewsDAO::getNewsListByQuery($where,$params,$limit);
	}

	/**
	 * @param News &$myObject
	 */
	public static final function saveOnly(News &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('News'));
		if( count($myObject->_getModified()) == 0 )
			return false; // return if no changes was made
		NewsDAO::store($myObject);
	}

	/**
	 * @param News &$myObject
	 */
	public static function save(News &$myObject){
		self::saveOnly($myObject);

		// save Game
		GameManager::saveOnly($myObject->getGame());
		$myObject->setGameid($myObject->getGame()->getGameid());

		// save User
		UserManager::saveOnly($myObject->getUser());
		$myObject->setUserid($myObject->getUser()->getUserid());
	}

	/**
	 * @param News &$myObject
	 */
	public static function delete(News &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('News'));
		if($myObject->_getIsNew())
			return false; // return if object is new
		$myObject->_setIsDeleted(true);
		NewsDAO::store($myObject);
	}

}
