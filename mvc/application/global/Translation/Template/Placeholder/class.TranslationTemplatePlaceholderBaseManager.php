<?php
#ä
/**
 * TranslationTemplatePlaceholder Base-Manager
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class TranslationTemplatePlaceholderBaseManager extends TranslationTemplatePlaceholderAbstractionLayer { 

	/**************************** ATTRIBUTES ****************************/
	const TRANSLATIONTEMPLATEID = 'translationtemplateid';
	const TRANSLATIONPLACEHOLDERID = 'translationplaceholderid';

	/**************************** SELECT METHODS ****************************/
	/**
	 * @param SQLLimit &$myLimit
	 * @return TranslationTemplatePlaceholderList
	 */
	public static final function getTranslationTemplatePlaceholderList(SQLLimit &$myLimit = null){
		return parent::getTranslationTemplatePlaceholderListBySql('1 = 1', null, $myLimit);
	}

	/**
	 * @param integer $translationtemplateid
	 * @param SQLLimit &$myLimit
	 * @return TranslationTemplatePlaceholderList
	 */
	public static final function getTranslationTemplatePlaceholderListByTranslationtemplateid($translationtemplateid, SQLLimit &$myLimit = null){
		return parent::getTranslationTemplatePlaceholderListBySql(self::TRANSLATIONTEMPLATEID.' = ?', array($translationtemplateid), $myLimit);
	}

	/**
	 * @param integer $translationplaceholderid
	 * @param SQLLimit &$myLimit
	 * @return TranslationTemplatePlaceholderList
	 */
	public static final function getTranslationTemplatePlaceholderListByTranslationplaceholderid($translationplaceholderid, SQLLimit &$myLimit = null){
		return parent::getTranslationTemplatePlaceholderListBySql(self::TRANSLATIONPLACEHOLDERID.' = ?', array($translationplaceholderid), $myLimit);
	}

	/**************************** REFERENCES ****************************/
	/**
	 * @param TranslationPlaceholder &$myObject
	 * @return TranslationTemplatePlaceholderList
	 */
	public static final function getTranslationTemplatePlaceholderListByTranslationPlaceholder(TranslationPlaceholder &$myObject, SQLLimit &$myLimit = null){
		return self::getTranslationTemplatePlaceholderListByTranslationplaceholderid($myObject->getTranslationplaceholderid(), $myLimit);
	}

	/**
	 * @param TranslationTemplatePlaceholder &$myTranslationTemplatePlaceholder
	 * @return TranslationPlaceholderList
	 */
	public static final function getTranslationPlaceholderListByTranslationTemplatePlaceholder(TranslationTemplatePlaceholder &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_TRANSLATION_PLACEHOLDER());
		return TranslationPlaceholderManager::getTranslationPlaceholderListBytbl_translation_template($myObject, $myLimit);
	}

	/**
	 * @param TranslationTemplate &$myObject
	 * @return TranslationTemplatePlaceholderList
	 */
	public static final function getTranslationTemplatePlaceholderListByTranslationTemplate(TranslationTemplate &$myObject, SQLLimit &$myLimit = null){
		return self::getTranslationTemplatePlaceholderListByTranslationtemplateid($myObject->getTranslationtemplateid(), $myLimit);
	}

	/**
	 * @param TranslationTemplatePlaceholder &$myTranslationTemplatePlaceholder
	 * @return TranslationTemplateList
	 */
	public static final function getTranslationTemplateListByTranslationTemplatePlaceholder(TranslationTemplatePlaceholder &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_TRANSLATION_TEMPLATE());
		return TranslationTemplateManager::getTranslationTemplateListBytbl_translation_placeholder($myObject, $myLimit);
	}

}
