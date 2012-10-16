<?php
#ä
require_once 'class.ORMBuilderBase.php';

/**
 * move template to project
 * @author MKaufmann
 */
abstract class ORMBuilderTemplateClass extends ORMBuilderBase {

	public static final function build(ORMConfig &$myConfig){
		$temp_folder = ORMCOMPILER_PATH.'/templates/';
		$path = $myConfig->getSystemPath();

		$file_baseiterator = 'class.BaseIterator.php';
		$file_baselist = 'class.BaseList.php';
		$file_baseobject = 'class.BaseObject.php';
		$file_globalinc = 'global.inc.php';
		$file_append = 'append.php';
		$file_htaccess = '.htaccess';
		$file_global = 'global.php';
		$file_websitemanager = 'class.WebsiteManager.php';

		if( !is_dir($path.'Utilities') )
			parent::createPath($path.'Utilities/');

		if( !is_dir($path.'Library') )
			parent::createPath($path.'Library/');

		if( !is_dir($path.'ExceptionHandling') )
			parent::createPath($path.'ExceptionHandling/');

		if( !is_dir($path.'Website') )
			parent::createPath($path.'Website/');

		if( !is_dir($path.'Query') )
			parent::createPath($path.'Query/');

		if( !file_exists($path.'Utilities/'.$file_baseiterator) )
			self::moveFileToPath($temp_folder.$file_baseiterator,$path.'Utilities/'.$file_baseiterator);

		if( !file_exists($path.'Utilities/'.$file_baselist) )
			self::moveFileToPath($temp_folder.$file_baselist,$path.'Utilities/'.$file_baselist);

		if( !file_exists($path.'Utilities/'.$file_baseobject) )
			self::moveFileToPath($temp_folder.$file_baseobject,$path.'Utilities/'.$file_baseobject);

		$myLibs = glob($temp_folder.'class.Library*.php');
		foreach ($myLibs as $libfile){
			$filename = substr($libfile, strpos($libfile,'class.'));
			if( !file_exists($path.'Library/'.$filename) )
				self::moveFileToPath($libfile,$path.'Library/'.$filename);
		}

		$myLibs = glob($temp_folder.'class.*DAO.php');
		foreach ($myLibs as $libfile){
			$filename = substr($libfile, strpos($libfile,'class.'));
			if( !file_exists($path.'Database/'.'DAO/'.$filename) )
				self::moveFileToPath($libfile,$path.'Database/'.'DAO/'.$filename);
		}

		$myLibs = glob($temp_folder.'class.DB*.php');
		$myLibs = array_merge($myLibs, glob($temp_folder.'class.SQLLimit.php'));
		foreach ($myLibs as $libfile){
			$filename = substr($libfile, strpos($libfile,'class.'));
			if( !file_exists($path.'Database/'.$filename) )
				self::moveFileToPath($libfile,$path.'Database/'.$filename);
		}

		$myLibs = glob($temp_folder.'ExceptionHandling/*');
		foreach ($myLibs as $libfile){
			$filename = substr($libfile, strpos($libfile,'class.'));
			if( !file_exists($path.'ExceptionHandling/'.$filename) )
				self::moveFileToPath($libfile,$path.'ExceptionHandling/'.$filename);
		}

		$myLibs = glob($temp_folder.'Query/class.*.php');
		foreach ($myLibs as $libfile){
			$filename = substr($libfile, strpos($libfile,'class.'));
			if( !file_exists($path.'Query/'.$filename) )
				self::moveFileToPath($libfile,$path.'Query/'.$filename);
		}

		// global.inc, append.php und .htaccess in den main ordner schieben
		if( !file_exists($path.$file_globalinc) )
			self::moveFileToPath($temp_folder.$file_globalinc, $path.$file_globalinc);
		if( !file_exists($path.$file_append) )
			self::moveFileToPath($temp_folder.$file_append, $path.$file_append);
		if( !file_exists($path.$file_htaccess) )
			self::moveFileToPath($temp_folder.$file_htaccess, $path.$file_htaccess);
		if( !file_exists($path.$file_global) )
			self::moveFileToPath($temp_folder.$file_global, $path.$file_global);
		if( !file_exists($path.'Website/'.$file_websitemanager) )
			self::moveFileToPath($temp_folder.$file_websitemanager, $path.'Website/'.$file_websitemanager);

	}

	public static function moveFileToPath($file, $path){
		echo 'move file: '.$file.'<br>';
		return copy($file, $path);
	}
}
?>