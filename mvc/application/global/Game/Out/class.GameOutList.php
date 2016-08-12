<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_LIST());

/**
 * GameOut List
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class GameOutList extends BaseList { 

	/**
	 * @return GameOut
	 */
	public function current(){
		return parent::current();
	}

	/**
	 * @param GameOut &$myObject
	 */
	public function add(GameOut &$myObject){
		parent::add($myObject);
	}

}
