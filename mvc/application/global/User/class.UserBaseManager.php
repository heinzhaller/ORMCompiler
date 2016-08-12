<?php
#ä
/**
 * User Base-Manager
 * @author Mario Kaufmann
 * @version 0.1 beta
 */
abstract class UserBaseManager extends UserAbstractionLayer { 

	/**************************** ATTRIBUTES ****************************/
	const USERID = 'userid';
	const USERNAME = 'username';
	const PASSWORD = 'password';
	const EMAIL = 'email';
	const TSTAMP_CREATED = 'tstamp_created';
	const TSTAMP_MODIFIED = 'tstamp_modified';
	const TSTAMP_DELETED = 'tstamp_deleted';
	const STATUSNAME = 'statusname';
	const TSTAMP_CONFIRMED = 'tstamp_confirmed';

	/**************************** SELECT METHODS ****************************/
	/**
	 * @param SQLLimit &$myLimit
	 * @return UserList
	 */
	public static final function getUserList(SQLLimit &$myLimit = null){
		return parent::getUserListBySql('1 = 1', null, $myLimit);
	}

	/**
	 * @param integer $userid
	 * @param SQLLimit &$myLimit
	 * @return User or null
	 */
	public static final function getUserByUserid($userid, SQLLimit &$myLimit = null){
		$myObject = parent::getUserListBySql(self::USERID.' = ?', array($userid), $myLimit);
		return ( $myObject->valid() ? $myObject->current() : null );
	}

	/**
	 * @param string $username
	 * @param SQLLimit &$myLimit
	 * @return User or null
	 */
	public static final function getUserByUsername($username, SQLLimit &$myLimit = null){
		$myObject = parent::getUserListBySql(self::USERNAME.' = ?', array($username), $myLimit);
		return ( $myObject->valid() ? $myObject->current() : null );
	}

	/**
	 * @param string $password
	 * @param SQLLimit &$myLimit
	 * @return UserList
	 */
	public static final function getUserListByPassword($password, SQLLimit &$myLimit = null){
		return parent::getUserListBySql(self::PASSWORD.' = ?', array($password), $myLimit);
	}

	/**
	 * @param string $email
	 * @param SQLLimit &$myLimit
	 * @return User or null
	 */
	public static final function getUserByEmail($email, SQLLimit &$myLimit = null){
		$myObject = parent::getUserListBySql(self::EMAIL.' = ?', array($email), $myLimit);
		return ( $myObject->valid() ? $myObject->current() : null );
	}

	/**
	 * @param integer $tstamp_created
	 * @param SQLLimit &$myLimit
	 * @return UserList
	 */
	public static final function getUserListByTstampCreated($tstamp_created, SQLLimit &$myLimit = null){
		return parent::getUserListBySql(self::TSTAMP_CREATED.' = ?', array($tstamp_created), $myLimit);
	}

	/**
	 * @param integer $tstamp_modified
	 * @param SQLLimit &$myLimit
	 * @return UserList
	 */
	public static final function getUserListByTstampModified($tstamp_modified, SQLLimit &$myLimit = null){
		return parent::getUserListBySql(self::TSTAMP_MODIFIED.' = ?', array($tstamp_modified), $myLimit);
	}

	/**
	 * @param integer $tstamp_deleted
	 * @param SQLLimit &$myLimit
	 * @return UserList
	 */
	public static final function getUserListByTstampDeleted($tstamp_deleted, SQLLimit &$myLimit = null){
		return parent::getUserListBySql(self::TSTAMP_DELETED.' = ?', array($tstamp_deleted), $myLimit);
	}

	/**
	 * @param string $statusname
	 * @param SQLLimit &$myLimit
	 * @return UserList
	 */
	public static final function getUserListByStatusname($statusname, SQLLimit &$myLimit = null){
		return parent::getUserListBySql(self::STATUSNAME.' = ?', array($statusname), $myLimit);
	}

	/**
	 * @param integer $tstamp_confirmed
	 * @param SQLLimit &$myLimit
	 * @return UserList
	 */
	public static final function getUserListByTstampConfirmed($tstamp_confirmed, SQLLimit &$myLimit = null){
		return parent::getUserListBySql(self::TSTAMP_CONFIRMED.' = ?', array($tstamp_confirmed), $myLimit);
	}

	/**************************** REFERENCES ****************************/
	/**
	 * @param Game &$myObject
	 * @return User
	 */
	public static final function getUserByGame(Game &$myObject){
		return self::getUserByUserid($myObject->getUserid());  // blah
	}

	/**
	 * @param User &$myUser
	 * @return GameList
	 */
	public static final function getGameListByUser(User &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_GAME());
		return GameManager::getGameListByUser($myObject, $myLimit);
	}

	/**
	 * @param GameHistory &$myObject
	 * @return User
	 */
	public static final function getUserByHistory(GameHistory &$myObject){
		return self::getUserByUserid($myObject->getUserid());  // blah
	}

	/**
	 * @param User &$myUser
	 * @return GameHistoryList
	 */
	public static final function getHistoryListByUser(User &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_GAME_HISTORY());
		return GameHistoryManager::getGameHistoryListByUser($myObject, $myLimit);
	}

	/**
	 * @param Mailqueue &$myObject
	 * @return User
	 */
	public static final function getUserByMailqueue(Mailqueue &$myObject){
		return self::getUserByUserid($myObject->getUserid());  // blah
	}

	/**
	 * @param User &$myUser
	 * @return MailqueueList
	 */
	public static final function getMailqueueListByUser(User &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_MAILQUEUE());
		return MailqueueManager::getMailqueueListByUser($myObject, $myLimit);
	}

	/**
	 * @param News &$myObject
	 * @return User
	 */
	public static final function getUserByNews(News &$myObject){
		return self::getUserByUserid($myObject->getUserid());  // blah
	}

	/**
	 * @param User &$myUser
	 * @return NewsList
	 */
	public static final function getNewsListByUser(User &$myObject, SQLLimit &$myLimit = null){
		Library::requireLibrary(LibraryKeys::APPLICATION_NEWS());
		return NewsManager::getNewsListByUser($myObject, $myLimit);
	}

}
