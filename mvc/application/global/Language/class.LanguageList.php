<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_LIST());

/**
 * Language List
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class LanguageList extends BaseList { 

	/**
	 * @return Language
	 */
	public function current(){
		return parent::current();
	}

	/**
	 * @param Language &$myObject
	 */
	public function add(Language &$myObject){
		parent::add($myObject);
	}

}
