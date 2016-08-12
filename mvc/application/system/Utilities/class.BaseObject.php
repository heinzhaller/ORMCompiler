<?php
#ä
/**
 * base object class
 * @author MKaufmann
 */
abstract class BaseObject {
		
	protected $is_new = true;
	protected $is_deleted = false;
	protected $columns = array();
	protected $references_loaded = array();
	
	public function _getIsNew(){
		return $this->is_new;
	}
	
	public function _setIsNew($bool){
		$this->is_new = (bool) $bool;
	}
	
	public function _getIsDeleted(){
		return $this->is_deleted;
	}
	
	public function _setIsDeleted($bool){
		$this->is_deleted = (bool) $bool;
	}
	
	public function _setModified($column){
			$this->columns[$column] = true;
	}
	
	public function _getIsModified($column){
		return ( isset($this->columns[$column]) AND $this->columns[$column] == true ) ? true : false;
	}
	
	public function _getModified(){
		$myArray = array();
		foreach ($this->columns as $col => $value )
			if($value == true)
				$myArray[] = $col;
		return $myArray;
	}
		
	public function _clearModifies(){
		foreach ($this->columns as $col => $value)
			$this->columns[$col] = false;
	}
	
	public function _checkForModify($old, $new){
		return ( $old != $new );
	}
	
	public function _getIsLoaded($ref){
		return isset($this->references_loaded[$ref]) ? $this->references_loaded[$ref] : false;
	}
	
	public function _setIsLoaded($ref){
		$this->references_loaded[$ref] = true;
	}
	
	public function _clearLoaded(){
		$this->references_loaded = array();
	}
	
}
?>