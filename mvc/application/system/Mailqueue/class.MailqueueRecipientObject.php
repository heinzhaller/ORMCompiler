<?php
/**
 * Mailqueue Recipient Object
 *
 * @author Mario Rimpler
 * @copyright 2009
 */
class MailqueueRecipientObject {

	//attributes
	private $mailqueuerecipientid;
	private $mailqueueid;
	private $recipientadress;
	private $recipientname;
	private $recipienttype;
	private $status = 0;
	private $lasttry;
	private $trys = 0;
	private $statustext;
	private $tstamp_created;
	private $tstamp_modified;

	/**************************** CONSTUCTOR ****************************/
	public function __construct($email, $name, $type = MailqueueRecipienttypeKeys::TO){
		$this->setRecipientadress($email);
		$this->setRecipientname($name);
		$this->setRecipienttype($type);
	}
	
	/**************************** ATTRIBUTES ****************************/

	public function setMailqueuerecipientid($integer){
		if(empty($integer))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL);
		if(is_integer($integer)){
			$this->mailqueuerecipientid = $integer;
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('integer',$integer));
		}
	}

	public function getMailqueuerecipientid(){
		return $this->mailqueuerecipientid;
	}

	public function setMailqueueid($integer){
		if(empty($integer))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL);
		if(is_integer($integer)){
			$this->mailqueueid = $integer;
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('integer',$integer));
		}
	}

	public function getMailqueueid(){
		return $this->mailqueueid;
	}

	public function setRecipientadress($string){
		if(empty($string))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL);
		if(isset($string) AND is_string($string)){
			$this->recipientadress = $string;
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('string',$string));
		}
	}

	public function getRecipientadress(){
		return $this->recipientadress;
	}

	public function setRecipientname($string){
		if(isset($string) AND is_string($string)){
			$this->recipientname = $string;
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('string',$string));
		}
	}

	public function getRecipientname(){
		return $this->recipientname;
	}

	public function setRecipienttype($string){
		if(empty($string))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL);
		if(isset($string) AND is_string($string)){
			$this->recipienttype = $string;
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('string',$string));
		}
	}

	public function getRecipienttype(){
		return $this->recipienttype;
	}

	public function setStatus($string){
		if(empty($string))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL);
		if(isset($string) AND is_string($string)){
			$this->status = $string;
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('string',$string));
		}
	}

	public function getStatus(){
		return $this->status;
	}

	public function setLasttry($string){
		if(isset($string) AND is_string($string)){
			$this->lasttry = $string;
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('string',$string));
		}
	}

	public function getLasttry(){
		return $this->lasttry;
	}

	public function setTrys($string){
		if(empty($string))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL);
		if(isset($string) AND is_string($string)){
			$this->trys = $string;
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('string',$string));
		}
	}

	public function getTrys(){
		return $this->trys;
	}

	public function setStatustext($string){
		if(isset($string) AND is_string($string)){
			$this->statustext = $string;
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('string',$string));
		}
	}

	public function getStatustext(){
		return $this->statustext;
	}

	public function setTstampCreated($integer){
		if(empty($integer))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL);
		if(is_integer($integer)){
			$this->tstamp_created = $integer;
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('integer',$integer));
		}
	}

	public function getTstampCreated(){
		return $this->tstamp_created;
	}

	public function setTstampModified($integer){
		if(is_integer($integer) AND !is_null($integer)){
			$this->tstamp_modified = $integer;
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('integer',$integer));
		}
	}

	public function getTstampModified(){
		return $this->tstamp_modified;
	}

}

?>