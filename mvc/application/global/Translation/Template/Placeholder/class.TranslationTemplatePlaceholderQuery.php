<?php
#ä
/**
 * TranslationTemplatePlaceholder Query
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class TranslationTemplatePlaceholderQuery extends BaseQuery { 

	/**************************** KEYS ****************************/
	const TRANSLATIONTEMPLATEID = 'tbl_translation_template_placeholder.translationtemplateid';
	const TRANSLATIONPLACEHOLDERID = 'tbl_translation_template_placeholder.translationplaceholderid';

	/**
	 * constructor
	 */
	public function __construct($load_member = true){
		$this->tablename = 'tbl_translation_template_placeholder';
		$this->modelname = 'TranslationTemplatePlaceholder';
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
	 * @return TranslationTemplatePlaceholderList
	 */
	public function find(){
		return parent::find();
	}

	/**
	 * @return TranslationTemplatePlaceholder
	 */
	public function findOne(){
		return parent::findOne();
	}

}
