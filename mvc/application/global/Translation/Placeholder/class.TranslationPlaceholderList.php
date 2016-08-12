<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_LIST());

/**
 * TranslationPlaceholder List
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class TranslationPlaceholderList extends BaseList { 

	/**
	 * @return TranslationPlaceholder
	 */
	public function current(){
		return parent::current();
	}

	/**
	 * @param TranslationPlaceholder &$myObject
	 */
	public function add(TranslationPlaceholder &$myObject){
		parent::add($myObject);
	}

}
