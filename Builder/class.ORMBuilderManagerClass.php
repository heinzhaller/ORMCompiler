<?php
##
require_once 'class.ORMBuilderBase.php';

abstract class ORMBuilderManagerClass extends ORMBuilderBase {
	
	public static final function build(ORMConfig &$myConfig, DBTable &$myTable, array $fk_tables = null){
		self::setConfig($myConfig);
		$myContent  = parent::HEADER();
		$myContent .= parent::COMMENT(self::makeClassName($myTable->getName()) . ' Manager');
		$myContent .= 'abstract class '.self::makeClassName($myTable->getName()).'Manager extends '.self::makeClassName($myTable->getName()).'BaseManager { '.parent::LN().parent::LN().parent::LN();
		$myContent .= parent::FOOTER();
		
		$filename = 'class.'.self::makeClassName($myTable->getName()).'Manager.php';
		$path = $myConfig->getApplicationPath();
		if( substr($path, -1) == '/' )
			$path = substr($path, 0, -1);
		$myName = str_replace(array('new_', 'tbl_'), '', strtolower($myTable->getName()));
		$myFolder = explode('_', $myName);
		foreach ($myFolder as $folder){
			$path .= '/'.parent::formatName($folder);
		}
		$path = $path.'/'.$filename;
		
		self::write($path,$myContent);
	}
	
}
?>