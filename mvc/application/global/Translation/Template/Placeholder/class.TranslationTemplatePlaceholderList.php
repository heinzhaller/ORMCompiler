<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_LIST());

/**
 * TranslationTemplatePlaceholder List
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class TranslationTemplatePlaceholderList extends BaseList { 

	/**
	 * @return TranslationTemplatePlaceholder
	 */
	public function current(){
		return parent::current();
	}

	/**
	 * @param TranslationTemplatePlaceholder &$myObject
	 */
	public function add(TranslationTemplatePlaceholder &$myObject){
		parent::add($myObject);
	}

}
