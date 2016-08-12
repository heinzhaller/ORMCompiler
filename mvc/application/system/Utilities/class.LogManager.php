<?php
#ä
class LogObject {
	
	private $tstamp_created;
	private $logdate;
	private $partnerid;
	private $customerid;
	private $shopid;
	private $ip;
	private $logcode;
	private $comment;

	public function setTstampCreated( $int ){
		$this->tstamp_created = (int) $int;
	}

	public function getTstampCreated(){
		return $this->tstamp_created;
	}

	public function setLogdate( $string ){
		$this->logdate = (string) $string;
	}

	public function getLogdate(){
		return $this->logdate;
	}
	
	public function setPartnerid( $integer ){
		$this->partnerid = ( !empty($integer) ? (integer) $integer : null );
	}

	public function getPartnerid(){
		return $this->partnerid;
	}

	public function setCustomerid( $integer ){
		$this->customerid = ( !empty($integer) ? (integer) $integer : null );
	}

	public function getCustomerid(){
		return $this->customerid;
	}

	public function setShopid( $integer ){
		$this->shopid = ( !empty($integer) ? (integer) $integer : null );
	}

	public function getShopid(){
		return $this->shopid;
	}

	public function setIp( $string ){
		$this->ip = (string) $string;
	}

	public function getIp(){
		return $this->ip;
	}

	public function setLogcode( $string ){
		$this->logcode = (string) $string;
	}
	
	public function getLogcode(){
		return $this->logcode;
	}

	public function setComment( $string ){
		$this->comment = (string) $string;
	}

	public function getComment(){
		return $this->comment;
	}
	
}

abstract class LogManager {
	
	/**
	 * get log object
	 *
	 * @return LogObject
	 */
	public static final function getLogObject(){
		$myObject = new LogObject();
		return $myObject;
	}
	
	/**
	 * save
	 *
	 * @param LogDAO $myObject
	 */
	private static final function save(LogDAO $myObject){
		if(strlen($myObject->getIp()) == 0)
			$myObject->setIp($_SERVER['REMOTE_ADDR']);
			
		if(strlen($myObject->getLogdate()) == 0)
			$myObject->setLogdate(time());
			$myObject->store();
	}
	
	/**
	 * copy DAO to LogObject
	 *
	 * @param LogDAO $myObject
	 * @return LogObject
	 */
	private function loadObjectFromLogDAO(LogDAO $myObject ){
		$myLogObject = new LogObject();
		$myLogObject->setTstampCreated( $myObject->getTstampCreated() );
		$myLogObject->setLogdate( $myObject->getLogdate() );
		$myLogObject->setPartnerid( $myObject->getPartnerid() );
		$myLogObject->setCustomerid( $myObject->getCustomerid() );
		$myLogObject->setIp( $myObject->getIp() );
		$myLogObject->setShopid( $myObject->getShopid() );
		$myLogObject->setLogcode( $myObject->getLogcode() );
		$myLogObject->setComment( $myObject->getCommentary() );
		
		return $myLogObject;
	}
	
	/**
	 * copy LogObject to DAO
	 *
	 * @param LogObject $myObject
	 * @return LogDAO
	 */
	private function loadLogDAOFromLogObject(LogObject $myObject ){
		require_once GLOBALCONFIG_GLOBALDIR.'/com.sfy.webglobal.database.ormbase/class.LogDAO.php';
		$myDAOObject = new LogDAO();
		$myDAOObject->setTstampCreated( $myObject->getTstampCreated() );
		$myDAOObject->setLogdate( $myObject->getLogdate() );
		$myDAOObject->setPartnerid( $myObject->getPartnerid() );
		$myDAOObject->setCustomerid( $myObject->getCustomerid() );
		$myDAOObject->setShopid( $myObject->getShopid() );
		$myDAOObject->setIp( $myObject->getIp() );
		$myDAOObject->setLogcode( $myObject->getLogcode() );
		$myDAOObject->setCommentary($myObject->getComment() );
		
		return $myDAOObject;
	}
	
	/**
	 * create log
	 *
	 * @param LogObject $myLogObject
	 */
	public static final function createLog(LogObject $myLogObject){
		$myLogDAO = self::loadLogDAOFromLogObject($myLogObject);
		self::save($myLogDAO);
	}
	
	public static final function getLogBySql($sql,array $params){
		require_once GLOBALCONFIG_GLOBALDIR.'/com.sfy.webglobal.database.ormbase/class.LogDAO.php';
		$myResults = LogDAO::queryWithPreparedStatementWhereCondition($sql,$params);
		
		return ((count($myResults) > 1)) ? $myResults : ( isset($myResults[0]) ? $myResults[0] : null);
	}
	
	public static final function getLogFromLastLoginByCustomerid($kid){
		require_once GLOBALCONFIG_GLOBALDIR.'/com.sfy.webglobal.database.ormbase/class.LogDAO.php';
		require_once GLOBALCONFIG_GLOBALDIR.'/com.sfy.webglobal.database/class.SQLLimit.php';
		$myParams[0] = $kid;
		$myResults = LogDAO::queryWithPreparedStatementWhereCondition('customerid = ? AND logcode = \'kd_login_success\' ORDER BY  tstamp_created DESC', $myParams, new SQLLimit(1));
		if(count($myResults) >= 1)
			return self::loadObjectFromLogDAO($myResults[0]);
		else
			return null;
	}
	
	public static final function getLogFromLastShopVisitByCustomerId($cid){
		require_once GLOBALCONFIG_GLOBALDIR.'/com.sfy.webglobal.database.ormbase/class.LogDAO.php';
		$myParams[0] = $cid;
		$myResults = LogDAO::queryWithPreparedStatementWhereCondition('customerid = ? AND logcode = \'shop_visited\' ORDER BY tstamp_created DESC', $myParams, new SQLLimit(1));
		if(count($myResults) >= 1)
			return self::loadObjectFromLogDAO($myResults[0]);
		else
			return null;
	}
}
?>