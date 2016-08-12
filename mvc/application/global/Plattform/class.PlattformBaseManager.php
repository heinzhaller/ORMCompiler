<?php
#ä
/**
 * Plattform Base-Manager
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class PlattformBaseManager extends PlattformAbstractionLayer { 

	/**************************** ATTRIBUTES ****************************/
	const PLATTFORMID = 'plattformid';
	const NAME = 'name';
	const SORTORDER = 'sortorder';

	/**************************** SELECT METHODS ****************************/
	/**
	 * @param SQLLimit &$myLimit
	 * @return PlattformList
	 */
	public static final function getPlattformList(SQLLimit &$myLimit = null){
		return parent::getPlattformListBySql('1 = 1', null, $myLimit);
	}

	/**
	 * @param integer $plattformid
	 * @param SQLLimit &$myLimit
	 * @return Plattform or null
	 */
	public static final function getPlattformByPlattformid($plattformid, SQLLimit &$myLimit = null){
		$myObject = parent::getPlattformListBySql(self::PLATTFORMID.' = ?', array($plattformid), $myLimit);
		return ( $myObject->valid() ? $myObject->current() : null );
	}

	/**
	 * @param string $name
	 * @param SQLLimit &$myLimit
	 * @return PlattformList
	 */
	public static final function getPlattformListByName($name, SQLLimit &$myLimit = null){
		return parent::getPlattformListBySql(self::NAME.' = ?', array($name), $myLimit);
	}

	/**
	 * @param integer $sortorder
	 * @param SQLLimit &$myLimit
	 * @return PlattformList
	 */
	public static final function getPlattformListBySortorder($sortorder, SQLLimit &$myLimit = null){
		return parent::getPlattformListBySql(self::SORTORDER.' = ?', array($sortorder), $myLimit);
	}

	/**************************** REFERENCES ****************************/
	/**
	 * @param Game &$myObject
	 * @return PlattformList
	 */
	public static final function getPlattformListByGame(Game &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_GAME_PLATTFORM());
		$myList = GamePlattformManager::getGamePlattformListByGame($myObject, $myLimit);
		$myPlattformList = new PlattformList();
		foreach($myList as $item)
			$myPlattformList->add(self::getPlattformByPlattformid($item->getPlattformid()));
		return $myPlattformList;
	}

	/**
	 * @param Plattform &$myPlattform
	 * @return GameList
	 */
	public static final function getGameListByPlattform(Plattform &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_GAME());
		return GameManager::getGameListByPlattform($myObject, $myLimit);
	}

}
