<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_OBJECT());

/**
 * Mailqueue Base-Object
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class MailqueueBase extends BaseObject { 

	// references
	private $ref_mailqueue_mailtype;
	private $ref_mailqueue_recipient_list = array();

	// attributes
	private $mailqueueid;
	private $managerid;
	private $charset = 'utf-8';
	private $senderadress;
	private $sendername;
	private $mailtypename;
	private $subject;
	private $content;
	private $commentary;
	private $filepath;
	private $filename;
	private $signature;
	private $tstamp_created;
	private $tstamp_modified;

	/**************************** REFERENCES ****************************/
	/**
	 * @param MailqueueMailtype
	 */
	public function setMailtype(MailqueueMailtype &$myObject){
		$this->ref_mailqueue_mailtype = $myObject;
	}

	/**
	 * @return MailqueueMailtype
	 */
	public function getMailtype(){
		if(empty($this->ref_mailqueue_mailtype))
			$this->ref_mailqueue_mailtype = MailqueueManager::getMailqueueMailtypeByMailqueue($this);
		return $this->ref_mailqueue_mailtype;
	}

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
			$this->ref_mailqueue_recipient_list = MailqueueManager::getMailqueueRecipientListByMailqueue($this, $myLimit);
		return $this->ref_mailqueue_recipient_list;
	}

	/**************************** ATTRIBUTES ****************************/
	/**
	 * @param integer $integer
	 */
	public function setMailqueueid($integer){
		if(is_null($integer))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: mailqueueid'));
		if(is_integer($integer)){
			if( $this->mailqueueid != $integer ){
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
	 * @param integer $integer
	 */
	public function setManagerid($integer){
		if(is_integer($integer) OR is_null($integer)){
			if( $this->managerid != $integer ){
				$this->managerid = $integer;
				$this->_setModified('managerid');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: managerid | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getManagerid(){
		return $this->managerid;
	}

	/**
	 * @param string $string
	 */
	public function setCharset($string){
		if(is_null($string))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: charset'));
		if(is_string($string)){
			if( $this->charset != $string ){
				$this->charset = $string;
				$this->_setModified('charset');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: charset | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getCharset(){
		return $this->charset;
	}

	/**
	 * @param string $string
	 */
	public function setSenderadress($string){
		if(is_null($string))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: senderadress'));
		if(is_string($string)){
			if( $this->senderadress != $string ){
				$this->senderadress = $string;
				$this->_setModified('senderadress');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: senderadress | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getSenderadress(){
		return $this->senderadress;
	}

	/**
	 * @param string $string
	 */
	public function setSendername($string){
		if(is_string($string) OR is_null($string)){
			if( $this->sendername != $string ){
				$this->sendername = $string;
				$this->_setModified('sendername');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: sendername | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getSendername(){
		return $this->sendername;
	}

	/**
	 * @param string $string
	 */
	public function setMailtypename($string){
		if(is_null($string))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: mailtypename'));
		if(is_string($string)){
			if( $this->mailtypename != $string ){
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

	/**
	 * @param string $string
	 */
	public function setSubject($string){
		if(is_null($string))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: subject'));
		if(is_string($string)){
			if( $this->subject != $string ){
				$this->subject = $string;
				$this->_setModified('subject');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: subject | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getSubject(){
		return $this->subject;
	}

	/**
	 * @param string $string
	 */
	public function setContent($string){
		if(is_string($string) OR is_null($string)){
			if( $this->content != $string ){
				$this->content = $string;
				$this->_setModified('content');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: content | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getContent(){
		return $this->content;
	}

	/**
	 * @param string $string
	 */
	public function setCommentary($string){
		if(is_string($string) OR is_null($string)){
			if( $this->commentary != $string ){
				$this->commentary = $string;
				$this->_setModified('commentary');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: commentary | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getCommentary(){
		return $this->commentary;
	}

	/**
	 * @param string $string
	 */
	public function setFilepath($string){
		if(is_string($string) OR is_null($string)){
			if( $this->filepath != $string ){
				$this->filepath = $string;
				$this->_setModified('filepath');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: filepath | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getFilepath(){
		return $this->filepath;
	}

	/**
	 * @param string $string
	 */
	public function setFilename($string){
		if(is_string($string) OR is_null($string)){
			if( $this->filename != $string ){
				$this->filename = $string;
				$this->_setModified('filename');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: filename | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getFilename(){
		return $this->filename;
	}

	/**
	 * @param string $string
	 */
	public function setSignature($string){
		if(is_string($string) OR is_null($string)){
			if( $this->signature != $string ){
				$this->signature = $string;
				$this->_setModified('signature');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: signature | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getSignature(){
		return $this->signature;
	}

	/**
	 * @param integer $integer
	 */
	public function setTstampCreated($integer){
		if(is_null($integer))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: tstamp_created'));
		if(is_integer($integer)){
			if( $this->tstamp_created != $integer ){
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
			if( $this->tstamp_modified != $integer ){
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
?>