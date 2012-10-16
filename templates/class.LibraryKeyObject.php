<?php
#ä
/**
 * Library Key Object 
 * @author MKaufmann
 */
class LibraryKeyObject {

	private $path;

	public function __construct($string){
		$this->setPath($string);
	}

	public function getPath(){
		return $this->path;
	}

	public function setPath($string){
		$this->path = trim($string);
	}

}
?>