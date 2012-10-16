<?php
#ä
class DBForeignKey {

	// attributes
	private $name;
	private $foreign_type;
	private $foreign_column;
	private $foreign_table;
	
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

	public function setForeignType($integer){
		if(is_integer($integer) OR is_null($integer)){
			$this->foreign_type = $integer;
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('integer',$integer));
		}
	}

	public function getForeignType(){
		return $this->foreign_type;
	}
	
	public function setForeignTable($string){
		if(is_string($string) OR is_null($string)){
			$this->foreign_table = $string;
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('string',$string));
		}
	}

	public function getForeignTable(){
		return $this->foreign_table;
	}
	
	public function setForeignColumn($string){
		if(is_string($string) OR is_null($string)){
			$this->foreign_column = $string;
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('string',$string));
		}
	}

	public function getForeignColumn(){
		return $this->foreign_column;
	}
	
}
?>