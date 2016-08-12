<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_OBJECT());

/**
 * Plattform Base-Object
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class PlattformBase extends BaseObject { 

	// references
	private $ref_game_list = array();

	// attributes
	private $plattformid;
	private $name;
	private $sortorder = 1;

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
			$this->setGameList(PlattformManager::getGameListByPlattform($this, $myLimit));
		return $this->ref_game_list;
	}

	/**************************** ATTRIBUTES ****************************/
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

	/**
	 * @param string $string
	 */
	public function setName($string){
		if(is_null($string))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: name'));
		if(is_string($string)){
			if( $this->name !== $string ){
				$this->name = $string;
				$this->_setModified('name');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: name | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getName(){
		return $this->name;
	}

	/**
	 * @param integer $integer
	 */
	public function setSortorder($integer){
		if(is_null($integer))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: sortorder'));
		if(is_integer($integer)){
			if( $this->sortorder !== $integer ){
				$this->sortorder = $integer;
				$this->_setModified('sortorder');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: sortorder | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getSortorder(){
		return $this->sortorder;
	}

}
