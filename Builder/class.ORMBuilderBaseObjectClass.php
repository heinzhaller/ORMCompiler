<?php
#ä
require_once 'class.ORMBuilderBase.php';

abstract class ORMBuilderBaseObjectClass extends ORMBuilderBase {

	public static final function build(ORMConfig &$myConfig, DBTable &$myTable, array $fk_tables = null){
		self::setConfig($myConfig);
		$myContent  = parent::HEADER();
		$myContent .= 'Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_OBJECT());'.parent::LN();
		$myContent .= parent::LN();
		$myContent .= parent::COMMENT(self::makeClassName($myTable->getName()) . ' Base-Object');
		$myContent .= 'abstract class '.self::makeClassName($myTable->getName()).'Base extends BaseObject { '.parent::LN().parent::LN();
		$myContent .= self::buildAttributes($myTable, $fk_tables);
		$myContent .= self::buildMethods($myTable, $fk_tables);
		$myContent .= parent::FOOTER();

		$filename = 'class.'.self::makeClassName($myTable->getName()).'Base.php';
		$path = $myConfig->getApplicationPath();
		if( substr($path, -1) == '/' )
			$path = substr($path, 0, -1);
		$myName = str_replace(array('new_', 'tbl_'), '', strtolower($myTable->getName()));
		$myFolder = explode('_', $myName);
		foreach ($myFolder as $folder){
			$path .= '/'.parent::formatName($folder);
		}
		$path_folder = $path;
		$path = $path.'/'.$filename;

		self::write($path,$myContent);

		$object_path = $path_folder.'/class.'.self::makeClassName($myTable->getName()).'.php';
		if(!file_exists($object_path))
			ORMBuilderObjectClass::build($myConfig, $myTable);
	}

	private function buildAttributes(DBTable &$myTable, array $fk_tables = null){
		$content  = parent::TAB()."// references".parent::LN();

		// new method
		$fk_columns = array();
		if(isset($fk_tables[$myTable->getName()]) AND !in_array($myTable->getName(),$fk_tables['unassigned']))
		foreach ($fk_tables[$myTable->getName()] as $reference){
			$referencetype = '';
			if ($reference['type'] == DBReferenceTypes::REFERENCE_MANY_TO_MANY OR $reference['type'] == DBReferenceTypes::REFERENCE_SINGLE_TO_MANY )
				$referencetype = '_list = array()';
			$content .= parent::TAB().'private '.'$ref_'.$reference['referenz_name_org'].$referencetype.';'.parent::LN();
			$fk_columns[] = self::makeRefName($reference['col_own']);
		}

		$content .= parent::LN();

		$content .= parent::TAB()."// attributes".parent::LN();
		foreach ($myTable->getColumns() as $column){
			//@TODO: funzt noch net
			// skip "single-to-single" reference - [Nur Objektzugriff erlaubt]
			//if( in_array($column->getName(), $fk_columns) AND $reference['type'] == DBReferenceTypes::REFERENCE_SINGLE_TO_SINGLE )
				//continue;

			$defaultvalue = ( is_numeric($column->getDefaultvalue()) ? $column->getDefaultvalue() : '\'' . $column->getDefaultvalue() . '\'' );
			$content .= parent::TAB().'private '.'$'.strtolower($column->getName()).( self::checkDefaultValue($column->getDefaultvalue()) ? ' = '.$defaultvalue : null).';'.parent::LN();
		}
		$content .= parent::LN();

		return $content;
	}

	private function buildMethods(DBTable &$myTable, array $fk_tables = null){
		// foreignkeys - references
		$content  = parent::TAB().'/**************************** REFERENCES ****************************/'.parent::LN();

		// new method
		$fk_columns = array();
		if(isset($fk_tables[$myTable->getName()]) AND !in_array($myTable->getName(),$fk_tables['unassigned']))
		foreach ($fk_tables[$myTable->getName()] as $reference){
			$attributename = $reference['referenz_name_org'];
			$reference_name = $reference['referenz_name'];
			$classname = $reference['classname'];
			$fk_columns[] = $attributename;
			$isMany = false;
			if( $reference['type'] == DBReferenceTypes::REFERENCE_MANY_TO_MANY OR $reference['type'] == DBReferenceTypes::REFERENCE_SINGLE_TO_MANY ){
				$attributename .= '_list';
				$classname .= 'List';
				$isMany = true;
			}
			$nullable = ( $reference['nullable'] == true ? ' = NULL' : null );
			$content .= parent::TAB().'/**'.parent::LN();
			$content .= parent::TAB().' * @param '.$classname.parent::LN();
			$content .= parent::TAB().' */'.parent::LN();
			$content .= parent::TAB().'public function '.self::makeAttSetFunction($reference_name).($isMany ? 'List' : '').'('.$classname.' &$myObject'.$nullable.'){'.parent::LN();
			$content .= parent::TAB().parent::TAB().'$this->ref_'.strtolower($attributename).' = $myObject;'.parent::LN();
			if( $isMany != true ){
				if($nullable != null)
					$content .= parent::TAB().parent::TAB().'if(!is_null($myObject))'.parent::LN();
				$content .= parent::TAB().parent::TAB().parent::TAB().'$this->set'.$reference['col_own_attributename'].'($myObject->get'.$reference['col_ref_attributename'].'());'.parent::LN();
			}
			$content .= parent::TAB().parent::TAB().'$this->_setIsLoaded(\'ref_'.strtolower($attributename).'\');'.parent::LN();
			$content .= parent::TAB().'}'.parent::LN().parent::LN();

			$content .= parent::TAB().'/**'.parent::LN();
			$content .= parent::TAB().' * @return '.$classname.parent::LN();
			$content .= parent::TAB().' */'.parent::LN();
			$content .= parent::TAB().'public function '.self::makeAttGetFunction($reference_name, $isMany).'{'.parent::LN();
			$content .= parent::TAB().parent::TAB().'if( !$this->_getIsLoaded(\'ref_'.strtolower($attributename).'\') )'.parent::LN();
			#$content .= parent::TAB().parent::TAB().parent::TAB().'$this->ref_'.strtolower($attributename).' = '.self::makeClassName($myTable->getName()).'Manager::get'.$reference_name.($isMany ? 'List' : '').'By'.self::makeClassName($myTable->getName()).'($this'.($isMany ? ', $myLimit' : '').');'.parent::LN();
			$content .= parent::TAB().parent::TAB().parent::TAB().'$this->'.self::makeAttSetFunction($reference_name).($isMany ? 'List' : '').'('.self::makeClassName($myTable->getName()).'Manager::get'.$reference_name.($isMany ? 'List' : '').'By'.self::makeClassName($myTable->getName()).'($this'.($isMany ? ', $myLimit' : '').'));'.parent::LN();
			$content .= parent::TAB().parent::TAB().'return $this->ref_'.strtolower($attributename).';'.parent::LN();
			$content .= parent::TAB().'}'.parent::LN().
			parent::LN();
		}

		// attribute setter and getter
		$content .= parent::TAB().'/**************************** ATTRIBUTES ****************************/'.parent::LN();
		foreach ($myTable->getColumns() as $column){
			// skip "single-to-single" reference - [Nur Objektzugriff erlaubt]
			if( in_array($column->getName(), $fk_columns) )
				continue;

			$typename = parent::getPHPType(strtolower(DBTypes::getCreoleName($column->getType())));

			$null_check = 'is_null($'.$typename.')'; // default null check
			$attr_check = 'is_'.self::getPHPType($typename).'($'.$typename.')'.( $column->getIsNullable() == true ? ' OR is_null($'.$typename.')' : null ).'';
			/*
			switch ( self::getPHPType($typename) ) {
				case 'string':
					$null_check = '!isset($'.$column->getType().') OR strlen($'.$column->getType().') == 0';
					$attr_check = 'is_string($'.$column->getType().')'.( $attribute['nn'] == FALSE ? ' OR is_null($'.$attribute['type'].')' : null ).'';
					break;
				case 'integer':
					if( $attribute['pk'] == true OR $attribute['fk'] == true)
						$null_check = 'empty($'.$column->getType().')';
					$attr_check = 'is_integer($'.$column->getType().')'.( $attribute['nn'] == FALSE ? ' OR is_null($'.$column->getType().')' : null ).'';
					break;
				case 'float':
					$attr_check = 'is_float($'.$column->getType().')'.( $attribute['nn'] == FALSE ? ' OR is_null($'.$column->getType().')' : null ).'';
					break;
				case 'double':
					$attr_check = 'is_double($'.$column->getType().')'.( $attribute['nn'] == FALSE ? ' OR is_null($'.$column->getType().')' : null ).'';
					break;
				case 'date':
				case 'time':
					$column->getType() = 'integer';
					$null_check = 'empty($'.$column->getType().')';
					$attr_check = 'is_integer($'.$column->getType().')'.( $attribute['nn'] == FALSE ? ' OR is_null($'.$column->getType().')' : null ).'';
					break;
			}
			*/

			// setter
			$content .= parent::TAB().'/**'.parent::LN();
			$content .= parent::TAB().' * @param '.self::getPHPType($typename).' $'.self::getPHPType($typename).parent::LN();
			$content .= parent::TAB().' */'.parent::LN();
			$content .= parent::TAB().'public function '.self::makeAttSetFunction($column->getName()).'('.( self::checkTypes($typename) === false ? self::getPHPType($typename).' ' : null ).'$'.self::getPHPType($typename).'){'.parent::LN();
			if( $column->getIsNullable() == false ){
				$content .= parent::TAB().parent::TAB().'if('.$null_check.')'."\r\n";
				$content .= parent::TAB().parent::TAB().parent::TAB().'throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_NULL, array(\'Attribute: '.$column->getName().'\'));'.parent::LN();
			}
			$content .= parent::TAB().parent::TAB().'if('.$attr_check.'){'.parent::LN();
			$content .= parent::TAB().parent::TAB().parent::TAB().'if( $this->'.strtolower($column->getName()).' !== $'.$typename.' ){'.parent::LN();
			$content .= parent::TAB().parent::TAB().parent::TAB().parent::TAB().'$this->'.strtolower($column->getName()).' = $'.$typename.';'.parent::LN();
			$content .= parent::TAB().parent::TAB().parent::TAB().parent::TAB().'$this->_setModified(\''.strtolower($column->getName()).'\');'.parent::LN();
			$content .= parent::TAB().parent::TAB().parent::TAB().'}'.parent::LN();
			$content .= parent::TAB().parent::TAB().'}else{'.parent::LN();
			$content .= parent::TAB().parent::TAB().parent::TAB().'throw new ExceptionObject(ExceptionKeys::ERROR_VALUE_WRONGDATATYPE,array(\'Attribute: '.$column->getName().' | Type: '.$typename.'\',$'.$typename.'));'.parent::LN();
			$content .= parent::TAB().parent::TAB().'}'.parent::LN();
			$content .= parent::TAB().'}'.parent::LN();
			$content .= parent::LN();

			// getter
			$content .= parent::TAB().'/**'.parent::LN();
			$content .= parent::TAB().' * @return '.self::getPHPType($typename).parent::LN();
			$content .= parent::TAB().' */'.parent::LN();
			$content .= parent::TAB().'public function '.self::makeAttGetFunction($column->getName()).'{'.parent::LN();
			$content .= parent::TAB().parent::TAB().'return $this->'.strtolower($column->getName()).';'.parent::LN();
			$content .= parent::TAB().'}'.parent::LN();
			$content .= parent::LN();
		}
		return $content;
	}


	private function makeAttGetFunction($attname, $isMany = false){
		$attname = 'get'.parent::formatAttributename(strtolower($attname)).($isMany == true ? 'List(SQLLimit &$myLimit = null)' :'()');
		return $attname;
	}

	private function makeAttSetFunction( $attname ){
		$attname = 'set'.parent::formatAttributename(strtolower($attname));
		return $attname;
	}

}
?>