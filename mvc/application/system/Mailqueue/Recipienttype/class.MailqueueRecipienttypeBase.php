<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_OBJECT());

/**
 * MailqueueRecipienttype Base-Object
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class MailqueueRecipienttypeBase extends BaseObject { 

	// references
	private $ref_mailqueue_recipient_list = array();

	// attributes
	private $typename;

	/**************************** REFERENCES ****************************/
	/**
	 * @param MailqueueRecipientList
	 */
	public function setRecipientList(MailqueueRecipientList &$myObject){
		$this->ref_mailqueue_recipient_list = $myObject;
	}

	/**
	 * @return MailqueueRecipientList
	 */
	public function getRecipientList(SQLLimit &$myLimit = null){
		if(empty($this->ref_mailqueue_recipient_list))
			$this->ref_mailqueue_recipient_list = MailqueueRecipienttypeManager::getMailqueueRecipientListByMailqueueRecipienttype($this, $myLimit);
		return $this->ref_mailqueue_recipient_list;
	}

	/**************************** ATTRIBUTES ****************************/
	/**
	 * @param string $string
	 */
	public function setTypename($string){
		if(is_null($string))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: typename'));
		if(is_string($string)){
			if( $this->typename != $string ){
				$this->typename = $string;
				$this->_setModified('typename');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: typename | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getTypename(){
		return $this->typename;
	}

}
?>