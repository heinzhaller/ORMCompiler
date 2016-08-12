<?php
#ä
/**
 * GameHistory Base-Manager
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class GameHistoryBaseManager extends GameHistoryAbstractionLayer { 

	/**************************** ATTRIBUTES ****************************/
	const GAMEHISTORYID = 'gamehistoryid';
	const GAMEID = 'gameid';
	const USERID = 'userid';
	const INFOTEXT = 'infotext';
	const TSTAMP_CREATED = 'tstamp_created';

	/**************************** SELECT METHODS ****************************/
	/**
	 * @param SQLLimit &$myLimit
	 * @return GameHistoryList
	 */
	public static final function getGameHistoryList(SQLLimit &$myLimit = null){
		return parent::getGameHistoryListBySql('1 = 1', null, $myLimit);
	}

	/**
	 * @param integer $gamehistoryid
	 * @param SQLLimit &$myLimit
	 * @return GameHistory or null
	 */
	public static final function getGameHistoryByGamehistoryid($gamehistoryid, SQLLimit &$myLimit = null){
		$myObject = parent::getGameHistoryListBySql(self::GAMEHISTORYID.' = ?', array($gamehistoryid), $myLimit);
		return ( $myObject->valid() ? $myObject->current() : null );
	}

	/**
	 * @param integer $gameid
	 * @param SQLLimit &$myLimit
	 * @return GameHistoryList
	 */
	public static final function getGameHistoryListByGameid($gameid, SQLLimit &$myLimit = null){
		return parent::getGameHistoryListBySql(self::GAMEID.' = ?', array($gameid), $myLimit);
	}

	/**
	 * @param integer $userid
	 * @param SQLLimit &$myLimit
	 * @return GameHistoryList
	 */
	public static final function getGameHistoryListByUserid($userid, SQLLimit &$myLimit = null){
		return parent::getGameHistoryListBySql(self::USERID.' = ?', array($userid), $myLimit);
	}

	/**
	 * @param string $infotext
	 * @param SQLLimit &$myLimit
	 * @return GameHistoryList
	 */
	public static final function getGameHistoryListByInfotext($infotext, SQLLimit &$myLimit = null){
		return parent::getGameHistoryListBySql(self::INFOTEXT.' = ?', array($infotext), $myLimit);
	}

	/**
	 * @param integer $tstamp_created
	 * @param SQLLimit &$myLimit
	 * @return GameHistoryList
	 */
	public static final function getGameHistoryListByTstampCreated($tstamp_created, SQLLimit &$myLimit = null){
		return parent::getGameHistoryListBySql(self::TSTAMP_CREATED.' = ?', array($tstamp_created), $myLimit);
	}

	/**************************** REFERENCES ****************************/
	/**
	 * @param Game &$myObject
	 * @return GameHistoryList
	 */
	public static final function getGameHistoryListByGame(Game &$myObject, SQLLimit &$myLimit = null){
		return self::getGameHistoryListByGameid($myObject->getGameid(), $myLimit);
	}

	/**
	 * @param GameHistory &$myGameHistory
	 * @return Game
	 */
	public static final function getGameByGameHistory(GameHistory &$myObject){
		Library::requireLibrary(LibraryKeys::APPLICATION_GAME());
		return GameManager::getGameByHistory($myObject);
	}

	/**
	 * @param User &$myObject
	 * @return GameHistoryList
	 */
	public static final function getGameHistoryListByUser(User &$myObject, SQLLimit &$myLimit = null){
		return self::getGameHistoryListByUserid($myObject->getUserid(), $myLimit);
	}

	/**
	 * @param GameHistory &$myGameHistory
	 * @return User
	 */
	public static final function getUserByGameHistory(GameHistory &$myObject){
		Library::requireLibrary(LibraryKeys::APPLICATION_USER());
		return UserManager::getUserByHistory($myObject);
	}

}
