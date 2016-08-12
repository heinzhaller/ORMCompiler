<?php
#ä
class BaseIterator implements Iterator {
	
    private $position = 0;
    private $array = array();

    public function __construct(array $array) {
        $this->position = 0;
        $this->array = $array;        
    }

    function rewind() {
        #var_dump(__METHOD__);
        $this->position = 0;
    }

    function current() {
        #var_dump(__METHOD__);
        return $this->array[$this->position];
    }

    function key() {
        #var_dump(__METHOD__);
        return $this->position;
    }

    function next() {
        #var_dump(__METHOD__);
        ++$this->position;
    }

    function valid() {
        #var_dump(__METHOD__);
        return isset($this->array[$this->position]);
    }
}
?>