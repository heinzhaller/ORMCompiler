<?php
#ä
/*
- str db_driver nn
- str db_host nn
- str db_database nn
- str db_loginname nn
- str db_password nn
- str application_path nn
- str abstraction_path nn
*/

require_once 'class.ORMBase.php';

class ORMConfig extends ORMBase {

	private $count = 0;
	private $count_must_have = 12;

	// attributes
	private $creole_path;
	public $pdo;
	private $db_driver;
	private $db_host;
	private $db_database;
	private $db_loginname;
	private $db_password;
	private $db_charset;
	private $application_path;
	private $abstraction_path;
	private $system_path;
	private $include_system = true;

	private $reference_unassigned = true;

	/**************************** ATTRIBUTES ****************************/

	public function setCreolePath($string){
		if(is_string($string) OR is_null($string)){
			$this->creole_path = $string;
			$this->count++;
		}
	}

	public function getCreolePath(){
		return $this->creole_path;
	}


	public function setDbDriver($string){
		if(!isset($string) OR strlen($string) == 0)
			throw new Exception('value cannot be null', 303);
		if(is_string($string)){
			$this->db_driver = $string;
			$this->count++;
		}
	}

	public function getDbDriver(){
		return $this->db_driver;
	}

	public function setDbHost($string){
		if(!isset($string) OR strlen($string) == 0)
			throw new Exception('value cannot be null',303);
		if(is_string($string)){
			$this->db_host = $string;
			$this->count++;
		}
	}

	public function getDbHost(){
		return $this->db_host;
	}

	public function setDbDatabase($string){
		if(!isset($string) OR strlen($string) == 0)
			throw new Exception('value cannot be null', 303);
		if(is_string($string)){
			$this->db_database = $string;
			$this->count++;
		}else{
			throw new Exception('value must be string');
		}
	}

	public function getDbDatabase(){
		return $this->db_database;
	}

	public function setDbLoginname($string){
		if(!isset($string) OR strlen($string) == 0)
			throw new Exception('value cannot be null', 303);
		if(is_string($string)){
			$this->db_loginname = $string;
			$this->count++;
		}else{
			throw new Exception('value must be string');
		}
	}

	public function getDbLoginname(){
		return $this->db_loginname;
	}

	public function setDbPassword($string){
		if(!isset($string) OR strlen($string) == 0)
			throw new Exception('value cannot be null', 303);
		if(is_string($string)){
			$this->db_password = $string;
			$this->count++;
		}else{
			throw new Exception('value must be string');
		}
	}

	public function getDbPassword(){
		return $this->db_password;
	}

	public function setDbCharset($string){
		if(!isset($string) OR strlen($string) == 0)
			throw new Exception('value cannot be null', 303);
		if(is_string($string)){
			$this->db_charset = $string;
			$this->count++;
		}else{
			throw new Exception('value must be string');
		}
	}

	public function getDbCharset(){
		return $this->db_charset;
	}

	public function setApplicationPath($string){
		if(!isset($string) OR strlen($string) == 0)
			throw new Exception('value cannot be null', 303);
		if(is_string($string)){
			$this->application_path = $string;
			$this->count++;
		}else{
			throw new Exception('value must be string');
		}
	}

	public function getApplicationPath(){
		return $this->application_path;
	}

	public function setAbstractionPath($string){
		if(!isset($string) OR strlen($string) == 0)
			throw new Exception('value cannot be null', 303);
		if(is_string($string)){
			$this->abstraction_path = $string;
			$this->count++;
		}else{
			throw new Exception('value must be string');
		}
	}

	public function getAbstractionPath(){
		return $this->abstraction_path;
	}

	public function setSystemPath($string){
		if(!isset($string) OR strlen($string) == 0)
			throw new Exception('value cannot be null', 303);
		if(is_string($string)){
			$this->system_path = $string;
			$this->count++;
		}else{
			throw new Exception('value must be string');
		}
	}

	public function getSystemPath(){
		return $this->system_path;
	}

	public function setIncludeSystem($bool){
		if(!isset($bool))
			throw new Exception('value cannot be null', 303);
		if(is_bool($bool)){
			$this->include_system = $bool;
			$this->count++;
		}else{
			throw new Exception('includesystem value must be bool');
		}
	}

	public function getIncludeSystem(){
		return $this->include_system;
	}

	public function setReferenceIsUnassigned($bool){
		if(!isset($bool))
			throw new Exception('value cannot be null', 303);
		if(is_bool($bool)){
			$this->reference_unassigned = $bool;
			$this->count++;
		}else{
			throw new Exception('is_unassign value must be bool');
		}
	}

	public function getReferenceIsUnassigned(){
		return $this->reference_unassigned;
	}

	public function isValid(){
		return ($this->count == $this->count_must_have);
	}

	public function reset(){
		$this->count = 0;
		$this->count_must_have = 12;
	}

}
?>