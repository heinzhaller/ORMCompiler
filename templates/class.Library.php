<?php
#ä
require_once 'class.LibraryKeyObject.php';
require_once 'class.LibraryKeyList.php';
require_once 'class.LibraryKeysBase.php';
require_once 'class.LibraryKeys.php';
/**
 * Library Main-Class
 * @author MKaufmann
 */
abstract class Library {

	/**
	 * require file by library key object
	 * @param LibraryKeyList
	 */
	public static final function requireLibrary(LibraryKeyList &$myList){
		while($myList->next()){
			if( file_exists($myList->getCurrent()->getPath()) ){
				require_once $myList->getCurrent()->getPath();
			}	ELSE{
				throw new ExceptionObject(ExceptionKeys::ERROR_FILE_NOT_EXISTS, array($myList->getCurrent()->getPath()));
			}
		}
	}

	/**
	 * include file by library key object
	 * @param LibraryKeyList
	 */
	public static final function includeLibrary(LibraryKeyList &$myList){
		while($myList->next()){
			if( file_exists($myList->getCurrent()->getPath()) ){
				include_once $myList->getCurrent()->getPath();
			}	ELSE{
				throw new ExceptionObject(ExceptionKeys::ERROR_FILE_NOT_EXISTS,array($myList->getCurrent()->getPath()));
			}
		}
	}
	
}
?>