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
		return $this->list[($this->pos == 0 ? $this->pos : ($this->pos - 1))];
	}

	/**
	 * @param MailqueueMailtype &$myObject
	 */
	public function add(MailqueueMailtype &$myObject){
		$this->list[$this->pos++] = $myObject;
	}

}
?>