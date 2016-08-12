<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_OBJECT());

/**
 * GameHistory Base-Object
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class GameHistoryBase extends BaseObject { 

	// references
	private $ref_game;
	private $ref_user;

	// attributes
	private $gamehistoryid;
	private $gameid;
	private $userid;
	private $infotext;
	private $tstamp_created;

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
			$this->setGame(GameHistoryManager::getGameByGameHistory($this));
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
			$this->setUser(GameHistoryManager::getUserByGameHistory($this));
		return $this->ref_user;
	}

	/**************************** ATTRIBUTES ****************************/
	/**
	 * @param integer $integer
	 */
	public function setGamehistoryid($integer){
		if(is_null($integer))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: gamehistoryid'));
		if(is_integer($integer)){
			if( $this->gamehistoryid !== $integer ){
				$this->gamehistoryid = $integer;
				$this->_setModified('gamehistoryid');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: gamehistoryid | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getGamehistoryid(){
		return $this->gamehistoryid;
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
	public function setInfotext($string){
		if(is_string($string) OR is_null($string)){
			if( $this->infotext !== $string ){
				$this->infotext = $string;
				$this->_setModified('infotext');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: infotext | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getInfotext(){
		return $this->infotext;
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

}
