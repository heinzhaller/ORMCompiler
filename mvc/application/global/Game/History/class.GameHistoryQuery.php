<?php
#ä
/**
 * GameHistory Query
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class GameHistoryQuery extends BaseQuery { 

	/**************************** KEYS ****************************/
	const GAMEHISTORYID = 'tbl_game_history.gamehistoryid';
	const GAMEID = 'tbl_game_history.gameid';
	const USERID = 'tbl_game_history.userid';
	const INFOTEXT = 'tbl_game_history.infotext';
	const TSTAMP_CREATED = 'tbl_game_history.tstamp_created';

	/**
	 * constructor
	 */
	public function __construct($load_member = true){
		$this->tablename = 'tbl_game_history';
		$this->modelname = 'GameHistory';
		if( !$load_member )
			return true;

		$myJoin = new GameQuery(false);
		$myJoin->add(GameQuery::GAMEID, Criteria::EQUAL, GameHistoryQuery::GAMEID);
		$this->addJoin($myJoin, Criteria::JOIN_INNER);

		$myJoin = new UserQuery(false);
		$myJoin->add(UserQuery::USERID, Criteria::EQUAL, GameHistoryQuery::USERID);
		$this->addJoin($myJoin, Criteria::JOIN_INNER);
	}

	/**
	 * @return int
	 */
	public function count(){
		return parent::count();
	}

	/**
	 * @return GameHistoryList
	 */
	public function find(){
		return parent::find();
	}

	/**
	 * @return GameHistory
	 */
	public function findOne(){
		return parent::findOne();
	}

}
