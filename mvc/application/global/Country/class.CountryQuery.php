<?php
#ä
/**
 * Country Query
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class CountryQuery extends BaseQuery { 

	/**************************** KEYS ****************************/
	const COUNTRYISO2 = 'tbl_country.countryiso2';
	const DESCRIPTION = 'tbl_country.description';
	const HAS_CLUBS = 'tbl_country.has_clubs';

	/**
	 * constructor
	 */
	public function __construct($load_member = true){
		$this->tablename = 'tbl_country';
		$this->modelname = 'Country';
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
	 * @return CountryList
	 */
	public function find(){
		return parent::find();
	}

	/**
	 * @return Country
	 */
	public function findOne(){
		return parent::findOne();
	}

}
