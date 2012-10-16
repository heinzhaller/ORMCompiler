<?php
#ä

/**
 * mysql limit
 * @author mkaufmann
 */
class SQLLimit {

	private $limit = null;
	private $offset = null;

	public function SQLLimit($limit, $offset = null){
		$this->limit = is_numeric($limit)? $limit: null;
		$this->offset = is_numeric($offset)? $offset: null;
	}

	public function getLimit(){
		return $this->limit;
	}

	public function getOffset(){
		return $this->offset;
	}

	public function getQueryWithLimitation($query){
		if(isset($this->limit) && is_numeric($this->limit)){
			if(isset($this->offset) && is_numeric($this->offset)){
				$limitQuery = $query.' LIMIT ?, ?';
			}else{
				$limitQuery = $query.' LIMIT ?';
			}
		}
		return $limitQuery;
	}
}
