<?php
#ä
/**
 * GameRating Base-Manager
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class GameRatingBaseManager extends GameRatingAbstractionLayer { 

	/**************************** ATTRIBUTES ****************************/
	const GAMERATINGID = 'gameratingid';
	const GAMEID = 'gameid';
	const IP = 'ip';
	const RATING = 'rating';
	const TSTAMP_CREATED = 'tstamp_created';

	/**************************** SELECT METHODS ****************************/
	/**
	 * @param SQLLimit &$myLimit
	 * @return GameRatingList
	 */
	public static final function getGameRatingList(SQLLimit &$myLimit = null){
		return parent::getGameRatingListBySql('1 = 1', null, $myLimit);
	}

	/**
	 * @param integer $gameratingid
	 * @param SQLLimit &$myLimit
	 * @return GameRating or null
	 */
	public static final function getGameRatingByGameratingid($gameratingid, SQLLimit &$myLimit = null){
		$myObject = parent::getGameRatingListBySql(self::GAMERATINGID.' = ?', array($gameratingid), $myLimit);
		return ( $myObject->valid() ? $myObject->current() : null );
	}

	/**
	 * @param integer $gameid
	 * @param SQLLimit &$myLimit
	 * @return GameRating or null
	 */
	public static final function getGameRatingByGameid($gameid, SQLLimit &$myLimit = null){
		$myObject = parent::getGameRatingListBySql(self::GAMEID.' = ?', array($gameid), $myLimit);
		return ( $myObject->valid() ? $myObject->current() : null );
	}

	/**
	 * @param string $ip
	 * @param SQLLimit &$myLimit
	 * @return GameRating or null
	 */
	public static final function getGameRatingByIp($ip, SQLLimit &$myLimit = null){
		$myObject = parent::getGameRatingListBySql(self::IP.' = ?', array($ip), $myLimit);
		return ( $myObject->valid() ? $myObject->current() : null );
	}

	/**
	 * @param integer $rating
	 * @param SQLLimit &$myLimit
	 * @return GameRatingList
	 */
	public static final function getGameRatingListByRating($rating, SQLLimit &$myLimit = null){
		return parent::getGameRatingListBySql(self::RATING.' = ?', array($rating), $myLimit);
	}

	/**
	 * @param integer $tstamp_created
	 * @param SQLLimit &$myLimit
	 * @return GameRatingList
	 */
	public static final function getGameRatingListByTstampCreated($tstamp_created, SQLLimit &$myLimit = null){
		return parent::getGameRatingListBySql(self::TSTAMP_CREATED.' = ?', array($tstamp_created), $myLimit);
	}

	/**************************** REFERENCES ****************************/
	/**
	 * @param Game &$myObject
	 * @return GameRating
	 */
	public static final function getGameRatingByGame(Game &$myObject){
		return self::getGameRatingByGameid($myObject->getGameid());  // blah
	}

	/**
	 * @param GameRating &$myGameRating
	 * @return Game
	 */
	public static final function getGameByGameRating(GameRating &$myObject){
		Library::requireLibrary(LibraryKeys::APPLICATION_GAME());
		return GameManager::getGameByRating($myObject);
	}

}
