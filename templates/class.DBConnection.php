<?php
#ä
/**
 * Class to create and store a connection to the database
 */
abstract class DBConnection {

	protected static $conn = null;

  /**
	 * Returns $connection.
	 * @see Connection $connection
	 * @return Connection
	 */
	public static final function getConnection(){
		if( is_null(self::$conn) OR self::$conn->isConnected() === false ){
			//echo 'CONNECT'."<hr>";
			Library:: requireLibrary(LibraryKeys::ABSTRACTION_CREOLE());
			Library:: requireLibrary(LibraryKeys::ABSTRACTION_DAO_BASE());

			$dsn = array(
				'phptype'  => GLOBAL_DB_DRIVER,
				'hostspec' => GLOBAL_DB_HOST,
			  'username' => GLOBAL_DB_USER,
			  'password' => GLOBAL_DB_PASS,
				'database' => GLOBAL_DB_DBNAME,
				'encoding' => (defined('GLOBAL_DB_CHARSET') ? GLOBAL_DB_CHARSET : null)
			);

			self::$conn = Creole::getConnection($dsn);
			if( is_null(self::$conn) )
      	throw new Exception ('no connection!');
			self::$conn->setAutoCommit(false);

			BaseDAO::genericQuery('SET NAMES \'utf8\'', array());
		}

		return self::$conn;
	}

	/**
 	 * Overwrites stored Connection with a new one
 	 */
	public static final function disconnect() {
		//echo 'disconnect<hr>';
		self::getConnection()->commit(); // transaction wird abgeschlossen und transaktions-modus geht zurück auf auto-commit
		self::getConnection()->close(); // verbindung schliessen
	}

	/**
 	 * Commits Transaction in the stored connection.
	 * Throws SQLException, if the stored connection is NULL.
	 */
	public static final function commit() {
		//echo 'commit<hr>';
		self::getConnection()->commit(); // transaction wird abgeschlossen und transaktions-modus geht zurück auf auto-commit
		self::getConnection()->begin(); // transaktions-modus auf DEFAULT umstellen - OCI8 "0" - transaction wartet auf commit/rollback
	}

	public static final function rollback() {
		//echo 'rollback<hr>';
		self::getConnection()->rollback();// transaction abbrechen und transaktions-modus geht zurück auf auto-commit
		self::getConnection()->begin(); // transaktions-modus auf DEFAULT umstellen - OCI8 "0" - transaction wartet auf commit/rollback
	}

}