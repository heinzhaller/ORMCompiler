<?php
#ä
require_once 'class.ORMBuilderBase.php';

abstract class ORMBuilderDAOClass extends ORMBuilderBase {

	/*
	public static final function build(ORMConfig &$myConfig, TableInfo &$myTable){
		self::setConfig($myConfig);
		$driver = self::makeClassName($myConfig->getDbDriver());
		$driver = 'Oracle';
		$class = 'ORMBuilderDAOCreoleClass';
		require_once ORMCOMPILER_PATH.'/Builder/DAO/'.strtolower($driver).'/class.ORMBuilderDAOCreoleClass.php';
		$myDAOBuilder = new $class(DBConnection::getConnection($myConfig));
		$myContent = $myDAOBuilder->run($myTable);

		$filename = 'class.'.self::makeClassName($myTable->getName()).'DAO.php';
		$path = $myConfig->getSystemPath().'Database/DAO/'.$filename;
		self::write($path,$myContent);
	}
	*/

	public static final function build(ORMConfig &$myConfig, DBTable &$myTable, array $fk_tables, array $m2m_tables){
		self::setConfig($myConfig);
		$myContent  = parent::HEADER();
		$myContent .= 'Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_BASE());'.parent::LN();
		$myContent .= parent::LN();
		$myContent .= parent::COMMENT(self::makeClassName($myTable->getName()) . ' DAO-Class [DAO]');
		$myContent .= 'abstract class '.self::makeClassName($myTable->getName()).'DAO extends BaseDAO { '.parent::LN().parent::LN();
		$myContent .= parent::TAB().'const TABLENAME = \''.strtolower($myTable->getName()).'\';'.parent::LN().parent::LN();
		$myContent .= self::buildPrimaryKeys($myTable);
		$myContent .= self::buildColumns($myTable);
		$myContent .= self::buildQuery($myTable, $fk_tables);
		$myContent .= self::buildFetchFromResult($myTable, $fk_tables);
		$myContent .= self::buildStore($myTable, $fk_tables);
		$myContent .= self::buildInsert($myTable, $fk_tables);
		$myContent .= self::buildUpdate($myTable, $fk_tables);
		$myContent .= parent::FOOTER();

		$filename = 'class.'.self::makeClassName($myTable->getName()).'DAO.php';
		$path = $myConfig->getSystemPath().'Database/DAO/'.$filename;

		self::write($path,$myContent);
	}

	private static final function buildPrimaryKeys(DBTable &$myTable){
		$content = parent::TAB().'protected static $primarykeys = array('.parent::LN();
		$pk = array();
		foreach ($myTable->getPrimaryKey()->getColumns() as $column){
			$pk[] = parent::TAB().parent::TAB().'\''.$column->getName().'\' => \'get'.self::formatAttributename($column->getName()).'\'';
		}
		$content .= implode(','.parent::LN(), $pk).parent::LN();
		$content .= parent::TAB().');'.parent::LN();
		$content .= self::LN();
		$content .= parent::TAB().'public function getPrimaryKeys(){'.parent::LN();
		$content .= parent::TAB().parent::TAB().'return self::$primarykeys;'.self::LN();
		$content .= parent::TAB().'}'.self::LN();
		$content .= self::LN();
		return $content;
	}

	private static final function buildColumns(DBTable &$myTable){
		$content = parent::TAB().'protected static $columns = array('.parent::LN();
		$classname = parent::makeClassName($myTable->getName());
		$tablename = strtolower($myTable->getName());
		$columns = array();
		foreach ( $myTable->getColumns() as $col ){
			$col instanceof DBColumn;
			// hier muss der manager vorher required sein
			//$col_content = parent::TAB().parent::TAB().$classname.'Manager::'.strtoupper($col->getName()). ' => \'';
			// so isses erstmal performanter
			$col_content = parent::TAB().parent::TAB().'\''.$col->getName().'\' => \'';
			if( $col->getType() == DBTypes::TIMESTAMP )
				$col_content .= 'UNIX_TIMESTAMP('.$tablename.'.'.$col->getName().') as '.strtoupper(self::makeClassName($tablename)).'_'.strtoupper($col->getName());
			else
				$col_content .= $tablename.'.'.$col->getName().' as '.strtoupper(self::makeClassName($tablename)).'_'.strtoupper($col->getName());
			$col_content .= '\'';
			$columns[] = $col_content;
		}
		$content .= implode(','.parent::LN(), $columns).parent::LN();
		$content .= parent::TAB().');'.parent::LN();
		$content .= self::LN();
		$content .= parent::TAB().'public function getColumns(){'.parent::LN();
		$content .= parent::TAB().parent::TAB().'return self::$columns;'.self::LN();
		$content .= parent::TAB().'}'.self::LN();
		$content .= self::LN();
		return $content;
	}

	private static final function buildQuery(DBTable &$myTable, array $fk_tables){
		$content = parent::TAB().'/**'.parent::LN();
		$content .= parent::TAB().' * @param string $where'.parent::LN();
		$content .= parent::TAB().' * @param array $params'.parent::LN();
		$content .= parent::TAB().' * @param SQLLimit &$myLimit'.parent::LN();
		$content .= parent::TAB().' */'.parent::LN();
		$content .= parent::TAB().'public static final function get'.self::makeClassName($myTable->getName()).'ListByQuery($where, array $params = null, SQLLimit &$myLimit = null){'.self::LN();
		$content .= parent::TAB().parent::TAB().'$myResult = self::genericQuery(\''.self::LN();
		$content .= parent::TAB().parent::TAB().'SELECT'.self::LN();
		$tablename = strtolower($myTable->getName());
		$cols = array();
		foreach ( $myTable->getColumns() as $col ){
			$col instanceof DBColumn;
			if( $col->getType() == DBTypes::TIMESTAMP )
			$cols[] = 'UNIX_TIMESTAMP('.$tablename.'.'.$col->getName().') as '.strtoupper(self::makeClassName($tablename)).'_'.strtoupper($col->getName());
			else
				$cols[] = $tablename.'.'.$col->getName().' as '.strtoupper(self::makeClassName($tablename)).'_'.strtoupper($col->getName());
		}

#		foreach ($fk_tables[$myTable->getName()] as $ref){
#			if( $ref['type'] == DBReferenceTypes::REFERENCE_SINGLE_TO_SINGLE )
#		}
		$content .= parent::TAB().parent::TAB().parent::TAB().implode(', ', $cols).self::LN();
		$content .= parent::TAB().parent::TAB().'FROM'.self::LN();
		$content .= parent::TAB().parent::TAB().parent::TAB().'\'.self::TABLENAME.\''.self::LN();
		$content .= parent::TAB().parent::TAB().'WHERE \'.$where, $params, $myLimit);'.self::LN();
		$content .= parent::TAB().parent::TAB().'$myList = new '.self::makeClassName($myTable->getName()).'List();'.self::LN();
		$content .= parent::TAB().parent::TAB().'while($myResult->next())'.self::LN();
		$content .= parent::TAB().parent::TAB().parent::TAB().'$myList->add(self::get'.self::makeClassName($myTable->getName()).'FromResult($myResult));'.self::LN();
		$content .= parent::TAB().parent::TAB().'return $myList;'.self::LN();
		$content .= parent::TAB().'}'.self::LN();
		$content .= self::LN();
		return $content;
	}

	private static final function buildFetchFromResult(DBTable &$myTable, $fk_tables){
		$content = parent::TAB().'/**'.parent::LN();
		$content .= parent::TAB().' * @param ResultSet &$myDataObject'.parent::LN();
		$content .= parent::TAB().' * @return '.self::makeClassName($myTable->getName()).''.parent::LN();
		$content .= parent::TAB().' */'.parent::LN();
		$content .= parent::TAB().'public static final function get'.self::makeClassName($myTable->getName()).'FromResult(ResultSet &$myResult, $load_references_from_database = false){'.self::LN();

		$content .= parent::TAB().parent::TAB().'$row = $myResult->getRow();'.self::LN();
		$content .= parent::TAB().parent::TAB().'// return null on empty left joins'.self::LN();
		foreach ($myTable->getPrimaryKey()->getColumns() as $column){
			$column instanceof DBColumn;
			$colname = strtoupper(self::makeClassName($myTable->getName()).'_'.strtoupper($column->getName()));
			$content .= parent::TAB().parent::TAB().'if( !$myResult->get(\''.$colname.'\') OR $myResult->get(\''.$colname.'\') == \'NULL\' )'.self::LN();
			$content .= parent::TAB().parent::TAB().parent::TAB().'return null;'.self::LN();
		}

		$content .= parent::TAB().parent::TAB().'Library::requireLibrary(LibraryKeys::APPLICATION_'.str_replace('TBL_', '', strtoupper($myTable->getName())).'());'.self::LN();
		$content .= parent::TAB().parent::TAB().'$myObject = new '.self::makeClassName($myTable->getName()).'();'.self::LN();
		$content .= parent::TAB().parent::TAB().'// get attributes from result "tablename + columnname"'.self::LN();

		// cols
		foreach ( $myTable->getColumns() as $col ){
			$type = DBCreoleTypes::getCreoleFunctionNames( self::getPHPType($col->getTypname()) );
			$colname = strtoupper(self::makeClassName($myTable->getName()).'_'.$col->getName());
			$content .= parent::TAB().parent::TAB().'try {'.self::LN();
			$content .= parent::TAB().parent::TAB().parent::TAB().'$myObject->set'.self::formatAttributename($col->getName()).'( $myResult->get'.self::formatAttributename($type).'(\''.$colname.'\'));'.self::LN();
			$content .= parent::TAB().parent::TAB().'} catch (SQLException $e) { throw $e; }'.self::LN();
		}

		// references
		$content .= parent::TAB().parent::TAB().'// references'.self::LN();
		#$content .= parent::TAB().parent::TAB().'if( $load_references_from_database ){'.self::LN();
		if(isset($fk_tables[$myTable->getName()]))
		foreach ( $fk_tables[$myTable->getName()] as $reference ){
			if( $reference['type'] != DBReferenceTypes::REFERENCE_SINGLE_TO_SINGLE )
				continue;

			$attributename = $reference['referenz_name_org'];
			$classname = $reference['classname'];
			$isMany = false;
			if( $reference['type'] == DBReferenceTypes::REFERENCE_MANY_TO_MANY OR $reference['type'] == DBReferenceTypes::REFERENCE_SINGLE_TO_MANY ){
				$attributename .= '_list';
				$classname .= 'List';
				$isMany = true;
			}

			// selbst referenz
			if($reference['table'] == $myTable->getName()){
				// ...
			}else{
				#if( strtoupper($myTable->getName()) == 'TBL_MANAGER' OR strtoupper($myTable->getName()) == 'TBL_MANAGER_MESSAGE')
				#	var_dump($reference);
				// ## hier abfragen ob existiert
				// TODO: wen der result auch die spalten der referenzen enthält - sollte das Referenz object auch geladen werden
				// strtoupper($reference['referenz_name'].'_'.$reference['col_ref_attributename']);
				//$content .= parent::TAB().parent::TAB().'Library::requireLibrary(LibraryKeys::APPLICATION_'.str_replace('TBL_', '', strtoupper($reference['table'])).'());'.self::LN();
				$content .= parent::TAB().parent::TAB().'if( array_key_exists(\''.strtoupper($reference['classname'].'_'.$reference['col_ref_attributename']).'\',$row) AND $load_references_from_database ){'.self::LN();
				$content .= parent::TAB().parent::TAB().parent::TAB().'include_once \'class.'.$reference['classname'].'DAO.php\';'.self::LN();
				$content .= parent::TAB().parent::TAB().parent::TAB().'$myRef = '.$reference['classname'].'DAO::get'.$reference['classname'].'FromResult($myResult); // try to build ref-object'.self::LN();
				$content .= parent::TAB().parent::TAB().parent::TAB().'if( $myRef )'.self::LN();
				$content .= parent::TAB().parent::TAB().parent::TAB().parent::TAB().'$myObject->set'.$reference['referenz_name'].'('.$reference['classname'].'DAO::get'.$reference['classname'].'FromResult($myResult));'.self::LN();
				$content .= parent::TAB().parent::TAB().parent::TAB().'$myObject->_setIsLoaded(\'ref_'.strtolower($attributename).'\');'.self::LN();
				$content .= parent::TAB().parent::TAB().'}'.self::LN();
			}
			// OOP method
			//$content .= parent::TAB().parent::TAB().'$myObject->set'.$reference['referenz_name'].'('.$reference['classname'].'Manager::get'.$reference['classname'].'By'.$reference['quelle_name'].'($myObject));'.self::LN();
			// ... hier direkt object übergeben
			#$content .= parent::TAB().parent::TAB().parent::TAB().'$myObject->set'.$reference['referenz_name'].'($myObject->get'.$reference['referenz_name'].'());'.self::LN();
		}
		#$content .= parent::TAB().parent::TAB().'}'.self::LN();

		$content .= parent::TAB().parent::TAB().'// set status'.self::LN();
		$content .= parent::TAB().parent::TAB().'$myObject->_clearModifies(); // clear modified columns'.self::LN();
		$content .= parent::TAB().parent::TAB().'$myObject->_setIsNew(false); // set status to "existing"'.self::LN();
		$content .= parent::TAB().parent::TAB().'return $myObject;'.self::LN();
		$content .= parent::TAB().'}'.self::LN();

		$content .= self::LN();
		return $content;
	}

	private static final function buildStore(DBTable &$myTable){
		$content = parent::TAB().'/**'.parent::LN();
		$content .= parent::TAB().' * insert, update or delete'.parent::LN();
		$content .= parent::TAB().' * @param BaseObject $myObject'.parent::LN();
		$content .= parent::TAB().' */'.parent::LN();
		$content .= parent::TAB().'public static final function store('.self::makeClassName($myTable->getName()).' &$myObject){'.self::LN();
		$content .= parent::TAB().parent::TAB().'if ( $myObject->_getIsNew() == true AND $myObject->_getIsDeleted() == false ) {'.self::LN();
		$content .= parent::TAB().parent::TAB().parent::TAB().'self::insert($myObject);'.self::LN();
		$content .= parent::TAB().parent::TAB().'} else if( count($myObject->_getModified()) > 0 AND $myObject->_getIsDeleted() == false) {'.self::LN();
		$content .= parent::TAB().parent::TAB().parent::TAB().'self::update($myObject);'.self::LN();
		$content .= parent::TAB().parent::TAB().'} else if( $myObject->_getIsDeleted() == true AND $myObject->_getIsNew() == false ){'.self::LN();
		$content .= parent::TAB().parent::TAB().parent::TAB().'self::delete($myObject);'.self::LN();
		$content .= parent::TAB().parent::TAB().'}'.self::LN();
		$content .= parent::TAB().'}'.self::LN();
		$content .= self::LN();
		return $content;
	}

	private static final function buildInsert(DBTable &$myTable, $fk_tables){
		$content = parent::TAB().'/**'.parent::LN();
		$content .= parent::TAB().' * insert object into database'.parent::LN();
		$content .= parent::TAB().' * @param '.self::makeClassName($myTable->getName()).' &$myObject'.parent::LN();
		$content .= parent::TAB().' */'.parent::LN();
		$content .= parent::TAB().'private static final function insert('.self::makeClassName($myTable->getName()).' &$myObject){'.self::LN();
		$content .= parent::TAB().parent::TAB().'$insert = array();'.self::LN();
		$content .= parent::TAB().parent::TAB().'$para = array();'.self::LN();
		$content .= self::LN();
		// cols
		foreach ( $myTable->getColumns() as $col ){
			$col instanceof DBColumn;
			$value = '?';
			if( $col->getType() == DBTypes::TIMESTAMP OR preg_match('/^tstamp\_/ui',$col->getName()) ){
				$content .= parent::TAB().parent::TAB().'if( !is_null($myObject->get'.self::formatAttributename($col->getName()).'()) ){'.self::LN();
				$content .= parent::TAB().parent::TAB().parent::TAB().'$para[] = \'FROM_UNIXTIME(?)\';'.self::LN();
				$content .= parent::TAB().parent::TAB().parent::TAB().'$insert[] = \''.$col->getName().'\';'.self::LN();
				$content .= parent::TAB().parent::TAB().'}'.self::LN();
			}else {
				$content .= parent::TAB().parent::TAB().'$para[] = \''.$value.'\';'.self::LN();
				$content .= parent::TAB().parent::TAB().'$insert[] = \''.$col->getName().'\';'.self::LN();
			}

		}
		$content .= self::LN();
		$content .= parent::TAB().parent::TAB().'$conn = DBConnection::getConnection();'.self::LN();
		$content .= parent::TAB().parent::TAB().'$stmt = $conn->prepareStatement(\''.self::LN();
		$content .= parent::TAB().parent::TAB().'INSERT INTO \'.self::TABLENAME.\' (\' . implode(\', \', $insert) . \')'.self::LN();
		$content .= parent::TAB().parent::TAB().'VALUES ( \' . implode(\', \', $para) . \')\');'.self::LN();
		$content .= self::LN();
		$content .= parent::TAB().parent::TAB().'$paramCount = 1;'.self::LN();
		foreach ( $myTable->getColumns() as $col ){
			$col instanceof DBColumn;
			$type = DBCreoleTypes::getCreoleFunctionNames( self::getPHPType($col->getTypname()) );
			if( $col->getType() == DBTypes::TIMESTAMP OR preg_match('/^tstamp\_/ui',$col->getName()) ){
				$content .= parent::TAB().parent::TAB().'if( !is_null($myObject->get'.self::formatAttributename($col->getName()).'()) ){'.self::LN();
				$content .= parent::TAB().parent::TAB().parent::TAB().'$stmt->set'.self::formatAttributename($type).'($paramCount++, $myObject->get'.self::formatAttributename($col->getName()).'());'.self::LN();
				$content .= parent::TAB().parent::TAB().'}'.self::LN();
			}else{
				$content .= parent::TAB().parent::TAB().'$stmt->set'.self::formatAttributename($type).'($paramCount++, $myObject->get'.self::formatAttributename($col->getName()).'());'.self::LN();
			}
		}
		$content .= self::LN();

		$myPrimaryKeys = $myTable->getPrimaryKey()->getColumns();

		$content .= parent::TAB().parent::TAB().'// execute and get last inserted id'.self::LN();
		$content .= parent::TAB().parent::TAB().'$stmt->executeUpdate();'.self::LN();
		// default value
		$content .= parent::TAB().parent::TAB().'$id = $myObject->get'.self::formatAttributename($myPrimaryKeys[0]->getName()).'();'.self::LN();
		// only if value is integer

		if(count($myPrimaryKeys) == 1 AND $myPrimaryKeys[0]->getisAutoincrement() == true ){
			$content .= parent::TAB().parent::TAB().'$idgen = $conn->getIdGenerator();'.self::LN();
			$content .= parent::TAB().parent::TAB().'if($idgen->isAfterInsert())'.self::LN();
			$content .= parent::TAB().parent::TAB().parent::TAB().'$id = $idgen->getId();'.self::LN();
		}
		$content .= self::LN();
		$content .= parent::TAB().parent::TAB().'// datensatz aus datenbank holen - alle änderungen müssen übnernommen werden'.self::LN();
		$pk_string = array();
		$pk_attr = array();
		foreach ($myTable->getPrimaryKey()->getColumns() as $column){
			$pk_string[] = strtolower($myTable->getName()).'.'.$column->getName().' = ?';
			$pk_attr[] = '$myObject->get'.self::formatAttributename($column->getName()).'()';
		}
		$content .= parent::TAB().parent::TAB().'$myList = self::get'.self::makeClassName($myTable->getName()).'ListByQuery(\''.implode(' AND ', $pk_string).'\', array('.( count($myTable->getPrimaryKey()->getColumns()) > 1 ? implode(', ', $pk_attr) : '$id' ) .'), new SQLLimit(1));'.self::LN();
		$content .= parent::TAB().parent::TAB().'$myNewObject = $myList->current();'.self::LN();

		foreach ( $myTable->getColumns() as $col )
			$content .= parent::TAB().parent::TAB().'$myObject->set'.parent::formatAttributename($col->getName()).'($myNewObject->get'.parent::formatAttributename($col->getName()).'()); // overwrite original'.self::LN();

		$content .= parent::TAB().parent::TAB().'$myObject->_setIsNew(false);'.self::LN();
		$content .= parent::TAB().'}'.self::LN();
		$content .= self::LN();
		return $content;
	}

	private static final function buildUpdate(DBTable &$myTable, $fk_tables){
		$content = parent::TAB().'/**'.parent::LN();
		$content .= parent::TAB().' * update object whit database'.parent::LN();
		$content .= parent::TAB().' * @param '.self::makeClassName($myTable->getName()).' &$myObject'.parent::LN();
		$content .= parent::TAB().' */'.parent::LN();
		$content .= parent::TAB().'private static final function update('.self::makeClassName($myTable->getName()).' &$myObject){'.self::LN();
		$content .= parent::TAB().parent::TAB().'$updates = array();'.self::LN();
		foreach ( $myTable->getColumns() as $col ){
			$col instanceof DBColumn;
			$value = '?';
			if( $col->getType() == DBTypes::TIMESTAMP OR preg_match('/^tstamp\_/ui',$col->getName()) )
				$value = 'FROM_UNIXTIME(?)';
			$content .= parent::TAB().parent::TAB().'if( $myObject->_getIsModified(\''.$col->getName().'\') ) {'.self::LN();
			$content .= parent::TAB().parent::TAB().parent::TAB().'$updates[] = \''.strtolower($myTable->getName()).'.'.$col->getName().' = '.$value.'\';'.self::LN();

			// aktuellen zeitstempel setzen
			if( preg_match('/^tstamp\_modified/ui',$col->getName()) ){
				$content .= parent::TAB().parent::TAB().'}else{'.self::LN();
				$content .= parent::TAB().parent::TAB().parent::TAB().'$updates[] = \''.strtolower($myTable->getName()).'.'.$col->getName().' = NOW()\';'.self::LN();
			}
			$content .= parent::TAB().parent::TAB().'}'.self::LN();
		}
		$content .= self::LN();
		$content .= parent::TAB().parent::TAB().'$conn = DBConnection::getConnection();'.self::LN();
		$pk_string = array();
		$pk_attr = array();
		$pk_lines = parent::TAB().parent::TAB().'// pk'.self::LN();
		foreach ($myTable->getPrimaryKey()->getColumns() as $column){
			$pk_string[] = strtolower($myTable->getName()).'.'.$column->getName().' = ?';
			$type = DBCreoleTypes::getCreoleFunctionNames( self::getPHPType($col->getTypname()) );
			$pk_attr[] = '$myObject->get'.self::formatAttributename($column->getName()).'()';
			$pk_lines .= parent::TAB().parent::TAB().'$stmt->set'.$type.'($paramCount++, $myObject->get'.self::formatAttributename($column->getName()).'());'.self::LN();
		}

		$content .= parent::TAB().parent::TAB().'$where = \'UPDATE \'.self::TABLENAME.\' SET \'.implode(\', \', $updates). \' WHERE '.implode(' AND ', $pk_string).'\';'.self::LN();
		$content .= parent::TAB().parent::TAB().'$stmt = $conn->prepareStatement($where);'.self::LN();
		$content .= parent::TAB().parent::TAB().'$paramCount = 1;'.self::LN();

		foreach ( $myTable->getColumns() as $col ){
			$type = DBCreoleTypes::getCreoleFunctionNames( self::getPHPType($col->getTypname()) );
			$content .= parent::TAB().parent::TAB().'if( $myObject->_getIsModified(\''.$col->getName().'\') )'.self::LN();
			$content .= parent::TAB().parent::TAB().parent::TAB().'$stmt->set'.$type.'($paramCount++, $myObject->get'.self::formatAttributename($col->getName()).'());'.self::LN();
		}

		$content .= $pk_lines;
		$content .= self::LN();
		$content .= parent::TAB().parent::TAB().'$stmt->executeUpdate();'.self::LN();
		$content .= self::LN();
		$content .= parent::TAB().parent::TAB().'// veränderten datensatz aus db laden (tstamp haben sich geändert)'.self::LN();
		$content .= parent::TAB().parent::TAB().'$myList = self::get'.self::makeClassName($myTable->getName()).'ListByQuery(\''.implode(' AND ', $pk_string).'\', array('.( count($myTable->getPrimaryKey()->getColumns()) > 1 ? implode(', ', $pk_attr) : $pk_attr[0] ) .'), new SQLLimit(1));'.self::LN();
		$content .= parent::TAB().parent::TAB().'$myObject = $myList->current(); // overwrite orginal'.self::LN();
		$content .= parent::TAB().'}'.self::LN();
		$content .= self::LN();
		return $content;
	}

}
?>