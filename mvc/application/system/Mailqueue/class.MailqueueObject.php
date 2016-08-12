<?php
/**
 * Mailqueue Main Object
 *
 * @author Mario Rimpler
 * @copyright 2009
 */
class MailqueueObject extends MailqueueBase {
	
	public function send(){
		MailqueueManager::save($this);
	}
}
?>