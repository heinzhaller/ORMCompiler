<?php

class CountryManager{
	public static function getBankAvailableCountry(){
		require_once (GLOBALCONFIG_GLOBALDIR.'/com.sfy.webglobal.database.ormbase/class.LaenderDAO.php');
		return LaenderDAO::queryWithPreparedStatementWhereCondition('bank_available = 1 ORDER BY iso2', array());
	}
	
	public static function getBankAvailableCountryByIso2($iso2){
		require_once (GLOBALCONFIG_GLOBALDIR.'/com.sfy.webglobal.database.ormbase/class.LaenderDAO.php');
		return LaenderDAO::queryWithPreparedStatementWhereCondition('bank_available = 1 and iso2 = ?', array($iso2));
	}
	
	public static function getCountryByIso2($iso2){
		require_once (GLOBALCONFIG_GLOBALDIR.'/com.sfy.webglobal.database.ormbase/class.LaenderDAO.php');
		return $rs = LaenderDAO::queryWithPreparedStatementWhereCondition('iso2 = ?', array($iso2));
	}	
}

?>