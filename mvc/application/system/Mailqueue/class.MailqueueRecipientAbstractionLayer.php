<?php
abstract class MailqueueRecipientAbstractionLayer {

	protected static final function getMailqueueRecipientObjectBySql($where,array $params = null,SQLLimit $limit = null){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('MailqueueRecipient'));
		$myDataObjects = MailqueueRecipientDAO::queryWithPreparedStatementWhereCondition($where,$params,$limit);
		$myObjects = array();
		if($myDataObjects)
		foreach($myDataObjects as $object){
			$myObjects[] = self::getMailqueueRecipientObjectFromDataObject($object);
		}
		return $myObjects;
	}

	private static final function getMailqueueRecipientObjectFromDataObject(MailqueueRecipientDAO &$myDataObject){
		$myObject = new MailqueueRecipientObject();
		$myObject->setMailqueuerecipientid($myDataObject->getMailqueuerecipientid());
		$myObject->setMailqueueid($myDataObject->getMailqueueid());
		$myObject->setRecipientadress($myDataObject->getRecipientadress());
		$myObject->setRecipientname($myDataObject->getRecipientname());
		$myObject->setRecipienttype($myDataObject->getRecipienttype());
		$myObject->setStatus($myDataObject->getStatus());
		$myObject->setLasttry($myDataObject->getLasttry());
		$myObject->setTrys($myDataObject->getTrys());
		$myObject->setStatustext($myDataObject->getStatustext());
		$myObject->setTstampCreated($myDataObject->getTstampCreated());
		$myObject->setTstampModified($myDataObject->getTstampModified());
		return $myObject;
	}

	private static final function getDataObjectFromMailqueueRecipientObject(MailqueueRecipientObject &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('MailqueueRecipient'));
		$myDataObject = new MailqueueRecipientDAO();
		$myDataObject->setMailqueuerecipientid($myObject->getMailqueuerecipientid());
		$myDataObject->setMailqueueid($myObject->getMailqueueid());
		$myDataObject->setRecipientadress($myObject->getRecipientadress());
		$myDataObject->setRecipientname($myObject->getRecipientname());
		$myDataObject->setRecipienttype($myObject->getRecipienttype());
		$myDataObject->setStatus($myObject->getStatus());
		$myDataObject->setLasttry($myObject->getLasttry());
		$myDataObject->setTrys($myObject->getTrys());
		$myDataObject->setStatustext($myObject->getStatustext());
		$myDataObject->setTstampCreated($myObject->getTstampCreated());
		$myDataObject->setTstampModified($myObject->getTstampModified());
		return $myDataObject;
	}

	public static final function save(MailqueueRecipientObject &$myObject){
		$myDataObject = self::getDataObjectFromMailqueueRecipientObject($myObject);
		$myDataObject->store();
		$myObject->setMailqueuerecipientid($myDataObject->getMailqueuerecipientid());
	}

}
?>