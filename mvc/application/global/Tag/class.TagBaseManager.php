<?php
#ä
/**
 * Tag Base-Manager
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class TagBaseManager extends TagAbstractionLayer { 

	/**************************** ATTRIBUTES ****************************/
	const TAGID = 'tagid';
	const NAME = 'name';
	const TSTAMP_CREATED = 'tstamp_created';
	const TSTAMP_MODIFIED = 'tstamp_modified';
	const TSTAMP_DELETED = 'tstamp_deleted';

	/**************************** SELECT METHODS ****************************/
	/**
	 * @param SQLLimit &$myLimit
	 * @return TagList
	 */
	public static final function getTagList(SQLLimit &$myLimit = null){
		return parent::getTagListBySql('1 = 1', null, $myLimit);
	}

	/**
	 * @param integer $tagid
	 * @param SQLLimit &$myLimit
	 * @return Tag or null
	 */
	public static final function getTagByTagid($tagid, SQLLimit &$myLimit = null){
		$myObject = parent::getTagListBySql(self::TAGID.' = ?', array($tagid), $myLimit);
		return ( $myObject->valid() ? $myObject->current() : null );
	}

	/**
	 * @param string $name
	 * @param SQLLimit &$myLimit
	 * @return TagList
	 */
	public static final function getTagListByName($name, SQLLimit &$myLimit = null){
		return parent::getTagListBySql(self::NAME.' = ?', array($name), $myLimit);
	}

	/**
	 * @param integer $tstamp_created
	 * @param SQLLimit &$myLimit
	 * @return TagList
	 */
	public static final function getTagListByTstampCreated($tstamp_created, SQLLimit &$myLimit = null){
		return parent::getTagListBySql(self::TSTAMP_CREATED.' = ?', array($tstamp_created), $myLimit);
	}

	/**
	 * @param integer $tstamp_modified
	 * @param SQLLimit &$myLimit
	 * @return TagList
	 */
	public static final function getTagListByTstampModified($tstamp_modified, SQLLimit &$myLimit = null){
		return parent::getTagListBySql(self::TSTAMP_MODIFIED.' = ?', array($tstamp_modified), $myLimit);
	}

	/**
	 * @param integer $tstamp_deleted
	 * @param SQLLimit &$myLimit
	 * @return TagList
	 */
	public static final function getTagListByTstampDeleted($tstamp_deleted, SQLLimit &$myLimit = null){
		return parent::getTagListBySql(self::TSTAMP_DELETED.' = ?', array($tstamp_deleted), $myLimit);
	}

	/**************************** REFERENCES ****************************/
	/**
	 * @param Game &$myObject
	 * @return TagList
	 */
	public static final function getTagListByGame(Game &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_GAME_TAG());
		$myList = GameTagManager::getGameTagListByGame($myObject, $myLimit);
		$myTagList = new TagList();
		foreach($myList as $item)
			$myTagList->add(self::getTagByTagid($item->getTagid()));
		return $myTagList;
	}

	/**
	 * @param Tag &$myTag
	 * @return GameList
	 */
	public static final function getGameListByTag(Tag &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_GAME());
		return GameManager::getGameListByTag($myObject, $myLimit);
	}

}
