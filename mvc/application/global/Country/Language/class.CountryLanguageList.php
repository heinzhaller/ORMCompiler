<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_LIST());

/**
 * CountryLanguage List
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class CountryLanguageList extends BaseList { 

	/**
	 * @return CountryLanguage
	 */
	public function current(){
		return parent::current();
	}

	/**
	 * @param CountryLanguage &$myObject
	 */
	public function add(CountryLanguage &$myObject){
		parent::add($myObject);
	}

}
