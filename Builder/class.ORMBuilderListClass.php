<?php
#�
require_once 'class.ORMBuilderBase.php';

abstract class ORMBuilderListClass extends ORMBuilderBase {

	public static final function build(ORMConfig &$myConfig, DBTable &$myTable){
		self::setConfig($myConfig);
		$myContent  = parent::HEADER();
		$myContent .= 'Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_LIST());'.parent::LN();
		$myContent .= parent::LN();
		$myContent .= parent::COMMENT(self::makeClassName($myTable->getName()) . ' List');
		$myContent .= 'class '.self::makeClassName($myTable->getName()).'List extends BaseList { '.parent::LN().parent::LN();

		// get
		$myContent .= parent::TAB().'/**'.parent::LN();
		$myContent .= parent::TAB().' * @return '.self::makeClassName($myTable->getName()).''.parent::LN();
		$myContent .= parent::TAB().' */'.parent::LN();
		$myContent .= parent::TAB().'public function current(){'.parent::LN();
		//$myContent .= parent::TAB().parent::TAB().'return $this->list[($this->pos == 0 ? $this->pos : ($this->pos - 1))];'.parent::LN();
		$myContent .= parent::TAB().parent::TAB().'return parent::current();'.parent::LN();
		$myContent .= parent::TAB().'}'.parent::LN();
		$myContent .= parent::LN();

		// add
		$myContent .= parent::TAB().'/**'.parent::LN();
		$myContent .= parent::TAB().' * @param '.self::makeClassName($myTable->getName()).' &$myObject'.parent::LN();
		$myContent .= parent::TAB().' */'.parent::LN();
		$myContent .= parent::TAB().'public function add('.self::makeClassName($myTable->getName()).' &$myObject){'.parent::LN();
		$myContent .= parent::TAB().parent::TAB().'parent::add($myObject);'.parent::LN();
		//$myContent .= parent::TAB().parent::TAB().'$this->list[] = $myObject;'.parent::LN();
		//$myContent .= parent::TAB().parent::TAB().'$this->pos = (count($this->list)-1);'.parent::LN();
		$myContent .= parent::TAB().'}'.parent::LN();
		$myContent .= parent::LN();

		$myContent .= parent::FOOTER();


		$filename = 'class.'.self::makeClassName($myTable->getName()).'List.php';
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