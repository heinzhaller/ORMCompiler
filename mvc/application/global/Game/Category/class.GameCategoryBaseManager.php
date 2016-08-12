<?php
#ä
/**
 * GameCategory Base-Manager
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class GameCategoryBaseManager extends GameCategoryAbstractionLayer { 

	/**************************** ATTRIBUTES ****************************/
	const GAMEID = 'gameid';
	const CATEGORYID = 'categoryid';

	/**************************** SELECT METHODS ****************************/
	/**
	 * @param SQLLimit &$myLimit
	 * @return GameCategoryList
	 */
	public static final function getGameCategoryList(SQLLimit &$myLimit = null){
		return parent::getGameCategoryListBySql('1 = 1', null, $myLimit);
	}

	/**
	 * @param integer $gameid
	 * @param SQLLimit &$myLimit
	 * @return GameCategoryList
	 */
	public static final function getGameCategoryListByGameid($gameid, SQLLimit &$myLimit = null){
		return parent::getGameCategoryListBySql(self::GAMEID.' = ?', array($gameid), $myLimit);
	}

	/**
	 * @param integer $categoryid
	 * @param SQLLimit &$myLimit
	 * @return GameCategoryList
	 */
	public static final function getGameCategoryListByCategoryid($categoryid, SQLLimit &$myLimit = null){
		return parent::getGameCategoryListBySql(self::CATEGORYID.' = ?', array($categoryid), $myLimit);
	}

	/**************************** REFERENCES ****************************/
	/**
	 * @param Game &$myObject
	 * @return GameCategoryList
	 */
	public static final function getGameCategoryListByGame(Game &$myObject, SQLLimit &$myLimit = null){
		return self::getGameCategoryListByGameid($myObject->getGameid(), $myLimit);
	}

	/**
	 * @param GameCategory &$myGameCategory
	 * @return GameList
	 */
	public static final function getGameListByGameCategory(GameCategory &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_GAME());
		return GameManager::getGameListBytbl_category($myObject, $myLimit);
	}

	/**
	 * @param Category &$myObject
	 * @return GameCategoryList
	 */
	public static final function getGameCategoryListByCategory(Category &$myObject, SQLLimit &$myLimit = null){
		return self::getGameCategoryListByCategoryid($myObject->getCategoryid(), $myLimit);
	}

	/**
	 * @param GameCategory &$myGameCategory
	 * @return CategoryList
	 */
	public static final function getCategoryListByGameCategory(GameCategory &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_CATEGORY());
		return CategoryManager::getCategoryListBytbl_game($myObject, $myLimit);
	}

}
