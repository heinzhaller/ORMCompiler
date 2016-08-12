<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_LIST());

/**
 * MailqueueMailtype List
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class MailqueueMailtypeList extends BaseList { 

	/**
	 * @return MailqueueMailtype
	 */
	public function current(){
		return parent::current();
	}

	/**
	 * @param MailqueueMailtype &$myObject
	 */
	public function add(MailqueueMailtype &$myObject){
		parent::add($myObject);
	}

}
