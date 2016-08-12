<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_LIST());

/**
 * Commentary List
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class CommentaryList extends BaseList { 

	/**
	 * @return Commentary
	 */
	public function current(){
		return parent::current();
	}

	/**
	 * @param Commentary &$myObject
	 */
	public function add(Commentary &$myObject){
		parent::add($myObject);
	}

}
