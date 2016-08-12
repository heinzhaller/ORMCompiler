<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_OBJECT());

/**
 * Commentary Base-Object
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class CommentaryBase extends BaseObject { 

	// references
	private $ref_game;

	// attributes
	private $commentaryid;
	private $parent_commentaryid;
	private $username;
	private $ip;
	private $message;
	private $tstamp_created;
	private $tstamp_modified;
	private $tstamp_deleted;
	private $gameid;

	/**************************** REFERENCES ****************************/
	/**
	 * @param Game
	 */
	public function setGame(Game &$myObject){
		$this->ref_game = $myObject;
			$this->setGameid($myObject->getGameid());
		$this->_setIsLoaded('ref_game');
	}

	/**
	 * @return Game
	 */
	public function getGame(){
		if( !$this->_getIsLoaded('ref_game') )
			$this->setGame(CommentaryManager::getGameByCommentary($this));
		return $this->ref_game;
	}

	/**************************** ATTRIBUTES ****************************/
	/**
	 * @param integer $integer
	 */
	public function setCommentaryid($integer){
		if(is_null($integer))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: commentaryid'));
		if(is_integer($integer)){
			if( $this->commentaryid !== $integer ){
				$this->commentaryid = $integer;
				$this->_setModified('commentaryid');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: commentaryid | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getCommentaryid(){
		return $this->commentaryid;
	}

	/**
	 * @param integer $integer
	 */
	public function setParentCommentaryid($integer){
		if(is_integer($integer) OR is_null($integer)){
			if( $this->parent_commentaryid !== $integer ){
				$this->parent_commentaryid = $integer;
				$this->_setModified('parent_commentaryid');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: parent_commentaryid | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getParentCommentaryid(){
		return $this->parent_commentaryid;
	}

	/**
	 * @param string $string
	 */
	public function setUsername($string){
		if(is_string($string) OR is_null($string)){
			if( $this->username !== $string ){
				$this->username = $string;
				$this->_setModified('username');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: username | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getUsername(){
		return $this->username;
	}

	/**
	 * @param string $string
	 */
	public function setIp($string){
		if(is_string($string) OR is_null($string)){
			if( $this->ip !== $string ){
				$this->ip = $string;
				$this->_setModified('ip');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: ip | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getIp(){
		return $this->ip;
	}

	/**
	 * @param string $string
	 */
	public function setMessage($string){
		if(is_string($string) OR is_null($string)){
			if( $this->message !== $string ){
				$this->message = $string;
				$this->_setModified('message');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: message | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getMessage(){
		return $this->message;
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

	/**
	 * @param integer $integer
	 */
	public function setTstampDeleted($integer){
		if(is_integer($integer) OR is_null($integer)){
			if( $this->tstamp_deleted !== $integer ){
				$this->tstamp_deleted = $integer;
				$this->_setModified('tstamp_deleted');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: tstamp_deleted | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getTstampDeleted(){
		return $this->tstamp_deleted;
	}

	/**
	 * @param integer $integer
	 */
	public function setGameid($integer){
		if(is_null($integer))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: gameid'));
		if(is_integer($integer)){
			if( $this->gameid !== $integer ){
				$this->gameid = $integer;
				$this->_setModified('gameid');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: gameid | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getGameid(){
		return $this->gameid;
	}

}
