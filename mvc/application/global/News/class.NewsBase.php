<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_OBJECT());

/**
 * News Base-Object
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class NewsBase extends BaseObject { 

	// references
	private $ref_game;
	private $ref_user;

	// attributes
	private $newsid;
	private $tstamp_created;
	private $tstamp_modified;
	private $tstamp_deleted;
	private $gameid;
	private $content;
	private $title;
	private $userid;

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
			$this->setGame(NewsManager::getGameByNews($this));
		return $this->ref_game;
	}

	/**
	 * @param User
	 */
	public function setUser(User &$myObject){
		$this->ref_user = $myObject;
			$this->setUserid($myObject->getUserid());
		$this->_setIsLoaded('ref_user');
	}

	/**
	 * @return User
	 */
	public function getUser(){
		if( !$this->_getIsLoaded('ref_user') )
			$this->setUser(NewsManager::getUserByNews($this));
		return $this->ref_user;
	}

	/**************************** ATTRIBUTES ****************************/
	/**
	 * @param integer $integer
	 */
	public function setNewsid($integer){
		if(is_null($integer))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: newsid'));
		if(is_integer($integer)){
			if( $this->newsid !== $integer ){
				$this->newsid = $integer;
				$this->_setModified('newsid');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: newsid | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getNewsid(){
		return $this->newsid;
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

	/**
	 * @param string $string
	 */
	public function setContent($string){
		if(is_string($string) OR is_null($string)){
			if( $this->content !== $string ){
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
	public function setTitle($string){
		if(is_string($string) OR is_null($string)){
			if( $this->title !== $string ){
				$this->title = $string;
				$this->_setModified('title');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: title | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getTitle(){
		return $this->title;
	}

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

}
