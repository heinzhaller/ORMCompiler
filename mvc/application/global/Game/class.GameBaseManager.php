<?php
#ä
/**
 * Game Base-Manager
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class GameBaseManager extends GameAbstractionLayer { 

	/**************************** ATTRIBUTES ****************************/
	const GAMEID = 'gameid';
	const USERID = 'userid';
	const TITLE = 'title';
	const TITLE_SEO = 'title_seo';
	const DESCRIPTION_SHORT = 'description_short';
	const DESCRIPTION_MEDIUM = 'description_medium';
	const DESCRIPTION = 'description';
	const TOTAL_RATING = 'total_rating';
	const TOTAL_IN = 'total_in';
	const TOTAL_OUT = 'total_out';
	const TSTAMP_CREATED = 'tstamp_created';
	const TSTAMP_MODIFIED = 'tstamp_modified';
	const TSTAMP_DELETED = 'tstamp_deleted';
	const REVIEWTEXT = 'reviewtext';
	const REVIEW_RATING_GRAPHICS = 'review_rating_graphics';
	const REVIEW_RATING_GAMEPLAY = 'review_rating_gameplay';
	const REVIEW_RATING_FUN = 'review_rating_fun';
	const REVIEW_RATING_MOTIVATION = 'review_rating_motivation';
	const REVIEW_RATING_HANDLING = 'review_rating_handling';
	const REVIEW_RATING_TOTAL = 'review_rating_total';
	const DEVELOPER = 'developer';
	const PUBLISHER = 'publisher';
	const URL = 'url';
	const BANNER = 'banner';
	const GENRE = 'genre';
	const RELEASEDATE = 'releasedate';
	const PLAYERS = 'players';
	const LANGUAGES = 'languages';
	const IS_SPECIAL_GAME = 'is_special_game';
	const VIEWS = 'views';
	const REVIEW_RATING_TEXT = 'review_rating_text';
	const IS_ACTIVE = 'is_active';

	/**************************** SELECT METHODS ****************************/
	/**
	 * @param SQLLimit &$myLimit
	 * @return GameList
	 */
	public static final function getGameList(SQLLimit &$myLimit = null){
		return parent::getGameListBySql('1 = 1', null, $myLimit);
	}

	/**
	 * @param integer $gameid
	 * @param SQLLimit &$myLimit
	 * @return Game or null
	 */
	public static final function getGameByGameid($gameid, SQLLimit &$myLimit = null){
		$myObject = parent::getGameListBySql(self::GAMEID.' = ?', array($gameid), $myLimit);
		return ( $myObject->valid() ? $myObject->current() : null );
	}

	/**
	 * @param integer $userid
	 * @param SQLLimit &$myLimit
	 * @return GameList
	 */
	public static final function getGameListByUserid($userid, SQLLimit &$myLimit = null){
		return parent::getGameListBySql(self::USERID.' = ?', array($userid), $myLimit);
	}

	/**
	 * @param string $title
	 * @param SQLLimit &$myLimit
	 * @return Game or null
	 */
	public static final function getGameByTitle($title, SQLLimit &$myLimit = null){
		$myObject = parent::getGameListBySql(self::TITLE.' = ?', array($title), $myLimit);
		return ( $myObject->valid() ? $myObject->current() : null );
	}

	/**
	 * @param string $title_seo
	 * @param SQLLimit &$myLimit
	 * @return GameList
	 */
	public static final function getGameListByTitleSeo($title_seo, SQLLimit &$myLimit = null){
		return parent::getGameListBySql(self::TITLE_SEO.' = ?', array($title_seo), $myLimit);
	}

	/**
	 * @param string $description_short
	 * @param SQLLimit &$myLimit
	 * @return GameList
	 */
	public static final function getGameListByDescriptionShort($description_short, SQLLimit &$myLimit = null){
		return parent::getGameListBySql(self::DESCRIPTION_SHORT.' = ?', array($description_short), $myLimit);
	}

	/**
	 * @param string $description_medium
	 * @param SQLLimit &$myLimit
	 * @return GameList
	 */
	public static final function getGameListByDescriptionMedium($description_medium, SQLLimit &$myLimit = null){
		return parent::getGameListBySql(self::DESCRIPTION_MEDIUM.' = ?', array($description_medium), $myLimit);
	}

	/**
	 * @param string $description
	 * @param SQLLimit &$myLimit
	 * @return GameList
	 */
	public static final function getGameListByDescription($description, SQLLimit &$myLimit = null){
		return parent::getGameListBySql(self::DESCRIPTION.' = ?', array($description), $myLimit);
	}

	/**
	 * @param double $total_rating
	 * @param SQLLimit &$myLimit
	 * @return GameList
	 */
	public static final function getGameListByTotalRating($total_rating, SQLLimit &$myLimit = null){
		return parent::getGameListBySql(self::TOTAL_RATING.' = ?', array($total_rating), $myLimit);
	}

	/**
	 * @param integer $total_in
	 * @param SQLLimit &$myLimit
	 * @return GameList
	 */
	public static final function getGameListByTotalIn($total_in, SQLLimit &$myLimit = null){
		return parent::getGameListBySql(self::TOTAL_IN.' = ?', array($total_in), $myLimit);
	}

	/**
	 * @param integer $total_out
	 * @param SQLLimit &$myLimit
	 * @return GameList
	 */
	public static final function getGameListByTotalOut($total_out, SQLLimit &$myLimit = null){
		return parent::getGameListBySql(self::TOTAL_OUT.' = ?', array($total_out), $myLimit);
	}

	/**
	 * @param integer $tstamp_created
	 * @param SQLLimit &$myLimit
	 * @return GameList
	 */
	public static final function getGameListByTstampCreated($tstamp_created, SQLLimit &$myLimit = null){
		return parent::getGameListBySql(self::TSTAMP_CREATED.' = ?', array($tstamp_created), $myLimit);
	}

	/**
	 * @param integer $tstamp_modified
	 * @param SQLLimit &$myLimit
	 * @return GameList
	 */
	public static final function getGameListByTstampModified($tstamp_modified, SQLLimit &$myLimit = null){
		return parent::getGameListBySql(self::TSTAMP_MODIFIED.' = ?', array($tstamp_modified), $myLimit);
	}

	/**
	 * @param integer $tstamp_deleted
	 * @param SQLLimit &$myLimit
	 * @return GameList
	 */
	public static final function getGameListByTstampDeleted($tstamp_deleted, SQLLimit &$myLimit = null){
		return parent::getGameListBySql(self::TSTAMP_DELETED.' = ?', array($tstamp_deleted), $myLimit);
	}

	/**
	 * @param string $reviewtext
	 * @param SQLLimit &$myLimit
	 * @return GameList
	 */
	public static final function getGameListByReviewtext($reviewtext, SQLLimit &$myLimit = null){
		return parent::getGameListBySql(self::REVIEWTEXT.' = ?', array($reviewtext), $myLimit);
	}

	/**
	 * @param double $review_rating_graphics
	 * @param SQLLimit &$myLimit
	 * @return GameList
	 */
	public static final function getGameListByReviewRatingGraphics($review_rating_graphics, SQLLimit &$myLimit = null){
		return parent::getGameListBySql(self::REVIEW_RATING_GRAPHICS.' = ?', array($review_rating_graphics), $myLimit);
	}

	/**
	 * @param double $review_rating_gameplay
	 * @param SQLLimit &$myLimit
	 * @return GameList
	 */
	public static final function getGameListByReviewRatingGameplay($review_rating_gameplay, SQLLimit &$myLimit = null){
		return parent::getGameListBySql(self::REVIEW_RATING_GAMEPLAY.' = ?', array($review_rating_gameplay), $myLimit);
	}

	/**
	 * @param double $review_rating_fun
	 * @param SQLLimit &$myLimit
	 * @return GameList
	 */
	public static final function getGameListByReviewRatingFun($review_rating_fun, SQLLimit &$myLimit = null){
		return parent::getGameListBySql(self::REVIEW_RATING_FUN.' = ?', array($review_rating_fun), $myLimit);
	}

	/**
	 * @param double $review_rating_motivation
	 * @param SQLLimit &$myLimit
	 * @return GameList
	 */
	public static final function getGameListByReviewRatingMotivation($review_rating_motivation, SQLLimit &$myLimit = null){
		return parent::getGameListBySql(self::REVIEW_RATING_MOTIVATION.' = ?', array($review_rating_motivation), $myLimit);
	}

	/**
	 * @param double $review_rating_handling
	 * @param SQLLimit &$myLimit
	 * @return GameList
	 */
	public static final function getGameListByReviewRatingHandling($review_rating_handling, SQLLimit &$myLimit = null){
		return parent::getGameListBySql(self::REVIEW_RATING_HANDLING.' = ?', array($review_rating_handling), $myLimit);
	}

	/**
	 * @param double $review_rating_total
	 * @param SQLLimit &$myLimit
	 * @return GameList
	 */
	public static final function getGameListByReviewRatingTotal($review_rating_total, SQLLimit &$myLimit = null){
		return parent::getGameListBySql(self::REVIEW_RATING_TOTAL.' = ?', array($review_rating_total), $myLimit);
	}

	/**
	 * @param string $developer
	 * @param SQLLimit &$myLimit
	 * @return GameList
	 */
	public static final function getGameListByDeveloper($developer, SQLLimit &$myLimit = null){
		return parent::getGameListBySql(self::DEVELOPER.' = ?', array($developer), $myLimit);
	}

	/**
	 * @param string $publisher
	 * @param SQLLimit &$myLimit
	 * @return GameList
	 */
	public static final function getGameListByPublisher($publisher, SQLLimit &$myLimit = null){
		return parent::getGameListBySql(self::PUBLISHER.' = ?', array($publisher), $myLimit);
	}

	/**
	 * @param string $url
	 * @param SQLLimit &$myLimit
	 * @return GameList
	 */
	public static final function getGameListByUrl($url, SQLLimit &$myLimit = null){
		return parent::getGameListBySql(self::URL.' = ?', array($url), $myLimit);
	}

	/**
	 * @param string $banner
	 * @param SQLLimit &$myLimit
	 * @return GameList
	 */
	public static final function getGameListByBanner($banner, SQLLimit &$myLimit = null){
		return parent::getGameListBySql(self::BANNER.' = ?', array($banner), $myLimit);
	}

	/**
	 * @param string $genre
	 * @param SQLLimit &$myLimit
	 * @return GameList
	 */
	public static final function getGameListByGenre($genre, SQLLimit &$myLimit = null){
		return parent::getGameListBySql(self::GENRE.' = ?', array($genre), $myLimit);
	}

	/**
	 * @param string $releasedate
	 * @param SQLLimit &$myLimit
	 * @return GameList
	 */
	public static final function getGameListByReleasedate($releasedate, SQLLimit &$myLimit = null){
		return parent::getGameListBySql(self::RELEASEDATE.' = ?', array($releasedate), $myLimit);
	}

	/**
	 * @param string $players
	 * @param SQLLimit &$myLimit
	 * @return GameList
	 */
	public static final function getGameListByPlayers($players, SQLLimit &$myLimit = null){
		return parent::getGameListBySql(self::PLAYERS.' = ?', array($players), $myLimit);
	}

	/**
	 * @param string $languages
	 * @param SQLLimit &$myLimit
	 * @return GameList
	 */
	public static final function getGameListByLanguages($languages, SQLLimit &$myLimit = null){
		return parent::getGameListBySql(self::LANGUAGES.' = ?', array($languages), $myLimit);
	}

	/**
	 * @param integer $is_special_game
	 * @param SQLLimit &$myLimit
	 * @return GameList
	 */
	public static final function getGameListByIsSpecialGame($is_special_game, SQLLimit &$myLimit = null){
		return parent::getGameListBySql(self::IS_SPECIAL_GAME.' = ?', array($is_special_game), $myLimit);
	}

	/**
	 * @param integer $views
	 * @param SQLLimit &$myLimit
	 * @return GameList
	 */
	public static final function getGameListByViews($views, SQLLimit &$myLimit = null){
		return parent::getGameListBySql(self::VIEWS.' = ?', array($views), $myLimit);
	}

	/**
	 * @param string $review_rating_text
	 * @param SQLLimit &$myLimit
	 * @return GameList
	 */
	public static final function getGameListByReviewRatingText($review_rating_text, SQLLimit &$myLimit = null){
		return parent::getGameListBySql(self::REVIEW_RATING_TEXT.' = ?', array($review_rating_text), $myLimit);
	}

	/**
	 * @param integer $is_active
	 * @param SQLLimit &$myLimit
	 * @return GameList
	 */
	public static final function getGameListByIsActive($is_active, SQLLimit &$myLimit = null){
		return parent::getGameListBySql(self::IS_ACTIVE.' = ?', array($is_active), $myLimit);
	}

	/**************************** REFERENCES ****************************/
	/**
	 * @param Commentary &$myObject
	 * @return Game
	 */
	public static final function getGameByCommentary(Commentary &$myObject){
		return self::getGameByGameid($myObject->getGameid());  // blah
	}

	/**
	 * @param Game &$myGame
	 * @return CommentaryList
	 */
	public static final function getCommentaryListByGame(Game &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_COMMENTARY());
		return CommentaryManager::getCommentaryListByGame($myObject, $myLimit);
	}

	/**
	 * @param User &$myObject
	 * @return GameList
	 */
	public static final function getGameListByUser(User &$myObject, SQLLimit &$myLimit = null){
		return self::getGameListByUserid($myObject->getUserid(), $myLimit);
	}

	/**
	 * @param Game &$myGame
	 * @return User
	 */
	public static final function getUserByGame(Game &$myObject){
		Library::requireLibrary(LibraryKeys::APPLICATION_USER());
		return UserManager::getUserByGame($myObject);
	}

	/**
	 * @param Category &$myObject
	 * @return GameList
	 */
	public static final function getGameListByCategory(Category &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_GAME_CATEGORY());
		$myList = GameCategoryManager::getGameCategoryListByCategory($myObject, $myLimit);
		$myGameList = new GameList();
		foreach($myList as $item)
			$myGameList->add(self::getGameByGameid($item->getGameid()));
		return $myGameList;
	}

	/**
	 * @param Game &$myGame
	 * @return CategoryList
	 */
	public static final function getCategoryListByGame(Game &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_CATEGORY());
		return CategoryManager::getCategoryListByGame($myObject, $myLimit);
	}

	/**
	 * @param GameHistory &$myObject
	 * @return Game
	 */
	public static final function getGameByHistory(GameHistory &$myObject){
		return self::getGameByGameid($myObject->getGameid());  // blah
	}

	/**
	 * @param Game &$myGame
	 * @return GameHistoryList
	 */
	public static final function getHistoryListByGame(Game &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_GAME_HISTORY());
		return GameHistoryManager::getGameHistoryListByGame($myObject, $myLimit);
	}

	/**
	 * @param GameIn &$myObject
	 * @return Game
	 */
	public static final function getGameByIn(GameIn &$myObject){
		return self::getGameByGameid($myObject->getGameid());  // blah
	}

	/**
	 * @param Game &$myGame
	 * @return GameInList
	 */
	public static final function getInListByGame(Game &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_GAME_IN());
		return GameInManager::getGameInListByGame($myObject, $myLimit);
	}

	/**
	 * @param GameOut &$myObject
	 * @return Game
	 */
	public static final function getGameByOut(GameOut &$myObject){
		return self::getGameByGameid($myObject->getGameid());  // blah
	}

	/**
	 * @param Game &$myGame
	 * @return GameOut
	 */
	public static final function getOutByGame(Game &$myObject){
		Library::requireLibrary(LibraryKeys::APPLICATION_GAME_OUT());
		return GameOutManager::getGameOutByGame($myObject);
	}

	/**
	 * @param Plattform &$myObject
	 * @return GameList
	 */
	public static final function getGameListByPlattform(Plattform &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_GAME_PLATTFORM());
		$myList = GamePlattformManager::getGamePlattformListByPlattform($myObject, $myLimit);
		$myGameList = new GameList();
		foreach($myList as $item)
			$myGameList->add(self::getGameByGameid($item->getGameid()));
		return $myGameList;
	}

	/**
	 * @param Game &$myGame
	 * @return PlattformList
	 */
	public static final function getPlattformListByGame(Game &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_PLATTFORM());
		return PlattformManager::getPlattformListByGame($myObject, $myLimit);
	}

	/**
	 * @param GameRating &$myObject
	 * @return Game
	 */
	public static final function getGameByRating(GameRating &$myObject){
		return self::getGameByGameid($myObject->getGameid());  // blah
	}

	/**
	 * @param Game &$myGame
	 * @return GameRating
	 */
	public static final function getRatingByGame(Game &$myObject){
		Library::requireLibrary(LibraryKeys::APPLICATION_GAME_RATING());
		return GameRatingManager::getGameRatingByGame($myObject);
	}

	/**
	 * @param Tag &$myObject
	 * @return GameList
	 */
	public static final function getGameListByTag(Tag &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_GAME_TAG());
		$myList = GameTagManager::getGameTagListByTag($myObject, $myLimit);
		$myGameList = new GameList();
		foreach($myList as $item)
			$myGameList->add(self::getGameByGameid($item->getGameid()));
		return $myGameList;
	}

	/**
	 * @param Game &$myGame
	 * @return TagList
	 */
	public static final function getTagListByGame(Game &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_TAG());
		return TagManager::getTagListByGame($myObject, $myLimit);
	}

	/**
	 * @param GameView &$myObject
	 * @return Game
	 */
	public static final function getGameByView(GameView &$myObject){
		return self::getGameByGameid($myObject->getGameid());  // blah
	}

	/**
	 * @param Game &$myGame
	 * @return GameView
	 */
	public static final function getViewByGame(Game &$myObject){
		Library::requireLibrary(LibraryKeys::APPLICATION_GAME_VIEW());
		return GameViewManager::getGameViewByGame($myObject);
	}

	/**
	 * @param Image &$myObject
	 * @return Game
	 */
	public static final function getGameByImage(Image &$myObject){
		return self::getGameByGameid($myObject->getGameid());  // blah
	}

	/**
	 * @param Game &$myGame
	 * @return ImageList
	 */
	public static final function getImageListByGame(Game &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_IMAGE());
		return ImageManager::getImageListByGame($myObject, $myLimit);
	}

	/**
	 * @param News &$myObject
	 * @return Game
	 */
	public static final function getGameByNews(News &$myObject){
		return self::getGameByGameid($myObject->getGameid());  // blah
	}

	/**
	 * @param Game &$myGame
	 * @return NewsList
	 */
	public static final function getNewsListByGame(Game &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_NEWS());
		return NewsManager::getNewsListByGame($myObject, $myLimit);
	}

	/**
	 * @param Video &$myObject
	 * @return Game
	 */
	public static final function getGameByVideo(Video &$myObject){
		return self::getGameByGameid($myObject->getGameid());  // blah
	}

	/**
	 * @param Game &$myGame
	 * @return VideoList
	 */
	public static final function getVideoListByGame(Game &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_VIDEO());
		return VideoManager::getVideoListByGame($myObject, $myLimit);
	}

}
