<?php
#ä
/*
- str name
- int type
- str typname
- int size
- int sizetype
- bool is_nullable
- bool is_autoincrement
- str defaultvalue
 */
class DBColumn {

	// references
	private $table;
	
	// attributes
	private $name;
	private $type;
	private $typname;
	private $size;
	private $sizetype;
	private $is_nullable;
	private $is_autoincrement;
	private $defaultvalue;
	private $comment;

	/**************************** REFERENCES ****************************/
	public function setTable(DBTable &$table){
		$this->table = &$table;
	}
	
	public function getTable(){
		return $this->table;
	}
	
	/**************************** ATTRIBUTES ****************************/
	public function setName($string){
		if(is_string($string) OR is_null($string)){
			$this->name = $string;
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('string',$string));
		}
	}

	public function getName(){
		return $this->name;
	}

	public function setType($integer){
		if(is_integer($integer) OR is_null($integer)){
			$this->type = $integer;
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('integer',$integer));
		}
	}

	public function getType(){
		return $this->type;
	}

	public function setTypname($string){
		if(is_string($string) OR is_null($string)){
			$this->typname = $string;
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('string',$string));
		}
	}

	public function getTypname(){
		return $this->typname;
	}

	public function setSize($float){
		if(is_float($float) OR is_null($float)){
			$this->size = $float;
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('float',$float));
		}
	}

	public function getSize(){
		return $this->size;
	}

	public function setSizetype($integer){
		if(is_integer($integer) OR is_null($integer)){
			$this->sizetype = $integer;
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('integer',$integer));
		}
	}

	public function getSizetype(){
		return $this->sizetype;
	}

	public function setIsNullable($bool){
		if(is_bool($bool) OR is_null($bool)){
			$this->is_nullable = $bool;
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('bool',$bool));
		}
	}

	public function getIsNullable(){
		return $this->is_nullable;
	}

	public function setIsAutoincrement($bool){
		if(is_bool($bool) OR is_null($bool)){
			$this->is_autoincrement = $bool;
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('bool',$bool));
		}
	}

	public function getIsAutoincrement(){
		return $this->is_autoincrement;
	}

	/**
	 * @param (dirty) $value
	 */
	public function setDefaultvalue($value){
		$this->defaultvalue = $value;
	}

	public function getDefaultvalue(){
		return $this->defaultvalue;
	}
	
	public function setComment($string){
		if(is_string($string) OR is_null($string)){
			$this->comment = $string;
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('string',$string));
		}
	}

	public function getComment(){
		return $this->comment;
	}

}
?>