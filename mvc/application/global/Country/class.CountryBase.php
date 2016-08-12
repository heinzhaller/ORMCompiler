<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_OBJECT());

/**
 * Country Base-Object
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class CountryBase extends BaseObject { 

	// references
	private $ref_language_list = array();

	// attributes
	private $countryiso2;
	private $description;
	private $has_clubs;

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
			$this->setLanguageList(CountryManager::getLanguageListByCountry($this, $myLimit));
		return $this->ref_language_list;
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

	/**
	 * @param integer $integer
	 */
	public function setHasClubs($integer){
		if(is_null($integer))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: has_clubs'));
		if(is_integer($integer)){
			if( $this->has_clubs !== $integer ){
				$this->has_clubs = $integer;
				$this->_setModified('has_clubs');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: has_clubs | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getHasClubs(){
		return $this->has_clubs;
	}

}
