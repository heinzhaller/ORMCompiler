<?php

// the compiler class

class ORMBuilderDAOMySQLClass {

	var $conn;

	var $primarykeys;
	
	/////////////////////// CONFIGURATION ///////////////////////

	var $skipTables = array(

	);

	var $stringTypes = array (
  	'enum', 'char', 'varchar', 'text', 'mediumtext'
  );

	var $includeTables = array(
		'cm_users'
	);

	var $templateField;

	var $templateClass;

	/////////////////////// COMPILER CODE ///////////////////////

	function ormCompiler($connStr) {
		$this->conn = Creole::getConnection($connStr);

		$this->templateClass = <<< END
class ###clsname### extends BasicDAO {

    // interne verwaltungsfunktionen

###attributes###

    public function __construct() {
      \$this->meta_New = true;
      \$this->meta_Modified = array();
    }

    public function isModified() {
      return (sizeof(\$this->meta_Modified) > 0);
    }


	public function setNew(){
		\$this->meta_New = true;
	}

	public function isNew() {
  	return \$this->meta_New;
	}

    // funktionen zum speichern von werten in die bzw. zum
    // laden von werten aus der datenbank

    private function loadDataFromStatement(\$stmt) {
      \$this->meta_New = false;
      \$this->meta_Modified = array();
###rsget###
		}

		public static function queryWithPreparedStatementWhereCondition(\$psWhereCondition, \$psWhereParams) {
			return ###clsname###::queryWithPreparedStatementWhereConditionReturnAsObjOfClass(\$psWhereCondition, \$psWhereParams, '###clsname###');
		}

	public static function queryWithPreparedStatementWhereConditionReturnAsObjOfClass(\$psWhereCondition, \$psWhereParams, \$subclass) {
		\$rs = parent::genericQuery('SELECT * FROM ###tblname### where ' . \$psWhereCondition, \$psWhereParams);
		\$ret = array();
		while (\$rs->next()) {
			\$obj = new \$subclass();
			\$obj->loadDataFromStatement(\$rs);
			\$ret[] = \$obj;
		}
		return \$ret;
	}

	public static function queryWithSql(\$psStatement, \$psWhereParams) {
		return ###clsname###::queryWithSqlReturnAsObjOfClass(\$psStatement, \$psWhereParams, '###clsname###');
	}

	public static function queryWithSqlReturnAsObjOfClass(\$psStatement, \$psWhereParams, \$subclass) {
		\$ret = array();
		\$rs = parent::genericQuery(\$psStatement, \$psWhereParams);
		while (\$rs->next()) {
			\$obj = new \$subclass();
			\$obj->loadDataFromStatement(\$rs);
			\$ret[] = \$obj;
		}
		return \$ret;
	}

	public function store() {
		\$conn = DBConnection::getConnection();
		if ( \$this->isNew() == true ) {
			\$this->storeNew(\$conn);
		} else if( \$this->isModified() == true ) {
			\$this->updateExisting(\$conn);
		}
	}

	private function storeNew(\$conn) {
		\$conn = DBConnection::getConnection();
		\$stmt = \$conn->prepareStatement("INSERT INTO ###tblname### (###insertcols###) VALUES (###insertparams###)");
###setinsertparams###

###idgenerator###
		}
###updateautoinsertattribute###
		\$this->meta_New = false;
		\$this->meta_Modified = array();
	}

	private function updateExisting(\$conn) {
		\$updates = array();
###setupdatestmts###
		if(!empty(\$updates)){
			\$stmt = \$conn->prepareStatement("UPDATE ###tblname### SET " . implode(', ', \$updates) . " WHERE ###updatewhereparams###");
			\$paramCount = 1;
###setupdateparams###
###setupdatewhereparams###
			\$stmt->executeUpdate();
		}
		\$this->meta_New = false;
		\$this->meta_Modified = array();
	}

	public function delete(){
		if(\$this->isDeleted() == FALSE )
			\$this->setDeleted(true);
	}

	public function isColumnModified(\$colname){
		return isset(\$this->meta_modified[\$colname]);
	}

}
END;

                        	$this->templateField = <<< END
	public \$###attname###;

	public function get###uattname###() {
		return \$this->###attname###;
	}

	public function set###uattname###(\$new###uattname###) { ###returnonpkeycolumnsifnotnew###
		if ((\$this->###attname### != \$new###uattname###) || (is_null(\$this->###attname###) != is_null(\$new###uattname###))) {
			\$this->###attname### = \$new###uattname###;
			\$this->meta_Modified['###attname###'] = true;
		}
	}
END;

                        	$this->templateStrField = <<< END
	public \$###attname###;

	public function get###uattname###() {
		return \$this->###attname###;
	}

	public function set###uattname###(\$new###uattname###) {  ###returnonpkeycolumnsifnotnew###
		if ((strcmp(\$this->###attname###, \$new###uattname###) != 0) || (is_null(\$this->###attname###) != is_null(\$new###uattname###))) {
			\$this->###attname### = \$new###uattname###;
			\$this->meta_Modified['###attname###'] = true;
		}
	}
END;

	 }

 function run($tables) {
 	if ($tables) $this->includeTables = $tables;
 	$dbinfo = $this->conn->getDatabaseInfo();
 	$out = '<?php' . "\r\n";
 	$out .= "Library::requireLibrary(LibraryKeys::ABSTRACTION_CREOLE());"."\r\n".
 	"Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_BASIC());\r\n\r\n";
 	foreach($dbinfo->getTables() as $tbl) {
 		$out .= $this->compileTable($tbl);
 	}
 	$out .= '?>';
 	return $out;
 }

 function compileTable(MySQLTableInfo &$tbl) {
 	if (($this->includeTables && !in_array($tbl->getName(), $this->includeTables)) ||
 	($this->skipTables && in_array($tbl->getName(), $this->skipTables))) return;
 	$tblName = $tbl->getName();
 	$clsName = $this->makeClassName($tblName);
 	$colOut = '';
 	$rsGetOut = '';
 	$setInsertParamsOut = '';
 	$setUpdateStmtsOut = '';
 	$setUpdateParamsOut = '';
 	$updateWhereParams = array();
 	$setUpdateWhereParamsOut = '';
 	$insertcols = array();
 	$insertparams = array();
 	$colnr = 0;
 	$pkeys= $tbl->getPrimaryKey();
 	$pkeyNames = array();
 	foreach($pkeys->getColumns() as $pkcol) {
 		$pkeyNames[$pkcol->getName()] = array();;
 		$pkeyNames[$pkcol->getName()]['ai'] = $pkcol->isAutoIncrement() == true;
 	}
 	foreach($tbl->getColumns() as $col) {
 		$colnr ++;
 		$colOut = $colOut . $this->compileColumnToAttributes($col, $pkeyNames[$col->getName()]) . "\n\n";
 		$rsGetOut = $rsGetOut . $this->compileColumnToRsGet($col) . "\n";
 		$insertcols[] = '`' . $col->getName() . '`';
 		$insertparams[] = '?';
 		$setInsertParamsOut = $setInsertParamsOut . $this->compileColumnToSetParams($colnr, $col) . "\n";
 		if (!isset($pkeyNames[$col->getName()])) {
 			$setUpdateStmtsOut = $setUpdateStmtsOut . $this->compileColumnToUpdateStmts($col) . "\n";
 			$setUpdateParamsOut = $setUpdateParamsOut . $this->compileColumnToSetParamsForUpdateStmt($col) . "\n";
 		} else {
 			$updateWhereParams[] = '`'.$col->getName() . '` = ?';
 			$setUpdateWhereParamsOut .= $setUpdateParamsOut . $this->compileColumnToSetParams('$paramCount++', $col) . "\n";
 		}
 	}
 	$out = $this->templateClass;
 	$out = str_replace('###tblname###', $tblName, $out);
 	$out = str_replace('###clsname###', $clsName, $out);
 	$out = str_replace('###attributes###', $colOut, $out);
 	$out = str_replace('###rsget###', $rsGetOut, $out);
 	$out = str_replace('###insertcols###', implode(', ' , $insertcols), $out);
 	$out = str_replace('###insertparams###', implode(', ' , $insertparams), $out);
 	$out = str_replace('###setinsertparams###', $setInsertParamsOut, $out);
 	$out = str_replace('###setupdatestmts###', $setUpdateStmtsOut, $out);
 	$out = str_replace('###setupdateparams###', $setUpdateParamsOut, $out);
 	$out = str_replace('###updatewhereparams###', implode(' AND ', $updateWhereParams), $out);
 	$out = str_replace('###setupdatewhereparams###', $setUpdateWhereParamsOut, $out);
 	
 	// primary keys wenn autoincrement
 	$pklines = "\r\n";
 	if(!empty($pkeyNames))
 	foreach ($pkeyNames as $key => $pk){
 		if($pk['ai'] == true ){
 			$pklines .= chr(9).chr(9).'$this->' . $this->makeAttName($key) . " = \$id;"."\r\n";
 			$auto_increment = true;
 		}
 	}
 	$out = str_replace('###updateautoinsertattribute###', $pklines,$out);

 	$generator = '';
 	if($auto_increment)
 		$generator = '
 		$idgen = $conn->getIdGenerator();
		if($idgen->isBeforeInsert()) {
			$id = $idgen->getId();
		}
		$stmt->executeUpdate();
		if($idgen->isAfterInsert()) {
			$id = $idgen->getId();
 		';
 		
 	$out = str_replace('###idgenerator###',$generator, $out);
 	return $out;
 }

 function compileColumnToAttributes($col, $isPkeyColumn) {
 	$colName = $col->getName();
 	$attName = $this->makeAttName($colName);
 	if (in_array($col->getNativeType(), $this->stringTypes)) {
 		$out = $this->templateStrField;
 	} else {
 		$out = $this->templateField;
 	}
 	$out = str_replace('###returnonpkeycolumnsifnotnew###', $isPkeyColumn? "\n      if (!\$this->meta_New) return;" : '', $out);
 	$out = str_replace('###attname###', $attName, $out);
 	$out = str_replace('###uattname###', ucfirst($attName), $out);
 	return $out;
 }


 function compileColumnToRsGet($col) {
 	// print '\t'.$col->getName().' ('.$col->getNativeType().")\n";
 	// $val = $stmt->getInt("RETVAL");
 	// $ival = $stmt->getInt("@intval");
 	// $fval = $stmt->getFloat("@floatval");
 	// $sval = $stmt->getString("@sval");
 	$colName = $col->getName();
 	$attName = $this->makeAttName($colName);
 	$out = '';
 	switch ($col->getNativeType()) {
 		case 'int':
 		case 'tinyint':
 			$out = "      try { \$this->$attName = \$stmt->getInt('$colName'); } catch (SQLException \$s) { }";
 			break;
 		case 'float':
 		case 'double':
 		case 'decimal':
 			$out = "      try { \$this->$attName = \$stmt->getFloat('$colName'); } catch (SQLException \$s) { }";
 			break;
 		case 'enum':
 		case 'char':
 		case 'varchar':
 		case 'text':
 		case 'mediumtext':
 			$out = "      try { \$this->$attName = \$stmt->getString('$colName'); } catch (SQLException \$s) { }";
 			break;
 		case 'date':
 			$out = "      try { \$this->$attName = \$stmt->getDate('$colName', NULL); } catch (SQLException \$s) { }";
 			break;
 		case 'datetime':
 		case 'timestamp':
 			$out = "      try { \$this->$attName = \$stmt->getTimestamp('$colName'); } catch (SQLException \$s) { }";
 			break;
 		default:
 			echo $col->getNativeType().' not recognized while compiling <hr>';
 	}
 	return $out;
 }

 function compileColumnToSetParams($colnr, $col) {
 	$colName = $col->getName();
 	$attName = $this->makeAttName($colName);
 	$out = '';
 	switch ($col->getNativeType()) {
 		case 'int':
 		case 'tinyint':
 			$out = "      \$stmt->setInt($colnr, \$this->$attName);";
 			break;
 		case 'float':
 		case 'double':
 		case 'decimal':
 			$out = "      \$stmt->setFloat($colnr, \$this->$attName);";
 			break;
 		case 'enum':
 		case 'char':
 		case 'varchar':
 		case 'text':
 		case 'mediumtext':
 			$out = "      \$stmt->setString($colnr, \$this->$attName);";
 			break;
 		case 'date':
 			$out = "      \$stmt->setDate($colnr, \$this->$attName);";
 			break;
 		case 'datetime':
 		case 'timestamp':
 			$out = "      \$stmt->setTimestamp($colnr, \$this->$attName);";
 			break;
 		default:
 			echo $col->getNativeType().' not recognized while compiling <hr>';
 	}
 	return $out;
 }

 function compileColumnToUpdateStmts($col) {
 	$colName = $col->getName();
 	$attName = $this->makeAttName($colName);
 	$out = '';
 	switch ($col->getNativeType()) {
 		case 'int':
 		case 'tinyint':
 		case 'float':
 		case 'double':
 		case 'decimal':
 		case 'enum':
 		case 'char':
 		case 'varchar':
 		case 'text':
 		case 'mediumtext':
 		case 'date':
 		case 'datetime':
 		case 'timestamp':
 			$out = "\$updates[] = '`$colName` = ?'";
 			break;
 		default:
 			echo $col->getNativeType().' not recognized while compiling <hr>';
 	}
 	if (strlen($out) > 0) {
 		$out = "      if (isset(\$this->meta_Modified['$attName'])) { $out; }";
 	}
 	return $out;
 }

 function compileColumnToSetParamsForUpdateStmt($col) {
 	$colName = $col->getName();
 	$attName = $this->makeAttName($colName);
 	$out = '';
 	switch ($col->getNativeType()) {
 		case 'int':
 		case 'tinyint':
 			$out = "setInt(\$paramCount++, \$this->$attName)";
 			break;
 		case 'float':
 		case 'double':
 		case 'decimal':
 			$out = "setFloat(\$paramCount++, \$this->$attName)";
 			break;
 		case 'enum':
 		case 'char':
 		case 'varchar':
 		case 'text':
 		case 'mediumtext':
 			$out = "setString(\$paramCount++, \$this->$attName)";
 			break;
 		case 'date':
 			$out = "setDate(\$paramCount++, \$this->$attName)";
 			break;
 		case 'datetime':
 		case 'timestamp':
 			$out = "setTimestamp(\$paramCount++, \$this->$attName)";
 			break;
 		default:
 			echo $col->getNativeType().' not recognized while compiling <hr>';
 	}
 	if (strlen($out) > 0) {
 		$out = "      if (isset(\$this->meta_Modified['$attName'])) { \$stmt->$out; }";
 	}
 	return $out;
 }

 function writeToFile($value) {
 	echo $value;
 }

 function makeClassName($tblName) {
 	$clsName = $tblName;
 	$clsName = str_replace('^new_', '', $clsName); // prefix new_ entfernen
 	$clsName = str_replace('tbl', '', $clsName); // tbl_ entfernen
 	$clsName = implode('', array_map('ucfirst', explode('_', $clsName))); // underscores entfernen und Teilworte gross schreiben
 	$clsName = $clsName . 'DAO';
 	return $clsName;
 }

 function makeAttName($colName) {
 	$attName = $colName;
 	$firstChar = strtolower($attName[0]);
		$attName = implode('', array_map('ucfirst', explode('_', $attName))); // underscores entfernen und Teilworte gross schreiben
		$attName = substr_replace($attName, $firstChar, 0, 1);
		return $attName;
	}
}

?>