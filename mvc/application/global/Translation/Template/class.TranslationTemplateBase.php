<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_OBJECT());

/**
 * TranslationTemplate Base-Object
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class TranslationTemplateBase extends BaseObject { 

	// references
	private $ref_translation_placeholder_list = array();

	// attributes
	private $translationtemplateid;
	private $templatename;
	private $commentary;
	private $tstamp_created;

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
			$this->setTranslationplaceholderList(TranslationTemplateManager::getTranslationPlaceholderListByTranslationTemplate($this, $myLimit));
		return $this->ref_translation_placeholder_list;
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
	 * @param string $string
	 */
	public function setTemplatename($string){
		if(is_null($string))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: templatename'));
		if(is_string($string)){
			if( $this->templatename !== $string ){
				$this->templatename = $string;
				$this->_setModified('templatename');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: templatename | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getTemplatename(){
		return $this->templatename;
	}

	/**
	 * @param string $string
	 */
	public function setCommentary($string){
		if(is_null($string))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: commentary'));
		if(is_string($string)){
			if( $this->commentary !== $string ){
				$this->commentary = $string;
				$this->_setModified('commentary');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: commentary | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getCommentary(){
		return $this->commentary;
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
