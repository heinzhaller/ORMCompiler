<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_OBJECT());

/**
 * GameTag Base-Object
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class GameTagBase extends BaseObject { 

	// references
	private $ref_game_list = array();
	private $ref_tag_list = array();

	// attributes
	private $gameid;
	private $tagid;

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
			$this->setGameList(GameTagManager::getGameListByGameTag($this, $myLimit));
		return $this->ref_game_list;
	}

	/**
	 * @param TagList
	 */
	public function setTagList(TagList &$myObject){
		$this->ref_tag_list = $myObject;
		$this->_setIsLoaded('ref_tag_list');
	}

	/**
	 * @return TagList
	 */
	public function getTagList(SQLLimit &$myLimit = null){
		if( !$this->_getIsLoaded('ref_tag_list') )
			$this->setTagList(GameTagManager::getTagListByGameTag($this, $myLimit));
		return $this->ref_tag_list;
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

}
