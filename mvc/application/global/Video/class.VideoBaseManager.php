<?php
#ä
/**
 * Video Base-Manager
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class VideoBaseManager extends VideoAbstractionLayer { 

	/**************************** ATTRIBUTES ****************************/
	const VIDEOID = 'videoid';
	const GAMEID = 'gameid';
	const FILENAME = 'filename';
	const URL = 'url';
	const TSTAMP_CREATED = 'tstamp_created';
	const TSTAMP_MODIFIED = 'tstamp_modified';
	const TSTAMP_DELETED = 'tstamp_deleted';
	const TITLE = 'title';

	/**************************** SELECT METHODS ****************************/
	/**
	 * @param SQLLimit &$myLimit
	 * @return VideoList
	 */
	public static final function getVideoList(SQLLimit &$myLimit = null){
		return parent::getVideoListBySql('1 = 1', null, $myLimit);
	}

	/**
	 * @param integer $videoid
	 * @param SQLLimit &$myLimit
	 * @return Video or null
	 */
	public static final function getVideoByVideoid($videoid, SQLLimit &$myLimit = null){
		$myObject = parent::getVideoListBySql(self::VIDEOID.' = ?', array($videoid), $myLimit);
		return ( $myObject->valid() ? $myObject->current() : null );
	}

	/**
	 * @param integer $gameid
	 * @param SQLLimit &$myLimit
	 * @return VideoList
	 */
	public static final function getVideoListByGameid($gameid, SQLLimit &$myLimit = null){
		return parent::getVideoListBySql(self::GAMEID.' = ?', array($gameid), $myLimit);
	}

	/**
	 * @param string $filename
	 * @param SQLLimit &$myLimit
	 * @return VideoList
	 */
	public static final function getVideoListByFilename($filename, SQLLimit &$myLimit = null){
		return parent::getVideoListBySql(self::FILENAME.' = ?', array($filename), $myLimit);
	}

	/**
	 * @param string $url
	 * @param SQLLimit &$myLimit
	 * @return VideoList
	 */
	public static final function getVideoListByUrl($url, SQLLimit &$myLimit = null){
		return parent::getVideoListBySql(self::URL.' = ?', array($url), $myLimit);
	}

	/**
	 * @param integer $tstamp_created
	 * @param SQLLimit &$myLimit
	 * @return VideoList
	 */
	public static final function getVideoListByTstampCreated($tstamp_created, SQLLimit &$myLimit = null){
		return parent::getVideoListBySql(self::TSTAMP_CREATED.' = ?', array($tstamp_created), $myLimit);
	}

	/**
	 * @param integer $tstamp_modified
	 * @param SQLLimit &$myLimit
	 * @return VideoList
	 */
	public static final function getVideoListByTstampModified($tstamp_modified, SQLLimit &$myLimit = null){
		return parent::getVideoListBySql(self::TSTAMP_MODIFIED.' = ?', array($tstamp_modified), $myLimit);
	}

	/**
	 * @param integer $tstamp_deleted
	 * @param SQLLimit &$myLimit
	 * @return VideoList
	 */
	public static final function getVideoListByTstampDeleted($tstamp_deleted, SQLLimit &$myLimit = null){
		return parent::getVideoListBySql(self::TSTAMP_DELETED.' = ?', array($tstamp_deleted), $myLimit);
	}

	/**
	 * @param string $title
	 * @param SQLLimit &$myLimit
	 * @return VideoList
	 */
	public static final function getVideoListByTitle($title, SQLLimit &$myLimit = null){
		return parent::getVideoListBySql(self::TITLE.' = ?', array($title), $myLimit);
	}

	/**************************** REFERENCES ****************************/
	/**
	 * @param Game &$myObject
	 * @return VideoList
	 */
	public static final function getVideoListByGame(Game &$myObject, SQLLimit &$myLimit = null){
		return self::getVideoListByGameid($myObject->getGameid(), $myLimit);
	}

	/**
	 * @param Video &$myVideo
	 * @return Game
	 */
	public static final function getGameByVideo(Video &$myObject){
		Library::requireLibrary(LibraryKeys::APPLICATION_GAME());
		return GameManager::getGameByVideo($myObject);
	}

}
