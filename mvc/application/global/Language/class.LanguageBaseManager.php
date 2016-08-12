<?php
#ä
/**
 * Language Base-Manager
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class LanguageBaseManager extends LanguageAbstractionLayer { 

	/**************************** ATTRIBUTES ****************************/
	const LANGUAGEISO2 = 'languageiso2';
	const DESCRIPTION = 'description';

	/**************************** SELECT METHODS ****************************/
	/**
	 * @param SQLLimit &$myLimit
	 * @return LanguageList
	 */
	public static final function getLanguageList(SQLLimit &$myLimit = null){
		return parent::getLanguageListBySql('1 = 1', null, $myLimit);
	}

	/**
	 * @param string $languageiso2
	 * @param SQLLimit &$myLimit
	 * @return Language or null
	 */
	public static final function getLanguageByLanguageiso2($languageiso2, SQLLimit &$myLimit = null){
		$myObject = parent::getLanguageListBySql(self::LANGUAGEISO2.' = ?', array($languageiso2), $myLimit);
		return ( $myObject->valid() ? $myObject->current() : null );
	}

	/**
	 * @param string $description
	 * @param SQLLimit &$myLimit
	 * @return LanguageList
	 */
	public static final function getLanguageListByDescription($description, SQLLimit &$myLimit = null){
		return parent::getLanguageListBySql(self::DESCRIPTION.' = ?', array($description), $myLimit);
	}

	/**************************** REFERENCES ****************************/
	/**
	 * @param Country &$myObject
	 * @return LanguageList
	 */
	public static final function getLanguageListByCountry(Country &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_COUNTRY_LANGUAGE());
		$myList = CountryLanguageManager::getCountryLanguageListByCountry($myObject, $myLimit);
		$myLanguageList = new LanguageList();
		foreach($myList as $item)
			$myLanguageList->add(self::getLanguageByLanguageiso2($item->getLanguageiso2()));
		return $myLanguageList;
	}

	/**
	 * @param Language &$myLanguage
	 * @return CountryList
	 */
	public static final function getCountryListByLanguage(Language &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_COUNTRY());
		return CountryManager::getCountryListByLanguage($myObject, $myLimit);
	}

	/**
	 * @param TranslationPlaceholderContent &$myObject
	 * @return Language
	 */
	public static final function getLanguageByPlaceholdercontent(TranslationPlaceholderContent &$myObject){
		return self::getLanguageByLanguageiso2($myObject->getLanguageiso2());  // blah
	}

	/**
	 * @param Language &$myLanguage
	 * @return TranslationPlaceholderContentList
	 */
	public static final function getPlaceholdercontentListByLanguage(Language &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_TRANSLATION_PLACEHOLDER_CONTENT());
		return TranslationPlaceholderContentManager::getTranslationPlaceholderContentListByLanguage($myObject, $myLimit);
	}

}
