<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_LIST());

/**
 * MailqueueRecipient List
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class MailqueueRecipientList extends BaseList { 

	/**
	 * @return MailqueueRecipient
	 */
	public function current(){
		return parent::current();
	}

	/**
	 * @param MailqueueRecipient &$myObject
	 */
	public function add(MailqueueRecipient &$myObject){
		parent::add($myObject);
	}

}
