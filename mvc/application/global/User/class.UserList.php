<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_LIST());

/**
 * User List
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class UserList extends BaseList { 

	/**
	 * @return User
	 */
	public function current(){
		return parent::current();
	}

	/**
	 * @param User &$myObject
	 */
	public function add(User &$myObject){
		parent::add($myObject);
	}

}
