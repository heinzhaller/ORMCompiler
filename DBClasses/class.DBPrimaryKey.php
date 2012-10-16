<?php
#ä
class DBPrimaryKey {

	// references
	private $columns = array();
	
	// attributes
	private $name;

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

}
?>