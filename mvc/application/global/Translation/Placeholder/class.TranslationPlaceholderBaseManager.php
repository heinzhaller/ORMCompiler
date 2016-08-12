<?php
#ä
/**
 * TranslationPlaceholder Base-Manager
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class TranslationPlaceholderBaseManager extends TranslationPlaceholderAbstractionLayer { 

	/**************************** ATTRIBUTES ****************************/
	const TRANSLATIONPLACEHOLDERID = 'translationplaceholderid';
	const PLACEHOLDERNAME = 'placeholdername';
	const TSTAMP_CREATED = 'tstamp_created';

	/**************************** SELECT METHODS ****************************/
	/**
	 * @param SQLLimit &$myLimit
	 * @return TranslationPlaceholderList
	 */
	public static final function getTranslationPlaceholderList(SQLLimit &$myLimit = null){
		return parent::getTranslationPlaceholderListBySql('1 = 1', null, $myLimit);
	}

	/**
	 * @param integer $translationplaceholderid
	 * @param SQLLimit &$myLimit
	 * @return TranslationPlaceholder or null
	 */
	public static final function getTranslationPlaceholderByTranslationplaceholderid($translationplaceholderid, SQLLimit &$myLimit = null){
		$myObject = parent::getTranslationPlaceholderListBySql(self::TRANSLATIONPLACEHOLDERID.' = ?', array($translationplaceholderid), $myLimit);
		return ( $myObject->valid() ? $myObject->current() : null );
	}

	/**
	 * @param string $placeholdername
	 * @param SQLLimit &$myLimit
	 * @return TranslationPlaceholder or null
	 */
	public static final function getTranslationPlaceholderByPlaceholdername($placeholdername, SQLLimit &$myLimit = null){
		$myObject = parent::getTranslationPlaceholderListBySql(self::PLACEHOLDERNAME.' = ?', array($placeholdername), $myLimit);
		return ( $myObject->valid() ? $myObject->current() : null );
	}

	/**
	 * @param integer $tstamp_created
	 * @param SQLLimit &$myLimit
	 * @return TranslationPlaceholderList
	 */
	public static final function getTranslationPlaceholderListByTstampCreated($tstamp_created, SQLLimit &$myLimit = null){
		return parent::getTranslationPlaceholderListBySql(self::TSTAMP_CREATED.' = ?', array($tstamp_created), $myLimit);
	}

	/**************************** REFERENCES ****************************/
	/**
	 * @param TranslationPlaceholderContent &$myObject
	 * @return TranslationPlaceholder
	 */
	public static final function getTranslationPlaceholderByPlaceholdercontent(TranslationPlaceholderContent &$myObject){
		return self::getTranslationPlaceholderByTranslationplaceholderid($myObject->getTranslationplaceholderid());  // blah
	}

	/**
	 * @param TranslationPlaceholder &$myTranslationPlaceholder
	 * @return TranslationPlaceholderContent
	 */
	public static final function getPlaceholdercontentByTranslationPlaceholder(TranslationPlaceholder &$myObject){
		Library::requireLibrary(LibraryKeys::APPLICATION_TRANSLATION_PLACEHOLDER_CONTENT());
		return TranslationPlaceholderContentManager::getTranslationPlaceholderContentByPlaceholder($myObject);
	}

	/**
	 * @param TranslationTemplate &$myObject
	 * @return TranslationPlaceholderList
	 */
	public static final function getTranslationPlaceholderListByTranslationTemplate(TranslationTemplate &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_TRANSLATION_TEMPLATE_PLACEHOLDER());
		$myList = TranslationTemplatePlaceholderManager::getTranslationTemplatePlaceholderListByTranslationTemplate($myObject, $myLimit);
		$myTranslationPlaceholderList = new TranslationPlaceholderList();
		foreach($myList as $item)
			$myTranslationPlaceholderList->add(self::getTranslationPlaceholderByTranslationplaceholderid($item->getTranslationplaceholderid()));
		return $myTranslationPlaceholderList;
	}

	/**
	 * @param TranslationPlaceholder &$myTranslationPlaceholder
	 * @return TranslationTemplateList
	 */
	public static final function getTranslationTemplateListByTranslationPlaceholder(TranslationPlaceholder &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_TRANSLATION_TEMPLATE());
		return TranslationTemplateManager::getTranslationTemplateListByTranslationPlaceholder($myObject, $myLimit);
	}

}
