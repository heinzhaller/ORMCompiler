<?php
#ä
/**
 * Language Query
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class LanguageQuery extends BaseQuery { 

	/**************************** KEYS ****************************/
	const LANGUAGEISO2 = 'tbl_language.languageiso2';
	const DESCRIPTION = 'tbl_language.description';

	/**
	 * constructor
	 */
	public function __construct($load_member = true){
		$this->tablename = 'tbl_language';
		$this->modelname = 'Language';
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
	 * @return LanguageList
	 */
	public function find(){
		return parent::find();
	}

	/**
	 * @return Language
	 */
	public function findOne(){
		return parent::findOne();
	}

}
