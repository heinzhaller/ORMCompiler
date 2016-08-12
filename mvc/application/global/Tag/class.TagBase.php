<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_OBJECT());

/**
 * Tag Base-Object
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class TagBase extends BaseObject { 

	// references
	private $ref_game_list = array();

	// attributes
	private $tagid;
	private $name;
	private $tstamp_created;
	private $tstamp_modified;
	private $tstamp_deleted;

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
			$this->setGameList(TagManager::getGameListByTag($this, $myLimit));
		return $this->ref_game_list;
	}

	/**************************** ATTRIBUTES ****************************/
	/**
	 * @param integer $integer
	 */
	public function setTagid($integer){
		if(is_null($integer))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: tagid'));
		if(is_integer($integer)){
			if( $this->tagid !== $integer ){
				$this->tagid = $integer;
				$this->_setModified('tagid');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: tagid | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getTagid(){
		return $this->tagid;
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

}
