<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_OBJECT());

/**
 * Language Base-Object
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class LanguageBase extends BaseObject { 

	// references
	private $ref_country_list = array();
	private $ref_translation_placeholder_content_list = array();

	// attributes
	private $languageiso2;
	private $description;

	/**************************** REFERENCES ****************************/
	/**
	 * @param CountryList
	 */
	public function setCountryList(CountryList &$myObject){
		$this->ref_country_list = $myObject;
		$this->_setIsLoaded('ref_country_list');
	}

	/**
	 * @return CountryList
	 */
	public function getCountryList(SQLLimit &$myLimit = null){
		if( !$this->_getIsLoaded('ref_country_list') )
			$this->setCountryList(LanguageManager::getCountryListByLanguage($this, $myLimit));
		return $this->ref_country_list;
	}

	/**
	 * @param TranslationPlaceholderContentList
	 */
	public function setPlaceholdercontentList(TranslationPlaceholderContentList &$myObject){
		$this->ref_translation_placeholder_content_list = $myObject;
		$this->_setIsLoaded('ref_translation_placeholder_content_list');
	}

	/**
	 * @return TranslationPlaceholderContentList
	 */
	public function getPlaceholdercontentList(SQLLimit &$myLimit = null){
		if( !$this->_getIsLoaded('ref_translation_placeholder_content_list') )
			$this->setPlaceholdercontentList(LanguageManager::getPlaceholdercontentListByLanguage($this, $myLimit));
		return $this->ref_translation_placeholder_content_list;
	}

	/**************************** ATTRIBUTES ****************************/
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
	public function setDescription($string){
		if(is_string($string) OR is_null($string)){
			if( $this->description !== $string ){
				$this->description = $string;
				$this->_setModified('description');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: description | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getDescription(){
		return $this->description;
	}

}
