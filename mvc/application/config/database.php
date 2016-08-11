<?
#ä

// database
define('GLOBAL_DB_DRIVER', 'mysql');
define('GLOBAL_DB_HOST', 'localhost');
define('GLOBAL_DB_DBNAME', 'test');
define('GLOBAL_DB_USER', 'root');
define('GLOBAL_DB_PASS', '');
define('GLOBAL_DB_CHARSET', 'UTF8');
define('GLOBAL_CREOLE_CONNECTIONSTRING', GLOBAL_DB_DRIVER.'://'.GLOBAL_DB_USER.':'.GLOBAL_DB_PASS.'@'.GLOBAL_DB_HOST.'/'.GLOBAL_DB_DBNAME);