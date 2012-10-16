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

	protected static final function getFormular(){
		return 'Formular/';
	}

	protected static final function getWebsite(){
		return 'Website/';
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

	public static final function APPLICATION_WEBSITE(){
		return new LibraryKeyList(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getWebsite().'class.WebsiteManager.php'));
	}

	public static final function APPLICATION_BOXER_GENERATOR(){
		return new LibraryKeyList(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().'Boxer/Generator/class.BoxerGeneratorManager.php'));
	}

	public static final function APPLICATION_FORMULAR_FORMULARBOXERPROFI(){
		$myList = new LibraryKeyList();
		$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getFormular().'class.Formular.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getFormular().'class.FormularBoxerProfi.php'));
		return $myList;
	}

	public static final function APPLICATION_FORMULAR_FORMULARBOXERAMATEURE(){
		$myList = new LibraryKeyList();
		$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getFormular().'class.Formular.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::getFormular().'class.FormularBoxerAmateur.php'));
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

	public static final function SYSTEM_UTILITIES_LIST(){
		$myList = new LibraryKeyList();
		$myList->add(self::returnValueAsObject(self::getRoot().self::getSystemLayer().self::getUtilities().'class.BaseIterator.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getSystemLayer().self::getUtilities().'class.BaseList.php'));
		return $myList;
	}

	public static final function SYSTEM_QUERY(){
		$myList = new LibraryKeyList();
		$myList->add(self::returnValueAsObject(self::getRoot().self::getSystemLayer().self::getQuery().'class.BaseQuery.php'));
		$myList->add(self::returnValueAsObject(self::getRoot().self::getSystemLayer().self::getQuery().'class.Criteria.php'));

		$path = self::getRoot().self::getApplicationLayer();
		$Directory = new RecursiveDirectoryIterator(self::getRoot().self::getApplicationLayer());
		$Iterator = new RecursiveIteratorIterator($Directory);
		$Regex = new RegexIterator($Iterator, '/^.*Query.php$/', RecursiveRegexIterator::GET_MATCH);
		foreach ($Regex as $file){
			$myList->add(self::returnValueAsObject($file[0]));
		}
		return $myList;
	}

}
?>