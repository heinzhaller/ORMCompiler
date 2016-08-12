<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_LIST());

/**
 * GameCategory List
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class GameCategoryList extends BaseList { 

	/**
	 * @return GameCategory
	 */
	public function current(){
		return parent::current();
	}

	/**
	 * @param GameCategory &$myObject
	 */
	public function add(GameCategory &$myObject){
		parent::add($myObject);
	}

}
