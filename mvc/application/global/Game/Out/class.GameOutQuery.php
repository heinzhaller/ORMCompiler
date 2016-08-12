<?php
#ä
/**
 * GameOut Query
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class GameOutQuery extends BaseQuery { 

	/**************************** KEYS ****************************/
	const GAMEOUTID = 'tbl_game_out.gameoutid';
	const GAMEID = 'tbl_game_out.gameid';
	const IP = 'tbl_game_out.ip';
	const TSTAMP_CREATED = 'tbl_game_out.tstamp_created';

	/**
	 * constructor
	 */
	public function __construct($load_member = true){
		$this->tablename = 'tbl_game_out';
		$this->modelname = 'GameOut';
		if( !$load_member )
			return true;

		$myJoin = new GameQuery(false);
		$myJoin->add(GameQuery::GAMEID, Criteria::EQUAL, GameOutQuery::GAMEID);
		$this->addJoin($myJoin, Criteria::JOIN_INNER);
	}

	/**
	 * @return int
	 */
	public function count(){
		return parent::count();
	}

	/**
	 * @return GameOutList
	 */
	public function find(){
		return parent::find();
	}

	/**
	 * @return GameOut
	 */
	public function findOne(){
		return parent::findOne();
	}

}
