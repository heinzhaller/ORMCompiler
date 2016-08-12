<?php
#ä
/**
 * TranslationTemplate AbstractionLayer [AL]
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class TranslationTemplateAbstractionLayer { 

	/**
	 * @return TranslationTemplateList
	 */
	protected static final function getTranslationTemplateListBySql($where,array $params = null,SQLLimit $limit = null){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('TranslationTemplate'));
		return TranslationTemplateDAO::getTranslationTemplateListByQuery($where,$params,$limit);
	}

	/**
	 * @param TranslationTemplate &$myObject
	 */
	public static final function saveOnly(TranslationTemplate &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('TranslationTemplate'));
		if( count($myObject->_getModified()) == 0 )
			return false; // return if no changes was made
		TranslationTemplateDAO::store($myObject);
	}

	/**
	 * @param TranslationTemplate &$myObject
	 */
	public static function save(TranslationTemplate &$myObject){
		self::saveOnly($myObject);

		// save TranslationPlaceholder
		foreach($myObject->getTranslationplaceholderList() as $mySub){
			$m2m_TranslationTemplatePlaceholder = new TranslationTemplatePlaceholder();
			$m2m_TranslationTemplatePlaceholder->setTranslationtemplateid($myObject->getTranslationtemplateid());
			$m2m_TranslationTemplatePlaceholder->setTranslationplaceholderid($mySub->getTranslationplaceholderid());
			TranslationTemplatePlaceholderManager::saveOnly($m2m_TranslationTemplatePlaceholder);
		}
	}

	/**
	 * @param TranslationTemplate &$myObject
	 */
	public static function delete(TranslationTemplate &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('TranslationTemplate'));
		if($myObject->_getIsNew())
			return false; // return if object is new
		$myObject->_setIsDeleted(true);
		TranslationTemplateDAO::store($myObject);
	}

}
