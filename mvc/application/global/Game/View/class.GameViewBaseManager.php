<?php
#ä
/**
 * GameView Base-Manager
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class GameViewBaseManager extends GameViewAbstractionLayer { 

	/**************************** ATTRIBUTES ****************************/
	const GAMEVIEWID = 'gameviewid';
	const GAMEID = 'gameid';
	const IP = 'ip';
	const TSTAMP_CREATED = 'tstamp_created';

	/**************************** SELECT METHODS ****************************/
	/**
	 * @param SQLLimit &$myLimit
	 * @return GameViewList
	 */
	public static final function getGameViewList(SQLLimit &$myLimit = null){
		return parent::getGameViewListBySql('1 = 1', null, $myLimit);
	}

	/**
	 * @param integer $gameviewid
	 * @param SQLLimit &$myLimit
	 * @return GameView or null
	 */
	public static final function getGameViewByGameviewid($gameviewid, SQLLimit &$myLimit = null){
		$myObject = parent::getGameViewListBySql(self::GAMEVIEWID.' = ?', array($gameviewid), $myLimit);
		return ( $myObject->valid() ? $myObject->current() : null );
	}

	/**
	 * @param integer $gameid
	 * @param SQLLimit &$myLimit
	 * @return GameView or null
	 */
	public static final function getGameViewByGameid($gameid, SQLLimit &$myLimit = null){
		$myObject = parent::getGameViewListBySql(self::GAMEID.' = ?', array($gameid), $myLimit);
		return ( $myObject->valid() ? $myObject->current() : null );
	}

	/**
	 * @param string $ip
	 * @param SQLLimit &$myLimit
	 * @return GameView or null
	 */
	public static final function getGameViewByIp($ip, SQLLimit &$myLimit = null){
		$myObject = parent::getGameViewListBySql(self::IP.' = ?', array($ip), $myLimit);
		return ( $myObject->valid() ? $myObject->current() : null );
	}

	/**
	 * @param integer $tstamp_created
	 * @param SQLLimit &$myLimit
	 * @return GameViewList
	 */
	public static final function getGameViewListByTstampCreated($tstamp_created, SQLLimit &$myLimit = null){
		return parent::getGameViewListBySql(self::TSTAMP_CREATED.' = ?', array($tstamp_created), $myLimit);
	}

	/**************************** REFERENCES ****************************/
	/**
	 * @param Game &$myObject
	 * @return GameView
	 */
	public static final function getGameViewByGame(Game &$myObject){
		return self::getGameViewByGameid($myObject->getGameid());  // blah
	}

	/**
	 * @param GameView &$myGameView
	 * @return Game
	 */
	public static final function getGameByGameView(GameView &$myObject){
		Library::requireLibrary(LibraryKeys::APPLICATION_GAME());
		return GameManager::getGameByView($myObject);
	}

}
