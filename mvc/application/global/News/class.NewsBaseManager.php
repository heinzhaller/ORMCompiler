<?php
#ä
/**
 * News Base-Manager
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class NewsBaseManager extends NewsAbstractionLayer { 

	/**************************** ATTRIBUTES ****************************/
	const NEWSID = 'newsid';
	const TSTAMP_CREATED = 'tstamp_created';
	const TSTAMP_MODIFIED = 'tstamp_modified';
	const TSTAMP_DELETED = 'tstamp_deleted';
	const GAMEID = 'gameid';
	const CONTENT = 'content';
	const TITLE = 'title';
	const USERID = 'userid';

	/**************************** SELECT METHODS ****************************/
	/**
	 * @param SQLLimit &$myLimit
	 * @return NewsList
	 */
	public static final function getNewsList(SQLLimit &$myLimit = null){
		return parent::getNewsListBySql('1 = 1', null, $myLimit);
	}

	/**
	 * @param integer $newsid
	 * @param SQLLimit &$myLimit
	 * @return News or null
	 */
	public static final function getNewsByNewsid($newsid, SQLLimit &$myLimit = null){
		$myObject = parent::getNewsListBySql(self::NEWSID.' = ?', array($newsid), $myLimit);
		return ( $myObject->valid() ? $myObject->current() : null );
	}

	/**
	 * @param integer $tstamp_created
	 * @param SQLLimit &$myLimit
	 * @return NewsList
	 */
	public static final function getNewsListByTstampCreated($tstamp_created, SQLLimit &$myLimit = null){
		return parent::getNewsListBySql(self::TSTAMP_CREATED.' = ?', array($tstamp_created), $myLimit);
	}

	/**
	 * @param integer $tstamp_modified
	 * @param SQLLimit &$myLimit
	 * @return NewsList
	 */
	public static final function getNewsListByTstampModified($tstamp_modified, SQLLimit &$myLimit = null){
		return parent::getNewsListBySql(self::TSTAMP_MODIFIED.' = ?', array($tstamp_modified), $myLimit);
	}

	/**
	 * @param integer $tstamp_deleted
	 * @param SQLLimit &$myLimit
	 * @return NewsList
	 */
	public static final function getNewsListByTstampDeleted($tstamp_deleted, SQLLimit &$myLimit = null){
		return parent::getNewsListBySql(self::TSTAMP_DELETED.' = ?', array($tstamp_deleted), $myLimit);
	}

	/**
	 * @param integer $gameid
	 * @param SQLLimit &$myLimit
	 * @return NewsList
	 */
	public static final function getNewsListByGameid($gameid, SQLLimit &$myLimit = null){
		return parent::getNewsListBySql(self::GAMEID.' = ?', array($gameid), $myLimit);
	}

	/**
	 * @param string $content
	 * @param SQLLimit &$myLimit
	 * @return NewsList
	 */
	public static final function getNewsListByContent($content, SQLLimit &$myLimit = null){
		return parent::getNewsListBySql(self::CONTENT.' = ?', array($content), $myLimit);
	}

	/**
	 * @param string $title
	 * @param SQLLimit &$myLimit
	 * @return NewsList
	 */
	public static final function getNewsListByTitle($title, SQLLimit &$myLimit = null){
		return parent::getNewsListBySql(self::TITLE.' = ?', array($title), $myLimit);
	}

	/**
	 * @param integer $userid
	 * @param SQLLimit &$myLimit
	 * @return NewsList
	 */
	public static final function getNewsListByUserid($userid, SQLLimit &$myLimit = null){
		return parent::getNewsListBySql(self::USERID.' = ?', array($userid), $myLimit);
	}

	/**************************** REFERENCES ****************************/
	/**
	 * @param Game &$myObject
	 * @return NewsList
	 */
	public static final function getNewsListByGame(Game &$myObject, SQLLimit &$myLimit = null){
		return self::getNewsListByGameid($myObject->getGameid(), $myLimit);
	}

	/**
	 * @param News &$myNews
	 * @return Game
	 */
	public static final function getGameByNews(News &$myObject){
		Library::requireLibrary(LibraryKeys::APPLICATION_GAME());
		return GameManager::getGameByNews($myObject);
	}

	/**
	 * @param User &$myObject
	 * @return NewsList
	 */
	public static final function getNewsListByUser(User &$myObject, SQLLimit &$myLimit = null){
		return self::getNewsListByUserid($myObject->getUserid(), $myLimit);
	}

	/**
	 * @param News &$myNews
	 * @return User
	 */
	public static final function getUserByNews(News &$myObject){
		Library::requireLibrary(LibraryKeys::APPLICATION_USER());
		return UserManager::getUserByNews($myObject);
	}

}
