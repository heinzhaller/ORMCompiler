<?php
#ä
/**
 * TranslationPlaceholderContent AbstractionLayer [AL]
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class TranslationPlaceholderContentAbstractionLayer { 

	/**
	 * @return TranslationPlaceholderContentList
	 */
	protected static final function getTranslationPlaceholderContentListBySql($where,array $params = null,SQLLimit $limit = null){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('TranslationPlaceholderContent'));
		return TranslationPlaceholderContentDAO::getTranslationPlaceholderContentListByQuery($where,$params,$limit);
	}

	/**
	 * @param TranslationPlaceholderContent &$myObject
	 */
	public static final function saveOnly(TranslationPlaceholderContent &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('TranslationPlaceholderContent'));
		if( count($myObject->_getModified()) == 0 )
			return false; // return if no changes was made
		TranslationPlaceholderContentDAO::store($myObject);
	}

	/**
	 * @param TranslationPlaceholderContent &$myObject
	 */
	public static function save(TranslationPlaceholderContent &$myObject){
		self::saveOnly($myObject);

		// save Language
		LanguageManager::saveOnly($myObject->getLanguage());
		$myObject->setLanguageiso2($myObject->getLanguage()->getLanguageiso2());

		// save TranslationPlaceholder
		TranslationPlaceholderManager::saveOnly($myObject->getPlaceholder());
		$myObject->setTranslationplaceholderid($myObject->getPlaceholder()->getTranslationplaceholderid());
	}

	/**
	 * @param TranslationPlaceholderContent &$myObject
	 */
	public static function delete(TranslationPlaceholderContent &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('TranslationPlaceholderContent'));
		if($myObject->_getIsNew())
			return false; // return if object is new
		$myObject->_setIsDeleted(true);
		TranslationPlaceholderContentDAO::store($myObject);
	}

}
