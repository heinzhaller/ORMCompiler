<?php
#ä
class DBIndex {
	
	// references
	private $columns = array();
	
	// attributes
	private $name;
	private $type;
	private $is_unique;

	/**************************** REFERENCES ****************************/
	public function setColumns(array $columns){
		$this->columns = $columns;
	}
	
	public function addColumn(DBColumn &$column){
		$this->columns[] = $column;
	}
	
	public function getColumns(){
		return $this->columns;
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

	public function setIsUnique($bool){
		if(is_bool($bool) OR is_null($bool)){
			$this->is_unique = $bool;
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('bool',$bool));
		}
	}

	public function getIsUnique(){
		return $this->is_unique;
	}

}

?>