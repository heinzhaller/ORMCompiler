<?php
#ä
/**
 * Category AbstractionLayer [AL]
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class CategoryAbstractionLayer { 

	/**
	 * @return CategoryList
	 */
	protected static final function getCategoryListBySql($where,array $params = null,SQLLimit $limit = null){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('Category'));
		return CategoryDAO::getCategoryListByQuery($where,$params,$limit);
	}

	/**
	 * @param Category &$myObject
	 */
	public static final function saveOnly(Category &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('Category'));
		if( count($myObject->_getModified()) == 0 )
			return false; // return if no changes was made
		CategoryDAO::store($myObject);
	}

	/**
	 * @param Category &$myObject
	 */
	public static function save(Category &$myObject){
		self::saveOnly($myObject);

		// save Category
		self::saveOnly($myObject->getCategory());
		$myObject->setParentCategoryid($myObject->getCategory()->getCategoryid());

		// save Game
		foreach($myObject->getGameList() as $mySub){
			$m2m_GameCategory = new GameCategory();
			$m2m_GameCategory->setCategoryid($myObject->getCategoryid());
			$m2m_GameCategory->setGameid($mySub->getGameid());
			GameCategoryManager::saveOnly($m2m_GameCategory);
		}
	}

	/**
	 * @param Category &$myObject
	 */
	public static function delete(Category &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('Category'));
		if($myObject->_getIsNew())
			return false; // return if object is new
		$myObject->_setIsDeleted(true);
		CategoryDAO::store($myObject);
	}

}
