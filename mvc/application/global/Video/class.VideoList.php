<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_LIST());

/**
 * Video List
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class VideoList extends BaseList { 

	/**
	 * @return Video
	 */
	public function current(){
		return parent::current();
	}

	/**
	 * @param Video &$myObject
	 */
	public function add(Video &$myObject){
		parent::add($myObject);
	}

}
