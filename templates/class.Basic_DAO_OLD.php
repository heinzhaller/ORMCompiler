<?php
Library::requireLibrary(LibraryKeys::ABSTRACTION_DATABASE_CONNECTION());
Library::requireLibrary(LibraryKeys::ABSTRACTION_DATABASE_LIMIT());

class BasicDAO {
	
  public static $diff;
	public $meta_New;
	public $meta_Modified;

  public function __construct(){
    $this->meta_New = true;
  	$this->meta_Modified = array();
  }
	
	/**
	 * execute generic query
	 * @param $sql
	 * @param $psWhereParams
     * @param $limitation limit for the given query
	 * @return ResultSet $result
	 */
	public static function genericQuery( $sql, $psWhereParams, $limitation = null) {
		$conn = DBConnection::getConnection();
		
		// start logging
		/*
		if( defined('GLOBALCONFIG_WEBLOG_ENABLED') AND GLOBALCONFIG_WEBLOG_ENABLED === 1 ){
			require_once GLOBALCONFIG_GLOBALDIR.'/com.sfy.modules/Log/WebLog/class.WebLogManager.php';
			WebLogManager::startQueryLog();
		}
		*/

		$query = $sql;
		if(isset($limitation) && $limitation instanceof SQLLimit){
			$query = $limitation->getQueryWithLimitation($query);
			if(!is_null($limitation->getOffset()) && is_numeric($limitation->getOffset())){
				$psWhereParams[] = $limitation->getOffset();
			}
			if(!is_null($limitation->getLimit()) && is_numeric($limitation->getLimit())){
				$psWhereParams[] = $limitation->getLimit();
			}
		}
		
		$stmt = $conn->prepareStatement($query);
		$rs = $stmt->executeQuery($psWhereParams);
				
		/*
		if( defined('GLOBALCONFIG_WEBLOG_ENABLED') AND GLOBALCONFIG_WEBLOG_ENABLED === 1 ){
			WebLogManager::stopQueryLog($query,$psWhereParams);
		}
		*/
		
		return $rs;
	}
	
}
?>
