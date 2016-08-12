<?php
#ä
/**
 * GameOut Base-Manager
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class GameOutBaseManager extends GameOutAbstractionLayer { 

	/**************************** ATTRIBUTES ****************************/
	const GAMEOUTID = 'gameoutid';
	const GAMEID = 'gameid';
	const IP = 'ip';
	const TSTAMP_CREATED = 'tstamp_created';

	/**************************** SELECT METHODS ****************************/
	/**
	 * @param SQLLimit &$myLimit
	 * @return GameOutList
	 */
	public static final function getGameOutList(SQLLimit &$myLimit = null){
		return parent::getGameOutListBySql('1 = 1', null, $myLimit);
	}

	/**
	 * @param integer $gameoutid
	 * @param SQLLimit &$myLimit
	 * @return GameOut or null
	 */
	public static final function getGameOutByGameoutid($gameoutid, SQLLimit &$myLimit = null){
		$myObject = parent::getGameOutListBySql(self::GAMEOUTID.' = ?', array($gameoutid), $myLimit);
		return ( $myObject->valid() ? $myObject->current() : null );
	}

	/**
	 * @param integer $gameid
	 * @param SQLLimit &$myLimit
	 * @return GameOut or null
	 */
	public static final function getGameOutByGameid($gameid, SQLLimit &$myLimit = null){
		$myObject = parent::getGameOutListBySql(self::GAMEID.' = ?', array($gameid), $myLimit);
		return ( $myObject->valid() ? $myObject->current() : null );
	}

	/**
	 * @param string $ip
	 * @param SQLLimit &$myLimit
	 * @return GameOut or null
	 */
	public static final function getGameOutByIp($ip, SQLLimit &$myLimit = null){
		$myObject = parent::getGameOutListBySql(self::IP.' = ?', array($ip), $myLimit);
		return ( $myObject->valid() ? $myObject->current() : null );
	}

	/**
	 * @param integer $tstamp_created
	 * @param SQLLimit &$myLimit
	 * @return GameOutList
	 */
	public static final function getGameOutListByTstampCreated($tstamp_created, SQLLimit &$myLimit = null){
		return parent::getGameOutListBySql(self::TSTAMP_CREATED.' = ?', array($tstamp_created), $myLimit);
	}

	/**************************** REFERENCES ****************************/
	/**
	 * @param Game &$myObject
	 * @return GameOut
	 */
	public static final function getGameOutByGame(Game &$myObject){
		return self::getGameOutByGameid($myObject->getGameid());  // blah
	}

	/**
	 * @param GameOut &$myGameOut
	 * @return Game
	 */
	public static final function getGameByGameOut(GameOut &$myObject){
		Library::requireLibrary(LibraryKeys::APPLICATION_GAME());
		return GameManager::getGameByOut($myObject);
	}

}
