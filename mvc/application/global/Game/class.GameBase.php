<?php
#ä
Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_OBJECT());

/**
 * Game Base-Object
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class GameBase extends BaseObject { 

	// references
	private $ref_commentary_list = array();
	private $ref_user;
	private $ref_category_list = array();
	private $ref_game_history_list = array();
	private $ref_game_in_list = array();
	private $ref_game_out;
	private $ref_plattform_list = array();
	private $ref_game_rating;
	private $ref_tag_list = array();
	private $ref_game_view;
	private $ref_image_list = array();
	private $ref_news_list = array();
	private $ref_video_list = array();

	// attributes
	private $gameid;
	private $userid;
	private $title;
	private $title_seo;
	private $description_short;
	private $description_medium;
	private $description;
	private $total_rating = 0;
	private $total_in = 0;
	private $total_out = 0;
	private $tstamp_created;
	private $tstamp_modified;
	private $tstamp_deleted;
	private $reviewtext;
	private $review_rating_graphics;
	private $review_rating_gameplay;
	private $review_rating_fun;
	private $review_rating_motivation;
	private $review_rating_handling;
	private $review_rating_total;
	private $developer;
	private $publisher;
	private $url;
	private $banner;
	private $genre;
	private $releasedate;
	private $players;
	private $languages;
	private $is_special_game = 0;
	private $views = 0;
	private $review_rating_text;
	private $is_active = 1;

	/**************************** REFERENCES ****************************/
	/**
	 * @param CommentaryList
	 */
	public function setCommentaryList(CommentaryList &$myObject){
		$this->ref_commentary_list = $myObject;
		$this->_setIsLoaded('ref_commentary_list');
	}

	/**
	 * @return CommentaryList
	 */
	public function getCommentaryList(SQLLimit &$myLimit = null){
		if( !$this->_getIsLoaded('ref_commentary_list') )
			$this->setCommentaryList(GameManager::getCommentaryListByGame($this, $myLimit));
		return $this->ref_commentary_list;
	}

	/**
	 * @param User
	 */
	public function setUser(User &$myObject){
		$this->ref_user = $myObject;
			$this->setUserid($myObject->getUserid());
		$this->_setIsLoaded('ref_user');
	}

	/**
	 * @return User
	 */
	public function getUser(){
		if( !$this->_getIsLoaded('ref_user') )
			$this->setUser(GameManager::getUserByGame($this));
		return $this->ref_user;
	}

	/**
	 * @param CategoryList
	 */
	public function setCategoryList(CategoryList &$myObject){
		$this->ref_category_list = $myObject;
		$this->_setIsLoaded('ref_category_list');
	}

	/**
	 * @return CategoryList
	 */
	public function getCategoryList(SQLLimit &$myLimit = null){
		if( !$this->_getIsLoaded('ref_category_list') )
			$this->setCategoryList(GameManager::getCategoryListByGame($this, $myLimit));
		return $this->ref_category_list;
	}

	/**
	 * @param GameHistoryList
	 */
	public function setHistoryList(GameHistoryList &$myObject){
		$this->ref_game_history_list = $myObject;
		$this->_setIsLoaded('ref_game_history_list');
	}

	/**
	 * @return GameHistoryList
	 */
	public function getHistoryList(SQLLimit &$myLimit = null){
		if( !$this->_getIsLoaded('ref_game_history_list') )
			$this->setHistoryList(GameManager::getHistoryListByGame($this, $myLimit));
		return $this->ref_game_history_list;
	}

	/**
	 * @param GameInList
	 */
	public function setInList(GameInList &$myObject){
		$this->ref_game_in_list = $myObject;
		$this->_setIsLoaded('ref_game_in_list');
	}

	/**
	 * @return GameInList
	 */
	public function getInList(SQLLimit &$myLimit = null){
		if( !$this->_getIsLoaded('ref_game_in_list') )
			$this->setInList(GameManager::getInListByGame($this, $myLimit));
		return $this->ref_game_in_list;
	}

	/**
	 * @param GameOut
	 */
	public function setOut(GameOut &$myObject){
		$this->ref_game_out = $myObject;
			$this->setGameid($myObject->getGameid());
		$this->_setIsLoaded('ref_game_out');
	}

	/**
	 * @return GameOut
	 */
	public function getOut(){
		if( !$this->_getIsLoaded('ref_game_out') )
			$this->setOut(GameManager::getOutByGame($this));
		return $this->ref_game_out;
	}

	/**
	 * @param PlattformList
	 */
	public function setPlattformList(PlattformList &$myObject){
		$this->ref_plattform_list = $myObject;
		$this->_setIsLoaded('ref_plattform_list');
	}

	/**
	 * @return PlattformList
	 */
	public function getPlattformList(SQLLimit &$myLimit = null){
		if( !$this->_getIsLoaded('ref_plattform_list') )
			$this->setPlattformList(GameManager::getPlattformListByGame($this, $myLimit));
		return $this->ref_plattform_list;
	}

	/**
	 * @param GameRating
	 */
	public function setRating(GameRating &$myObject){
		$this->ref_game_rating = $myObject;
			$this->setGameid($myObject->getGameid());
		$this->_setIsLoaded('ref_game_rating');
	}

	/**
	 * @return GameRating
	 */
	public function getRating(){
		if( !$this->_getIsLoaded('ref_game_rating') )
			$this->setRating(GameManager::getRatingByGame($this));
		return $this->ref_game_rating;
	}

	/**
	 * @param TagList
	 */
	public function setTagList(TagList &$myObject){
		$this->ref_tag_list = $myObject;
		$this->_setIsLoaded('ref_tag_list');
	}

	/**
	 * @return TagList
	 */
	public function getTagList(SQLLimit &$myLimit = null){
		if( !$this->_getIsLoaded('ref_tag_list') )
			$this->setTagList(GameManager::getTagListByGame($this, $myLimit));
		return $this->ref_tag_list;
	}

	/**
	 * @param GameView
	 */
	public function setView(GameView &$myObject){
		$this->ref_game_view = $myObject;
			$this->setGameid($myObject->getGameid());
		$this->_setIsLoaded('ref_game_view');
	}

	/**
	 * @return GameView
	 */
	public function getView(){
		if( !$this->_getIsLoaded('ref_game_view') )
			$this->setView(GameManager::getViewByGame($this));
		return $this->ref_game_view;
	}

	/**
	 * @param ImageList
	 */
	public function setImageList(ImageList &$myObject){
		$this->ref_image_list = $myObject;
		$this->_setIsLoaded('ref_image_list');
	}

	/**
	 * @return ImageList
	 */
	public function getImageList(SQLLimit &$myLimit = null){
		if( !$this->_getIsLoaded('ref_image_list') )
			$this->setImageList(GameManager::getImageListByGame($this, $myLimit));
		return $this->ref_image_list;
	}

	/**
	 * @param NewsList
	 */
	public function setNewsList(NewsList &$myObject){
		$this->ref_news_list = $myObject;
		$this->_setIsLoaded('ref_news_list');
	}

	/**
	 * @return NewsList
	 */
	public function getNewsList(SQLLimit &$myLimit = null){
		if( !$this->_getIsLoaded('ref_news_list') )
			$this->setNewsList(GameManager::getNewsListByGame($this, $myLimit));
		return $this->ref_news_list;
	}

	/**
	 * @param VideoList
	 */
	public function setVideoList(VideoList &$myObject){
		$this->ref_video_list = $myObject;
		$this->_setIsLoaded('ref_video_list');
	}

	/**
	 * @return VideoList
	 */
	public function getVideoList(SQLLimit &$myLimit = null){
		if( !$this->_getIsLoaded('ref_video_list') )
			$this->setVideoList(GameManager::getVideoListByGame($this, $myLimit));
		return $this->ref_video_list;
	}

	/**************************** ATTRIBUTES ****************************/
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
	 * @param integer $integer
	 */
	public function setUserid($integer){
		if(is_null($integer))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: userid'));
		if(is_integer($integer)){
			if( $this->userid !== $integer ){
				$this->userid = $integer;
				$this->_setModified('userid');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: userid | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getUserid(){
		return $this->userid;
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

	/**
	 * @param string $string
	 */
	public function setTitleSeo($string){
		if(is_string($string) OR is_null($string)){
			if( $this->title_seo !== $string ){
				$this->title_seo = $string;
				$this->_setModified('title_seo');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: title_seo | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getTitleSeo(){
		return $this->title_seo;
	}

	/**
	 * @param string $string
	 */
	public function setDescriptionShort($string){
		if(is_null($string))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: description_short'));
		if(is_string($string)){
			if( $this->description_short !== $string ){
				$this->description_short = $string;
				$this->_setModified('description_short');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: description_short | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getDescriptionShort(){
		return $this->description_short;
	}

	/**
	 * @param string $string
	 */
	public function setDescriptionMedium($string){
		if(is_string($string) OR is_null($string)){
			if( $this->description_medium !== $string ){
				$this->description_medium = $string;
				$this->_setModified('description_medium');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: description_medium | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getDescriptionMedium(){
		return $this->description_medium;
	}

	/**
	 * @param string $string
	 */
	public function setDescription($string){
		if(is_null($string))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: description'));
		if(is_string($string)){
			if( $this->description !== $string ){
				$this->description = $string;
				$this->_setModified('description');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: description | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getDescription(){
		return $this->description;
	}

	/**
	 * @param double $double
	 */
	public function setTotalRating($double){
		if(is_null($double))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: total_rating'));
		if(is_double($double)){
			if( $this->total_rating !== $double ){
				$this->total_rating = $double;
				$this->_setModified('total_rating');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: total_rating | Type: double',$double));
		}
	}

	/**
	 * @return double
	 */
	public function getTotalRating(){
		return $this->total_rating;
	}

	/**
	 * @param integer $integer
	 */
	public function setTotalIn($integer){
		if(is_integer($integer) OR is_null($integer)){
			if( $this->total_in !== $integer ){
				$this->total_in = $integer;
				$this->_setModified('total_in');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: total_in | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getTotalIn(){
		return $this->total_in;
	}

	/**
	 * @param integer $integer
	 */
	public function setTotalOut($integer){
		if(is_integer($integer) OR is_null($integer)){
			if( $this->total_out !== $integer ){
				$this->total_out = $integer;
				$this->_setModified('total_out');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: total_out | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getTotalOut(){
		return $this->total_out;
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
	public function setReviewtext($string){
		if(is_string($string) OR is_null($string)){
			if( $this->reviewtext !== $string ){
				$this->reviewtext = $string;
				$this->_setModified('reviewtext');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: reviewtext | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getReviewtext(){
		return $this->reviewtext;
	}

	/**
	 * @param double $double
	 */
	public function setReviewRatingGraphics($double){
		if(is_double($double) OR is_null($double)){
			if( $this->review_rating_graphics !== $double ){
				$this->review_rating_graphics = $double;
				$this->_setModified('review_rating_graphics');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: review_rating_graphics | Type: double',$double));
		}
	}

	/**
	 * @return double
	 */
	public function getReviewRatingGraphics(){
		return $this->review_rating_graphics;
	}

	/**
	 * @param double $double
	 */
	public function setReviewRatingGameplay($double){
		if(is_double($double) OR is_null($double)){
			if( $this->review_rating_gameplay !== $double ){
				$this->review_rating_gameplay = $double;
				$this->_setModified('review_rating_gameplay');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: review_rating_gameplay | Type: double',$double));
		}
	}

	/**
	 * @return double
	 */
	public function getReviewRatingGameplay(){
		return $this->review_rating_gameplay;
	}

	/**
	 * @param double $double
	 */
	public function setReviewRatingFun($double){
		if(is_double($double) OR is_null($double)){
			if( $this->review_rating_fun !== $double ){
				$this->review_rating_fun = $double;
				$this->_setModified('review_rating_fun');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: review_rating_fun | Type: double',$double));
		}
	}

	/**
	 * @return double
	 */
	public function getReviewRatingFun(){
		return $this->review_rating_fun;
	}

	/**
	 * @param double $double
	 */
	public function setReviewRatingMotivation($double){
		if(is_double($double) OR is_null($double)){
			if( $this->review_rating_motivation !== $double ){
				$this->review_rating_motivation = $double;
				$this->_setModified('review_rating_motivation');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: review_rating_motivation | Type: double',$double));
		}
	}

	/**
	 * @return double
	 */
	public function getReviewRatingMotivation(){
		return $this->review_rating_motivation;
	}

	/**
	 * @param double $double
	 */
	public function setReviewRatingHandling($double){
		if(is_double($double) OR is_null($double)){
			if( $this->review_rating_handling !== $double ){
				$this->review_rating_handling = $double;
				$this->_setModified('review_rating_handling');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: review_rating_handling | Type: double',$double));
		}
	}

	/**
	 * @return double
	 */
	public function getReviewRatingHandling(){
		return $this->review_rating_handling;
	}

	/**
	 * @param double $double
	 */
	public function setReviewRatingTotal($double){
		if(is_double($double) OR is_null($double)){
			if( $this->review_rating_total !== $double ){
				$this->review_rating_total = $double;
				$this->_setModified('review_rating_total');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: review_rating_total | Type: double',$double));
		}
	}

	/**
	 * @return double
	 */
	public function getReviewRatingTotal(){
		return $this->review_rating_total;
	}

	/**
	 * @param string $string
	 */
	public function setDeveloper($string){
		if(is_string($string) OR is_null($string)){
			if( $this->developer !== $string ){
				$this->developer = $string;
				$this->_setModified('developer');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: developer | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getDeveloper(){
		return $this->developer;
	}

	/**
	 * @param string $string
	 */
	public function setPublisher($string){
		if(is_string($string) OR is_null($string)){
			if( $this->publisher !== $string ){
				$this->publisher = $string;
				$this->_setModified('publisher');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: publisher | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getPublisher(){
		return $this->publisher;
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
	 * @param string $string
	 */
	public function setBanner($string){
		if(is_string($string) OR is_null($string)){
			if( $this->banner !== $string ){
				$this->banner = $string;
				$this->_setModified('banner');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: banner | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getBanner(){
		return $this->banner;
	}

	/**
	 * @param string $string
	 */
	public function setGenre($string){
		if(is_string($string) OR is_null($string)){
			if( $this->genre !== $string ){
				$this->genre = $string;
				$this->_setModified('genre');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: genre | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getGenre(){
		return $this->genre;
	}

	/**
	 * @param string $string
	 */
	public function setReleasedate($string){
		if(is_string($string) OR is_null($string)){
			if( $this->releasedate !== $string ){
				$this->releasedate = $string;
				$this->_setModified('releasedate');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: releasedate | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getReleasedate(){
		return $this->releasedate;
	}

	/**
	 * @param string $string
	 */
	public function setPlayers($string){
		if(is_string($string) OR is_null($string)){
			if( $this->players !== $string ){
				$this->players = $string;
				$this->_setModified('players');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: players | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getPlayers(){
		return $this->players;
	}

	/**
	 * @param string $string
	 */
	public function setLanguages($string){
		if(is_string($string) OR is_null($string)){
			if( $this->languages !== $string ){
				$this->languages = $string;
				$this->_setModified('languages');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: languages | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getLanguages(){
		return $this->languages;
	}

	/**
	 * @param integer $integer
	 */
	public function setIsSpecialGame($integer){
		if(is_null($integer))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: is_special_game'));
		if(is_integer($integer)){
			if( $this->is_special_game !== $integer ){
				$this->is_special_game = $integer;
				$this->_setModified('is_special_game');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: is_special_game | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getIsSpecialGame(){
		return $this->is_special_game;
	}

	/**
	 * @param integer $integer
	 */
	public function setViews($integer){
		if(is_null($integer))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: views'));
		if(is_integer($integer)){
			if( $this->views !== $integer ){
				$this->views = $integer;
				$this->_setModified('views');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: views | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getViews(){
		return $this->views;
	}

	/**
	 * @param string $string
	 */
	public function setReviewRatingText($string){
		if(is_string($string) OR is_null($string)){
			if( $this->review_rating_text !== $string ){
				$this->review_rating_text = $string;
				$this->_setModified('review_rating_text');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: review_rating_text | Type: string',$string));
		}
	}

	/**
	 * @return string
	 */
	public function getReviewRatingText(){
		return $this->review_rating_text;
	}

	/**
	 * @param integer $integer
	 */
	public function setIsActive($integer){
		if(is_null($integer))
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array('Attribute: is_active'));
		if(is_integer($integer)){
			if( $this->is_active !== $integer ){
				$this->is_active = $integer;
				$this->_setModified('is_active');
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array('Attribute: is_active | Type: integer',$integer));
		}
	}

	/**
	 * @return integer
	 */
	public function getIsActive(){
		return $this->is_active;
	}

}
