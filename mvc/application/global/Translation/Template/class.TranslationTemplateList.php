<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_LIST());

/**
 * TranslationTemplate List
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class TranslationTemplateList extends BaseList { 

	/**
	 * @return TranslationTemplate
	 */
	public function current(){
		return parent::current();
	}

	/**
	 * @param TranslationTemplate &$myObject
	 */
	public function add(TranslationTemplate &$myObject){
		parent::add($myObject);
	}

}
