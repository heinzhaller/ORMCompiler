<?php
#ä
/**
 * Country Base-Manager
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class CountryBaseManager extends CountryAbstractionLayer { 

	/**************************** ATTRIBUTES ****************************/
	const COUNTRYISO2 = 'countryiso2';
	const DESCRIPTION = 'description';
	const HAS_CLUBS = 'has_clubs';

	/**************************** SELECT METHODS ****************************/
	/**
	 * @param SQLLimit &$myLimit
	 * @return CountryList
	 */
	public static final function getCountryList(SQLLimit &$myLimit = null){
		return parent::getCountryListBySql('1 = 1', null, $myLimit);
	}

	/**
	 * @param string $countryiso2
	 * @param SQLLimit &$myLimit
	 * @return Country or null
	 */
	public static final function getCountryByCountryiso2($countryiso2, SQLLimit &$myLimit = null){
		$myObject = parent::getCountryListBySql(self::COUNTRYISO2.' = ?', array($countryiso2), $myLimit);
		return ( $myObject->valid() ? $myObject->current() : null );
	}

	/**
	 * @param string $description
	 * @param SQLLimit &$myLimit
	 * @return CountryList
	 */
	public static final function getCountryListByDescription($description, SQLLimit &$myLimit = null){
		return parent::getCountryListBySql(self::DESCRIPTION.' = ?', array($description), $myLimit);
	}

	/**
	 * @param integer $has_clubs
	 * @param SQLLimit &$myLimit
	 * @return CountryList
	 */
	public static final function getCountryListByHasClubs($has_clubs, SQLLimit &$myLimit = null){
		return parent::getCountryListBySql(self::HAS_CLUBS.' = ?', array($has_clubs), $myLimit);
	}

	/**************************** REFERENCES ****************************/
	/**
	 * @param Language &$myObject
	 * @return CountryList
	 */
	public static final function getCountryListByLanguage(Language &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_COUNTRY_LANGUAGE());
		$myList = CountryLanguageManager::getCountryLanguageListByLanguage($myObject, $myLimit);
		$myCountryList = new CountryList();
		foreach($myList as $item)
			$myCountryList->add(self::getCountryByCountryiso2($item->getCountryiso2()));
		return $myCountryList;
	}

	/**
	 * @param Country &$myCountry
	 * @return LanguageList
	 */
	public static final function getLanguageListByCountry(Country &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_LANGUAGE());
		return LanguageManager::getLanguageListByCountry($myObject, $myLimit);
	}

}
