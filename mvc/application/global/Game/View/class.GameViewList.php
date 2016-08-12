<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_LIST());

/**
 * GameView List
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class GameViewList extends BaseList { 

	/**
	 * @return GameView
	 */
	public function current(){
		return parent::current();
	}

	/**
	 * @param GameView &$myObject
	 */
	public function add(GameView &$myObject){
		parent::add($myObject);
	}

}
