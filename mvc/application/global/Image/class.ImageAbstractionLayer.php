<?php
#ä
/**
 * Image AbstractionLayer [AL]
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class ImageAbstractionLayer { 

	/**
	 * @return ImageList
	 */
	protected static final function getImageListBySql($where,array $params = null,SQLLimit $limit = null){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('Image'));
		return ImageDAO::getImageListByQuery($where,$params,$limit);
	}

	/**
	 * @param Image &$myObject
	 */
	public static final function saveOnly(Image &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('Image'));
		if( count($myObject->_getModified()) == 0 )
			return false; // return if no changes was made
		ImageDAO::store($myObject);
	}

	/**
	 * @param Image &$myObject
	 */
	public static function save(Image &$myObject){
		self::saveOnly($myObject);

		// save Game
		GameManager::saveOnly($myObject->getGame());
		$myObject->setGameid($myObject->getGame()->getGameid());
	}

	/**
	 * @param Image &$myObject
	 */
	public static function delete(Image &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('Image'));
		if($myObject->_getIsNew())
			return false; // return if object is new
		$myObject->_setIsDeleted(true);
		ImageDAO::store($myObject);
	}

}
