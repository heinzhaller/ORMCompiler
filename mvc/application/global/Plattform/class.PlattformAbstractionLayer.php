<?php
#ä
/**
 * Plattform AbstractionLayer [AL]
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class PlattformAbstractionLayer { 

	/**
	 * @return PlattformList
	 */
	protected static final function getPlattformListBySql($where,array $params = null,SQLLimit $limit = null){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('Plattform'));
		return PlattformDAO::getPlattformListByQuery($where,$params,$limit);
	}

	/**
	 * @param Plattform &$myObject
	 */
	public static final function saveOnly(Plattform &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('Plattform'));
		if( count($myObject->_getModified()) == 0 )
			return false; // return if no changes was made
		PlattformDAO::store($myObject);
	}

	/**
	 * @param Plattform &$myObject
	 */
	public static function save(Plattform &$myObject){
		self::saveOnly($myObject);

		// save Game
		foreach($myObject->getGameList() as $mySub){
			$m2m_GamePlattform = new GamePlattform();
			$m2m_GamePlattform->setPlattformid($myObject->getPlattformid());
			$m2m_GamePlattform->setGameid($mySub->getGameid());
			GamePlattformManager::saveOnly($m2m_GamePlattform);
		}
	}

	/**
	 * @param Plattform &$myObject
	 */
	public static function delete(Plattform &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('Plattform'));
		if($myObject->_getIsNew())
			return false; // return if object is new
		$myObject->_setIsDeleted(true);
		PlattformDAO::store($myObject);
	}

}
