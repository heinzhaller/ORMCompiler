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
		return $this->list[($this->pos == 0 ? $this->pos : ($this->pos - 1))];
	}

	/**
	 * @param Mailqueue &$myObject
	 */
	public function add(Mailqueue &$myObject){
		$this->list[$this->pos++] = $myObject;
	}

}
?>