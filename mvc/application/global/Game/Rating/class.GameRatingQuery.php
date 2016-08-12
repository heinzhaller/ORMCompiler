<?php
#ä
/**
 * GameRating Query
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class GameRatingQuery extends BaseQuery { 

	/**************************** KEYS ****************************/
	const GAMERATINGID = 'tbl_game_rating.gameratingid';
	const GAMEID = 'tbl_game_rating.gameid';
	const IP = 'tbl_game_rating.ip';
	const RATING = 'tbl_game_rating.rating';
	const TSTAMP_CREATED = 'tbl_game_rating.tstamp_created';

	/**
	 * constructor
	 */
	public function __construct($load_member = true){
		$this->tablename = 'tbl_game_rating';
		$this->modelname = 'GameRating';
		if( !$load_member )
			return true;

		$myJoin = new GameQuery(false);
		$myJoin->add(GameQuery::GAMEID, Criteria::EQUAL, GameRatingQuery::GAMEID);
		$this->addJoin($myJoin, Criteria::JOIN_INNER);
	}

	/**
	 * @return int
	 */
	public function count(){
		return parent::count();
	}

	/**
	 * @return GameRatingList
	 */
	public function find(){
		return parent::find();
	}

	/**
	 * @return GameRating
	 */
	public function findOne(){
		return parent::findOne();
	}

}
