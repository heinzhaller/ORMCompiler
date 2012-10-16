<?php
#ä
/**
 * .:: CONVERTER - CREOLE ::.
 * build database objects whit creole 
 * @author MKaufmann
 */
//@TODO: base klasse verwenden
#abstract class DBAbstractionCreole extends DBAbstractionBase {
abstract class DBAbstractionCreole {
	
	private $foreignkeys = array();
	private $primarykeys = array();
	
	/**
	 * @param DatabaseInfo $database
	 * @return DBDatabase
	 */
	public static final function getDatabase(DatabaseInfo &$database){
		$myDatabase = new DBDatabase();
		$myDatabase->setName($database->getName());
		if($database instanceof OCI8DatabaseInfo)
			$myDatabase->setName($database->getSchema());
		foreach($database->getTables() as $table){
			if( substr(strtolower($table->getName()), 0, 3) == 'tbl' )
				$myDatabase->addTable(self::getTable($table));
		}
		return $myDatabase;
	}
	
	/**
	 * @param $table
	 * @return DBTable
	 */
	public static final function getTable(TableInfo &$table){
		$myTable = new DBTable();
		$myTable->setName($table->getName());
		#$myTable->setComment($table->get);
		// columns
		foreach($table->getColumns() as $column){
			if($column instanceof ColumnInfo)
				$myTable->addColumn(self::getColumn($column));
		}
		// indices
		foreach($table->getIndices() as $index){
			if($index instanceof IndexInfo)
				$myTable->addIndex(self::getIndex($index));
		}
		// foreign keys
		foreach($table->getForeignKeys() as $foreignkey){
			if($foreignkey instanceof ForeignKeyInfo)
				$myTable->addForeignKey(self::getForeignKey($foreignkey));
		}
		// primary key
		if($table->getPrimaryKey() != null)
			$myTable->setPrimaryKey(self::getPrimaryKey($table->getPrimaryKey()));
		
		return $myTable;
	}
	
	/**
	 * @param ColumnInfo $column
	 * @return DBColumn
	 */
	public static final function getColumn(ColumnInfo &$column){
		$myColumn = new DBColumn();
		$myColumn->setName($column->getName());
		
		$oracle_type = DBCreoleTypes::getType($column->getNativeType());
		if($oracle_type == -1)
			$oracle_type = DBTypes::getCreoleCode($column->getNativeType());
		if(preg_match('/^TIMESTAMP/ui', $column->getNativeType()))
			$oracle_type = DBTypes::TIMESTAMP;
		if($oracle_type == DBTypes::NUMERIC )
		if(preg_match('/^DECIMAL\(([0-9]+)\,([0-9]+)$/ui', $column->getNativeType()) OR ( (int) $column->getPrecision() > 0 AND (int) $column->getScale() > 0))
			$oracle_type = DBTypes::DECIMAL;
		if(preg_match('/^DECIMAL\(1\,0$/ui', $column->getNativeType()) OR ( (int)$column->getPrecision() == 1 AND (int) $column->getScale() == 0) )
			$oracle_type = DBTypes::BOOLEAN;
		if(preg_match('/^DECIMAL\(([0-9]+)\,0$/ui', $column->getNativeType()) OR ( (int) $column->getPrecision() == 11 AND (int) $column->getScale() == 0) )
			$oracle_type = DBTypes::INTEGER;	
		if(preg_match('/^NUMBER\(([0-9]+)\,([0-9]+)$/ui', $column->getNativeType()) OR ( (int) $column->getPrecision() > 0 AND (int) $column->getScale() > 0))
			$oracle_type = DBTypes::DECIMAL;
		if(preg_match('/^NUMBER\(1\,0$/ui', $column->getNativeType()) OR ( (int)$column->getPrecision() == 1 AND (int) $column->getScale() == 0) )
			$oracle_type = DBTypes::BOOLEAN;
		if(preg_match('/^NUMBER\(([0-9]+)\,0$/ui', $column->getNativeType()) OR ( (int) $column->getPrecision() == 11 AND (int) $column->getScale() == 0) )
			$oracle_type = DBTypes::INTEGER;			

		$creole_string = DBTypes::getCreoleName($oracle_type);
		$creole_int = DBTypes::getCreoleCode(strtoupper($creole_string));
		$myColumn->setType($creole_int);
		$myColumn->setTypname($creole_string);
		$myColumn->setSize((float)$column->getSize());
		#$myColumn->setSizetype();
		$myColumn->setDefaultvalue($column->getDefaultValue());
		$myColumn->setIsNullable($column->isNullable() == 'N' ? true : false);
		$myColumn->setIsAutoincrement($column->isAutoIncrement());
		return $myColumn;
	}
	
	/**
	 * @param IndexInfo $index
	 * @return DBIndex
	 */
	public static final function getIndex(IndexInfo &$index){
		$myIndex = new DBIndex();
		$myIndex->setName($index->getName());
		$myIndex->setIsUnique($index->isUnique());
		//$myIndex->setType();
		foreach ($index->getColumns() as $column){
			if($column instanceof ColumnInfo)
				$myIndex->addColumn(self::getColumn($column));	
		}
		return $myIndex;	
	}
	
	/**
	 * @param ForeignKeyInfo $foreignkey
	 * @return DBForeignKey
	 */
	public static final function getForeignKey(ForeignKeyInfo &$foreignkey){
		$myForeignKey = new DBForeignKey();
		$myForeignKey->setName($foreignkey->getName());
		$references = $foreignkey->getReferences();
		$ref_column = $references[0][1];
		$ref_table = $ref_column->getTable();
		/*
		$myForeignKey->setForeignType(DBReferenceTypes::REFERENCE_SINGLE_TO_MANY);
		foreach ($ref_table->getPrimaryKey()->getColumns() as $pk_column){
			if( $ref_column->getName() == $pk_column->getName() )
				$myForeignKey->setForeignType(DBReferenceTypes::REFERENCE_SINGLE_TO_SINGLE);
		}
		
		foreach ($ref_table->getIndices() as $fk_column){
			if( $ref_column->getName() == $pk_column->getName() )
				$myForeignKey->setForeignType(DBReferenceTypes::REFERENCE_SINGLE_TO_SINGLE);
		}
		*/
		$myForeignKey->setForeignTable($ref_table->getName());
		$myForeignKey->setForeignColumn($ref_column->getName());
		
		
		return $myForeignKey;	
	}
	
	/**
	 * @param PrimaryKeyInfo $primarykey
	 * @return DBPrimaryKey
	 */
	public static final function getPrimaryKey(PrimaryKeyInfo &$primarykey){
		$myPrimaryKey = new DBPrimaryKey();
		$myPrimaryKey->setName($primarykey->getName());
		foreach ($primarykey->getColumns() as $column){
			if($column instanceof ColumnInfo)
				$myPrimaryKey->addColumn(self::getColumn($column));
		}
		return $myPrimaryKey;
	}
	
	protected static final function setReferencetypes(DBDatabase &$myDatabase){
		foreach($myDatabase as $myTable){
			foreach ($myTable->getForeignKeys() as $myFK){
				foreach($myDatabase as $myTable2){
					if($myTable2->getName() == $myFK->getForeignTable() ){
						$myFK->setForeignType(DBReferenceTypes::REFERENCE_MANY_TO_MANY); // default "many to many"
						// check primary keys
						foreach ($myTable2->getPrimaryKey()->getColumns() as $pk_column){
							if( $pk_column->getName() == $myFK->setForeignColumn() )
								$myFK->setForeignType(DBReferenceTypes::REFERENCE_SINGLE_TO_SINGLE);
						}
						// check indices
						foreach ($myTable2->getIndices() as $index){
							if( in_array($myFK->setForeignColumn(), $index->getColumns()) AND count($index->getColumns()) == 1 AND $index->getIsUnique() )
								$myFK->setForeignType(DBReferenceTypes::REFERENCE_SINGLE_TO_SINGLE);
							ELSE
							foreach ($index->getColumns() as $idx_columns){
								if( $idx_column->getName() == $myFK->setForeignColumn() AND $index->getIsUnique() == FALSE )
									$myFK->setForeignType(DBReferenceTypes::REFERENCE_SINGLE_TO_MANY);
							}
						}
					}
					
				}
			}
		}
	}
	
}
?>