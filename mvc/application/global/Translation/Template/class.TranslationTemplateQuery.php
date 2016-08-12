<?php
#ä
/**
 * TranslationTemplate Query
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
class TranslationTemplateQuery extends BaseQuery { 

	/**************************** KEYS ****************************/
	const TRANSLATIONTEMPLATEID = 'tbl_translation_template.translationtemplateid';
	const TEMPLATENAME = 'tbl_translation_template.templatename';
	const COMMENTARY = 'tbl_translation_template.commentary';
	const TSTAMP_CREATED = 'tbl_translation_template.tstamp_created';

	/**
	 * constructor
	 */
	public function __construct($load_member = true){
		$this->tablename = 'tbl_translation_template';
		$this->modelname = 'TranslationTemplate';
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
	 * @return TranslationTemplateList
	 */
	public function find(){
		return parent::find();
	}

	/**
	 * @return TranslationTemplate
	 */
	public function findOne(){
		return parent::findOne();
	}

}
