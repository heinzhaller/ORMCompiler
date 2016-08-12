<?php
#ä
Library::requireLibrary(LibraryKeys::ABSTRACTION_DATABASE_CONNECTION());
Library::requireLibrary(LibraryKeys::ABSTRACTION_DATABASE_LIMIT());

/**
 * DAO base class
 * @author MKaufmann
 */
abstract class BaseDAO {

	public static $count = 0;

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

		self::$count++;

		// prepare
		$stmt = $conn->prepareStatement($query);
		if( $limitation AND !is_null($limitation->getOffset()) )
			$stmt->setOffset($limitation->getOffset());
		if( $limitation AND !is_null($limitation->getLimit()) )
			$stmt->setLimit($limitation->getLimit());

		// execute query
		$result = $stmt->executeQuery($psWhereParams);
		$time = round( microtime(true) - $timer , 4);
		$color = '';
		if( isset($_SERVER['DOCUMENT_ROOT']) AND $time > 1.0 AND class_exists('CacheManager') )
		{
			$color = 'red';

			// SAVE TO APC
			$key = 'MYSQL_SLOW_QUERY';
			$mysql = CacheManager::get($key);
			if( !$mysql )
				$mysql = array();

			$hash = md5($sql);
			if( isset($mysql[$hash]) )
				$mysql[$hash]['cnt']++;
			else
				$mysql[$hash]['cnt'] = 1;
			$mysql[$hash]['sql'] = $sql;
			$mysql[$hash]['params'] = $sql;
			$mysql[$hash]['time'] = $time;
			CacheManager::set($key, $mysql, 0);
		}
		if( isset($_GET['debugmode']) )
			echo( '<br><span class="'.$color.'">'.$sql.' time: ' .$time.'s'.'</span><br>' );
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