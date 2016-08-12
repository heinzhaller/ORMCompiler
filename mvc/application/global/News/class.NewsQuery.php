<?php
#ä
/**
 * News Query
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class NewsQuery extends BaseQuery { 

	/**************************** KEYS ****************************/
	const NEWSID = 'tbl_news.newsid';
	const TSTAMP_CREATED = 'tbl_news.tstamp_created';
	const TSTAMP_MODIFIED = 'tbl_news.tstamp_modified';
	const TSTAMP_DELETED = 'tbl_news.tstamp_deleted';
	const GAMEID = 'tbl_news.gameid';
	const CONTENT = 'tbl_news.content';
	const TITLE = 'tbl_news.title';
	const USERID = 'tbl_news.userid';

	/**
	 * constructor
	 */
	public function __construct($load_member = true){
		$this->tablename = 'tbl_news';
		$this->modelname = 'News';
		if( !$load_member )
			return true;

		$myJoin = new GameQuery(false);
		$myJoin->add(GameQuery::GAMEID, Criteria::EQUAL, NewsQuery::GAMEID);
		$this->addJoin($myJoin, Criteria::JOIN_INNER);

		$myJoin = new UserQuery(false);
		$myJoin->add(UserQuery::USERID, Criteria::EQUAL, NewsQuery::USERID);
		$this->addJoin($myJoin, Criteria::JOIN_INNER);
	}

	/**
	 * @return int
	 */
	public function count(){
		return parent::count();
	}

	/**
	 * @return NewsList
	 */
	public function find(){
		return parent::find();
	}

	/**
	 * @return News
	 */
	public function findOne(){
		return parent::findOne();
	}

}
