<?php
#ä
/**
 * CountryLanguage Query
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class CountryLanguageQuery extends BaseQuery { 

	/**************************** KEYS ****************************/
	const COUNTRYISO2 = 'tbl_country_language.countryiso2';
	const LANGUAGEISO2 = 'tbl_country_language.languageiso2';

	/**
	 * constructor
	 */
	public function __construct($load_member = true){
		$this->tablename = 'tbl_country_language';
		$this->modelname = 'CountryLanguage';
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
	 * @return CountryLanguageList
	 */
	public function find(){
		return parent::find();
	}

	/**
	 * @return CountryLanguage
	 */
	public function findOne(){
		return parent::findOne();
	}

}
