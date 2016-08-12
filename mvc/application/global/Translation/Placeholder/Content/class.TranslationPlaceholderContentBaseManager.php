<?php
#ä
/**
 * TranslationPlaceholderContent Base-Manager
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class TranslationPlaceholderContentBaseManager extends TranslationPlaceholderContentAbstractionLayer { 

	/**************************** ATTRIBUTES ****************************/
	const TRANSLATIONCONTENTID = 'translationcontentid';
	const TRANSLATIONPLACEHOLDERID = 'translationplaceholderid';
	const LANGUAGEISO2 = 'languageiso2';
	const CONTENT = 'content';
	const HASH = 'hash';
	const TSTAMP_CREATED = 'tstamp_created';
	const TSTAMP_MODIFIED = 'tstamp_modified';

	/**************************** SELECT METHODS ****************************/
	/**
	 * @param SQLLimit &$myLimit
	 * @return TranslationPlaceholderContentList
	 */
	public static final function getTranslationPlaceholderContentList(SQLLimit &$myLimit = null){
		return parent::getTranslationPlaceholderContentListBySql('1 = 1', null, $myLimit);
	}

	/**
	 * @param integer $translationcontentid
	 * @param SQLLimit &$myLimit
	 * @return TranslationPlaceholderContent or null
	 */
	public static final function getTranslationPlaceholderContentByTranslationcontentid($translationcontentid, SQLLimit &$myLimit = null){
		$myObject = parent::getTranslationPlaceholderContentListBySql(self::TRANSLATIONCONTENTID.' = ?', array($translationcontentid), $myLimit);
		return ( $myObject->valid() ? $myObject->current() : null );
	}

	/**
	 * @param integer $translationplaceholderid
	 * @param SQLLimit &$myLimit
	 * @return TranslationPlaceholderContent or null
	 */
	public static final function getTranslationPlaceholderContentByTranslationplaceholderid($translationplaceholderid, SQLLimit &$myLimit = null){
		$myObject = parent::getTranslationPlaceholderContentListBySql(self::TRANSLATIONPLACEHOLDERID.' = ?', array($translationplaceholderid), $myLimit);
		return ( $myObject->valid() ? $myObject->current() : null );
	}

	/**
	 * @param string $languageiso2
	 * @param SQLLimit &$myLimit
	 * @return TranslationPlaceholderContent or null
	 */
	public static final function getTranslationPlaceholderContentByLanguageiso2($languageiso2, SQLLimit &$myLimit = null){
		$myObject = parent::getTranslationPlaceholderContentListBySql(self::LANGUAGEISO2.' = ?', array($languageiso2), $myLimit);
		return ( $myObject->valid() ? $myObject->current() : null );
	}

	/**
	 * @param string $content
	 * @param SQLLimit &$myLimit
	 * @return TranslationPlaceholderContentList
	 */
	public static final function getTranslationPlaceholderContentListByContent($content, SQLLimit &$myLimit = null){
		return parent::getTranslationPlaceholderContentListBySql(self::CONTENT.' = ?', array($content), $myLimit);
	}

	/**
	 * @param string $hash
	 * @param SQLLimit &$myLimit
	 * @return TranslationPlaceholderContentList
	 */
	public static final function getTranslationPlaceholderContentListByHash($hash, SQLLimit &$myLimit = null){
		return parent::getTranslationPlaceholderContentListBySql(self::HASH.' = ?', array($hash), $myLimit);
	}

	/**
	 * @param integer $tstamp_created
	 * @param SQLLimit &$myLimit
	 * @return TranslationPlaceholderContentList
	 */
	public static final function getTranslationPlaceholderContentListByTstampCreated($tstamp_created, SQLLimit &$myLimit = null){
		return parent::getTranslationPlaceholderContentListBySql(self::TSTAMP_CREATED.' = ?', array($tstamp_created), $myLimit);
	}

	/**
	 * @param integer $tstamp_modified
	 * @param SQLLimit &$myLimit
	 * @return TranslationPlaceholderContentList
	 */
	public static final function getTranslationPlaceholderContentListByTstampModified($tstamp_modified, SQLLimit &$myLimit = null){
		return parent::getTranslationPlaceholderContentListBySql(self::TSTAMP_MODIFIED.' = ?', array($tstamp_modified), $myLimit);
	}

	/**************************** REFERENCES ****************************/
	/**
	 * @param Language &$myObject
	 * @return TranslationPlaceholderContentList
	 */
	public static final function getTranslationPlaceholderContentListByLanguage(Language &$myObject, SQLLimit &$myLimit = null){
		return self::getTranslationPlaceholderContentListByLanguageiso2($myObject->getLanguageiso2(), $myLimit);
	}

	/**
	 * @param TranslationPlaceholderContent &$myTranslationPlaceholderContent
	 * @return Language
	 */
	public static final function getLanguageByTranslationPlaceholderContent(TranslationPlaceholderContent &$myObject){
		Library::requireLibrary(LibraryKeys::APPLICATION_LANGUAGE());
		return LanguageManager::getLanguageByPlaceholdercontent($myObject);
	}

	/**
	 * @param TranslationPlaceholder &$myObject
	 * @return TranslationPlaceholderContent
	 */
	public static final function getTranslationPlaceholderContentByPlaceholder(TranslationPlaceholder &$myObject){
		return self::getTranslationPlaceholderContentByTranslationplaceholderid($myObject->getTranslationplaceholderid());  // blah
	}

	/**
	 * @param TranslationPlaceholderContent &$myTranslationPlaceholderContent
	 * @return TranslationPlaceholder
	 */
	public static final function getPlaceholderByTranslationPlaceholderContent(TranslationPlaceholderContent &$myObject){
		Library::requireLibrary(LibraryKeys::APPLICATION_TRANSLATION_PLACEHOLDER());
		return TranslationPlaceholderManager::getTranslationPlaceholderByPlaceholdercontent($myObject);
	}

}
