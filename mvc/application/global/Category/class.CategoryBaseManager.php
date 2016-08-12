<?php
#ä
/**
 * Category Base-Manager
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class CategoryBaseManager extends CategoryAbstractionLayer { 

	/**************************** ATTRIBUTES ****************************/
	const CATEGORYID = 'categoryid';
	const PARENT_CATEGORYID = 'parent_categoryid';
	const NAME = 'name';
	const DESCRIPTION = 'description';
	const SORTORDER = 'sortorder';
	const ICON = 'icon';

	/**************************** SELECT METHODS ****************************/
	/**
	 * @param SQLLimit &$myLimit
	 * @return CategoryList
	 */
	public static final function getCategoryList(SQLLimit &$myLimit = null){
		return parent::getCategoryListBySql('1 = 1', null, $myLimit);
	}

	/**
	 * @param integer $categoryid
	 * @param SQLLimit &$myLimit
	 * @return Category or null
	 */
	public static final function getCategoryByCategoryid($categoryid, SQLLimit &$myLimit = null){
		$myObject = parent::getCategoryListBySql(self::CATEGORYID.' = ?', array($categoryid), $myLimit);
		return ( $myObject->valid() ? $myObject->current() : null );
	}

	/**
	 * @param integer $parent_categoryid
	 * @param SQLLimit &$myLimit
	 * @return CategoryList
	 */
	public static final function getCategoryListByParentCategoryid($parent_categoryid, SQLLimit &$myLimit = null){
		return parent::getCategoryListBySql(self::PARENT_CATEGORYID.' = ?', array($parent_categoryid), $myLimit);
	}

	/**
	 * @param string $name
	 * @param SQLLimit &$myLimit
	 * @return CategoryList
	 */
	public static final function getCategoryListByName($name, SQLLimit &$myLimit = null){
		return parent::getCategoryListBySql(self::NAME.' = ?', array($name), $myLimit);
	}

	/**
	 * @param string $description
	 * @param SQLLimit &$myLimit
	 * @return CategoryList
	 */
	public static final function getCategoryListByDescription($description, SQLLimit &$myLimit = null){
		return parent::getCategoryListBySql(self::DESCRIPTION.' = ?', array($description), $myLimit);
	}

	/**
	 * @param integer $sortorder
	 * @param SQLLimit &$myLimit
	 * @return CategoryList
	 */
	public static final function getCategoryListBySortorder($sortorder, SQLLimit &$myLimit = null){
		return parent::getCategoryListBySql(self::SORTORDER.' = ?', array($sortorder), $myLimit);
	}

	/**
	 * @param string $icon
	 * @param SQLLimit &$myLimit
	 * @return CategoryList
	 */
	public static final function getCategoryListByIcon($icon, SQLLimit &$myLimit = null){
		return parent::getCategoryListBySql(self::ICON.' = ?', array($icon), $myLimit);
	}

	/**************************** REFERENCES ****************************/
	/**
	 * @param Category &$myObject
	 * @return Category
	 */
	public static final function getCategoryByCategory(Category &$myObject){
		return self::getCategoryByCategoryid($myObject->getCategoryid()); // blub
	}

	/**
	 * @param Game &$myObject
	 * @return CategoryList
	 */
	public static final function getCategoryListByGame(Game &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_GAME_CATEGORY());
		$myList = GameCategoryManager::getGameCategoryListByGame($myObject, $myLimit);
		$myCategoryList = new CategoryList();
		foreach($myList as $item)
			$myCategoryList->add(self::getCategoryByCategoryid($item->getCategoryid()));
		return $myCategoryList;
	}

	/**
	 * @param Category &$myCategory
	 * @return GameList
	 */
	public static final function getGameListByCategory(Category &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_GAME());
		return GameManager::getGameListByCategory($myObject, $myLimit);
	}

}
