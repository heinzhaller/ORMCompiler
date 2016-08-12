<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_OBJECT());

/**
 * TranslationPlaceholderContent Base-Object
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class TranslationPlaceholderContentBase extends BaseObject { 

	// references
	private $ref_language;
	private $ref_translation_placeholder;

	// attributes
	private $translationcontentid;
	private $translationplaceholderid;
	private $languageiso2 = 'DE';
	private $content;
	private $hash;
	private $tstamp_created;
	private $tstamp_modified;

	/**************************** REFERENCES ****************************/
	/**
	 * @param Language
	 */
	public function setLanguage(Language &$myObject){
		$this->ref_language = $myObject;
			$this->setLanguageiso2($myObject->getLanguageiso2());
		$this->_setIsLoaded('ref_language');
	}

	/**
	 * @return Language
	 */
	public function getLanguage(){
		if( !$this->_getIsLoaded('ref_language') )
			$this->setLanguage(TranslationPlaceholderContentManager::getLanguageByTranslationPlaceholderContent($this));
		return $this->ref_language;
	}

	/**
	 * @param TranslationPlaceholder
	 */
	public function setPlaceholder(TranslationPlaceholder &$myObject){
		$this->ref_translation_placeholder = $myObject;
			$this->setTranslationplaceholderid($myObject->getTranslationplaceholderid());
		$this->_setIsLoaded('ref_translation_placeholder');
	}

	/**
	 * @return TranslationPlaceholder
	 */
	public function getPlaceholder(){
		if( !$this->_getIsLoaded('ref_translation_placeholder') )
			$this->setPlaceholder(TranslationPlaceholderContentManager::getPlaceholderByTranslationPlaceholderContent($this));
		return $this->ref_translation_placeholder;
	}

	/**************************** ATTRIBUTES ****************************/
	/**
	 * @param integer $integer
	 */
	public function setTranslationcontentid($integer){
		if(is_null($integer))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: translationcontentid'));
		if(is_integer($integer)){
			if( $this->translationcontentid !== $integer ){
				$this->translationcontentid = $integer;
				$this->_setModified('translationcontentid');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: translationcontentid | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getTranslationcontentid(){
		return $this->translationcontentid;
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

	/**
	 * @param string $string
	 */
	public function setLanguageiso2($string){
		if(is_null($string))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: languageiso2'));
		if(is_string($string)){
			if( $this->languageiso2 !== $string ){
				$this->languageiso2 = $string;
				$this->_setModified('languageiso2');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: languageiso2 | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getLanguageiso2(){
		return $this->languageiso2;
	}

	/**
	 * @param string $string
	 */
	public function setContent($string){
		if(is_null($string))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: content'));
		if(is_string($string)){
			if( $this->content !== $string ){
				$this->content = $string;
				$this->_setModified('content');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: content | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getContent(){
		return $this->content;
	}

	/**
	 * @param string $string
	 */
	public function setHash($string){
		if(is_null($string))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: hash'));
		if(is_string($string)){
			if( $this->hash !== $string ){
				$this->hash = $string;
				$this->_setModified('hash');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: hash | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getHash(){
		return $this->hash;
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

	/**
	 * @param integer $integer
	 */
	public function setTstampModified($integer){
		if(is_integer($integer) OR is_null($integer)){
			if( $this->tstamp_modified !== $integer ){
				$this->tstamp_modified = $integer;
				$this->_setModified('tstamp_modified');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: tstamp_modified | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getTstampModified(){
		return $this->tstamp_modified;
	}

}
