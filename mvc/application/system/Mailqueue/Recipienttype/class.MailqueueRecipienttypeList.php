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
		return $this->list[($this->pos == 0 ? $this->pos : ($this->pos - 1))];
	}

	/**
	 * @param MailqueueRecipienttype &$myObject
	 */
	public function add(MailqueueRecipienttype &$myObject){
		$this->list[$this->pos++] = $myObject;
	}

}
?>