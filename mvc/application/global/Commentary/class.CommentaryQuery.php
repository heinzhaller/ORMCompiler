<?php
#ä
/**
 * Commentary Query
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class CommentaryQuery extends BaseQuery { 

	/**************************** KEYS ****************************/
	const COMMENTARYID = 'tbl_commentary.commentaryid';
	const PARENT_COMMENTARYID = 'tbl_commentary.parent_commentaryid';
	const USERNAME = 'tbl_commentary.username';
	const IP = 'tbl_commentary.ip';
	const MESSAGE = 'tbl_commentary.message';
	const TSTAMP_CREATED = 'tbl_commentary.tstamp_created';
	const TSTAMP_MODIFIED = 'tbl_commentary.tstamp_modified';
	const TSTAMP_DELETED = 'tbl_commentary.tstamp_deleted';
	const GAMEID = 'tbl_commentary.gameid';

	/**
	 * constructor
	 */
	public function __construct($load_member = true){
		$this->tablename = 'tbl_commentary';
		$this->modelname = 'Commentary';
		if( !$load_member )
			return true;

		$myJoin = new GameQuery(false);
		$myJoin->add(GameQuery::GAMEID, Criteria::EQUAL, CommentaryQuery::GAMEID);
		$this->addJoin($myJoin, Criteria::JOIN_INNER);
	}

	/**
	 * @return int
	 */
	public function count(){
		return parent::count();
	}

	/**
	 * @return CommentaryList
	 */
	public function find(){
		return parent::find();
	}

	/**
	 * @return Commentary
	 */
	public function findOne(){
		return parent::findOne();
	}

}
