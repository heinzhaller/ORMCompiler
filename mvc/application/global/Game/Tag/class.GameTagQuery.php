<?php
#ä
/**
 * GameTag Query
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class GameTagQuery extends BaseQuery { 

	/**************************** KEYS ****************************/
	const GAMEID = 'tbl_game_tag.gameid';
	const TAGID = 'tbl_game_tag.tagid';

	/**
	 * constructor
	 */
	public function __construct($load_member = true){
		$this->tablename = 'tbl_game_tag';
		$this->modelname = 'GameTag';
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
	 * @return GameTagList
	 */
	public function find(){
		return parent::find();
	}

	/**
	 * @return GameTag
	 */
	public function findOne(){
		return parent::findOne();
	}

}
