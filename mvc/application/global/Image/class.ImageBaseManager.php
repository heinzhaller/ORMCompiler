<?php
#ä
/**
 * Image Base-Manager
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class ImageBaseManager extends ImageAbstractionLayer { 

	/**************************** ATTRIBUTES ****************************/
	const IMAGEID = 'imageid';
	const TITLE = 'title';
	const GAMEID = 'gameid';
	const FILENAME = 'filename';
	const PATH = 'path';
	const SORTORDER = 'sortorder';
	const TSTAMP_CREATED = 'tstamp_created';
	const TSTAMP_MODIFIED = 'tstamp_modified';
	const TSTAMP_DELETED = 'tstamp_deleted';

	/**************************** SELECT METHODS ****************************/
	/**
	 * @param SQLLimit &$myLimit
	 * @return ImageList
	 */
	public static final function getImageList(SQLLimit &$myLimit = null){
		return parent::getImageListBySql('1 = 1', null, $myLimit);
	}

	/**
	 * @param integer $imageid
	 * @param SQLLimit &$myLimit
	 * @return Image or null
	 */
	public static final function getImageByImageid($imageid, SQLLimit &$myLimit = null){
		$myObject = parent::getImageListBySql(self::IMAGEID.' = ?', array($imageid), $myLimit);
		return ( $myObject->valid() ? $myObject->current() : null );
	}

	/**
	 * @param string $title
	 * @param SQLLimit &$myLimit
	 * @return ImageList
	 */
	public static final function getImageListByTitle($title, SQLLimit &$myLimit = null){
		return parent::getImageListBySql(self::TITLE.' = ?', array($title), $myLimit);
	}

	/**
	 * @param integer $gameid
	 * @param SQLLimit &$myLimit
	 * @return ImageList
	 */
	public static final function getImageListByGameid($gameid, SQLLimit &$myLimit = null){
		return parent::getImageListBySql(self::GAMEID.' = ?', array($gameid), $myLimit);
	}

	/**
	 * @param string $filename
	 * @param SQLLimit &$myLimit
	 * @return ImageList
	 */
	public static final function getImageListByFilename($filename, SQLLimit &$myLimit = null){
		return parent::getImageListBySql(self::FILENAME.' = ?', array($filename), $myLimit);
	}

	/**
	 * @param string $path
	 * @param SQLLimit &$myLimit
	 * @return ImageList
	 */
	public static final function getImageListByPath($path, SQLLimit &$myLimit = null){
		return parent::getImageListBySql(self::PATH.' = ?', array($path), $myLimit);
	}

	/**
	 * @param integer $sortorder
	 * @param SQLLimit &$myLimit
	 * @return ImageList
	 */
	public static final function getImageListBySortorder($sortorder, SQLLimit &$myLimit = null){
		return parent::getImageListBySql(self::SORTORDER.' = ?', array($sortorder), $myLimit);
	}

	/**
	 * @param integer $tstamp_created
	 * @param SQLLimit &$myLimit
	 * @return ImageList
	 */
	public static final function getImageListByTstampCreated($tstamp_created, SQLLimit &$myLimit = null){
		return parent::getImageListBySql(self::TSTAMP_CREATED.' = ?', array($tstamp_created), $myLimit);
	}

	/**
	 * @param integer $tstamp_modified
	 * @param SQLLimit &$myLimit
	 * @return ImageList
	 */
	public static final function getImageListByTstampModified($tstamp_modified, SQLLimit &$myLimit = null){
		return parent::getImageListBySql(self::TSTAMP_MODIFIED.' = ?', array($tstamp_modified), $myLimit);
	}

	/**
	 * @param integer $tstamp_deleted
	 * @param SQLLimit &$myLimit
	 * @return ImageList
	 */
	public static final function getImageListByTstampDeleted($tstamp_deleted, SQLLimit &$myLimit = null){
		return parent::getImageListBySql(self::TSTAMP_DELETED.' = ?', array($tstamp_deleted), $myLimit);
	}

	/**************************** REFERENCES ****************************/
	/**
	 * @param Game &$myObject
	 * @return ImageList
	 */
	public static final function getImageListByGame(Game &$myObject, SQLLimit &$myLimit = null){
		return self::getImageListByGameid($myObject->getGameid(), $myLimit);
	}

	/**
	 * @param Image &$myImage
	 * @return Game
	 */
	public static final function getGameByImage(Image &$myObject){
		Library::requireLibrary(LibraryKeys::APPLICATION_GAME());
		return GameManager::getGameByImage($myObject);
	}

}
