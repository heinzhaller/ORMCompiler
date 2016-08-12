<?php
#ä
/**
 * TranslationTemplatePlaceholder AbstractionLayer [AL]
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class TranslationTemplatePlaceholderAbstractionLayer { 

	/**
	 * @return TranslationTemplatePlaceholderList
	 */
	protected static final function getTranslationTemplatePlaceholderListBySql($where,array $params = null,SQLLimit $limit = null){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('TranslationTemplatePlaceholder'));
		return TranslationTemplatePlaceholderDAO::getTranslationTemplatePlaceholderListByQuery($where,$params,$limit);
	}

	/**
	 * @param TranslationTemplatePlaceholder &$myObject
	 */
	public static final function saveOnly(TranslationTemplatePlaceholder &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('TranslationTemplatePlaceholder'));
		if( count($myObject->_getModified()) == 0 )
			return false; // return if no changes was made
		TranslationTemplatePlaceholderDAO::store($myObject);
	}

	/**
	 * @param TranslationTemplatePlaceholder &$myObject
	 */
	public static function save(TranslationTemplatePlaceholder &$myObject){
		self::saveOnly($myObject);
	}

	/**
	 * @param TranslationTemplatePlaceholder &$myObject
	 */
	public static function delete(TranslationTemplatePlaceholder &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('TranslationTemplatePlaceholder'));
		if($myObject->_getIsNew())
			return false; // return if object is new
		$myObject->_setIsDeleted(true);
		TranslationTemplatePlaceholderDAO::store($myObject);
	}

}
