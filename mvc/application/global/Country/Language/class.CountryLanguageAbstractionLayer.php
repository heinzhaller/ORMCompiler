<?php
#ä
/**
 * CountryLanguage AbstractionLayer [AL]
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class CountryLanguageAbstractionLayer { 

	/**
	 * @return CountryLanguageList
	 */
	protected static final function getCountryLanguageListBySql($where,array $params = null,SQLLimit $limit = null){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('CountryLanguage'));
		return CountryLanguageDAO::getCountryLanguageListByQuery($where,$params,$limit);
	}

	/**
	 * @param CountryLanguage &$myObject
	 */
	public static final function saveOnly(CountryLanguage &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('CountryLanguage'));
		if( count($myObject->_getModified()) == 0 )
			return false; // return if no changes was made
		CountryLanguageDAO::store($myObject);
	}

	/**
	 * @param CountryLanguage &$myObject
	 */
	public static function save(CountryLanguage &$myObject){
		self::saveOnly($myObject);
	}

	/**
	 * @param CountryLanguage &$myObject
	 */
	public static function delete(CountryLanguage &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('CountryLanguage'));
		if($myObject->_getIsNew())
			return false; // return if object is new
		$myObject->_setIsDeleted(true);
		CountryLanguageDAO::store($myObject);
	}

}
