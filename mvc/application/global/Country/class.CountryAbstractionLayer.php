<?php
#ä
/**
 * Country AbstractionLayer [AL]
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class CountryAbstractionLayer { 

	/**
	 * @return CountryList
	 */
	protected static final function getCountryListBySql($where,array $params = null,SQLLimit $limit = null){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('Country'));
		return CountryDAO::getCountryListByQuery($where,$params,$limit);
	}

	/**
	 * @param Country &$myObject
	 */
	public static final function saveOnly(Country &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('Country'));
		if( count($myObject->_getModified()) == 0 )
			return false; // return if no changes was made
		CountryDAO::store($myObject);
	}

	/**
	 * @param Country &$myObject
	 */
	public static function save(Country &$myObject){
		self::saveOnly($myObject);

		// save Language
		foreach($myObject->getLanguageList() as $mySub){
			$m2m_CountryLanguage = new CountryLanguage();
			$m2m_CountryLanguage->setCountryiso2($myObject->getCountryiso2());
			$m2m_CountryLanguage->setLanguageiso2($mySub->getLanguageiso2());
			CountryLanguageManager::saveOnly($m2m_CountryLanguage);
		}
	}

	/**
	 * @param Country &$myObject
	 */
	public static function delete(Country &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('Country'));
		if($myObject->_getIsNew())
			return false; // return if object is new
		$myObject->_setIsDeleted(true);
		CountryDAO::store($myObject);
	}

}
