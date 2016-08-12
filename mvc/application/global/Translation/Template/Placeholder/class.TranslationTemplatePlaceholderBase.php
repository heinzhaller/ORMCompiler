<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_OBJECT());

/**
 * TranslationTemplatePlaceholder Base-Object
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class TranslationTemplatePlaceholderBase extends BaseObject { 

	// references
	private $ref_translation_placeholder_list = array();
	private $ref_translation_template_list = array();

	// attributes
	private $translationtemplateid;
	private $translationplaceholderid;

	/**************************** REFERENCES ****************************/
	/**
	 * @param TranslationPlaceholderList
	 */
	public function setTranslationplaceholderList(TranslationPlaceholderList &$myObject){
		$this->ref_translation_placeholder_list = $myObject;
		$this->_setIsLoaded('ref_translation_placeholder_list');
	}

	/**
	 * @return TranslationPlaceholderList
	 */
	public function getTranslationplaceholderList(SQLLimit &$myLimit = null){
		if( !$this->_getIsLoaded('ref_translation_placeholder_list') )
			$this->setTranslationplaceholderList(TranslationTemplatePlaceholderManager::getTranslationPlaceholderListByTranslationTemplatePlaceholder($this, $myLimit));
		return $this->ref_translation_placeholder_list;
	}

	/**
	 * @param TranslationTemplateList
	 */
	public function setTranslationtemplateList(TranslationTemplateList &$myObject){
		$this->ref_translation_template_list = $myObject;
		$this->_setIsLoaded('ref_translation_template_list');
	}

	/**
	 * @return TranslationTemplateList
	 */
	public function getTranslationtemplateList(SQLLimit &$myLimit = null){
		if( !$this->_getIsLoaded('ref_translation_template_list') )
			$this->setTranslationtemplateList(TranslationTemplatePlaceholderManager::getTranslationTemplateListByTranslationTemplatePlaceholder($this, $myLimit));
		return $this->ref_translation_template_list;
	}

	/**************************** ATTRIBUTES ****************************/
	/**
	 * @param integer $integer
	 */
	public function setTranslationtemplateid($integer){
		if(is_null($integer))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: translationtemplateid'));
		if(is_integer($integer)){
			if( $this->translationtemplateid !== $integer ){
				$this->translationtemplateid = $integer;
				$this->_setModified('translationtemplateid');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: translationtemplateid | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getTranslationtemplateid(){
		return $this->translationtemplateid;
	}

	/**
	 * @param integer $integer
	 */
	public function setTranslationplaceholderid($integer){
		if(is_null($integer))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: translationplaceholderid'));
		if(is_integer($integer)){
			if( $this->translationplaceholderid !== $integer ){
				$this->translationplaceholderid = $integer;
				$this->_setModified('translationplaceholderid');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: translationplaceholderid | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getTranslationplaceholderid(){
		return $this->translationplaceholderid;
	}

}
