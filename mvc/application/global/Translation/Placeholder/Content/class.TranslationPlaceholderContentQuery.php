<?php
#ä
/**
 * TranslationPlaceholderContent Query
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class TranslationPlaceholderContentQuery extends BaseQuery { 

	/**************************** KEYS ****************************/
	const TRANSLATIONCONTENTID = 'tbl_translation_placeholder_content.translationcontentid';
	const TRANSLATIONPLACEHOLDERID = 'tbl_translation_placeholder_content.translationplaceholderid';
	const LANGUAGEISO2 = 'tbl_translation_placeholder_content.languageiso2';
	const CONTENT = 'tbl_translation_placeholder_content.content';
	const HASH = 'tbl_translation_placeholder_content.hash';
	const TSTAMP_CREATED = 'tbl_translation_placeholder_content.tstamp_created';
	const TSTAMP_MODIFIED = 'tbl_translation_placeholder_content.tstamp_modified';

	/**
	 * constructor
	 */
	public function __construct($load_member = true){
		$this->tablename = 'tbl_translation_placeholder_content';
		$this->modelname = 'TranslationPlaceholderContent';
		if( !$load_member )
			return true;

		$myJoin = new LanguageQuery(false);
		$myJoin->add(LanguageQuery::LANGUAGEISO2, Criteria::EQUAL, TranslationPlaceholderContentQuery::LANGUAGEISO2);
		$this->addJoin($myJoin, Criteria::JOIN_INNER);

		$myJoin = new TranslationPlaceholderQuery(false);
		$myJoin->add(TranslationPlaceholderQuery::TRANSLATIONPLACEHOLDERID, Criteria::EQUAL, TranslationPlaceholderContentQuery::TRANSLATIONPLACEHOLDERID);
		$this->addJoin($myJoin, Criteria::JOIN_INNER);
	}

	/**
	 * @return int
	 */
	public function count(){
		return parent::count();
	}

	/**
	 * @return TranslationPlaceholderContentList
	 */
	public function find(){
		return parent::find();
	}

	/**
	 * @return TranslationPlaceholderContent
	 */
	public function findOne(){
		return parent::findOne();
	}

}
