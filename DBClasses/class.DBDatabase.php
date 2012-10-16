<?php
#ä
class DBDatabase {

	// references
	private $tables = array();
	
	// attributes
	private $name;
	
	/**************************** REFERENCES ****************************/
	public function setTables(array $tables){
		$this->tables = $tables;
	}
	
	public function addTable(DBTable &$table){
		$this->tables[] = $table;
	}
	
	public function getTables(){
		return $this->tables;
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