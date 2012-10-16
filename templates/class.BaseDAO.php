<?php
#ä
Library::requireLibrary(LibraryKeys::ABSTRACTION_DATABASE_CONNECTION());
Library::requireLibrary(LibraryKeys::ABSTRACTION_DATABASE_LIMIT());

/**
 * DAO base class
 * @author MKaufmann
 */
abstract class BaseDAO {

	/**
	 * execute generic query
	 * @param $sql
	 * @param $psWhereParams
   * @param $limitation limit for the given query
	 * @return ResultSet $result
	 */
	public static final function genericQuery( $sql, $psWhereParams, SQLLimit $limitation = null) {
		$timer = microtime(true);
		$conn = DBConnection::getConnection();

		$query = $sql;

		// prepare
		$stmt = $conn->prepareStatement($query);
		if( $limitation AND !is_null($limitation->getOffset()) )
			$stmt->setOffset($limitation->getOffset());
		if( $limitation AND !is_null($limitation->getLimit()) )
			$stmt->setLimit($limitation->getLimit());

		// execute query
		$result = $stmt->executeQuery($psWhereParams);
		if( isset($_GET['debugmode']) )
			echo( '<br>'.$sql.' time: ' . round( microtime(true) - $timer , 4).'s'.'<br>' );
		return $result;
	}



	#protected abstract static function insert(BaseObject &$myObject);
	#protected abstract static function update(BaseObject &$myObject);

  protected static function delete(BaseObject &$myObject){
  	$DAO_name = get_class($myObject).'DAO';
  	$primarykeys = call_user_func(array($DAO_name,'getPrimaryKeys'));
  	eval("\$tablename = $DAO_name::TABLENAME;");
  	$where = '1 = 1';
  	$params = array();
  	foreach($primarykeys as $pk => $function ){
  		$where .= ' AND '. $pk.' = ?';
  		$params[] = $myObject->$function();
  	}
		return self::genericQuery('DELETE FROM '.$tablename.' WHERE '.$where, $params);
  }

}
?>