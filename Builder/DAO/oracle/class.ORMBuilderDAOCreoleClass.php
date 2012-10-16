<?php
#ä
	class ORMBuilderDAOCreoleClass {

		var $conn;
		
		/////////////////////// CONFIGURATION ///////////////////////

		var $skipTables = array(
		);
			
		var $stringTypes = array (
			'VARCHAR', 'CHAR', 'VARCHAR2', 'TEXT', 'CLOB'
		);
		
		var $includeTables = array(
		);
		
		var $templateField;
		
		var $templateClass;
	
		/////////////////////// COMPILER CODE ///////////////////////

		function __construct($conn) {
			$this->conn = $conn; 
			$this->templateClass = <<< END
class ###clsname### extends BasicDAO {
    	
	private \$primarykeys = array( ###primarykeys### );
	private \$is_deleted = false;
	
	public function getSubclassname(){
		return __CLASS__;
	}
	
###attributes###
	/**
	 * Gets data from a database query and puts the values to the class attributes.
	 * @param \$stmt result of a query
	 */
	private function loadDataFromStatement(\$stmt) {
	  	\$this->meta_New = false;
	    \$this->meta_Modified = array();
###rsget###
	}
	
    /**
     * Creates SELECT query of the table that fits to this DAO, restricted by the given WHERE clause.
     * @param \$psWhereCondition free where condition
     * @param \$psWhereParams array of params that are needed for the where condition
     * @param \$limitation limit for the given query
     * @return Array Result of the query in form of a DAO
     */
	public static function queryWithPreparedStatementWhereCondition(\$psWhereCondition, array \$psWhereParams  = null, SQLLimit \$limitation = null) {
		return self::queryWithPreparedStatementWhereConditionReturnAsObjOfClass(\$psWhereCondition, \$psWhereParams, '###clsname###', \$limitation);
	}

    /**
     * Creates SELECT query of the table that is given by the parameter, restricted by the given WHERE clause.
     * The parameter of the table name is needed for inheritage, for example.
     * @param \$psWhereCondition free where condition
     * @param \$psWhereParams array of params that are needed for the where condition
     * @param \$subclass name of the class you want to instanciate for the return of the DAO
     * @param \$limitation limit for the given query
     * @return Array Result of the query in form of a DAO
     */
  	public static function queryWithPreparedStatementWhereConditionReturnAsObjOfClass(\$psWhereCondition, array \$psWhereParams = null, \$subclass, SQLLimit \$limitation = null) {
		\$rs = self::genericQuery('SELECT ###tblcolumns### FROM ###tblname### where ' . \$psWhereCondition, \$psWhereParams, \$limitation);
		\$ret = array();
		while (\$rs->next()) {
		   \$obj = new \$subclass();
		   \$obj->loadDataFromStatement(\$rs);
		   \$ret[] = \$obj;
		}
		return \$ret;
	}
	/**
	 * Generic query will be send to the database. The result have to be the complete table of this DAO and will be mapped to the DAO
	 * @param \$query a complex query that cannot be send via the other methods
	 * @param \$queryParams array of params that are needed for the where condition
     * @param \$limitation limit for the given query
	 * @return Array Result of the query in form of a DAO
	 */
	public static function genericDAOquery(\$query, array \$queryParams = null, SQLLimit \$limitation = null) {
		\$rs = self::genericQuery(\$query, \$queryParams, \$limitation);
		\$ret = array();
		while (\$rs->next()) {
		   \$obj = new ###clsname###();
		   \$obj->loadDataFromStatement(\$rs);
		   \$ret[] = \$obj;
		}
		return \$ret;
	}
	
    /**
     * Joins table that is associated with this class with a given set of tables. The where condidion have to be written. A set of
     * columns can be given. If no columns are given the statement returns all columns.
     * @param \$column comma separated String with names of the columns or null
     * @param \$tableArray array with the names of the tables
     * @param \$psWhereCondition String with the WHERE condition
     * @param \$psWhereParams array of variables for the where condition
     * @param \$limitation limit for the given query
     * @return ResultSet Result of the query 
     */
  	public static function queryWithPreparedStatementWithJoin(\$columns, array \$tableArray = null, \$psWhereCondition, array \$psWhereParams = null, SQLLimit \$limitation = null) {
		if (empty(\$tableArray)) {
			return;
		}
		\$tableString = '';
		foreach(\$tableArray as \$table) {
			\$tableString = ",".\$table;
		}
		if(is_null(\$columns) || trim(\$columns) == '') {
			\$columns = '###tblcolumns###';
		}
		
		\$query = 'SELECT ' .\$columns. ' FROM ###tblname### ' . \$tableString . ' where ' . \$psWhereCondition;
		\$rs = self::genericQuery(\$query, \$psWhereParams, \$limitation);
		return \$rs;
	}
	
    /**
     * Free statement to send to the database.
     * @param \$psStatement free SQL query
     * @param \$psWhereParams array of variables for the where condition
     * @param \$limitation limit for the given query
     * @return Array this DAO filled by the result of the query.
     */
	public static function queryWithSql(\$psStatement, array \$psWhereParams = null, SQLLimit \$limitation = null) {
		return self::queryWithSqlReturnAsObjOfClass(\$psStatement, \$psWhereParams, '###clsname###', \$limitation);
	}

    /**
     * Free statement to send to the database.
     * @param \$psStatement free SQL query
     * @param \$psWhereParams array of variables for the where condition
     * @param \$subclass name of the class you want to instanciate for the return of the DAO
     * @param \$limitation limit for the given query
     * @return Array the given DAO filled by the result of the query.
     */
	public static function queryWithSqlReturnAsObjOfClass(\$psStatement, array \$psWhereParams = null, \$subclass, SQLLimit \$limitation = null) {
		\$rs = self::genericQuery(\$psStatement, \$psWhereParams, \$limitation);	
		\$ret = array();
		while (\$rs->next()) {
			\$obj = new \$subclass();
		    \$obj->loadDataFromStatement(\$rs);
		    \$ret[] = \$obj;
		}
		return \$ret;
	}
	
    /**
     * Function to create or update this DAO object in the database. Transient objects and objects to update 
     * will be differed in this method.
     */
	public function store() {
		\$conn = DBConnection::getConnection();
		if ( \$this->isNew() == true AND \$this->isDeleted() == false ) {
			\$this->storeNew(\$conn);
		} else if( \$this->isModified() == true AND \$this->isDeleted() == false) {
			\$this->updateExisting(\$conn);
		} else if( \$this->isDeleted() == true ){
			if( \$this->isNew() != true )
				\$this->delete();
		}
	}
	
    /**
     * Internal function to store transient objects in the database.
     * @param \$conn Database connection
     */
	private function storeNew(\$conn) {

		\$insert = array();
		\$para = array();
###setinsertcolumns###
		\$stmt = \$conn->prepareStatement("INSERT INTO ###tblname### (" . implode(', ', \$insert) . ") VALUES (" . implode(', ', \$para) . ")");
      	
      	\$paramCount = 1;
###setinsertparams###

      	###idgenerator###
      	###updateautoinsertattribute###

      	 \$this->meta_New = false;
      	\$this->meta_Modified = array();
    }

    /**
     * Internal function to update modified persistent objects in the database.
     * @param \$conn Database connection
     */
    private function updateExisting(\$conn) {
        \$updates = array();
###setupdatestmts###
        \$stmt = \$conn->prepareStatement("UPDATE ###tblname### SET " . implode(', ', \$updates) . " WHERE ###updatewhereparams###");
        \$paramCount = 1;
###setupdateparams######setupdatewhereparams###        \$stmt->executeUpdate();
        \$this->meta_New = false;
        \$this->meta_Modified = array();
    }

  protected function delete(){
  	\$where = '';
  	foreach(\$this->getPrimaryKeys() as \$pk){
  		\$where .= \$pk.' = ?';
  	}
		return BasicDAO::genericQuery('DELETE FROM ###tblname### WHERE '.\$where, array(\$this->getPrimaryKeys()));
  }
    
	public function getPrimaryKeys(){
		return \$this->primarykeys;
	}

	public function isModified() {
		return (sizeof(\$this->meta_Modified) > 0);
	}

	public function isNew() {
		return \$this->meta_New;
	}
	
	public function isDeleted() {
		return \$this->is_deleted;
	}
	
	public function setDeleted(\$bool) {
		return \$this->is_deleted = \$bool;
	}
    
 	public function isColumnModified( \$column ){
		return \$this->meta_Modified[\$column];
 	}
 		

    // function setNew(b : boolean) {}
    // function resetModified() {}
    // function save() {}
}
END;

			$this->templateField = <<< END
	private \$###attname###;

    /**
     * Get property of attribute ###attname###
     * @return attribute
     */
	public function get###uattname###() {
  	    return \$this->###attname###;
    }

    /**
     * Set property of attribute ###attname###. Sets modification flag. New attribute must be different than the stored one.
     */
    public function set###uattname###(\$new###uattname###) { ###returnonpkeycolumnsifnotnew###
        if ((\$this->get###uattname###() !== \$new###uattname###) || (is_null(\$new###uattname###) && \$this->isNew())) {
        	###checkfieldlength###
            \$this->###attname### = \$new###uattname###;
            \$this->meta_Modified['###attname###'] = true;
        }
    }
END;

			$this->templateStrField = <<< END
    /**
     * Column attribute
     */
    private \$###attname###;

    /**
     * Get property of attribute ###attname###
     * @return attribute
     */
    public function get###uattname###() {
        return \$this->###attname###;
    }
    /**
     * Set property of attribute ###attname###. Sets modification flag. New attribute must be different than the stored one.
     */
    public function set###uattname###(\$new###uattname###) {  ###returnonpkeycolumnsifnotnew###
        if ((strcmp(\$this->get###uattname###(), \$new###uattname###) != 0) || (is_null(\$new###uattname###) && \$this->isNew())) {
        	###checkfieldlength###
            \$this->###attname### = (string) \$new###uattname###;
            \$this->meta_Modified['###attname###'] = true;
        }
    }
END;
			
			$this->templateSequenceInsert = <<< END
		\$idgen = \$conn->getIdGenerator();
		\$id = 0;
    	if(\$idgen->isBeforeInsert()) {
      		\$id = \$idgen->getId('###sequencename###');
      	}
     	if(\$idgen->isAfterInsert()) {
        	\$id = \$idgen->getId();
      	}
END;
		}
		
		function run(TableInfo $table) {
			if ($table) $this->includeTables[] = $table;
			$dbinfo = $this->conn->getDatabaseInfo();
			$output = '<?php' . "\n\n";
			$output .= 'Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_BASIC());'."\n\n";
			$seq = $dbinfo->getSequences();
			$output .=  $this->compileTable($table, $seq);
			$output .=  '?>';
			
			return $output;
		}
		
		function compileTable(TableInfo $tbl, $seq) {
//			if (($this->includeTables && !in_array($tbl->getName(), $this->includeTables)) ||
//			    ($this->skipTables && in_array($tbl->getName(), $this->skipTables))) return;
			$tblName = $tbl->getName();
			$clsName = $this->makeClassName($tblName);
			
			//check if sequence is available
			$sequenceName = $this->makeSequenceName($tblName);
			$hasSeq = true;

			if(!in_array(strtoupper($sequenceName), $seq)){
				$sequenceName = '';
				$sequenceInsert = '';
				$hasSeq = false;
			}else{
				$hasSeq = true;
				$sequenceInsert = str_replace('###sequencename###', $sequenceName, $this->templateSequenceInsert);
			}
			$colOut = '';
			$rsGetOut = '';
			$setInsertParamsOut = '';
			$setUpdateStmtsOut = '';
			$setUpdateParamsOut = '';
			$checkInputLength = '';
			$updateWhereParams = array();
			$setUpdateWhereParamsOut = '';
			$insertcols = array();
			$setInsertColumnsOut = '';
			$tblColumnsList = array();
			$primarykeys = array();
			$colnr = 0;
			$pkeys = $tbl->getPrimaryKey();
            $pkeyNames = array();
            foreach($pkeys->getColumns() as $pkcol) {
            	$primarykeys[] = '\''.$pkcol->getName().'\'';
							if($pkcol->isAutoIncrement())
            		$pkeyNames[strtoupper($pkcol->getName())] = true;
            }
			
			foreach($tbl->getColumns() as $col) {
				$colnr ++;
				$colOut = $colOut . $this->compileColumnToAttributes($col,( isset($pkeyNames[$col->getName()]) ? $pkeyNames[$col->getName()] : null ), $hasSeq, $tbl->getName()) . "\n\n";
				$rsGetOut = $rsGetOut . $this->compileColumnToSetAttribute($col) . "\n";
				$insertcols[] = $col->getName();
				$setInsertParamsOut .= $this->compileColumnToSetParamsForUpdateStmt($col) . "\n";
				$setInsertColumnsOut .= $this->compileColumnToInsertStmts($col) . "\n";
				if (!isset($pkeyNames[$col->getName()])) {
					$setUpdateStmtsOut .= $this->compileColumnToUpdateStmts($col) . "\n";
					$setUpdateParamsOut .= $this->compileColumnToSetParamsForUpdateStmt($col) . "\n";
				} else {
					$updateWhereParams[] = $col->getName() . ' = ?';
					$setUpdateWhereParamsOut = $this->compileColumnToSetParams('$paramCount++', $col) . "\n";
				}
				if($col->getNativeType() === 'TIMESTAMP(6)' OR $col->getNativeType() === 'TIMESTAMP' ) {
					$tblColumnsList[] ='unix_timestamp('.strtoupper($col->getName()).') as '.strtoupper($col->getName());
				} else {
					$tblColumnsList[] =strtoupper($col->getName());
				}
				
			}
			$out = $this->templateClass;
			$out = str_replace('###tblname###', $tblName, $out);
			$out = str_replace('###clsname###', $clsName, $out);
			$out = str_replace('###attributes###', $colOut, $out);
			$out = str_replace('###rsget###', substr($rsGetOut, 0, -1), $out);
			$out = str_replace('###insertcols###', implode(', ' , $insertcols), $out);
			$out = str_replace('###setinsertcolumns###', $setInsertColumnsOut, $out);
			$out = str_replace('###setinsertparams###', $setInsertParamsOut, $out);
			$out = str_replace('###setupdatestmts###', $setUpdateStmtsOut, $out);
			$out = str_replace('###setupdateparams###', $setUpdateParamsOut, $out);
			$out = str_replace('###updatewhereparams###', implode(' AND ', $updateWhereParams), $out);
			$out = str_replace('###setupdatewhereparams###', $setUpdateWhereParamsOut, $out);
			$out = str_replace('###SequenceInsert###', $sequenceInsert, $out);
			$out = str_replace('###tblcolumns###', implode(', ' , $tblColumnsList), $out);
			$out = str_replace('###primarykeys###', implode(', ' , $primarykeys), $out);
			
			/* old
			$pkeyNames = array_keys($pkeyNames);
			if (sizeof($pkeyNames) == 1) {
				$attName = $this->makeAttName($pkeyNames[0]);
				$repl = "        \$this->" . $attName . " = \$id;\n";
				$repl .= "        \$this->meta_Modified['" . $attName . "'] = true;";
				
				$out = str_replace('###updateautoinsertattribute###', $repl, $out);
			}else{
				$out = str_replace('###updateautoinsertattribute###', '', $out);
			}
			*/
			
		 	// primary keys wenn autoincrement
		 	$pklines = "\r\n";
		 	if(!empty($pkeyNames))
		 	foreach ($pkeyNames as $key => $pk){
		 		if($pk == true ){
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
				if($idgen->isAfterInsert())
					$id = $idgen->getId();
		 		';
		 	$out = str_replace('###idgenerator###',$generator, $out);
			
			return $out;
		}
		
		private function addCheckToSetter($col, $tblName) {
			$checkCode = '';
			switch ($col->getNativeType()) {
				case 'VARCHAR2':
				case 'VARCHAR':
				case 'CHAR': $checkCode=$this->checkStringLength($col, $tblName); break;
			}
			return $checkCode;
		}
		
		private function checkStringLength($col, $tblName) {
			$length=$col->getSize()/4;
			if ($length == 1000) {
				$statement = $this->conn->prepareStatement("select CHAR_LENGTH from all_tab_columns where table_name = ? AND COLUMN_NAME = ?");
				$psWhereParams = array(strtoupper($tblName), strtoupper($col->getName()) );
				$rs = $statement->executeQuery($psWhereParams);
				$rs->next();
				$length = $rs->getInt('CHAR_LENGTH');
			}
			$attrName = $this->makeAttName($col->getName());
			$parameter = '$new'.ucfirst($attrName);
			return "if(strlen(".$parameter.") > ".$length.") {
				".$parameter." = mb_strcut(".$parameter.", 0, ".$length.", 'UTF-8');
			}";
			//throw new SQLException('".$attrName." too long. Given value is '.strlen(\$new".ucfirst($attrName).").', maximum is ".$length."');
		}
		
		function compileColumnToAttributes($col, $isPkeyColumn, $hasSeq, $tblName) {
			$colName = $col->getName();
			$attName = $this->makeAttName($colName);
			if (in_array($col->getNativeType(), $this->stringTypes)) {
				$out = $this->templateStrField;
				$out = str_replace('###returnonpkeycolumnsifnotnew###', '', $out);
			} else {
				$out = $this->templateField;
				$out = str_replace('###returnonpkeycolumnsifnotnew###', $isPkeyColumn && $hasSeq? "\n      if ( \$this->isNew() ) return;" : '', $out);
			}
			$checkInputLength=$this->addCheckToSetter($col, $tblName);
			$out = str_replace('###attname###', $attName, $out);
			$out = str_replace('###uattname###', ucfirst($attName), $out);
			$out = str_replace('###checkfieldlength###', $checkInputLength, $out);
			return $out;
		}

		function compileColumnToSetAttribute($col) {
			
			$colName = strtoupper($col->getName());
			$attName = $this->makeAttName($colName);
			$setAttName = $this->makeAttSetFunction($colName);
			$out = 'try { ';
			switch (strtoupper($col->getNativeType())) {
				case 'INT':
				case 'DECIMAL':
				case 'NUMBER':
				case 'FLOAT':
				case 'DOUBLE':
				case 'TINYINT':
					$out .= $this->checkNumbers(null, $col, 'SetAtt');
					break;
				case 'VARCHAR2':
				case 'VARCHAR':
				case 'CLOB':
				case 'CHAR':
				case 'TEXT':
					$out .= chr(9).chr(9)."\$this->$setAttName( \$stmt->getString('$colName')); ";
					break;
				case 'DATE':
					$out .= chr(9).chr(9)."\$this->$setAttName( \$stmt->getDate('$colName', NULL)); ";
					break;
				case 'TIMESTAMP(6)':
				case 'TIMESTAMP':
					$out .= chr(9).chr(9)."\$this->$setAttName( \$stmt->getInt('".$colName."')); ";
					break;
				default:
					echo $col->getNativeType().' not recognized while compiling <hr>';
			}
			
			$out .= '} catch (SQLException $s) { }';
			return $out;
		}
		
		function compileColumnToSetParams($colnr, $col) {
			$colName = $col->getName();
			$attName = $this->makeAttName($colName);
			$attGetName = $this->makeAttGetFunction($colName);
			$out = '';
			switch (strtoupper($col->getNativeType())) {
				case 'INT':
				case 'DECIMAL':
				case 'NUMBER':
				case 'FLOAT':
				case 'DOUBLE':
				case 'TINYINT':
					$out = $this->checkNumbers($colnr, $col, 'SET');
					break;
				case 'VARCHAR2':
				case 'VARCHAR':
				case 'CLOB':
				case 'CHAR':
				case 'TEXT':
					$out = chr(9).chr(9)."\$stmt->setString($colnr, \$this->$attGetName);";
					break;
				case 'DATE':
					$out = chr(9).chr(9)."\$stmt->setDate($colnr, \$this->$attGetName);";
					break;
				case 'TIMESTAMP(6)':
				case 'TIMESTAMP':
					$out = chr(9).chr(9)."\$stmt->setInt($colnr, \$this->$attGetName);";
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
			switch (strtoupper($col->getNativeType())) {
				case 'INT':
				case 'DECIMAL':
				case 'NUMBER':
				case 'FLOAT':
				case 'DOUBLE':
				case 'VARCHAR2':
				case 'VARCHAR':
				case 'CLOB':
				case 'DATE':
				case 'CHAR':
				case 'TEXT':
				case 'TINYINT':
					$out = "\$updates[] = '$colName = ?'";
					break;
				case 'TIMESTAMP(6)':
				case 'TIMESTAMP':
					$out = "\$updates[] = '$colName = from_unixtime(?)'";
					break;
				default:
					echo $col->getNativeType().' not recognized while compiling <hr>';
			}
			if (strlen($out) > 0) {
				$out = "        if (isset(\$this->meta_Modified['$attName'])) { $out; }";
			}
			return $out;
		}
		
		function compileColumnToInsertStmts($col) {
			$colName = $col->getName();
			$attName = $this->makeAttName($colName);
			$out = '';
			switch (strtoupper($col->getNativeType())) {
				case 'INT':
				case 'DECIMAL':
				case 'NUMBER':
				case 'FLOAT':
				case 'DOUBLE':
				case 'VARCHAR2':
				case 'VARCHAR':
				case 'CLOB':
				case 'DATE':
				case 'CHAR':
				case 'TEXT':
				case 'TIMESTAMP(6)':
				case 'TIMESTAMP':
				case 'TINYINT':
					$out = "\$insert[] = '$colName'";
					break;
				default:
					echo $col->getNativeType().' not recognized while compiling <hr>';
			}
			if (strlen($out) > 0) {
				switch ($col->getNativeType()) {
					case 'TIMESTAMP(6)':
					case 'TIMESTAMP':
						$ret = "        if (isset(\$this->meta_Modified['$attName'])) {\n\t\t\t\$para[] = 'from_unixtime(?)';\n\t\t\t$out;\n\t\t}";
						break;
					default:
						$ret = "        if (isset(\$this->meta_Modified['$attName'])) {\n\t\t\t\$para[] = '?';\n\t\t\t$out;\n\t\t}";
				}
			}
			return $ret;
		}
		
		function compileColumnToSetParamsForUpdateStmt($col) {
			$colName = $col->getName();
			$attName = $this->makeAttName($colName);
			$attGetName = $this->makeAttGetFunction($colName);
			$out = '';
			switch (strtoupper($col->getNativeType())) {
				case 'INT':
				case 'DECIMAL':
				case 'NUMBER':
				case 'FLOAT':
				case 'DOUBLE':
				case 'TINYINT':
					$out = $this->checkNumbers(null, $col, 'UPDATE');
					break;
				case 'VARCHAR2':
				case 'VARCHAR':
				case 'CLOB':
				case 'CHAR':
				case 'TEXT':
					$out = "setString(\$paramCount++, \$this->$attGetName)";
					break;
				case 'DATE':
					$out = "setDate(\$paramCount++, \$this->$attGetName)";
					break;
				case 'TIMESTAMP(6)':
				case 'TIMESTAMP':
					$out = "setInt(\$paramCount++, \$this->$attGetName)";
					break;
				default:
					echo $col->getNativeType().' not recognized while compiling <hr>';
			}
			
			if (strlen($out) > 0) {
				$out = "        if (isset(\$this->meta_Modified['$attName'])) { \$stmt->$out; }";
			}
			return $out;
		}
		
		function writeToFile($value) {
			echo $value;
		}
		
		function makeClassName($tblName) {		
			$clsName = strtoupper($tblName);
			$clsName = str_replace('NEW_', '', $clsName); // prefix NEW_ entfernen
			$clsName = str_replace('TBL_', '', $clsName); // prefix TBL_ entfernen
			$clsName = strtolower($clsName);
			$clsName = implode('', array_map('ucfirst', explode('_', $clsName))); // underscores entfernen und Teilworte gross schreiben
			$clsName = $clsName . 'DAO';
			return $clsName;
		}
		
		function makeSequenceName($tblName) {		
			$seqName = $tblName;
			$seqName = str_replace('NEW_', '', $seqName); // prefix NEW_ entfernen
			$seqName = str_replace('TBL_', '', $seqName); // prefix TBL_ entfernen
			$seqName = strtoupper($seqName);
			$seqName = $seqName . '_SEQ';
			return $seqName;
		}
		
		function makeAttName($colName) {
			$attName = strtolower($colName);
			$attName = implode('', array_map('ucfirst', explode('_', $attName))); // underscores entfernen und Teilworte gross schreiben
			$attName = strtolower($attName[0]).substr( $attName, 1, strlen($attName));
			return $attName;
		}
		
		function makeAttGetFunction( $attname ){
			$attname = $this->makeAttName($attname);
			$attname = 'get'.strtoupper($attname[0]).substr( $attname, 1, strlen($attname)).'()';
			return $attname;
		}
		
		function makeAttSetFunction( $attname ){
			$attname = $this->makeAttName($attname);
			$attname = 'set'.strtoupper($attname[0]).substr( $attname, 1, strlen($attname));
			return $attname;
		}
		
		private function checkNumbers($colnr, $column, $mode) {
			$name = $this->makeAttName($column->getName());
			$tableName = $column->getTable()->getName();
			$ret = "";
			$setter = $this->makeAttSetFunction($name);
			$getter = $this->makeAttGetFunction($name);
			$colName = strtoupper($column->getName());
			if($column->getScale() != 0) {
				switch($mode) {
					case 'SET':
						$ret = chr(9).chr(9)."\$stmt->setFloat($colnr, \$this->$getter);";
						break;
					case 'SetAtt':
						$ret = chr(9).chr(9)."\$this->$setter( \$stmt->getFloat('$colName')); ";
						break;
					case 'UPDATE':
						$ret = "setFloat(\$paramCount++, \$this->$getter)";
						break;
				}
			} else {
				if($column->getPrecision() != 1 OR $column->getScale() == 0 ) {
					switch($mode) {
					case 'SET':
						$ret = chr(9).chr(9)."\$stmt->setInt($colnr, \$this->$getter);";
						break;
					case 'SetAtt':
						$ret = chr(9).chr(9)."\$this->$setter( \$stmt->getInt('$colName')); ";
						break;
					case 'UPDATE':
						$ret = "setInt(\$paramCount++, \$this->$getter)";
						break;
					}
				} else {
					$searchColumnName = implode(explode('_', $column->getName()));
					$statement = $this->conn->prepareStatement("SELECT SEARCH_CONDITION from User_constraints WHERE User_constraints.CONSTRAINT_NAME like ? AND User_constraints.TABLE_NAME = ? AND User_constraints.OWNER = ?");
					$psWhereParams = array("CHK_%_".$searchColumnName, $tableName, "SFY_NEW");
					$rs = $statement->executeQuery($psWhereParams);
					if(!$rs->next()) {
						switch($mode) {
							case 'SET':
								$ret = chr(9).chr(9)."\$stmt->setInt($colnr, \$this->$getter);";
								break;
							case 'SetAtt':
								$ret = chr(9).chr(9)."\$this->$setter( \$stmt->getInt('$colName')); ";
								break;
							case 'UPDATE':
								$ret = "setInt(\$paramCount++, \$this->$getter)";
								break;
						}
					} else { 
						do{
							echo $rs->getString('SEARCH_CONDITION');
							if(substr_count(strtoupper($rs->getString('SEARCH_CONDITION')), ' IN (0,1)') == 0) {
								switch($mode) {
								case 'SET':
									$ret = chr(9).chr(9)."\$stmt->setInt($colnr, \$this->$getter);";
									break;
								case 'SetAtt':
									$ret = chr(9).chr(9)."\$this->$setter( \$stmt->getInt('$colName')); ";
									break;
								case 'UPDATE':
									$ret = "setInt(\$paramCount++, \$this->$getter)";
									break;
								}	
							} else {
								switch($mode) {
								case 'SET':
									$ret = chr(9).chr(9)."\$stmt->setBoolean($colnr, \$this->$getter);";
									break;
								case 'SetAtt':
									$ret = chr(9).chr(9)."\$this->$setter( \$stmt->getBoolean('$colName')); ";
									break;
								case 'UPDATE':
									$ret = "setBoolean(\$paramCount++, \$this->$getter)";
									break;
								}
							}
	 					}while ($rs->next());
					}
				}	
			}
			return $ret;
		}
	}

?>