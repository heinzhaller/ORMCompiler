<?php
/**
 * Cache Manager to use cache small amount of frequently used data.
 * @version 1.0
 */
abstract class CacheManager {
	const CATEGORY_MENU_TYPE = 'CATEGORY_MENU_';

	/**
	 * Retrieves APC's Shared Memory Allocation information
	 * @param Boolean $bool limited
	 * @return Array of Shared Memory Allocation data; FALSE on failure.
	 */
	public static final function getSharedMemoryAllocationInformation($bool = false){
		return apc_sma_info($bool);
	}

	/**
	 * Retrieves cached information from APC's data store
	 * @param String $cache_type [Keys: "user" or "filehits]
	 * @param Boolean $bool limited; If limited  is TRUE, the return value will exclude the individual list of cache entries.
	 * @return Array of cached data (and meta-data), or FALSE on failure
	 */
	public static final function getCacheInformation($cache_type = 'user', $bool = false){
		return apc_cache_info($cache_type, $bool);
	}

	protected static final function clearSessions(){
		if(!empty($_SESSION['CACHE_TIME']))
		foreach( $_SESSION['CACHE_TIME'] as $key => $times )
			if( ($times['startfrom']+$times['ttl']) < time() )
				self::delete($key);
	}

	/**
	 * Get the cached data.
	 * @param $key The key where the data is stored at.
	 * @return The data.
	 */
	public static final function get($key) {
		if( function_exists('apc_fetch') )
		{
			return apc_fetch($key);
		}
		else
		{
			self::clearSessions();
			return @$_SESSION['CACHE_' . $key ];
		}
	}

	/**
	 * Store the data in the cache.
	 * @param $key The key where the data is stored at.
	 * @param $data The data to be cached.
	 * @param $ttl The time to live value.
	 * @return Gibt bei Erfolg TRUE zurück, im Fehlerfall FALSE.
	 */
	public static final function set($key, $data, $ttl = 0) {
		if( function_exists('apc_delete'))
		{
			apc_store($key, $data, $ttl);
		}
		else
		{
			self::clearSessions();
			@$_SESSION['CACHE_TIME'][$key]['ttl'] = $ttl;
			@$_SESSION['CACHE_TIME'][$key]['startfrom'] = time();
			$_SESSION['CACHE_' . $key ] = $data;
		}
	}

	/**
	 * Removes a stored variable from the cache.
	 * @param $key The key used to store the value.
	 * @return Gibt bei Erfolg TRUE zurück, im Fehlerfall FALSE.
	 */
	public static final function delete($key) {
		if( function_exists('apc_delete'))
		{
			apc_delete($key);
		}
		else
		{
			unset($_SESSION['CACHE_' . $key ]);
			unset($_SESSION['CACHE_TIME']['CACHE_' . $key]);
		}
	}

	/**
	 * Generate a key based on the parameters of the db request.
	 * @param array $type The type of stored data. Because key must be unique.
	 * @param $param The parameters of the db request.
	 * @return Generated key. MD5 hash of type + parameters.
	 */
	public static final function genKey($type, array $param) {
		return md5($type . implode($param));
	}


	public static final function loadConstants($key)
	{
		return @apc_load_constants($key);
	}

	public static final function defineConstants($key, array $data)
	{
		return apc_define_constants($key, $data);
	}

	public static final function clearCache($type = 'user')
	{
		return apc_clear_cache($type);
	}

	public static final function clearTranslations()
	{
		self::delete('_TRANSLATION_LAST_EXECUTE_TIME'); // sperre rausnehmen

		$myCache = self::getCacheInformation();
		foreach ( $myCache['cache_list'] as $key )
		{
			if( preg_match('/^TRANS\_/',$key['info']) )
				self::delete($key['info']);
		}
	}

}
