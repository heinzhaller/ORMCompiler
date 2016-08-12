<?php
#ä
/**
 * Language AbstractionLayer [AL]
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class LanguageAbstractionLayer { 

	/**
	 * @return LanguageList
	 */
	protected static final function getLanguageListBySql($where,array $params = null,SQLLimit $limit = null){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('Language'));
		return LanguageDAO::getLanguageListByQuery($where,$params,$limit);
	}

	/**
	 * @param Language &$myObject
	 */
	public static final function saveOnly(Language &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('Language'));
		if( count($myObject->_getModified()) == 0 )
			return false; // return if no changes was made
		LanguageDAO::store($myObject);
	}

	/**
	 * @param Language &$myObject
	 */
	public static function save(Language &$myObject){
		self::saveOnly($myObject);

		// save Country
		foreach($myObject->getCountryList() as $mySub){
			$m2m_CountryLanguage = new CountryLanguage();
			$m2m_CountryLanguage->setLanguageiso2($myObject->getLanguageiso2());
			$m2m_CountryLanguage->setCountryiso2($mySub->getCountryiso2());
			CountryLanguageManager::saveOnly($m2m_CountryLanguage);
		}

		// save TranslationPlaceholderContent
		foreach($myObject->getPlaceholdercontentList() as $sub){
			$sub->setLanguageiso2($myObject->getLanguageiso2());
			TranslationPlaceholderContentManager::saveOnly($sub);
		}
	}

	/**
	 * @param Language &$myObject
	 */
	public static function delete(Language &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('Language'));
		if($myObject->_getIsNew())
			return false; // return if object is new
		$myObject->_setIsDeleted(true);
		LanguageDAO::store($myObject);
	}

}
