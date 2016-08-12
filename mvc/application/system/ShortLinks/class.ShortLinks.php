<?php
class ShortLinks{
	private $shortUrl;
	
	public function getShortUrl(){
		return $this->shortUrl;	
	}
	
	public function setShortUrl($shortUrl){
		$this->shortUrl = $shortUrl;
	}
}
