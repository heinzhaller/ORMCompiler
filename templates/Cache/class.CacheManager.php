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
	public static final function getCacheInformation($cache_type = null, $bool = false){
		return apc_cache_info($cache_type, $bool);
	}

	/**
	 * Get the cached data.
	 * @param $key The key where the data is stored at.
	 * @return The data.
	 */
	public static final function get($key) {
		return apc_fetch($key);
	}

	/**
	 * Store the data in the cache.
	 * @param $key The key where the data is stored at.
	 * @param $data The data to be cached.
	 * @param $ttl The time to live value.
	 * @return Gibt bei Erfolg TRUE zurück, im Fehlerfall FALSE.
	 */
	public static final function set($key, $data, $ttl) {
		return apc_store($key, $data, $ttl);
	}

	/**
	 * Removes a stored variable from the cache.
	 * @param $key The key used to store the value.
	 * @return Gibt bei Erfolg TRUE zurück, im Fehlerfall FALSE.
	 */
	public static final function delete($key) {
		return apc_delete($key);
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


	public static final function loadConstants($key){
		return apc_load_constants($key);
	}

}
