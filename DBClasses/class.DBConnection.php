<?php
#ä

abstract class DBConnection {
    	
	public static $connection;
    	
	/**
	     * Returns Connection.
	     * @see Connection::$connection
	     * @return Connection
	     */
	public static final function getConnection(ORMConfig &$myConfig){
		if( !empty(self::$connection) )
			return self::$connection;

			require_once $myConfig->getCreolePath();
			
			$dsn = array(
				'phptype'  => $myConfig->getDbDriver(),
        'hostspec' => $myConfig->getDbHost(),
        'username' => $myConfig->getDbLoginname(),
        'password' => $myConfig->getDbPassword(),
				'database' => $myConfig->getDbDatabase(),
				'encoding' => ( $myConfig->getDbCharset() ? $myConfig->getDbCharset() : null)
			);

			#$conn = Creole::getConnection($dsn, Creole::PERSISTENT);
			$conn = Creole::getConnection($dsn, Creole::COMPAT_ASSOC_LOWER);
			if(!($conn->getAutoCommit() === false)){
				$conn->setAutoCommit(false);
			}
	
	#$conn->begin(); // start transaction
	self::$connection = $conn;
	return $conn;
	}
		
		/**
		 * Overwrites stored Connection with a new one
		 */
		function disconnect() {
			DBConnection::getConnection()->close();
		}
		
		/**
		 * Commits Transaction in the stored connection. 
		 * Throws SQLException, if the stored connection is NULL.
		 */
		function commit() {
			DBConnection::getConnection()->commit();
		}
		
		function rollback() {
			DBConnection::getConnection()->rollback();
		}			
	}
?>