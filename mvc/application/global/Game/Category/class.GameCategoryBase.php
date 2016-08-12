<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_OBJECT());

/**
 * GameCategory Base-Object
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class GameCategoryBase extends BaseObject { 

	// references
	private $ref_game_list = array();
	private $ref_category_list = array();

	// attributes
	private $gameid;
	private $categoryid;

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
			$this->setGameList(GameCategoryManager::getGameListByGameCategory($this, $myLimit));
		return $this->ref_game_list;
	}

	/**
	 * @param CategoryList
	 */
	public function setCategoryList(CategoryList &$myObject){
		$this->ref_category_list = $myObject;
		$this->_setIsLoaded('ref_category_list');
	}

	/**
	 * @return CategoryList
	 */
	public function getCategoryList(SQLLimit &$myLimit = null){
		if( !$this->_getIsLoaded('ref_category_list') )
			$this->setCategoryList(GameCategoryManager::getCategoryListByGameCategory($this, $myLimit));
		return $this->ref_category_list;
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
	public function setCategoryid($integer){
		if(is_null($integer))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: categoryid'));
		if(is_integer($integer)){
			if( $this->categoryid !== $integer ){
				$this->categoryid = $integer;
				$this->_setModified('categoryid');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: categoryid | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getCategoryid(){
		return $this->categoryid;
	}

}
