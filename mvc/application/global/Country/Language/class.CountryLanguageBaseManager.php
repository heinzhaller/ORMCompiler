<?php
#ä
/**
 * CountryLanguage Base-Manager
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class CountryLanguageBaseManager extends CountryLanguageAbstractionLayer { 

	/**************************** ATTRIBUTES ****************************/
	const COUNTRYISO2 = 'countryiso2';
	const LANGUAGEISO2 = 'languageiso2';

	/**************************** SELECT METHODS ****************************/
	/**
	 * @param SQLLimit &$myLimit
	 * @return CountryLanguageList
	 */
	public static final function getCountryLanguageList(SQLLimit &$myLimit = null){
		return parent::getCountryLanguageListBySql('1 = 1', null, $myLimit);
	}

	/**
	 * @param string $countryiso2
	 * @param SQLLimit &$myLimit
	 * @return CountryLanguageList
	 */
	public static final function getCountryLanguageListByCountryiso2($countryiso2, SQLLimit &$myLimit = null){
		return parent::getCountryLanguageListBySql(self::COUNTRYISO2.' = ?', array($countryiso2), $myLimit);
	}

	/**
	 * @param string $languageiso2
	 * @param SQLLimit &$myLimit
	 * @return CountryLanguageList
	 */
	public static final function getCountryLanguageListByLanguageiso2($languageiso2, SQLLimit &$myLimit = null){
		return parent::getCountryLanguageListBySql(self::LANGUAGEISO2.' = ?', array($languageiso2), $myLimit);
	}

	/**************************** REFERENCES ****************************/
	/**
	 * @param Language &$myObject
	 * @return CountryLanguageList
	 */
	public static final function getCountryLanguageListByLanguage(Language &$myObject, SQLLimit &$myLimit = null){
		return self::getCountryLanguageListByLanguageiso2($myObject->getLanguageiso2(), $myLimit);
	}

	/**
	 * @param CountryLanguage &$myCountryLanguage
	 * @return LanguageList
	 */
	public static final function getLanguageListByCountryLanguage(CountryLanguage &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_LANGUAGE());
		return LanguageManager::getLanguageListBytbl_country($myObject, $myLimit);
	}

	/**
	 * @param Country &$myObject
	 * @return CountryLanguageList
	 */
	public static final function getCountryLanguageListByCountry(Country &$myObject, SQLLimit &$myLimit = null){
		return self::getCountryLanguageListByCountryiso2($myObject->getCountryiso2(), $myLimit);
	}

	/**
	 * @param CountryLanguage &$myCountryLanguage
	 * @return CountryList
	 */
	public static final function getCountryListByCountryLanguage(CountryLanguage &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_COUNTRY());
		return CountryManager::getCountryListBytbl_language($myObject, $myLimit);
	}

}
