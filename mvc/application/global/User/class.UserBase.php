<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_OBJECT());

/**
 * User Base-Object
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class UserBase extends BaseObject { 

	// references
	private $ref_game_list = array();
	private $ref_game_history_list = array();
	private $ref_mailqueue_list = array();
	private $ref_news_list = array();

	// attributes
	private $userid;
	private $username;
	private $password;
	private $email;
	private $tstamp_created;
	private $tstamp_modified;
	private $tstamp_deleted;
	private $statusname;
	private $tstamp_confirmed;

	/**************************** REFERENCES ****************************/
	/**
	 * @param GameList
	 */
	public function setGameList(GameList &$myObject){
		$this->ref_game_list = $myObject;
		$this->_setIsLoaded('ref_game_list');
	}

	/**
	 * @return GameList
	 */
	public function getGameList(SQLLimit &$myLimit = null){
		if( !$this->_getIsLoaded('ref_game_list') )
			$this->setGameList(UserManager::getGameListByUser($this, $myLimit));
		return $this->ref_game_list;
	}

	/**
	 * @param GameHistoryList
	 */
	public function setHistoryList(GameHistoryList &$myObject){
		$this->ref_game_history_list = $myObject;
		$this->_setIsLoaded('ref_game_history_list');
	}

	/**
	 * @return GameHistoryList
	 */
	public function getHistoryList(SQLLimit &$myLimit = null){
		if( !$this->_getIsLoaded('ref_game_history_list') )
			$this->setHistoryList(UserManager::getHistoryListByUser($this, $myLimit));
		return $this->ref_game_history_list;
	}

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
			$this->setMailqueueList(UserManager::getMailqueueListByUser($this, $myLimit));
		return $this->ref_mailqueue_list;
	}

	/**
	 * @param NewsList
	 */
	public function setNewsList(NewsList &$myObject){
		$this->ref_news_list = $myObject;
		$this->_setIsLoaded('ref_news_list');
	}

	/**
	 * @return NewsList
	 */
	public function getNewsList(SQLLimit &$myLimit = null){
		if( !$this->_getIsLoaded('ref_news_list') )
			$this->setNewsList(UserManager::getNewsListByUser($this, $myLimit));
		return $this->ref_news_list;
	}

	/**************************** ATTRIBUTES ****************************/
	/**
	 * @param integer $integer
	 */
	public function setUserid($integer){
		if(is_null($integer))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: userid'));
		if(is_integer($integer)){
			if( $this->userid !== $integer ){
				$this->userid = $integer;
				$this->_setModified('userid');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: userid | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getUserid(){
		return $this->userid;
	}

	/**
	 * @param string $string
	 */
	public function setUsername($string){
		if(is_null($string))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: username'));
		if(is_string($string)){
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
	public function setPassword($string){
		if(is_string($string) OR is_null($string)){
			if( $this->password !== $string ){
				$this->password = $string;
				$this->_setModified('password');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: password | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getPassword(){
		return $this->password;
	}

	/**
	 * @param string $string
	 */
	public function setEmail($string){
		if(is_string($string) OR is_null($string)){
			if( $this->email !== $string ){
				$this->email = $string;
				$this->_setModified('email');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: email | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getEmail(){
		return $this->email;
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
	 * @param string $string
	 */
	public function setStatusname($string){
		if(is_string($string) OR is_null($string)){
			if( $this->statusname !== $string ){
				$this->statusname = $string;
				$this->_setModified('statusname');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: statusname | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getStatusname(){
		return $this->statusname;
	}

	/**
	 * @param integer $integer
	 */
	public function setTstampConfirmed($integer){
		if(is_integer($integer) OR is_null($integer)){
			if( $this->tstamp_confirmed !== $integer ){
				$this->tstamp_confirmed = $integer;
				$this->_setModified('tstamp_confirmed');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: tstamp_confirmed | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getTstampConfirmed(){
		return $this->tstamp_confirmed;
	}

}
