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
		return $this->list[($this->pos == 0 ? $this->pos : ($this->pos - 1))];
	}

	/**
	 * @param MailqueueRecipient &$myObject
	 */
	public function add(MailqueueRecipient &$myObject){
		$this->list[$this->pos++] = $myObject;
	}

}
?>