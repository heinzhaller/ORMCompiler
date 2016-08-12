<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_LIST());

/**
 * Category List
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class CategoryList extends BaseList { 

	/**
	 * @return Category
	 */
	public function current(){
		return parent::current();
	}

	/**
	 * @param Category &$myObject
	 */
	public function add(Category &$myObject){
		parent::add($myObject);
	}

}
