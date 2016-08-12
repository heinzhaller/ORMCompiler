<?php
#ä
/**
 * GamePlattform Query
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class GamePlattformQuery extends BaseQuery { 

	/**************************** KEYS ****************************/
	const GAMEID = 'tbl_game_plattform.gameid';
	const PLATTFORMID = 'tbl_game_plattform.plattformid';

	/**
	 * constructor
	 */
	public function __construct($load_member = true){
		$this->tablename = 'tbl_game_plattform';
		$this->modelname = 'GamePlattform';
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
	 * @return GamePlattformList
	 */
	public function find(){
		return parent::find();
	}

	/**
	 * @return GamePlattform
	 */
	public function findOne(){
		return parent::findOne();
	}

}
