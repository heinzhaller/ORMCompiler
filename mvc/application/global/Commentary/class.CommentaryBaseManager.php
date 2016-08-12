<?php
#ä
/**
 * Commentary Base-Manager
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class CommentaryBaseManager extends CommentaryAbstractionLayer { 

	/**************************** ATTRIBUTES ****************************/
	const COMMENTARYID = 'commentaryid';
	const PARENT_COMMENTARYID = 'parent_commentaryid';
	const USERNAME = 'username';
	const IP = 'ip';
	const MESSAGE = 'message';
	const TSTAMP_CREATED = 'tstamp_created';
	const TSTAMP_MODIFIED = 'tstamp_modified';
	const TSTAMP_DELETED = 'tstamp_deleted';
	const GAMEID = 'gameid';

	/**************************** SELECT METHODS ****************************/
	/**
	 * @param SQLLimit &$myLimit
	 * @return CommentaryList
	 */
	public static final function getCommentaryList(SQLLimit &$myLimit = null){
		return parent::getCommentaryListBySql('1 = 1', null, $myLimit);
	}

	/**
	 * @param integer $commentaryid
	 * @param SQLLimit &$myLimit
	 * @return Commentary or null
	 */
	public static final function getCommentaryByCommentaryid($commentaryid, SQLLimit &$myLimit = null){
		$myObject = parent::getCommentaryListBySql(self::COMMENTARYID.' = ?', array($commentaryid), $myLimit);
		return ( $myObject->valid() ? $myObject->current() : null );
	}

	/**
	 * @param integer $parent_commentaryid
	 * @param SQLLimit &$myLimit
	 * @return CommentaryList
	 */
	public static final function getCommentaryListByParentCommentaryid($parent_commentaryid, SQLLimit &$myLimit = null){
		return parent::getCommentaryListBySql(self::PARENT_COMMENTARYID.' = ?', array($parent_commentaryid), $myLimit);
	}

	/**
	 * @param string $username
	 * @param SQLLimit &$myLimit
	 * @return CommentaryList
	 */
	public static final function getCommentaryListByUsername($username, SQLLimit &$myLimit = null){
		return parent::getCommentaryListBySql(self::USERNAME.' = ?', array($username), $myLimit);
	}

	/**
	 * @param string $ip
	 * @param SQLLimit &$myLimit
	 * @return CommentaryList
	 */
	public static final function getCommentaryListByIp($ip, SQLLimit &$myLimit = null){
		return parent::getCommentaryListBySql(self::IP.' = ?', array($ip), $myLimit);
	}

	/**
	 * @param string $message
	 * @param SQLLimit &$myLimit
	 * @return CommentaryList
	 */
	public static final function getCommentaryListByMessage($message, SQLLimit &$myLimit = null){
		return parent::getCommentaryListBySql(self::MESSAGE.' = ?', array($message), $myLimit);
	}

	/**
	 * @param integer $tstamp_created
	 * @param SQLLimit &$myLimit
	 * @return CommentaryList
	 */
	public static final function getCommentaryListByTstampCreated($tstamp_created, SQLLimit &$myLimit = null){
		return parent::getCommentaryListBySql(self::TSTAMP_CREATED.' = ?', array($tstamp_created), $myLimit);
	}

	/**
	 * @param integer $tstamp_modified
	 * @param SQLLimit &$myLimit
	 * @return CommentaryList
	 */
	public static final function getCommentaryListByTstampModified($tstamp_modified, SQLLimit &$myLimit = null){
		return parent::getCommentaryListBySql(self::TSTAMP_MODIFIED.' = ?', array($tstamp_modified), $myLimit);
	}

	/**
	 * @param integer $tstamp_deleted
	 * @param SQLLimit &$myLimit
	 * @return CommentaryList
	 */
	public static final function getCommentaryListByTstampDeleted($tstamp_deleted, SQLLimit &$myLimit = null){
		return parent::getCommentaryListBySql(self::TSTAMP_DELETED.' = ?', array($tstamp_deleted), $myLimit);
	}

	/**
	 * @param integer $gameid
	 * @param SQLLimit &$myLimit
	 * @return CommentaryList
	 */
	public static final function getCommentaryListByGameid($gameid, SQLLimit &$myLimit = null){
		return parent::getCommentaryListBySql(self::GAMEID.' = ?', array($gameid), $myLimit);
	}

	/**************************** REFERENCES ****************************/
	/**
	 * @param Game &$myObject
	 * @return CommentaryList
	 */
	public static final function getCommentaryListByGame(Game &$myObject, SQLLimit &$myLimit = null){
		return self::getCommentaryListByGameid($myObject->getGameid(), $myLimit);
	}

	/**
	 * @param Commentary &$myCommentary
	 * @return Game
	 */
	public static final function getGameByCommentary(Commentary &$myObject){
		Library::requireLibrary(LibraryKeys::APPLICATION_GAME());
		return GameManager::getGameByCommentary($myObject);
	}

}
