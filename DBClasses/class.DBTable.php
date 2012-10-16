<?php
#ä
class DBTable {

	// references
	private $columns = array();
	private $foreign_keys = array();
	private $indices = array();
	private $primary_key;

	// attributes
	private $name;
	private $comment;

	/**************************** REFERENCES ****************************/
	public function setColumns(array $columns){
		$this->columns = $columns;
	}

	public function addColumn(DBColumn &$column){
		$this->columns[] = $column;
	}

	/**
	 * return DBColumn
	 */
	public function getColumns(){
		return $this->columns;
	}

	public function setForeignKeys(array $foreignkeys){
		$this->foreign_keys = $foreignkeys;
	}

	public function addForeignKey(DBForeignKey &$foreignkey){
		$this->foreign_keys[] = $foreignkey;
	}

	/**
	 * @return DBForeignKey
	 */
	public function getForeignKeys(){
		return $this->foreign_keys;
	}

	public function setIndices(array $indices){
		$this->indices = $indices;
	}

	public function addIndex(DBIndex &$foreignkey){
		$this->indices[] = $foreignkey;
	}

	public function getIndices(){
		return $this->indices;
	}

	public function setPrimaryKey(DBPrimaryKey &$primarykey){
		$this->primary_key = $primarykey;
	}

	/**
	 * @return DBPrimaryKey
	 */
	public function getPrimaryKey(){
		return $this->primary_key;
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