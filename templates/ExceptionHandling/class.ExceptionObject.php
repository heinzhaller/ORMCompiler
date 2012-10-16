<?php
#ä
/**
 * extended exception object
 * @author mrimpler 2010-01-08
 * @version 1.0
 */
class ExceptionObject extends Exception {
	
	private $layer;
	private $type;
	
	public function __construct($code, $params = null){
		parent::__construct(null, $code);
		ExceptionHandler::getExceptionByCode($this, $code, $params);
	}
	
	public function setType($type){
		$this->type = $type;
	}
	
	public function getType(){
		return $this->type;
	}
	
	public function setLayer($layer){
		$this->layer = $layer;
	}
	
	public function getLayer(){
		return $this->layer;
	}
	
	public function setLine($line){
		$this->line = $line;
	}
	
	public function setFile($file){
		$this->file = $file;
	}
		
	public function setMessage($message){
		$this->message = $message;
	}
		
	public function setCode($code){
		$this->code = $code;
	}
		
}
?>