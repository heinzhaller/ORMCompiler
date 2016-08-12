<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_LIST());

/**
 * TranslationPlaceholderContent List
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class TranslationPlaceholderContentList extends BaseList { 

	/**
	 * @return TranslationPlaceholderContent
	 */
	public function current(){
		return parent::current();
	}

	/**
	 * @param TranslationPlaceholderContent &$myObject
	 */
	public function add(TranslationPlaceholderContent &$myObject){
		parent::add($myObject);
	}

}
