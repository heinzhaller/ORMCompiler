<?php
#ä
/**
 * TranslationPlaceholder Query
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class TranslationPlaceholderQuery extends BaseQuery { 

	/**************************** KEYS ****************************/
	const TRANSLATIONPLACEHOLDERID = 'tbl_translation_placeholder.translationplaceholderid';
	const PLACEHOLDERNAME = 'tbl_translation_placeholder.placeholdername';
	const TSTAMP_CREATED = 'tbl_translation_placeholder.tstamp_created';

	/**
	 * constructor
	 */
	public function __construct($load_member = true){
		$this->tablename = 'tbl_translation_placeholder';
		$this->modelname = 'TranslationPlaceholder';
		if( !$load_member )
			return true;

		$myJoin = new TranslationPlaceholderContentQuery(false);
		$myJoin->add(TranslationPlaceholderContentQuery::TRANSLATIONPLACEHOLDERID, Criteria::EQUAL, TranslationPlaceholderQuery::TRANSLATIONPLACEHOLDERID);
		$this->addJoin($myJoin, Criteria::JOIN_INNER);
	}

	/**
	 * @return int
	 */
	public function count(){
		return parent::count();
	}

	/**
	 * @return TranslationPlaceholderList
	 */
	public function find(){
		return parent::find();
	}

	/**
	 * @return TranslationPlaceholder
	 */
	public function findOne(){
		return parent::findOne();
	}

}
