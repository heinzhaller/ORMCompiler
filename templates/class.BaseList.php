<?php
#ä
class BaseList implements IteratorAggregate {

	protected $list;
	public $pos  = 0;

	public function __construct(){
		$this->pos = 0;
		$this->list = array();
	}

	/**
	 * foreach
	 * @return MyIterator
	 */
	public function getIterator() {
		return new BaseIterator($this->list);
	}

	/**
	 * extract current element from list
	 */
	public function extract(){
		$object = $this->current();
		$this->remove();
		return $object;
	}

	/**
	 * remove current element
	 */
	public function remove(){
		unset($this->list[$this->pos]);
		$this->list = array_values($this->list); // keys neu generien
		$this->next();
	}

	public function add(&$myObject){
		$this->list[] = $myObject;
	}

	public function rewind(){
		$this->pos = 0;
	}

	public function current(){
		return $this->list[$this->pos];
	}

	public function get($pos){
		return $this->list[$pos];
	}

	public function key() {
		return $this->pos;
	}

	public function pos() {
		return $this->pos;
	}

	public function next(){
		if( $this->pos == (count($this->list)-1) ){
			$this->reset();
			return false;
		}else{
			return $this->list[++$this->pos];
		}
	}

	public function reset(){
		if( $this->count() == 0 )
			return false;
		$this->pos = 0;
		return true;
	}

	public function valid() {
		return isset($this->list[$this->pos]);
	}

	public function count(){
		return count($this->list);
	}

	public function shuffle(){
		shuffle($this->list);
	}

	public function toArray(){
		return (array) $this->list;
	}

	/**
	 * extract first element from list
	 */
	public function shift(){
		return array_shift($this->list);
	}

	/**
	 * extract last element from list
	 */
	public function pop(){
		return array_pop($this->list);
	}

	public function reverse(){
		krsort($this->list);
	}

}