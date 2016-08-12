<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_LIST());

/**
 * Mailqueue List
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class MailqueueList extends BaseList { 

	/**
	 * @return Mailqueue
	 */
	public function current(){
		return parent::current();
	}

	/**
	 * @param Mailqueue &$myObject
	 */
	public function add(Mailqueue &$myObject){
		parent::add($myObject);
	}

}
