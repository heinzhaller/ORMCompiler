<?php
#ä
/**
 * Game AbstractionLayer [AL]
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class GameAbstractionLayer { 

	/**
	 * @return GameList
	 */
	protected static final function getGameListBySql($where,array $params = null,SQLLimit $limit = null){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('Game'));
		return GameDAO::getGameListByQuery($where,$params,$limit);
	}

	/**
	 * @param Game &$myObject
	 */
	public static final function saveOnly(Game &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('Game'));
		if( count($myObject->_getModified()) == 0 )
			return false; // return if no changes was made
		GameDAO::store($myObject);
	}

	/**
	 * @param Game &$myObject
	 */
	public static function save(Game &$myObject){
		self::saveOnly($myObject);

		// save Commentary
		foreach($myObject->getCommentaryList() as $sub){
			$sub->setGameid($myObject->getGameid());
			CommentaryManager::saveOnly($sub);
		}

		// save User
		UserManager::saveOnly($myObject->getUser());
		$myObject->setUserid($myObject->getUser()->getUserid());

		// save Category
		foreach($myObject->getCategoryList() as $mySub){
			$m2m_GameCategory = new GameCategory();
			$m2m_GameCategory->setGameid($myObject->getGameid());
			$m2m_GameCategory->setCategoryid($mySub->getCategoryid());
			GameCategoryManager::saveOnly($m2m_GameCategory);
		}

		// save GameHistory
		foreach($myObject->getHistoryList() as $sub){
			$sub->setGameid($myObject->getGameid());
			GameHistoryManager::saveOnly($sub);
		}

		// save GameIn
		foreach($myObject->getInList() as $sub){
			$sub->setGameid($myObject->getGameid());
			GameInManager::saveOnly($sub);
		}

		// save GameOut
		GameOutManager::saveOnly($myObject->getOut());
		$myObject->setGameid($myObject->getOut()->getGameid());

		// save Plattform
		foreach($myObject->getPlattformList() as $mySub){
			$m2m_GamePlattform = new GamePlattform();
			$m2m_GamePlattform->setGameid($myObject->getGameid());
			$m2m_GamePlattform->setPlattformid($mySub->getPlattformid());
			GamePlattformManager::saveOnly($m2m_GamePlattform);
		}

		// save GameRating
		GameRatingManager::saveOnly($myObject->getRating());
		$myObject->setGameid($myObject->getRating()->getGameid());

		// save Tag
		foreach($myObject->getTagList() as $mySub){
			$m2m_GameTag = new GameTag();
			$m2m_GameTag->setGameid($myObject->getGameid());
			$m2m_GameTag->setTagid($mySub->getTagid());
			GameTagManager::saveOnly($m2m_GameTag);
		}

		// save GameView
		GameViewManager::saveOnly($myObject->getView());
		$myObject->setGameid($myObject->getView()->getGameid());

		// save Image
		foreach($myObject->getImageList() as $sub){
			$sub->setGameid($myObject->getGameid());
			ImageManager::saveOnly($sub);
		}

		// save News
		foreach($myObject->getNewsList() as $sub){
			$sub->setGameid($myObject->getGameid());
			NewsManager::saveOnly($sub);
		}

		// save Video
		foreach($myObject->getVideoList() as $sub){
			$sub->setGameid($myObject->getGameid());
			VideoManager::saveOnly($sub);
		}
	}

	/**
	 * @param Game &$myObject
	 */
	public static function delete(Game &$myObject){
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC('Game'));
		if($myObject->_getIsNew())
			return false; // return if object is new
		$myObject->_setIsDeleted(true);
		GameDAO::store($myObject);
	}

}
