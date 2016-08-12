<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_OBJECT());

/**
 * Video Base-Object
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class VideoBase extends BaseObject { 

	// references
	private $ref_game;

	// attributes
	private $videoid;
	private $gameid;
	private $filename;
	private $url;
	private $tstamp_created;
	private $tstamp_modified;
	private $tstamp_deleted;
	private $title;

	/**************************** REFERENCES ****************************/
	/**
	 * @param Game
	 */
	public function setGame(Game &$myObject){
		$this->ref_game = $myObject;
			$this->setGameid($myObject->getGameid());
		$this->_setIsLoaded('ref_game');
	}

	/**
	 * @return Game
	 */
	public function getGame(){
		if( !$this->_getIsLoaded('ref_game') )
			$this->setGame(VideoManager::getGameByVideo($this));
		return $this->ref_game;
	}

	/**************************** ATTRIBUTES ****************************/
	/**
	 * @param integer $integer
	 */
	public function setVideoid($integer){
		if(is_null($integer))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: videoid'));
		if(is_integer($integer)){
			if( $this->videoid !== $integer ){
				$this->videoid = $integer;
				$this->_setModified('videoid');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: videoid | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getVideoid(){
		return $this->videoid;
	}

	/**
	 * @param integer $integer
	 */
	public function setGameid($integer){
		if(is_null($integer))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: gameid'));
		if(is_integer($integer)){
			if( $this->gameid !== $integer ){
				$this->gameid = $integer;
				$this->_setModified('gameid');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: gameid | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getGameid(){
		return $this->gameid;
	}

	/**
	 * @param string $string
	 */
	public function setFilename($string){
		if(is_string($string) OR is_null($string)){
			if( $this->filename !== $string ){
				$this->filename = $string;
				$this->_setModified('filename');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: filename | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getFilename(){
		return $this->filename;
	}

	/**
	 * @param string $string
	 */
	public function setUrl($string){
		if(is_string($string) OR is_null($string)){
			if( $this->url !== $string ){
				$this->url = $string;
				$this->_setModified('url');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: url | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getUrl(){
		return $this->url;
	}

	/**
	 * @param integer $integer
	 */
	public function setTstampCreated($integer){
		if(is_null($integer))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: tstamp_created'));
		if(is_integer($integer)){
			if( $this->tstamp_created !== $integer ){
				$this->tstamp_created = $integer;
				$this->_setModified('tstamp_created');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: tstamp_created | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getTstampCreated(){
		return $this->tstamp_created;
	}

	/**
	 * @param integer $integer
	 */
	public function setTstampModified($integer){
		if(is_integer($integer) OR is_null($integer)){
			if( $this->tstamp_modified !== $integer ){
				$this->tstamp_modified = $integer;
				$this->_setModified('tstamp_modified');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: tstamp_modified | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getTstampModified(){
		return $this->tstamp_modified;
	}

	/**
	 * @param integer $integer
	 */
	public function setTstampDeleted($integer){
		if(is_integer($integer) OR is_null($integer)){
			if( $this->tstamp_deleted !== $integer ){
				$this->tstamp_deleted = $integer;
				$this->_setModified('tstamp_deleted');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: tstamp_deleted | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getTstampDeleted(){
		return $this->tstamp_deleted;
	}

	/**
	 * @param string $string
	 */
	public function setTitle($string){
		if(is_null($string))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: title'));
		if(is_string($string)){
			if( $this->title !== $string ){
				$this->title = $string;
				$this->_setModified('title');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: title | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getTitle(){
		return $this->title;
	}

}
