<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_LIST());

/**
 * GameIn List
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class GameInList extends BaseList { 

	/**
	 * @return GameIn
	 */
	public function current(){
		return parent::current();
	}

	/**
	 * @param GameIn &$myObject
	 */
	public function add(GameIn &$myObject){
		parent::add($myObject);
	}

}
