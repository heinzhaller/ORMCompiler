<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_OBJECT());

/**
 * MailqueueMailtype Base-Object
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class MailqueueMailtypeBase extends BaseObject { 

	// references
	private $ref_mailqueue_list = array();

	// attributes
	private $mailtypename;

	/**************************** REFERENCES ****************************/
	/**
	 * @param MailqueueList
	 */
	public function setMailqueueList(MailqueueList &$myObject){
		$this->ref_mailqueue_list = $myObject;
		$this->_setIsLoaded('ref_mailqueue_list');
	}

	/**
	 * @return MailqueueList
	 */
	public function getMailqueueList(SQLLimit &$myLimit = null){
		if( !$this->_getIsLoaded('ref_mailqueue_list') )
			$this->setMailqueueList(MailqueueMailtypeManager::getMailqueueListByMailqueueMailtype($this, $myLimit));
		return $this->ref_mailqueue_list;
	}

	/**************************** ATTRIBUTES ****************************/
	/**
	 * @param string $string
	 */
	public function setMailtypename($string){
		if(is_null($string))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: mailtypename'));
		if(is_string($string)){
			if( $this->mailtypename !== $string ){
				$this->mailtypename = $string;
				$this->_setModified('mailtypename');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: mailtypename | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getMailtypename(){
		return $this->mailtypename;
	}

}
