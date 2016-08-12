<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_LIST());

/**
 * GamePlattform List
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class GamePlattformList extends BaseList { 

	/**
	 * @return GamePlattform
	 */
	public function current(){
		return parent::current();
	}

	/**
	 * @param GamePlattform &$myObject
	 */
	public function add(GamePlattform &$myObject){
		parent::add($myObject);
	}

}
