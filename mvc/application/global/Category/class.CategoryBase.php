<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_OBJECT());

/**
 * Category Base-Object
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class CategoryBase extends BaseObject { 

	// references
	private $ref_category;
	private $ref_game_list = array();

	// attributes
	private $categoryid;
	private $parent_categoryid;
	private $name;
	private $description;
	private $sortorder;
	private $icon;

	/**************************** REFERENCES ****************************/
	/**
	 * @param Category
	 */
	public function setCategory(Category &$myObject = NULL){
		$this->ref_category = $myObject;
		if(!is_null($myObject))
			$this->setCategoryid($myObject->getParentCategoryid());
		$this->_setIsLoaded('ref_category');
	}

	/**
	 * @return Category
	 */
	public function getCategory(){
		if( !$this->_getIsLoaded('ref_category') )
			$this->setCategory(CategoryManager::getCategoryByCategory($this));
		return $this->ref_category;
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
			$this->setGameList(CategoryManager::getGameListByCategory($this, $myLimit));
		return $this->ref_game_list;
	}

	/**************************** ATTRIBUTES ****************************/
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

	/**
	 * @param integer $integer
	 */
	public function setParentCategoryid($integer){
		if(is_integer($integer) OR is_null($integer)){
			if( $this->parent_categoryid !== $integer ){
				$this->parent_categoryid = $integer;
				$this->_setModified('parent_categoryid');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: parent_categoryid | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getParentCategoryid(){
		return $this->parent_categoryid;
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
	 * @param string $string
	 */
	public function setDescription($string){
		if(is_string($string) OR is_null($string)){
			if( $this->description !== $string ){
				$this->description = $string;
				$this->_setModified('description');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: description | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getDescription(){
		return $this->description;
	}

	/**
	 * @param integer $integer
	 */
	public function setSortorder($integer){
		if(is_integer($integer) OR is_null($integer)){
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

	/**
	 * @param string $string
	 */
	public function setIcon($string){
		if(is_string($string) OR is_null($string)){
			if( $this->icon !== $string ){
				$this->icon = $string;
				$this->_setModified('icon');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: icon | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getIcon(){
		return $this->icon;
	}

}
