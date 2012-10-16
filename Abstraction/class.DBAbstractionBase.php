<?php
#ä
require_once 'DBClasses/class.DBDatabase.php';
require_once 'DBClasses/class.DBTable.php';
require_once 'DBClasses/class.DBColumn.php';
require_once 'DBClasses/class.DBIndex.php';
require_once 'DBClasses/class.DBForeignKey.php';
require_once 'DBClasses/class.DBTypes.php';

/**
 * .:: BASE-CONVERTER-CLASS ::.
 * build own database objects
 * @author MKaufmann
 */
abstract class DBAbstractionBase {

	public abstract static function getDatabase();
	protected abstract static function getTable();
	protected abstract static function getColumn();
	protected abstract static function getPrimaryKey();
	protected abstract static function getForeignKey();
	protected abstract static function getIndex();

}
?>