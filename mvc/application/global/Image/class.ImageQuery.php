<?php
#ä
/**
 * Image Query
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class ImageQuery extends BaseQuery { 

	/**************************** KEYS ****************************/
	const IMAGEID = 'tbl_image.imageid';
	const TITLE = 'tbl_image.title';
	const GAMEID = 'tbl_image.gameid';
	const FILENAME = 'tbl_image.filename';
	const PATH = 'tbl_image.path';
	const SORTORDER = 'tbl_image.sortorder';
	const TSTAMP_CREATED = 'tbl_image.tstamp_created';
	const TSTAMP_MODIFIED = 'tbl_image.tstamp_modified';
	const TSTAMP_DELETED = 'tbl_image.tstamp_deleted';

	/**
	 * constructor
	 */
	public function __construct($load_member = true){
		$this->tablename = 'tbl_image';
		$this->modelname = 'Image';
		if( !$load_member )
			return true;

		$myJoin = new GameQuery(false);
		$myJoin->add(GameQuery::GAMEID, Criteria::EQUAL, ImageQuery::GAMEID);
		$this->addJoin($myJoin, Criteria::JOIN_INNER);
	}

	/**
	 * @return int
	 */
	public function count(){
		return parent::count();
	}

	/**
	 * @return ImageList
	 */
	public function find(){
		return parent::find();
	}

	/**
	 * @return Image
	 */
	public function findOne(){
		return parent::findOne();
	}

}
