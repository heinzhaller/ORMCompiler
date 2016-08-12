<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_LIST());

/**
 * GameTag List
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class GameTagList extends BaseList { 

	/**
	 * @return GameTag
	 */
	public function current(){
		return parent::current();
	}

	/**
	 * @param GameTag &$myObject
	 */
	public function add(GameTag &$myObject){
		parent::add($myObject);
	}

}
