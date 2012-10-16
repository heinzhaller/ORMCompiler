<?php
#ä
require_once 'class.ORMBuilderBase.php';

abstract class ORMBuilderAbstractionClass extends ORMBuilderBase {

	public static final function build(ORMConfig &$myConfig, DBTable &$myTable, array $fk_tables, array $m2m_tables){
		self::setConfig($myConfig);
		$myContent  = parent::HEADER();
		$myContent .= parent::COMMENT(self::makeClassName($myTable->getName()) . ' AbstractionLayer [AL]');
		$myContent .= 'abstract class '.self::makeClassName($myTable->getName()).'AbstractionLayer { '.parent::LN().parent::LN();
		$myContent .= self::buildSelectMethod($myTable);
		#$myContent .= self::buildCopyMethods($myTable, $fk_tables);
		$myContent .= self::buildSaveMethod($myTable, $fk_tables, $m2m_tables);
		$myContent .= self::buildDeleteMethod($myTable);

		$myContent .= parent::FOOTER();

		$filename = 'class.'.self::makeClassName($myTable->getName()).'AbstractionLayer.php';
		$path = $myConfig->getAbstractionPath();
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

	private static final function buildSelectMethod(DBTable &$myTable){
		$content = parent::TAB().'/**'.parent::LN();
		$content .= parent::TAB().' * @return '.self::makeClassName($myTable->getName()).'List'.parent::LN();
		$content .= parent::TAB().' */'.parent::LN();
		$content .= parent::TAB().'protected static final function get'.self::makeClassName($myTable->getName()).'ListBySql($where,array $params = null,SQLLimit $limit = null){'.parent::LN();
		$content .= parent::TAB().parent::TAB().'Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC(\''.self::makeClassName($myTable->getName()).'\'));'.parent::LN();
		$content .= parent::TAB().parent::TAB().'return '.self::makeClassName($myTable->getName()).'DAO::get'.self::makeClassName($myTable->getName()).'ListByQuery($where,$params,$limit);'.self::LN();
		$content .= parent::TAB().'}'.self::LN();
		$content .= self::LN();
		return $content;
	}

	private static final function buildCopyMethods(DBTable &$myTable, array $fk_tables){
		// from dao to object
		$content = parent::TAB().'/**'.parent::LN();
		$content .= parent::TAB().' * @param '.self::makeClassName($myTable->getName()).'DAO &$myDataObject'.parent::LN();
		$content .= parent::TAB().' * @return '.self::makeClassName($myTable->getName()).''.parent::LN();
		$content .= parent::TAB().' */'.parent::LN();
		$content .= parent::TAB().'private static final function get'.self::makeClassName($myTable->getName()).'FromDataObject('.self::makeClassName($myTable->getName()).'DAO &$myDataObject){'.parent::LN();
		$content .= parent::TAB().parent::TAB().'Library::requireLibrary(LibraryKeys::APPLICATION_'.strtoupper(self::makeName($myTable->getName())).'());'.self::LN();
		$content .= parent::TAB().parent::TAB().'$myObject = new '.self::makeClassName($myTable->getName()).'();'.self::LN();
		$content .= parent::TAB().parent::TAB().'$myObject->_setIsNew(false);'.self::LN();
		foreach($myTable->getColumns() as $column ){
			$content .= parent::TAB().parent::TAB().'$myObject->'.'set'.parent::formatAttributename($column->getName()).'($myDataObject->'.'get'.parent::formatAttributename($column->getName()).'());'.self::LN();
		}
		// force-load "single-to-single" reference - [Referenzen werden mitgeladen - gezwungen, sonst gehen die Informationen verloren]
		if(isset($fk_tables[$myTable->getName()]))
		foreach($fk_tables[$myTable->getName()] as $key => $ref){
			if( $ref['type'] == DBReferenceTypes::REFERENCE_SINGLE_TO_SINGLE ){
				$ref_name = str_replace('TBL_', '', strtoupper($ref['table']));
				if($ref['table'] == $myTable->getName()){
					$content .= parent::TAB().parent::TAB().'$myObject->'.'set'.$ref['referenz_name'].'('.$ref['classname'].'Manager::get'.$ref['classname'].'By'.parent::formatAttributename($ref['col_own']).'($myDataObject->get'.parent::formatAttributename($ref['col_ref']) .'()));'.self::LN();
				}else{
					$content .= parent::TAB().parent::TAB().'Library::requireLibrary(LibraryKeys::APPLICATION_'.$ref_name.'());'.self::LN();
					$content .= parent::TAB().parent::TAB().'$myObject->'.'set'.$ref['referenz_name'].'('.$ref['classname'].'Manager::get'.$ref['classname'].'By'.parent::formatAttributename($ref['col_ref']).'($myDataObject->get'.parent::formatAttributename($ref['col_own']) .'()));'.self::LN();
				}

			}
		}
		$content .= parent::TAB().parent::TAB().'$myObject->_clearModifies(); // clear modified columns'.self::LN();
		$content .= parent::TAB().parent::TAB().'return $myObject;'.self::LN();
		$content .= parent::TAB().'}'.self::LN();
		$content .= self::LN();

		// from object to dao
		$content .= parent::TAB().'/**'.parent::LN();
		$content .= parent::TAB().' * @param '.self::makeClassName($myTable->getName()).' &$myObject'.parent::LN();
		$content .= parent::TAB().' * @return '.self::makeClassName($myTable->getName()).'DAO'.parent::LN();
		$content .= parent::TAB().' */'.parent::LN();
		$content .= parent::TAB().'private static final function getDataObjectFrom'.self::makeClassName($myTable->getName()).'('.self::makeClassName($myTable->getName()).' &$myObject){'.parent::LN();
		$content .= parent::TAB().parent::TAB().'Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC(\''.self::makeClassName($myTable->getName()).'\'));'.parent::LN();
		$pk_check = array();
		$pk_string = array();
		$pks = array();
		$pknames = array();
		foreach ($myTable->getPrimaryKey()->getColumns() as $column){
			$pk_check[] = '!is_null($myObject->get'.parent::formatAttributename($column->getName()).'() AND !$myObject->_getIsNew())';
			$pk_string[] = strtolower($column->getName()).' = ?';
			$pks[] = '$myObject->get'.parent::formatAttributename($column->getName()).'()';
			$pknames[] = $column->getName();
		}
		$content .= parent::TAB().parent::TAB().'if( '.implode(' AND ', $pk_check).' ){'.self::LN();
		$content .= parent::TAB().parent::TAB().parent::TAB().'$myDataObject = '.self::makeClassName($myTable->getName()).'DAO::queryWithPreparedStatementWhereCondition(\''.implode(' AND ', $pk_string).'\', array('.implode(',', $pks).'));'.self::LN();
		$content .= parent::TAB().parent::TAB().parent::TAB().'$myDataObject = $myDataObject[0];'.self::LN();
		$content .= parent::TAB().parent::TAB().'}else{'.self::LN();
		$content .= parent::TAB().parent::TAB().parent::TAB().'$myDataObject = new '.self::makeClassName($myTable->getName()).'DAO();'.self::LN();
		$content .= parent::TAB().parent::TAB().'}'.self::LN();
		// setter
		foreach($myTable->getColumns() as $column ){
			if( in_array($column->getName(), $pknames) ) // skip primary keys
				continue;
				$content .= parent::TAB().parent::TAB().'$myDataObject->'.'set'.parent::formatAttributename($column->getName()).'($myObject->'.'get'.parent::formatAttributename($column->getName()).'());'.self::LN();
		}
		$content .= parent::TAB().parent::TAB().'// references - overwrite whit informations from object'.self::LN();
		if(isset($fk_tables[$myTable->getName()]))
		foreach($fk_tables[$myTable->getName()] as $ref)
			if( $ref['type'] == DBReferenceTypes::REFERENCE_SINGLE_TO_SINGLE ){
				$content .= parent::TAB().parent::TAB().'if($myObject->'.'get'.$ref['referenz_name'].'())'.self::LN();
				if( $ref['table'] == $myTable->getName() )
					$content .= parent::TAB().parent::TAB().parent::TAB().'$myDataObject->'.'set'.parent::formatAttributename($ref['col_ref']).'($myObject->'.'get'.$ref['referenz_name'].'()->get'.parent::formatAttributename($ref['col_own']).'());'.self::LN();
				else
					$content .= parent::TAB().parent::TAB().parent::TAB().'$myDataObject->'.'set'.parent::formatAttributename($ref['col_own']).'($myObject->'.'get'.$ref['referenz_name'].'()->get'.parent::formatAttributename($ref['col_ref']).'());'.self::LN();
			}
		$content .= parent::TAB().parent::TAB().'return $myDataObject;'.self::LN();
		$content .= parent::TAB().'}'.self::LN();
		$content .= self::LN();

		return $content;
	}

	private static final function buildSaveMethod(DBTable &$myTable,array $fk_tables, array $m2m_tables){
		// save only
		$content = parent::TAB().'/**'.parent::LN();
		$content .= parent::TAB().' * @param '.self::makeClassName($myTable->getName()).' &$myObject'.parent::LN();
		$content .= parent::TAB().' */'.parent::LN();
		$content .= parent::TAB().'public static final function saveOnly('.self::makeClassName($myTable->getName()).' &$myObject){'.self::LN();
		$content .= parent::TAB().parent::TAB().'Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC(\''.self::makeClassName($myTable->getName()).'\'));'.parent::LN();
		$content .= parent::TAB().parent::TAB().'if( count($myObject->_getModified()) == 0 )'.parent::LN();
		$content .= parent::TAB().parent::TAB().parent::TAB().'return false; // return if no changes was made'.parent::LN();
		$content .= parent::TAB().parent::TAB().self::makeClassName($myTable->getName()).'DAO::store($myObject);'.self::LN();

		$pk_col = array();
		foreach ($myTable->getPrimaryKey()->getColumns() as $column){
			$pk_col[] = parent::formatAttributename($column->getName());
			// macht die DAO schon
			//$content .= parent::TAB().parent::TAB().'$myObject->set'.parent::formatAttributename($column->getName()).'($myDataObject->get'.parent::formatAttributename($column->getName()).'());'.self::LN();
		}

		$content .= parent::TAB().'}'.parent::LN();
		$content .= parent::LN();

		// save whit sub-objects
		$content .= parent::TAB().'/**'.parent::LN();
		$content .= parent::TAB().' * @param '.self::makeClassName($myTable->getName()).' &$myObject'.parent::LN();
		$content .= parent::TAB().' */'.parent::LN();
		$content .= parent::TAB().'public static function save('.self::makeClassName($myTable->getName()).' &$myObject){'.self::LN();
		$content .= parent::TAB().parent::TAB().'self::saveOnly($myObject);'.self::LN();

		if( !isset($m2m_tables[$myTable->getName()]) )
			if(isset($fk_tables[$myTable->getName()]) AND !in_array($myTable->getName(),$fk_tables['unassigned']))
				foreach ($fk_tables[$myTable->getName()] as $ref){
					$ref_name = $ref['classname'];
					$ref_col = parent::formatAttributename($ref['col_ref']);
					$attributename = $ref['referenz_name'];
					$is_m2m = ( !is_null($ref['ref_table']) AND $ref['ref_table'] != $myTable->getName()); // reference ist m2m

					// skip "not redirectable" references
					$assigned = in_array($ref['table'],$fk_tables['unassigned']);
					#$assigned = ($fk_tables[$ref['name']][$myTable->getName()]['assigned'] == false);
					if( $assigned AND !$is_m2m )
						continue;

					$is_m2m = !is_null($ref['ref_table']); // reference ist m2m
					$m2m = self::makeClassName($ref['ref_table']);
					$is_many = ($ref['type'] == DBReferenceTypes::REFERENCE_MANY_TO_MANY OR $ref['type'] == DBReferenceTypes::REFERENCE_SINGLE_TO_MANY );
					$referencetype = '';
					if($is_many)
						$referencetype .= 'List';

					$nullable = $ref['nullable'];

					$content .= self::LN();
					$content .= parent::TAB().parent::TAB().'// save '.$ref_name.self::LN();
					if($is_m2m == false){

						if( $ref['type'] == DBReferenceTypes::REFERENCE_SINGLE_TO_MANY ){
							$content .= parent::TAB().parent::TAB().'foreach($myObject->get'.self::makeClassName($ref['referenz_name']).$referencetype.'() as $sub){'.self::LN();
							$content .= parent::TAB().parent::TAB().parent::TAB().'$sub->set'.$ref['col_ref_attributename'].'($myObject->get'.$ref['col_own_attributename'].'());'.self::LN();
							$content .= parent::TAB().parent::TAB().parent::TAB().$ref_name.'Manager::saveOnly($sub);'.self::LN();
							#$content .= parent::TAB().parent::TAB().parent::TAB().'$myObject->set'.$ref['col_own_attributename'].'($myObject->get'.$ref['col_ref_attributename'].'());'.self::LN();
							$content .= parent::TAB().parent::TAB().'}'.self::LN();
						}else{
							// single-to-single
							if($myTable->getName() == $ref['table']){
								$content .= parent::TAB().parent::TAB().'self::saveOnly($myObject->get'.$ref['referenz_name'].'());'.self::LN();
								$content .= parent::TAB().parent::TAB().'$myObject->set'.$ref['col_ref_attributename'].'($myObject->get'.$ref['referenz_name'].'()->get'.$ref['col_own_attributename'].'());'.self::LN();
							}else{
								if($nullable)
									$content .= parent::TAB().parent::TAB().'if(!is_null($myObject->get'.$ref['referenz_name'].'())){'.self::LN();
								$content .= parent::TAB().parent::TAB().($nullable ? parent::TAB() : null).$ref_name.'Manager::saveOnly($myObject->get'.$ref['referenz_name'].'());'.self::LN();
								$content .= parent::TAB().parent::TAB().($nullable ? parent::TAB() : null).'$myObject->set'.$ref['col_own_attributename'].'($myObject->get'.$ref['referenz_name'].'()->get'.$ref['col_ref_attributename'].'());'.self::LN();
								if($nullable)
									$content .= parent::TAB().parent::TAB().'}'.self::LN();
							}
						}

					}else{
						// m2m
						$primarykey = $pk_col[0];
						$content .= parent::TAB().parent::TAB().'foreach($myObject->get'.self::makeClassName($ref['referenz_name']).$referencetype.'() as $mySub){'.self::LN();
						#$content .= parent::TAB().parent::TAB().parent::TAB().$m2m.'Manager::saveM2M($myObject,$sub);'.self::LN();
						$content .= parent::TAB().parent::TAB().parent::TAB().'$m2m_'.$m2m.' = new '.$m2m.'();'.self::LN();
						$content .= parent::TAB().parent::TAB().parent::TAB().'$m2m_'.$m2m.'->set'.$primarykey.'($myObject->get'.$primarykey.'());'.self::LN();
						$content .= parent::TAB().parent::TAB().parent::TAB().'$m2m_'.$m2m.'->set'.$ref_col.'($mySub->get'.$ref_col.'());'.self::LN();
						$content .= parent::TAB().parent::TAB().parent::TAB().$m2m.'Manager::saveOnly($m2m_'.$m2m.');'.self::LN();
						$content .= parent::TAB().parent::TAB().'}'.self::LN();
					}
				}

		$content .= parent::TAB().'}'.self::LN();
		$content .= self::LN();
		return $content;
	}

	private static final function buildDeleteMethod(DBTable &$myTable){
		$content = parent::TAB().'/**'.parent::LN();
		$content .= parent::TAB().' * @param '.self::makeClassName($myTable->getName()).' &$myObject'.parent::LN();
		$content .= parent::TAB().' */'.parent::LN();
		$content .= parent::TAB().'public static function delete('.self::makeClassName($myTable->getName()).' &$myObject){'.self::LN();
		$content .= parent::TAB().parent::TAB().'Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC(\''.self::makeClassName($myTable->getName()).'\'));'.parent::LN();
		$content .= parent::TAB().parent::TAB().'if($myObject->_getIsNew())'.self::LN();
		$content .= parent::TAB().parent::TAB().parent::TAB().'return false; // return if object is new'.self::LN();
		$content .= parent::TAB().parent::TAB().'$myObject->_setIsDeleted(true);'.self::LN();
		$content .= parent::TAB().parent::TAB().self::makeClassName($myTable->getName()).'DAO::store($myObject);'.self::LN();
		$content .= parent::TAB().'}'.self::LN();
		$content .= self::LN();
		return $content;
	}

	private function makeName($name){
		return str_replace(array('new_', 'tbl_'), '', strtolower($name));
	}

	private function makeAttGetFunction($attname){
		$attname = 'get'.parent::formatAttributename(strtolower($attname)).'()';
		return $attname;
	}

	private function makeAttSetFunction( $attname ){
		$attname = 'set'.parent::formatAttributename(strtolower($attname));
		return $attname;
	}

}
?>