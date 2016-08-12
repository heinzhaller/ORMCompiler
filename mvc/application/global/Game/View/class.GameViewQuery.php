<?php
#ä
/**
 * GameView Query
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class GameViewQuery extends BaseQuery { 

	/**************************** KEYS ****************************/
	const GAMEVIEWID = 'tbl_game_view.gameviewid';
	const GAMEID = 'tbl_game_view.gameid';
	const IP = 'tbl_game_view.ip';
	const TSTAMP_CREATED = 'tbl_game_view.tstamp_created';

	/**
	 * constructor
	 */
	public function __construct($load_member = true){
		$this->tablename = 'tbl_game_view';
		$this->modelname = 'GameView';
		if( !$load_member )
			return true;

		$myJoin = new GameQuery(false);
		$myJoin->add(GameQuery::GAMEID, Criteria::EQUAL, GameViewQuery::GAMEID);
		$this->addJoin($myJoin, Criteria::JOIN_INNER);
	}

	/**
	 * @return int
	 */
	public function count(){
		return parent::count();
	}

	/**
	 * @return GameViewList
	 */
	public function find(){
		return parent::find();
	}

	/**
	 * @return GameView
	 */
	public function findOne(){
		return parent::findOne();
	}

}
