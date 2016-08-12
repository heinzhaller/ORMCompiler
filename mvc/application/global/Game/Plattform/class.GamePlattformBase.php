<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_OBJECT());

/**
 * GamePlattform Base-Object
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class GamePlattformBase extends BaseObject { 

	// references
	private $ref_plattform_list = array();
	private $ref_game_list = array();

	// attributes
	private $gameid;
	private $plattformid;

	/**************************** REFERENCES ****************************/
	/**
	 * @param PlattformList
	 */
	public function setPlattformList(PlattformList &$myObject){
		$this->ref_plattform_list = $myObject;
		$this->_setIsLoaded('ref_plattform_list');
	}

	/**
	 * @return PlattformList
	 */
	public function getPlattformList(SQLLimit &$myLimit = null){
		if( !$this->_getIsLoaded('ref_plattform_list') )
			$this->setPlattformList(GamePlattformManager::getPlattformListByGamePlattform($this, $myLimit));
		return $this->ref_plattform_list;
	}

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
			$this->setGameList(GamePlattformManager::getGameListByGamePlattform($this, $myLimit));
		return $this->ref_game_list;
	}

	/**************************** ATTRIBUTES ****************************/
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
	public function setPlattformid($integer){
		if(is_null($integer))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: plattformid'));
		if(is_integer($integer)){
			if( $this->plattformid !== $integer ){
				$this->plattformid = $integer;
				$this->_setModified('plattformid');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: plattformid | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getPlattformid(){
		return $this->plattformid;
	}

}
