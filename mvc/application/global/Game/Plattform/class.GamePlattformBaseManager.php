<?php
#ä
/**
 * GamePlattform Base-Manager
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class GamePlattformBaseManager extends GamePlattformAbstractionLayer { 

	/**************************** ATTRIBUTES ****************************/
	const GAMEID = 'gameid';
	const PLATTFORMID = 'plattformid';

	/**************************** SELECT METHODS ****************************/
	/**
	 * @param SQLLimit &$myLimit
	 * @return GamePlattformList
	 */
	public static final function getGamePlattformList(SQLLimit &$myLimit = null){
		return parent::getGamePlattformListBySql('1 = 1', null, $myLimit);
	}

	/**
	 * @param integer $gameid
	 * @param SQLLimit &$myLimit
	 * @return GamePlattformList
	 */
	public static final function getGamePlattformListByGameid($gameid, SQLLimit &$myLimit = null){
		return parent::getGamePlattformListBySql(self::GAMEID.' = ?', array($gameid), $myLimit);
	}

	/**
	 * @param integer $plattformid
	 * @param SQLLimit &$myLimit
	 * @return GamePlattformList
	 */
	public static final function getGamePlattformListByPlattformid($plattformid, SQLLimit &$myLimit = null){
		return parent::getGamePlattformListBySql(self::PLATTFORMID.' = ?', array($plattformid), $myLimit);
	}

	/**************************** REFERENCES ****************************/
	/**
	 * @param Plattform &$myObject
	 * @return GamePlattformList
	 */
	public static final function getGamePlattformListByPlattform(Plattform &$myObject, SQLLimit &$myLimit = null){
		return self::getGamePlattformListByPlattformid($myObject->getPlattformid(), $myLimit);
	}

	/**
	 * @param GamePlattform &$myGamePlattform
	 * @return PlattformList
	 */
	public static final function getPlattformListByGamePlattform(GamePlattform &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_PLATTFORM());
		return PlattformManager::getPlattformListBytbl_game($myObject, $myLimit);
	}

	/**
	 * @param Game &$myObject
	 * @return GamePlattformList
	 */
	public static final function getGamePlattformListByGame(Game &$myObject, SQLLimit &$myLimit = null){
		return self::getGamePlattformListByGameid($myObject->getGameid(), $myLimit);
	}

	/**
	 * @param GamePlattform &$myGamePlattform
	 * @return GameList
	 */
	public static final function getGameListByGamePlattform(GamePlattform &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_GAME());
		return GameManager::getGameListBytbl_plattform($myObject, $myLimit);
	}

}
