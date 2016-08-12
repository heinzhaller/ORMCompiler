<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_LIST());

/**
 * GameRating List
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class GameRatingList extends BaseList { 

	/**
	 * @return GameRating
	 */
	public function current(){
		return parent::current();
	}

	/**
	 * @param GameRating &$myObject
	 */
	public function add(GameRating &$myObject){
		parent::add($myObject);
	}

}
