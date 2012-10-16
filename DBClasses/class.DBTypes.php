<?php
#ä
abstract class DBTypes {

        const BOOLEAN = 1;
        const BIGINT = 2;
        const SMALLINT = 3;
        const TINYINT = 4;
        const INTEGER = 5;
        const CHAR = 6;
        const VARCHAR = 7;
        const FLOAT = 8;
        const DOUBLE = 9;
        const DATE = 10;
        const TIME = 11;
        const TIMESTAMP = 12;
        const VARBINARY = 13;
        const NUMERIC = 14;
        const BLOB = 15;
        const CLOB = 16;
        const LONGVARCHAR = 17;
        const DECIMAL = 18;
        const REAL = 19;
        const BINARY = 20;
        const LONGVARBINARY = 21;
        const YEAR = 22;
        
        /** this is "ARRAY" from JDBC types */
        const ARR = 23;
        
        // mysql
        const TEXT = 24;
        
        // others
        const OTHER = -1;
        
        /** Map of Creole type integers to the setter/getter affix. */
        protected static $affixMap = array(
                self::BOOLEAN => 'Boolean',
                self::BIGINT => 'String',
                self::CHAR => 'String',
                self::DATE => 'Date',
                self::DOUBLE => 'Float',
                self::FLOAT => 'Float',
                self::INTEGER => 'Int',
                self::SMALLINT => 'Int',
                self::TINYINT => 'Int',
                self::TIME => 'Time',
                self::TIMESTAMP => 'Timestamp',
                self::TEXT => 'String',
                self::VARCHAR => 'String',
                self::VARBINARY => 'Blob',
                self::NUMERIC => 'Float',
                self::BLOB => 'Blob',
                self::CLOB => 'Clob',
                self::LONGVARCHAR => 'String',
                self::DECIMAL => 'Float',
                self::REAL => 'Float',
                self::BINARY => 'Blob',
                self::LONGVARBINARY => 'Blob',
                self::YEAR => 'Int',
                self::ARR => 'Array',
                self::OTHER => '', // get() and set() for unknown
                );
        
        /** Map of Creole type integers to their textual name. */
        protected static $creoleTypeMap = array(
                self::BOOLEAN => 'BOOLEAN',
                self::BIGINT => 'BIGINT',
                self::SMALLINT => 'SMALLINT',
                self::TINYINT => 'TINYINT',
                self::INTEGER => 'INTEGER',
                self::NUMERIC => 'NUMERIC',
                self::DECIMAL => 'DECIMAL',
                self::REAL => 'REAL',
                self::FLOAT => 'FLOAT',
                self::DOUBLE => 'DOUBLE',
                self::CHAR => 'CHAR',
                self::VARCHAR => 'VARCHAR',
                self::TIME => 'TIME',
                self::TEXT => 'TEXT',
                self::TIMESTAMP => 'TIMESTAMP',
                self::DATE => 'DATE',
                self::YEAR => 'YEAR',
                self::VARBINARY => 'VARBINARY',                
                self::BLOB => 'BLOB',
                self::CLOB => 'CLOB',
                self::LONGVARCHAR => 'LONGVARCHAR',
                self::BINARY => 'BINARY',
                self::LONGVARBINARY => 'LONGVARBINARY',                
                self::ARR => 'ARR',
                self::OTHER => 'OTHER', // string is "raw" return
                );
        
        /**
         * This method returns the generic Creole (JDBC-like) type
         * when given the native db type.
         * @param string $nativeType DB native type (e.g. 'TEXT', 'byetea', etc.).
         * @return int Creole native type (e.g. Types::LONGVARCHAR, Types::BINARY, etc.).
         */
        abstract static function getType($nativeType);
        
        /**
         * This method will return a native type that corresponds to the specified
         * Creole (JDBC-like) type.
         * If there is more than one matching native type, then the LAST defined 
         * native type will be returned.
         * @return string Native type string.
         */
        abstract static function getNativeType($creoleType);
        
        /**
         * Gets the "affix" to use for ResultSet::get*() and PreparedStatement::set*() methods.
         * <code>
         * $setter = 'set' . CreoleTypes::getAffix(CreoleTypes::INTEGER);
         * $stmt->$setter(1, $intval);
         * // or
         * $getter = 'get' . CreoleTypes::getAffix(CreoleTypes::TIMESTAMP);
         * $timestamp = $rs->$getter();
         * </code>
         * @param int $creoleType The Creole types.
         * @return string The default affix for getting/setting cols of this type.
         * @throws SQLException if $creoleType does not correspond to an affix
         */
        public static function getAffix($creoleType)
        {
            if (!isset(self::$affixMap[$creoleType])) {
                $e = new SQLException("Unable to return 'affix' for unknown CreoleType: " . $creoleType);
                throw $e;
            }
            return self::$affixMap[$creoleType];
        }
        
        /**
         * Given the integer type, this method will return the corresponding type name.
         * @param int $creoleType the integer Creole type.
         * @return string The name of the Creole type (e.g. 'VARCHAR').
         */
        public static function getCreoleName($creoleType)
        {
            if (!isset(self::$creoleTypeMap[$creoleType])) {
                return null;
            }
            return self::$creoleTypeMap[$creoleType];
        }
        
        /**
         * Given the name of a type (e.g. 'VARCHAR') this method will return the corresponding integer.
         * @param string $creoleTypeName The case-sensisive (must be uppercase) name of the Creole type (e.g. 'VARCHAR').
         * @return int the Creole type.
         */
        public static function getCreoleCode($creoleTypeName)
        {
        	foreach ( self::$creoleTypeMap as $key => $value )
        		if( $value == strtoupper($creoleTypeName) )
        			return $key;
        }
}
?>