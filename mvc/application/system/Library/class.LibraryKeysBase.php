<?php
#ä
/**
 * Library Keys
 * @author MKaufmann
 */
abstract class LibraryKeysBase {

	/**
	 * return Path as Object
	 * @param string $string
	 * @return LibraryKeyObject
	 */
	protected static final function returnValueAsObject($string){
		return new LibraryKeyObject($string);
	}

	/**
	 * @param string $path
	 * @return LibraryKeyList
	 */
	public static final function getLibraryKeyListByPath($path){
		$myList = new LibraryKeyList();
		$dir_iterator = new RecursiveDirectoryIterator($path);
		$iterator = new RecursiveIteratorIterator($dir_iterator, RecursiveIteratorIterator::SELF_FIRST);
		foreach ($iterator as $file) {
			if(preg_match('/class\.([A-z]+)\.php$/ui', $file->getFilename()))
		    $myList->add(new LibraryKeyObject($file->getPath().'/'.$file->getFilename()));
		}
		return $myList;
	}

	/**
	 * root directory
	 */
	protected static final function getRoot(){
		return '';
	}

	/**************** LAYER ****************/

	protected static final function getApplicationLayer(){
		return GLOBAL_INCLUDE_APPLICATIONLAYER;
	}

	protected static final function getAbstractionLayer(){
		return GLOBAL_INCLUDE_ABSTRACTIONLAYER;
	}

	protected static final function getSystemLayer(){
		return GLOBAL_INCLUDE_SYSTEMLAYER;
	}

	/**************** DEFAULT KEYS ****************/

	protected static final function getUtilities(){
		return 'Utilities/';
	}

	protected static final function getDatabase(){
		return 'Database/';
	}

	protected static final function getDAO(){
		return 'DAO/';
	}

	protected static final function getCreole(){
		return 'creole/';
	}

	protected static final function getQuery(){
		return 'Query/';
	}


	protected static final function getCache(){
		return 'Cache/';
	}

	protected static final function getException(){
		return 'ExceptionHandling/';
	}

	protected static final function getCalendar(){
		return 'Calendar/';
	}

	protected static final function getFightSystem(){
		return 'Fight/';
	}

	protected static final function getFormular(){
		return 'Formular/';
	}

	protected static final function getPayPal(){
		return 'Paypal/';
	}

	protected static final function getWebsite(){
		return 'Website/';
	}

	public static final function getForum() {
		return 'Forum/';
	}

	public static final function getForumcategory() {
		return 'Forum/Category/';
	}

	public static final function getForumthread() {
		return 'Forum/Thread/';
	}

	public static final function getForumtopic() {
		return 'Forum/Topic/';
	}

	public static final function getForumTopicfollower() {
		return 'Forum/Topic/Follower/';
	}

	public static final function getController() {
		return 'Controller/';
	}

	public static final function getLayout() {
		return 'Layout/';
	}

	// ++++ ABSTRACTION ++++ //
	public static final function ABSTRACTION_CREOLE(){
		return new LibraryKeyList(self::returnValueAsObject(self::getRoot().self::getSystemLayer().self::getDatabase().self::getCreole().'Creole.php'));
	}

	public static final function ABSTRACTION_DATABASE_CONNECTION(){
		return new LibraryKeyList(self::returnValueAsObject(self::getRoot().self::getSystemLayer().self::getDatabase().'class.DBConnection.php'));
	}

	public static final function ABSTRACTION_DATABASE_LIMIT(){
		return new LibraryKeyList(self::returnValueAsObject(self::getRoot().self::getSystemLayer().self::getDatabase().'class.SQLLimit.php'));
	}

	public static final function ABSTRACTION_DAO_BASE(){
		return new LibraryKeyList(self::returnValueAsObject(self::getRoot().self::getSystemLayer().self::getDatabase().self::getDAO().'class.BaseDAO.php'));
	}

	public static final function ABSTRACTION_DAO_GENERIC($name){
		return new LibraryKeyList(self::returnValueAsObject(self::getRoot().self::getSystemLayer().self::getDatabase().self::getDAO().'class.'.$name.'DAO.php'));
	}

	public static final function APPLICATION_FORMULAR(){
		return new LibraryKeyList(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getFormular().'class.Formular.php'));
	}

	public static final function APPLICATION_CALENDAR(){
		return new LibraryKeyList(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getCalendar().'class.Calendar.php'));
	}

	public static final function APPLICATION_PAYPAL(){
		return new LibraryKeyList(self::returnValueAsObject(self::getRoot().self::getSystemLayer().self::getPayPal().'class.PaypalIPN.php'));
	}

	public static final function APPLICATION_WEBSITE(){
		return new LibraryKeyList(self::returnValueAsObject(self::getRoot().self::getSystemLayer().self::getWebsite().'class.WebsiteManager.php'));
	}

	public static final function APPLICATION_BOXER_GENERATOR(){
		return new LibraryKeyList(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().'Boxer/Generator/class.BoxerGeneratorManager.php'));
	}

	public static final function APPLICATION_FIGHTSYSTEM(){
		$myList = new LibraryKeyList();
		$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getFightSystem().'class.FightSystem.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getFightSystem().'class.FightBoxer.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getFightSystem().'class.FightText.php'));
		return $myList;
	}

	public static final function SYSTEM_EXCEPTIONHANDLER(){
		$myList = new LibraryKeyList();
		$myList->add(self::returnValueAsObject(self::getRoot().self::getSystemLayer().self::getException().'class.ExceptionList.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getSystemLayer().self::getException().'class.ExceptionObject.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getSystemLayer().self::getException().'class.ExceptionHandler.php'));
		return $myList;
	}

	public static final function SYSTEM_UTILITIES_OBJECT(){
		$myList = new LibraryKeyList();
		$myList->add(self::returnValueAsObject(self::getRoot().self::getSystemLayer().self::getUtilities().'class.BaseObject.php'));
		return $myList;
	}


	public static final function SYSTEM_UTILITIES_CACHE(){
		$myList = new LibraryKeyList();
		$myList->add(self::returnValueAsObject(self::getRoot().self::getSystemLayer().self::getCache().'class.CacheKeys.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getSystemLayer().self::getCache().'class.CacheManager.php'));
		return $myList;
	}


	public static final function SYSTEM_UTILITIES_CURRENCY(){
		$myList = new LibraryKeyList();
		$myList->add(self::returnValueAsObject(self::getRoot().self::getSystemLayer().self::getUtilities().'class.CurrencyManager.php'));
		return $myList;
	}

	public static final function SYSTEM_UTILITIES_DATE(){
		$myList = new LibraryKeyList();
		$myList->add(self::returnValueAsObject(self::getRoot().self::getSystemLayer().self::getUtilities().'class.DateManager.php'));
		return $myList;
	}

	public static final function SYSTEM_UTILITIES_DIRECTORY(){
		$myList = new LibraryKeyList();
		$myList->add(self::returnValueAsObject(self::getRoot().self::getSystemLayer().self::getUtilities().'class.DirectoryManager.php'));
		return $myList;
	}

	public static final function SYSTEM_UTILITIES_LIST(){
		$myList = new LibraryKeyList();
		$myList->add(self::returnValueAsObject(self::getRoot().self::getSystemLayer().self::getUtilities().'class.BaseIterator.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getSystemLayer().self::getUtilities().'class.BaseList.php'));
		return $myList;
	}

	public static final function SYSTEM_UTILITIES_CRONJOB(){
		$myList = new LibraryKeyList();
		$myList->add(self::returnValueAsObject(self::getRoot().self::getSystemLayer().self::getUtilities().'class.CronjobBase.php'));
		return $myList;
	}

	public static final function SYSTEM_QUERY(){
		$myList = new LibraryKeyList();
		$timer = microtime(true);
		$myList->add(self::returnValueAsObject(self::getRoot().self::getSystemLayer().self::getQuery().'class.BaseQuery.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getSystemLayer().self::getQuery().'class.Criteria.php'));
		return $myList;
	}

	public static final function APPLICATION_CONTROLLER(){
		return new LibraryKeyList(self::returnValueAsObject(self::getRoot().self::getSystemLayer().self::getController().'class.Controller.php'));
	}

	public static final function APPLICATION_LAYOUT(){
		return new LibraryKeyList(self::returnValueAsObject(self::getRoot().self::getSystemLayer().self::getLayout().'class.Layout.php'));
	}

	public static final function APPLICATION_FORUM() {
		$myList = new LibraryKeyList();
		$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getForum().'class.ForumBase.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getAbstractionLayer().self::getForum().'class.ForumAbstractionLayer.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getForum().'class.Forum.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getForum().'class.ForumList.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getForum().'class.ForumBaseManager.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getForum().'class.ForumManager.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getForum().'class.ForumQuery.php'));
		return $myList;
	}

	public static final function APPLICATION_FORUM_CATEGORY() {
		$myList = new LibraryKeyList();
		$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getForumCategory().'class.ForumCategoryBase.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getAbstractionLayer().self::getForumCategory().'class.ForumCategoryAbstractionLayer.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getForumCategory().'class.ForumCategory.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getForumCategory().'class.ForumCategoryList.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getForumCategory().'class.ForumCategoryBaseManager.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getForumCategory().'class.ForumCategoryManager.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getForumCategory().'class.ForumCategoryQuery.php'));
		return $myList;
	}

	public static final function APPLICATION_FORUM_THREAD() {
		$myList = new LibraryKeyList();
		$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getForumThread().'class.ForumThreadBase.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getAbstractionLayer().self::getForumThread().'class.ForumThreadAbstractionLayer.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getForumThread().'class.ForumThread.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getForumThread().'class.ForumThreadList.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getForumThread().'class.ForumThreadBaseManager.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getForumThread().'class.ForumThreadManager.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getForumThread().'class.ForumThreadQuery.php'));
		return $myList;
	}

	public static final function APPLICATION_FORUM_TOPIC() {
		$myList = new LibraryKeyList();
		$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getForumTopic().'class.ForumTopicBase.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getAbstractionLayer().self::getForumTopic().'class.ForumTopicAbstractionLayer.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getForumTopic().'class.ForumTopic.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getForumTopic().'class.ForumTopicList.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getForumTopic().'class.ForumTopicBaseManager.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getForumTopic().'class.ForumTopicManager.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getForumTopic().'class.ForumTopicQuery.php'));
		return $myList;
	}

	public static final function APPLICATION_FORUM_TOPIC_FOLLOWER() {
		$myList = new LibraryKeyList();
		$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getForumTopicFollower().'class.ForumTopicFollowerBase.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getAbstractionLayer().self::getForumTopicFollower().'class.ForumTopicFollowerAbstractionLayer.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getForumTopicFollower().'class.ForumTopicFollower.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getForumTopicFollower().'class.ForumTopicFollowerList.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getForumTopicFollower().'class.ForumTopicFollowerBaseManager.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getForumTopicFollower().'class.ForumTopicFollowerManager.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getForumTopicFollower().'class.ForumTopicFollowerQuery.php'));
		return $myList;
	}

}