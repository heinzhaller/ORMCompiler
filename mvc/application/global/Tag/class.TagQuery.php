<?php
#ä
/**
 * Tag Query
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class TagQuery extends BaseQuery { 

	/**************************** KEYS ****************************/
	const TAGID = 'tbl_tag.tagid';
	const NAME = 'tbl_tag.name';
	const TSTAMP_CREATED = 'tbl_tag.tstamp_created';
	const TSTAMP_MODIFIED = 'tbl_tag.tstamp_modified';
	const TSTAMP_DELETED = 'tbl_tag.tstamp_deleted';

	/**
	 * constructor
	 */
	public function __construct($load_member = true){
		$this->tablename = 'tbl_tag';
		$this->modelname = 'Tag';
		if( !$load_member )
			return true;
	}

	/**
	 * @return int
	 */
	public function count(){
		return parent::count();
	}

	/**
	 * @return TagList
	 */
	public function find(){
		return parent::find();
	}

	/**
	 * @return Tag
	 */
	public function findOne(){
		return parent::findOne();
	}

}
