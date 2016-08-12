<?php
abstract class MailqueueRecipientManager extends MailqueueRecipientAbstractionLayer {

	public static final function getMailqueueRecipientObjectByPrimaryKey($primarykey){
		$myObject = parent::getMailqueueRecipientObjectBySql('primarykey = ?',array($primarykey));
		return (isset($myObject) ? $myObject : null );
	}

}

?>