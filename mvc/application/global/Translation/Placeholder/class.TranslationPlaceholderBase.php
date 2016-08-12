<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_OBJECT());

/**
 * TranslationPlaceholder Base-Object
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class TranslationPlaceholderBase extends BaseObject { 

	// references
	private $ref_translation_placeholder_content;
	private $ref_translation_template_list = array();

	// attributes
	private $translationplaceholderid;
	private $placeholdername;
	private $tstamp_created;

	/**************************** REFERENCES ****************************/
	/**
	 * @param TranslationPlaceholderContent
	 */
	public function setPlaceholdercontent(TranslationPlaceholderContent &$myObject){
		$this->ref_translation_placeholder_content = $myObject;
			$this->setTranslationplaceholderid($myObject->getTranslationplaceholderid());
		$this->_setIsLoaded('ref_translation_placeholder_content');
	}

	/**
	 * @return TranslationPlaceholderContent
	 */
	public function getPlaceholdercontent(){
		if( !$this->_getIsLoaded('ref_translation_placeholder_content') )
			$this->setPlaceholdercontent(TranslationPlaceholderManager::getPlaceholdercontentByTranslationPlaceholder($this));
		return $this->ref_translation_placeholder_content;
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
			$this->setTranslationtemplateList(TranslationPlaceholderManager::getTranslationTemplateListByTranslationPlaceholder($this, $myLimit));
		return $this->ref_translation_template_list;
	}

	/**************************** ATTRIBUTES ****************************/
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

	/**
	 * @param string $string
	 */
	public function setPlaceholdername($string){
		if(is_null($string))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: placeholdername'));
		if(is_string($string)){
			if( $this->placeholdername !== $string ){
				$this->placeholdername = $string;
				$this->_setModified('placeholdername');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: placeholdername | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getPlaceholdername(){
		return $this->placeholdername;
	}

	/**
	 * @param integer $integer
	 */
	public function setTstampCreated($integer){
		if(is_null($integer))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: tstamp_created'));
		if(is_integer($integer)){
			if( $this->tstamp_created !== $integer ){
				$this->tstamp_created = $integer;
				$this->_setModified('tstamp_created');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: tstamp_created | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getTstampCreated(){
		return $this->tstamp_created;
	}

}
