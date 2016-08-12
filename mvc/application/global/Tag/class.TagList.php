<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_LIST());

/**
 * Tag List
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class TagList extends BaseList { 

	/**
	 * @return Tag
	 */
	public function current(){
		return parent::current();
	}

	/**
	 * @param Tag &$myObject
	 */
	public function add(Tag &$myObject){
		parent::add($myObject);
	}

}
