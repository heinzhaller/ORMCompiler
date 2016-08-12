<?php
#ä
/**
 * Game Query
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class GameQuery extends BaseQuery { 

	/**************************** KEYS ****************************/
	const GAMEID = 'tbl_game.gameid';
	const USERID = 'tbl_game.userid';
	const TITLE = 'tbl_game.title';
	const TITLE_SEO = 'tbl_game.title_seo';
	const DESCRIPTION_SHORT = 'tbl_game.description_short';
	const DESCRIPTION_MEDIUM = 'tbl_game.description_medium';
	const DESCRIPTION = 'tbl_game.description';
	const TOTAL_RATING = 'tbl_game.total_rating';
	const TOTAL_IN = 'tbl_game.total_in';
	const TOTAL_OUT = 'tbl_game.total_out';
	const TSTAMP_CREATED = 'tbl_game.tstamp_created';
	const TSTAMP_MODIFIED = 'tbl_game.tstamp_modified';
	const TSTAMP_DELETED = 'tbl_game.tstamp_deleted';
	const REVIEWTEXT = 'tbl_game.reviewtext';
	const REVIEW_RATING_GRAPHICS = 'tbl_game.review_rating_graphics';
	const REVIEW_RATING_GAMEPLAY = 'tbl_game.review_rating_gameplay';
	const REVIEW_RATING_FUN = 'tbl_game.review_rating_fun';
	const REVIEW_RATING_MOTIVATION = 'tbl_game.review_rating_motivation';
	const REVIEW_RATING_HANDLING = 'tbl_game.review_rating_handling';
	const REVIEW_RATING_TOTAL = 'tbl_game.review_rating_total';
	const DEVELOPER = 'tbl_game.developer';
	const PUBLISHER = 'tbl_game.publisher';
	const URL = 'tbl_game.url';
	const BANNER = 'tbl_game.banner';
	const GENRE = 'tbl_game.genre';
	const RELEASEDATE = 'tbl_game.releasedate';
	const PLAYERS = 'tbl_game.players';
	const LANGUAGES = 'tbl_game.languages';
	const IS_SPECIAL_GAME = 'tbl_game.is_special_game';
	const VIEWS = 'tbl_game.views';
	const REVIEW_RATING_TEXT = 'tbl_game.review_rating_text';
	const IS_ACTIVE = 'tbl_game.is_active';

	/**
	 * constructor
	 */
	public function __construct($load_member = true){
		$this->tablename = 'tbl_game';
		$this->modelname = 'Game';
		if( !$load_member )
			return true;

		$myJoin = new UserQuery(false);
		$myJoin->add(UserQuery::USERID, Criteria::EQUAL, GameQuery::USERID);
		$this->addJoin($myJoin, Criteria::JOIN_INNER);

		$myJoin = new GameOutQuery(false);
		$myJoin->add(GameOutQuery::GAMEID, Criteria::EQUAL, GameQuery::GAMEID);
		$this->addJoin($myJoin, Criteria::JOIN_INNER);

		$myJoin = new GameRatingQuery(false);
		$myJoin->add(GameRatingQuery::GAMEID, Criteria::EQUAL, GameQuery::GAMEID);
		$this->addJoin($myJoin, Criteria::JOIN_INNER);

		$myJoin = new GameViewQuery(false);
		$myJoin->add(GameViewQuery::GAMEID, Criteria::EQUAL, GameQuery::GAMEID);
		$this->addJoin($myJoin, Criteria::JOIN_INNER);
	}

	/**
	 * @return int
	 */
	public function count(){
		return parent::count();
	}

	/**
	 * @return GameList
	 */
	public function find(){
		return parent::find();
	}

	/**
	 * @return Game
	 */
	public function findOne(){
		return parent::findOne();
	}

}
