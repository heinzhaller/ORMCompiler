<?php
#ä
require_once 'class.ORMBuilderBase.php';

abstract class ORMBuilderLibraryClass extends ORMBuilderBase {

	public static final function build(ORMConfig &$myConfig, DBDatabase &$myDatabase){
		self::setConfig($myConfig);
		$myContent  = parent::HEADER();
		$myContent .= parent::COMMENT('LibraryKeys');
		$myContent .= 'abstract class LibraryKeys extends LibraryKeysBase { '.parent::LN().parent::LN();
		$myContent .= parent::TAB().'/**************************** KEYS ****************************/'.parent::LN().parent::LN();
		$myContent .= self::buildFolder($myDatabase);
		$myContent .= self::buildKeys($myDatabase);

		$myContent .= parent::FOOTER();

		$filename = 'class.LibraryKeys.php';
		$path = $myConfig->getSystemPath().'Library/'.$filename;
		self::write($path,$myContent);
	}

	private static final function buildFolder(DBDatabase &$myDatabase){
		$content = '';
		foreach ($myDatabase->getTables() as $table){
			$classname =self::makeClassName($table->getName());
			$folder = str_replace(array('NEW_', 'TBL_'), '', strtoupper($table->getName()));
			$myPath = explode('_', $folder);
			foreach ($myPath as $key => $path)
				$myPath[$key] = self::makeClassName($path);

			$content  .= parent::TAB().'public static final function get'.self::makeClassName($classname).'() {'.parent::LN();
			$content  .= parent::TAB().parent::TAB().'return \''.implode('/', $myPath).'/\';'.parent::LN();
			$content  .= parent::TAB().'}'.parent::LN();
			$content  .= parent::LN();
		}
		return $content;
	}

	private static final function buildKeys(DBDatabase &$myDatabase){
		$content = '';
		foreach ($myDatabase->getTables() as $table){
			$folder = str_replace(array('NEW_', 'TBL_'), '', strtoupper($table->getName()));
			$classname =self::makeClassName($table->getName());
			$content  .= parent::TAB().'public static final function APPLICATION_'.$folder.'() {'.parent::LN();
			// require whole folder - recursive
			#$content  .= parent::TAB().parent::TAB().'return parent::getLibraryKeyListByPath(parent::getApplicationLayer().\''.$folder.'\');'.parent::LN();
			$content  .= parent::TAB().parent::TAB().'$myList = new LibraryKeyList();'.parent::LN();
			$content  .= parent::TAB().parent::TAB().'$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::get'.$classname.'().\'class.'.$classname.'Base.php\'));'.parent::LN();
			$content  .= parent::TAB().parent::TAB().'$myList->add(self::returnValueAsObject(self::getRoot().self::getAbstractionLayer().self::get'.$classname.'().\'class.'.$classname.'AbstractionLayer.php\'));'.parent::LN();
			$content  .= parent::TAB().parent::TAB().'$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::get'.$classname.'().\'class.'.$classname.'.php\'));'.parent::LN();
			$content  .= parent::TAB().parent::TAB().'$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::get'.$classname.'().\'class.'.$classname.'List.php\'));'.parent::LN();
			$content  .= parent::TAB().parent::TAB().'$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::get'.$classname.'().\'class.'.$classname.'BaseManager.php\'));'.parent::LN();
			$content  .= parent::TAB().parent::TAB().'$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::get'.$classname.'().\'class.'.$classname.'Manager.php\'));'.parent::LN();
			$content  .= parent::TAB().parent::TAB().'$myList->add(self::returnValueAsObject(self::getRoot().self::getApplicationLayer().self::get'.$classname.'().\'class.'.$classname.'Query.php\'));'.parent::LN();
			$content  .= parent::TAB().parent::TAB().'return $myList;'.parent::LN();
			$content  .= parent::TAB().'}'.parent::LN();
			$content  .= parent::LN();
		}
		return $content;
	}

}
?>