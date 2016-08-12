<?php
#ä
/**
 * GameTag Base-Manager
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class GameTagBaseManager extends GameTagAbstractionLayer { 

	/**************************** ATTRIBUTES ****************************/
	const GAMEID = 'gameid';
	const TAGID = 'tagid';

	/**************************** SELECT METHODS ****************************/
	/**
	 * @param SQLLimit &$myLimit
	 * @return GameTagList
	 */
	public static final function getGameTagList(SQLLimit &$myLimit = null){
		return parent::getGameTagListBySql('1 = 1', null, $myLimit);
	}

	/**
	 * @param integer $gameid
	 * @param SQLLimit &$myLimit
	 * @return GameTagList
	 */
	public static final function getGameTagListByGameid($gameid, SQLLimit &$myLimit = null){
		return parent::getGameTagListBySql(self::GAMEID.' = ?', array($gameid), $myLimit);
	}

	/**
	 * @param integer $tagid
	 * @param SQLLimit &$myLimit
	 * @return GameTagList
	 */
	public static final function getGameTagListByTagid($tagid, SQLLimit &$myLimit = null){
		return parent::getGameTagListBySql(self::TAGID.' = ?', array($tagid), $myLimit);
	}

	/**************************** REFERENCES ****************************/
	/**
	 * @param Game &$myObject
	 * @return GameTagList
	 */
	public static final function getGameTagListByGame(Game &$myObject, SQLLimit &$myLimit = null){
		return self::getGameTagListByGameid($myObject->getGameid(), $myLimit);
	}

	/**
	 * @param GameTag &$myGameTag
	 * @return GameList
	 */
	public static final function getGameListByGameTag(GameTag &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_GAME());
		return GameManager::getGameListBytbl_tag($myObject, $myLimit);
	}

	/**
	 * @param Tag &$myObject
	 * @return GameTagList
	 */
	public static final function getGameTagListByTag(Tag &$myObject, SQLLimit &$myLimit = null){
		return self::getGameTagListByTagid($myObject->getTagid(), $myLimit);
	}

	/**
	 * @param GameTag &$myGameTag
	 * @return TagList
	 */
	public static final function getTagListByGameTag(GameTag &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_TAG());
		return TagManager::getTagListBytbl_game($myObject, $myLimit);
	}

}
