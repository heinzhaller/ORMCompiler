<?php
#ä
/**
 * GameCategory Query
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class GameCategoryQuery extends BaseQuery { 

	/**************************** KEYS ****************************/
	const GAMEID = 'tbl_game_category.gameid';
	const CATEGORYID = 'tbl_game_category.categoryid';

	/**
	 * constructor
	 */
	public function __construct($load_member = true){
		$this->tablename = 'tbl_game_category';
		$this->modelname = 'GameCategory';
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
	 * @return GameCategoryList
	 */
	public function find(){
		return parent::find();
	}

	/**
	 * @return GameCategory
	 */
	public function findOne(){
		return parent::findOne();
	}

}
