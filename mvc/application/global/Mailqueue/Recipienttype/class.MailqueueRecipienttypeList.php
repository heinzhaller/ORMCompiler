<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_LIST());

/**
 * MailqueueRecipienttype List
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class MailqueueRecipienttypeList extends BaseList { 

	/**
	 * @return MailqueueRecipienttype
	 */
	public function current(){
		return parent::current();
	}

	/**
	 * @param MailqueueRecipienttype &$myObject
	 */
	public function add(MailqueueRecipienttype &$myObject){
		parent::add($myObject);
	}

}
