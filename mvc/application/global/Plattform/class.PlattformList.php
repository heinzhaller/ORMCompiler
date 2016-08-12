<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_LIST());

/**
 * Plattform List
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class PlattformList extends BaseList { 

	/**
	 * @return Plattform
	 */
	public function current(){
		return parent::current();
	}

	/**
	 * @param Plattform &$myObject
	 */
	public function add(Plattform &$myObject){
		parent::add($myObject);
	}

}
