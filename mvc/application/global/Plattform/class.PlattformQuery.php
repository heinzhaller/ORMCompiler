<?php
#ä
/**
 * Plattform Query
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class PlattformQuery extends BaseQuery { 

	/**************************** KEYS ****************************/
	const PLATTFORMID = 'tbl_plattform.plattformid';
	const NAME = 'tbl_plattform.name';
	const SORTORDER = 'tbl_plattform.sortorder';

	/**
	 * constructor
	 */
	public function __construct($load_member = true){
		$this->tablename = 'tbl_plattform';
		$this->modelname = 'Plattform';
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
	 * @return PlattformList
	 */
	public function find(){
		return parent::find();
	}

	/**
	 * @return Plattform
	 */
	public function findOne(){
		return parent::findOne();
	}

}
