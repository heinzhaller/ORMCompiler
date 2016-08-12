<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_LIST());

/**
 * GameHistory List
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class GameHistoryList extends BaseList { 

	/**
	 * @return GameHistory
	 */
	public function current(){
		return parent::current();
	}

	/**
	 * @param GameHistory &$myObject
	 */
	public function add(GameHistory &$myObject){
		parent::add($myObject);
	}

}
