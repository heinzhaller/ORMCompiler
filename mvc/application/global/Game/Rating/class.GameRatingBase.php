<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_OBJECT());

/**
 * GameRating Base-Object
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class GameRatingBase extends BaseObject { 

	// references
	private $ref_game;

	// attributes
	private $gameratingid;
	private $gameid;
	private $ip;
	private $rating;
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
			$this->setGame(GameRatingManager::getGameByGameRating($this));
		return $this->ref_game;
	}

	/**************************** ATTRIBUTES ****************************/
	/**
	 * @param integer $integer
	 */
	public function setGameratingid($integer){
		if(is_null($integer))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: gameratingid'));
		if(is_integer($integer)){
			if( $this->gameratingid !== $integer ){
				$this->gameratingid = $integer;
				$this->_setModified('gameratingid');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: gameratingid | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getGameratingid(){
		return $this->gameratingid;
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
	 * @param integer $integer
	 */
	public function setRating($integer){
		if(is_null($integer))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: rating'));
		if(is_integer($integer)){
			if( $this->rating !== $integer ){
				$this->rating = $integer;
				$this->_setModified('rating');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: rating | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getRating(){
		return $this->rating;
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
