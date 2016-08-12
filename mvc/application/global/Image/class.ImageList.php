<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_LIST());

/**
 * Image List
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class ImageList extends BaseList { 

	/**
	 * @return Image
	 */
	public function current(){
		return parent::current();
	}

	/**
	 * @param Image &$myObject
	 */
	public function add(Image &$myObject){
		parent::add($myObject);
	}

}
