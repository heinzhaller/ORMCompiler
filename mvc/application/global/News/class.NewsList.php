<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_LIST());

/**
 * News List
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class NewsList extends BaseList { 

	/**
	 * @return News
	 */
	public function current(){
		return parent::current();
	}

	/**
	 * @param News &$myObject
	 */
	public function add(News &$myObject){
		parent::add($myObject);
	}

}
