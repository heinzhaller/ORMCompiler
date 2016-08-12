<?php
#ä
/**
 * TranslationPlaceholder AbstractionLayer [AL]
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class TranslationPlaceholderAbstractionLayer { 

	/**
	 * @return TranslationPlaceholderList
	 */
	protected static final function getTranslationPlaceholderListBySql($where,array $params = null,SQLLimit $limit = null){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('TranslationPlaceholder'));
		return TranslationPlaceholderDAO::getTranslationPlaceholderListByQuery($where,$params,$limit);
	}

	/**
	 * @param TranslationPlaceholder &$myObject
	 */
	public static final function saveOnly(TranslationPlaceholder &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('TranslationPlaceholder'));
		if( count($myObject->_getModified()) == 0 )
			return false; // return if no changes was made
		TranslationPlaceholderDAO::store($myObject);
	}

	/**
	 * @param TranslationPlaceholder &$myObject
	 */
	public static function save(TranslationPlaceholder &$myObject){
		self::saveOnly($myObject);

		// save TranslationPlaceholderContent
		TranslationPlaceholderContentManager::saveOnly($myObject->getPlaceholdercontent());
		$myObject->setTranslationplaceholderid($myObject->getPlaceholdercontent()->getTranslationplaceholderid());

		// save TranslationTemplate
		foreach($myObject->getTranslationtemplateList() as $mySub){
			$m2m_TranslationTemplatePlaceholder = new TranslationTemplatePlaceholder();
			$m2m_TranslationTemplatePlaceholder->setTranslationplaceholderid($myObject->getTranslationplaceholderid());
			$m2m_TranslationTemplatePlaceholder->setTranslationtemplateid($mySub->getTranslationtemplateid());
			TranslationTemplatePlaceholderManager::saveOnly($m2m_TranslationTemplatePlaceholder);
		}
	}

	/**
	 * @param TranslationPlaceholder &$myObject
	 */
	public static function delete(TranslationPlaceholder &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('TranslationPlaceholder'));
		if($myObject->_getIsNew())
			return false; // return if object is new
		$myObject->_setIsDeleted(true);
		TranslationPlaceholderDAO::store($myObject);
	}

}
