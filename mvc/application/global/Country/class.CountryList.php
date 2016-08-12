<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_LIST());

/**
 * Country List
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class CountryList extends BaseList { 

	/**
	 * @return Country
	 */
	public function current(){
		return parent::current();
	}

	/**
	 * @param Country &$myObject
	 */
	public function add(Country &$myObject){
		parent::add($myObject);
	}

}
