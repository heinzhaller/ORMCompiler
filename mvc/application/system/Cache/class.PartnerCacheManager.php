<?php
#ä
require_once GLOBALCONFIG_GLOBALDIR.'/com.sfy.modules/Cache/class.CacheManager.php';

abstract class PartnerCacheManager {

	private static $apc_key = 'PARTNER_CACHE_ID_###ID###_###TYPE###';
	private static $partnerid = 1;
	private static $default_expiretime = 86400;
	
	public static final function setPartnerid($partnerid){
		self::$partnerid = (int) $partnerid;
	}
	
	private static final function getApcPartnerCacheKey($partnerid,$type){
		return str_replace(array('###ID###','###TYPE###'),array($partnerid,$type), self::$apc_key);
	}
	
	public static final function getPartnerCache($partnerid,$type = 'data'){
		return CacheManager::get(self::getApcPartnerCacheKey($partnerid,$type));
	}

	public static final function storePartnerCache($partnerid, $var, $ttl = 0){
		CacheManager::set(self::getApcPartnerCacheKey($partnerid), $var, $ttl);
	}
	
	public static final function savePartnerCacheFiles($partnerid, $files){
		CacheManager::set(self::getApcPartnerCacheKey($partnerid,'FILES'), $files, self::$default_expiretime);
	}
	
	public static final function getPartnerCacheFiles($partnerid){
		return CacheManager::get(self::getApcPartnerCacheKey($partnerid,'FILES'));
	}
	
	public static final function saveUpline($partnerid, array $upline){
		$var = CacheManager::get(self::getApcPartnerCacheKey($partnerid,'UPLINE'));
		$var['upline'] = $upline;
		self::storePartnerCache($partnerid,$var,self::$default_expiretime);
	}
	
	public static final function getUpline($partnerid){
		apc_clear_cache();
		$var = CacheManager::get(self::getApcPartnerCacheKey($partnerid,'UPLINE'));
		if($var == FALSE ) {
			require_once GLOBALCONFIG_GLOBALDIR.'/com.sfy.modules/Partner/class.PartnerManager.php';
			$var = PartnerManager::getUplineFromPartnerid($partnerid);
			CacheManager::set(self::getApcPartnerCacheKey($partnerid,'UPLINE'),$var,self::$default_expiretime);			
		}
		return ( isset($var) ? $var : null );
	}
	
}
?>