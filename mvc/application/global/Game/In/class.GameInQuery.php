<?php
#ä
/**
 * GameIn Query
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class GameInQuery extends BaseQuery { 

	/**************************** KEYS ****************************/
	const GAMEINID = 'tbl_game_in.gameinid';
	const GAMEID = 'tbl_game_in.gameid';
	const IP = 'tbl_game_in.ip';
	const TSTAMP_CREATED = 'tbl_game_in.tstamp_created';

	/**
	 * constructor
	 */
	public function __construct($load_member = true){
		$this->tablename = 'tbl_game_in';
		$this->modelname = 'GameIn';
		if( !$load_member )
			return true;

		$myJoin = new GameQuery(false);
		$myJoin->add(GameQuery::GAMEID, Criteria::EQUAL, GameInQuery::GAMEID);
		$this->addJoin($myJoin, Criteria::JOIN_INNER);
	}

	/**
	 * @return int
	 */
	public function count(){
		return parent::count();
	}

	/**
	 * @return GameInList
	 */
	public function find(){
		return parent::find();
	}

	/**
	 * @return GameIn
	 */
	public function findOne(){
		return parent::findOne();
	}

}
