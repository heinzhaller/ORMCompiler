<?php
#ä
/**
 * Video Query
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class VideoQuery extends BaseQuery { 

	/**************************** KEYS ****************************/
	const VIDEOID = 'tbl_video.videoid';
	const GAMEID = 'tbl_video.gameid';
	const FILENAME = 'tbl_video.filename';
	const URL = 'tbl_video.url';
	const TSTAMP_CREATED = 'tbl_video.tstamp_created';
	const TSTAMP_MODIFIED = 'tbl_video.tstamp_modified';
	const TSTAMP_DELETED = 'tbl_video.tstamp_deleted';
	const TITLE = 'tbl_video.title';

	/**
	 * constructor
	 */
	public function __construct($load_member = true){
		$this->tablename = 'tbl_video';
		$this->modelname = 'Video';
		if( !$load_member )
			return true;

		$myJoin = new GameQuery(false);
		$myJoin->add(GameQuery::GAMEID, Criteria::EQUAL, VideoQuery::GAMEID);
		$this->addJoin($myJoin, Criteria::JOIN_INNER);
	}

	/**
	 * @return int
	 */
	public function count(){
		return parent::count();
	}

	/**
	 * @return VideoList
	 */
	public function find(){
		return parent::find();
	}

	/**
	 * @return Video
	 */
	public function findOne(){
		return parent::findOne();
	}

}
