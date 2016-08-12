<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_LIST());

/**
 * Game List
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class GameList extends BaseList { 

	/**
	 * @return Game
	 */
	public function current(){
		return parent::current();
	}

	/**
	 * @param Game &$myObject
	 */
	public function add(Game &$myObject){
		parent::add($myObject);
	}

}
