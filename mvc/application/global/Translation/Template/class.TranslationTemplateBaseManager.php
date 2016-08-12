<?php
#ä
/**
 * TranslationTemplate Base-Manager
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class TranslationTemplateBaseManager extends TranslationTemplateAbstractionLayer { 

	/**************************** ATTRIBUTES ****************************/
	const TRANSLATIONTEMPLATEID = 'translationtemplateid';
	const TEMPLATENAME = 'templatename';
	const COMMENTARY = 'commentary';
	const TSTAMP_CREATED = 'tstamp_created';

	/**************************** SELECT METHODS ****************************/
	/**
	 * @param SQLLimit &$myLimit
	 * @return TranslationTemplateList
	 */
	public static final function getTranslationTemplateList(SQLLimit &$myLimit = null){
		return parent::getTranslationTemplateListBySql('1 = 1', null, $myLimit);
	}

	/**
	 * @param integer $translationtemplateid
	 * @param SQLLimit &$myLimit
	 * @return TranslationTemplate or null
	 */
	public static final function getTranslationTemplateByTranslationtemplateid($translationtemplateid, SQLLimit &$myLimit = null){
		$myObject = parent::getTranslationTemplateListBySql(self::TRANSLATIONTEMPLATEID.' = ?', array($translationtemplateid), $myLimit);
		return ( $myObject->valid() ? $myObject->current() : null );
	}

	/**
	 * @param string $templatename
	 * @param SQLLimit &$myLimit
	 * @return TranslationTemplateList
	 */
	public static final function getTranslationTemplateListByTemplatename($templatename, SQLLimit &$myLimit = null){
		return parent::getTranslationTemplateListBySql(self::TEMPLATENAME.' = ?', array($templatename), $myLimit);
	}

	/**
	 * @param string $commentary
	 * @param SQLLimit &$myLimit
	 * @return TranslationTemplateList
	 */
	public static final function getTranslationTemplateListByCommentary($commentary, SQLLimit &$myLimit = null){
		return parent::getTranslationTemplateListBySql(self::COMMENTARY.' = ?', array($commentary), $myLimit);
	}

	/**
	 * @param integer $tstamp_created
	 * @param SQLLimit &$myLimit
	 * @return TranslationTemplateList
	 */
	public static final function getTranslationTemplateListByTstampCreated($tstamp_created, SQLLimit &$myLimit = null){
		return parent::getTranslationTemplateListBySql(self::TSTAMP_CREATED.' = ?', array($tstamp_created), $myLimit);
	}

	/**************************** REFERENCES ****************************/
	/**
	 * @param TranslationPlaceholder &$myObject
	 * @return TranslationTemplateList
	 */
	public static final function getTranslationTemplateListByTranslationPlaceholder(TranslationPlaceholder &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_TRANSLATION_TEMPLATE_PLACEHOLDER());
		$myList = TranslationTemplatePlaceholderManager::getTranslationTemplatePlaceholderListByTranslationPlaceholder($myObject, $myLimit);
		$myTranslationTemplateList = new TranslationTemplateList();
		foreach($myList as $item)
			$myTranslationTemplateList->add(self::getTranslationTemplateByTranslationtemplateid($item->getTranslationtemplateid()));
		return $myTranslationTemplateList;
	}

	/**
	 * @param TranslationTemplate &$myTranslationTemplate
	 * @return TranslationPlaceholderList
	 */
	public static final function getTranslationPlaceholderListByTranslationTemplate(TranslationTemplate &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_TRANSLATION_PLACEHOLDER());
		return TranslationPlaceholderManager::getTranslationPlaceholderListByTranslationTemplate($myObject, $myLimit);
	}

}
