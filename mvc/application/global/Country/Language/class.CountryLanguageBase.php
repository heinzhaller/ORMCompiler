<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_OBJECT());

/**
 * CountryLanguage Base-Object
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class CountryLanguageBase extends BaseObject { 

	// references
	private $ref_language_list = array();
	private $ref_country_list = array();

	// attributes
	private $countryiso2;
	private $languageiso2;

	/**************************** REFERENCES ****************************/
	/**
	 * @param LanguageList
	 */
	public function setLanguageList(LanguageList &$myObject){
		$this->ref_language_list = $myObject;
		$this->_setIsLoaded('ref_language_list');
	}

	/**
	 * @return LanguageList
	 */
	public function getLanguageList(SQLLimit &$myLimit = null){
		if( !$this->_getIsLoaded('ref_language_list') )
			$this->setLanguageList(CountryLanguageManager::getLanguageListByCountryLanguage($this, $myLimit));
		return $this->ref_language_list;
	}

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
			$this->setCountryList(CountryLanguageManager::getCountryListByCountryLanguage($this, $myLimit));
		return $this->ref_country_list;
	}

	/**************************** ATTRIBUTES ****************************/
	/**
	 * @param string $string
	 */
	public function setCountryiso2($string){
		if(is_null($string))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: countryiso2'));
		if(is_string($string)){
			if( $this->countryiso2 !== $string ){
				$this->countryiso2 = $string;
				$this->_setModified('countryiso2');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: countryiso2 | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getCountryiso2(){
		return $this->countryiso2;
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

}
