<?php
/**
 * Mailqueue API
 *
 * @author Mario Rimpler
 * @copyright 2009-04-09
 */
abstract class MailqueueAPI {
	
	private static final function unserializeMailqueueObeject($serialized_string){
		include_once '/home/workspace/webglobal/com.sfy.modules/MailqueueModule/class.MailqueueObject.php';
		$myObject = unserialize($serialized_string);
		
		if(is_object($myObject) AND get_class($myObject) == 'MailqueueObject')
			return $myObject;
	}
	
	private static final function unserializeMailqueueRecipientObeject($serialized_string){
		include_once '/home/workspace/webglobal/com.sfy.modules/MailqueueModule/class.MailqueueRecipientObject.php';
		$myObject = unserialize($serialized_string);
		
		if(is_object($myObject) AND get_class($myObject) == 'MailqueueRecipientObject')
			return $myObject;
	}
	
	private static final function copyMailqueueObjectToMailqueueDAO(MailqueueObject $myMailqueueObject){
		require_once('/home/workspace/webglobal/com.sfy.webglobal.database.ormbase/class.ProspectApplAnswerMailMailqueueDAO.php');
		$myMailqueue = new ProspectApplAnswerMailMailqueueDAO();
		$myMailqueue->setCharset($myMailqueueObject->getCharset());
		$myMailqueue->setLpuid($myMailqueueObject->getPartnerid());
		$myMailqueue->setMailsender($myMailqueueObject->getMailsenderAddress());
		$myMailqueue->setMailsendername($myMailqueueObject->getMailsenderName());
		$myMailqueue->setMailtypid($myMailqueueObject->getMailtypeid());
		$myMailqueue->setMailtext($myMailqueueObject->getMailContent());
		$myMailqueue->setMailsubject($myMailqueueObject->getMailSubject());
		$myMailqueue->setSignature($myMailqueueObject->getSignature());
		$myMailqueue->setSprache($myMailqueueObject->getLanguageiso2());
		$myMailqueue->setFilename($myMailqueueObject->getFileName());
		$myMailqueue->setFilepath($myMailqueueObject->getFilePath());
		$myMailqueue->setInternerkommentar($myMailqueueObject->getComment());
		return $myMailqueue;
	}
	
	private static final function copyMailqueueRecipientToMailqueueRecipientDAO(MailqueueRecipientObject $recipient, $uniqueid){
		require_once('/home/workspace/webglobal/com.sfy.webglobal.database.ormbase/class.ProspectApplAnswerMailMailqueueRecipientsDAO.php');
		$myRecipient = new ProspectApplAnswerMailMailqueueRecipientsDAO();
		$myRecipient->setMailqueueuid((int)$uniqueid);
		$myRecipient->setRecipientaddress($recipient->getRecipientAddress());
		$myRecipient->setRecipientname($recipient->getRecipientName());
		$myRecipient->setRecipienttype($recipient->getRecipientType());
		$myRecipient->setLasttry(null);
		$myRecipient->setStatustext(null);
		$myRecipient->setStatus(0);
		$myRecipient->setTrys(0);
		return $myRecipient;
	}
	
	public static final function sendMailqueueFromCurlSession($mailbody, array $recipients){
		include_once '/home/workspace/webglobal/com.sfy.modules/MailqueueModule/class.MailqueueObject.php';
		
		$myMailqueueObject = self::unserializeMailqueueObeject(stripslashes($mailbody));
		foreach ( $recipients as $reciepient ){
			$myRecipientObjects[] = self::unserializeMailqueueRecipientObeject(stripslashes($reciepient));
		}
		
		return self::sendMailqueue($myMailqueueObject,$myRecipientObjects);
	}
	
	public static final function sendMailqueue(MailqueueObject $myMailqueueObject, array $myMailqueueRecipients){
		// add mailcontent
		$myMailqueue = self::copyMailqueueObjectToMailqueueDAO($myMailqueueObject);
		$myMailqueue->store();

		// add recipient
		foreach ( $myMailqueueRecipients as $recipient ){
			$myRecipient = self::copyMailqueueRecipientToMailqueueRecipientDAO($recipient,(int)$myMailqueue->getUid());
			$myRecipient->store();
		}
		
		return $myMailqueue->getUid();
	}
	
}
?>