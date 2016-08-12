<?php
#ä
/**
 * GameIn Base-Manager
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class GameInBaseManager extends GameInAbstractionLayer { 

	/**************************** ATTRIBUTES ****************************/
	const GAMEINID = 'gameinid';
	const GAMEID = 'gameid';
	const IP = 'ip';
	const TSTAMP_CREATED = 'tstamp_created';

	/**************************** SELECT METHODS ****************************/
	/**
	 * @param SQLLimit &$myLimit
	 * @return GameInList
	 */
	public static final function getGameInList(SQLLimit &$myLimit = null){
		return parent::getGameInListBySql('1 = 1', null, $myLimit);
	}

	/**
	 * @param integer $gameinid
	 * @param SQLLimit &$myLimit
	 * @return GameIn or null
	 */
	public static final function getGameInByGameinid($gameinid, SQLLimit &$myLimit = null){
		$myObject = parent::getGameInListBySql(self::GAMEINID.' = ?', array($gameinid), $myLimit);
		return ( $myObject->valid() ? $myObject->current() : null );
	}

	/**
	 * @param integer $gameid
	 * @param SQLLimit &$myLimit
	 * @return GameIn or null
	 */
	public static final function getGameInByGameid($gameid, SQLLimit &$myLimit = null){
		$myObject = parent::getGameInListBySql(self::GAMEID.' = ?', array($gameid), $myLimit);
		return ( $myObject->valid() ? $myObject->current() : null );
	}

	/**
	 * @param string $ip
	 * @param SQLLimit &$myLimit
	 * @return GameIn or null
	 */
	public static final function getGameInByIp($ip, SQLLimit &$myLimit = null){
		$myObject = parent::getGameInListBySql(self::IP.' = ?', array($ip), $myLimit);
		return ( $myObject->valid() ? $myObject->current() : null );
	}

	/**
	 * @param integer $tstamp_created
	 * @param SQLLimit &$myLimit
	 * @return GameInList
	 */
	public static final function getGameInListByTstampCreated($tstamp_created, SQLLimit &$myLimit = null){
		return parent::getGameInListBySql(self::TSTAMP_CREATED.' = ?', array($tstamp_created), $myLimit);
	}

	/**************************** REFERENCES ****************************/
	/**
	 * @param Game &$myObject
	 * @return GameInList
	 */
	public static final function getGameInListByGame(Game &$myObject, SQLLimit &$myLimit = null){
		return self::getGameInListByGameid($myObject->getGameid(), $myLimit);
	}

	/**
	 * @param GameIn &$myGameIn
	 * @return Game
	 */
	public static final function getGameByGameIn(GameIn &$myObject){
		Library::requireLibrary(LibraryKeys::APPLICATION_GAME());
		return GameManager::getGameByIn($myObject);
	}

}
