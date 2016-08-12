<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_OBJECT());

/**
 * MailqueueRecipient Base-Object
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class MailqueueRecipientBase extends BaseObject { 

	// references
	private $ref_mailqueue;
	private $ref_mailqueue_recipienttype;

	// attributes
	private $mailqueuerecipientid;
	private $mailqueueid;
	private $recipientadress;
	private $recipientname;
	private $typename;
	private $status = 0;
	private $lasttry;
	private $trys = 0;
	private $statustext;
	private $tstamp_created;
	private $tstamp_modified;

	/**************************** REFERENCES ****************************/
	/**
	 * @param Mailqueue
	 */
	public function setMailqueue(Mailqueue &$myObject){
		$this->ref_mailqueue = $myObject;
			$this->setMailqueueid($myObject->getMailqueueid());
		$this->_setIsLoaded('ref_mailqueue');
	}

	/**
	 * @return Mailqueue
	 */
	public function getMailqueue(){
		if( !$this->_getIsLoaded('ref_mailqueue') )
			$this->setMailqueue(MailqueueRecipientManager::getMailqueueByMailqueueRecipient($this));
		return $this->ref_mailqueue;
	}

	/**
	 * @param MailqueueRecipienttype
	 */
	public function setRecipienttype(MailqueueRecipienttype &$myObject){
		$this->ref_mailqueue_recipienttype = $myObject;
			$this->setTypename($myObject->getTypename());
		$this->_setIsLoaded('ref_mailqueue_recipienttype');
	}

	/**
	 * @return MailqueueRecipienttype
	 */
	public function getRecipienttype(){
		if( !$this->_getIsLoaded('ref_mailqueue_recipienttype') )
			$this->setRecipienttype(MailqueueRecipientManager::getRecipienttypeByMailqueueRecipient($this));
		return $this->ref_mailqueue_recipienttype;
	}

	/**************************** ATTRIBUTES ****************************/
	/**
	 * @param integer $integer
	 */
	public function setMailqueuerecipientid($integer){
		if(is_null($integer))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: mailqueuerecipientid'));
		if(is_integer($integer)){
			if( $this->mailqueuerecipientid !== $integer ){
				$this->mailqueuerecipientid = $integer;
				$this->_setModified('mailqueuerecipientid');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: mailqueuerecipientid | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getMailqueuerecipientid(){
		return $this->mailqueuerecipientid;
	}

	/**
	 * @param integer $integer
	 */
	public function setMailqueueid($integer){
		if(is_null($integer))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: mailqueueid'));
		if(is_integer($integer)){
			if( $this->mailqueueid !== $integer ){
				$this->mailqueueid = $integer;
				$this->_setModified('mailqueueid');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: mailqueueid | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getMailqueueid(){
		return $this->mailqueueid;
	}

	/**
	 * @param string $string
	 */
	public function setRecipientadress($string){
		if(is_null($string))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: recipientadress'));
		if(is_string($string)){
			if( $this->recipientadress !== $string ){
				$this->recipientadress = $string;
				$this->_setModified('recipientadress');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: recipientadress | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getRecipientadress(){
		return $this->recipientadress;
	}

	/**
	 * @param string $string
	 */
	public function setRecipientname($string){
		if(is_string($string) OR is_null($string)){
			if( $this->recipientname !== $string ){
				$this->recipientname = $string;
				$this->_setModified('recipientname');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: recipientname | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getRecipientname(){
		return $this->recipientname;
	}

	/**
	 * @param string $string
	 */
	public function setTypename($string){
		if(is_null($string))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: typename'));
		if(is_string($string)){
			if( $this->typename !== $string ){
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

	/**
	 * @param integer $integer
	 */
	public function setStatus($integer){
		if(is_null($integer))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: status'));
		if(is_integer($integer)){
			if( $this->status !== $integer ){
				$this->status = $integer;
				$this->_setModified('status');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: status | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getStatus(){
		return $this->status;
	}

	/**
	 * @param integer $integer
	 */
	public function setLasttry($integer){
		if(is_integer($integer) OR is_null($integer)){
			if( $this->lasttry !== $integer ){
				$this->lasttry = $integer;
				$this->_setModified('lasttry');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: lasttry | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getLasttry(){
		return $this->lasttry;
	}

	/**
	 * @param integer $integer
	 */
	public function setTrys($integer){
		if(is_null($integer))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: trys'));
		if(is_integer($integer)){
			if( $this->trys !== $integer ){
				$this->trys = $integer;
				$this->_setModified('trys');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: trys | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getTrys(){
		return $this->trys;
	}

	/**
	 * @param string $string
	 */
	public function setStatustext($string){
		if(is_string($string) OR is_null($string)){
			if( $this->statustext !== $string ){
				$this->statustext = $string;
				$this->_setModified('statustext');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: statustext | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getStatustext(){
		return $this->statustext;
	}

	/**
	 * @param integer $integer
	 */
	public function setTstampCreated($integer){
		if(is_null($integer))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: tstamp_created'));
		if(is_integer($integer)){
			if( $this->tstamp_created !== $integer ){
				$this->tstamp_created = $integer;
				$this->_setModified('tstamp_created');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: tstamp_created | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getTstampCreated(){
		return $this->tstamp_created;
	}

	/**
	 * @param integer $integer
	 */
	public function setTstampModified($integer){
		if(is_integer($integer) OR is_null($integer)){
			if( $this->tstamp_modified !== $integer ){
				$this->tstamp_modified = $integer;
				$this->_setModified('tstamp_modified');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: tstamp_modified | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getTstampModified(){
		return $this->tstamp_modified;
	}

}
