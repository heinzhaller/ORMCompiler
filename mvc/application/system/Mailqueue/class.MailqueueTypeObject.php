<?php
/**
 * Mailqueue Type Object
 *
 * @author Mario Rimpler
 * @copyright 2009
 */
class MailqueueTypeObject {
	
	private $typeid;
	private $decription;
	
	public function setTypeid($int) {
		$this->typeid = (int) $int;
	}
	
	public function getTypeid() {
		return $this->typeid;  		
	}
	
	public function setDescription($string) {
		$this->decription = (string) $string;
	}
	
	public function getDescription() {
		return $this->decription;  		
	}
	
}
?>