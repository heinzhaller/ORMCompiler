<?php
#ä
/**
 * Library Key List
 * @author MKaufmann
 */
class LibraryKeyList {
	
	public $pos = 0;
	public $list = array( 0 => null );
	
	/**
	 * @param LibraryKeyObject $myObject
	 */
	public function __construct(LibraryKeyObject &$myObject = null){
		if($myObject)
			$this->add($myObject);
	}
	
	/**
	 * @return LibraryKeyObject
	 */
	public function next(){
		if(isset($this->list[$this->pos + 1])){
			return $this->list[++$this->pos];
		}else{
			return false;
		}
	}
	
	/**
	 * @return LibraryKeyObject
	 */
	public function getCurrent(){
		return $this->list[$this->pos];
	}
	
	/**
	 * @param LibraryKeyObject $myObject
	 */
	public function add(LibraryKeyObject &$myObject){
		$this->list[] = $myObject;
	}
	
	public function remove(){
		$this->list[$this->pos] = $myObject;
	}
	
}