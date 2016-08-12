<?php
#ä
/**
 * Tag AbstractionLayer [AL]
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class TagAbstractionLayer { 

	/**
	 * @return TagList
	 */
	protected static final function getTagListBySql($where,array $params = null,SQLLimit $limit = null){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('Tag'));
		return TagDAO::getTagListByQuery($where,$params,$limit);
	}

	/**
	 * @param Tag &$myObject
	 */
	public static final function saveOnly(Tag &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('Tag'));
		if( count($myObject->_getModified()) == 0 )
			return false; // return if no changes was made
		TagDAO::store($myObject);
	}

	/**
	 * @param Tag &$myObject
	 */
	public static function save(Tag &$myObject){
		self::saveOnly($myObject);

		// save Game
		foreach($myObject->getGameList() as $mySub){
			$m2m_GameTag = new GameTag();
			$m2m_GameTag->setTagid($myObject->getTagid());
			$m2m_GameTag->setGameid($mySub->getGameid());
			GameTagManager::saveOnly($m2m_GameTag);
		}
	}

	/**
	 * @param Tag &$myObject
	 */
	public static function delete(Tag &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('Tag'));
		if($myObject->_getIsNew())
			return false; // return if object is new
		$myObject->_setIsDeleted(true);
		TagDAO::store($myObject);
	}

}
