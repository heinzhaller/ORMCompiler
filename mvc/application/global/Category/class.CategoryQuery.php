<?php
#ä
/**
 * Category Query
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class CategoryQuery extends BaseQuery { 

	/**************************** KEYS ****************************/
	const CATEGORYID = 'tbl_category.categoryid';
	const PARENT_CATEGORYID = 'tbl_category.parent_categoryid';
	const NAME = 'tbl_category.name';
	const DESCRIPTION = 'tbl_category.description';
	const SORTORDER = 'tbl_category.sortorder';
	const ICON = 'tbl_category.icon';

	/**
	 * constructor
	 */
	public function __construct($load_member = true){
		$this->tablename = 'tbl_category';
		$this->modelname = 'Category';
		if( !$load_member )
			return true;
	}

	/**
	 * @return int
	 */
	public function count(){
		return parent::count();
	}

	/**
	 * @return CategoryList
	 */
	public function find(){
		return parent::find();
	}

	/**
	 * @return Category
	 */
	public function findOne(){
		return parent::findOne();
	}

}
