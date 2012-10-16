<?php
#ä
abstract class ORMBuilderBase {

	private static $path;
	private static $builder_version = '0.1 beta';
	private static $builder_author = array('Mario Kaufmann');
	private static $config;

	private static $chmod_dir = 0770;
	private static $chmod_file = 0644;
	private static $unix_owner = 'hudson';
	private static $unix_group = 'www-data';

	public static final function setConfig(ORMConfig &$myConfig){
		self::$config = $myConfig;
	}

	public static final function getConfig(){
		return self::$config;
	}

	public static final function TAB(){
		return chr(9);
	}

	public static final function LN(){
		return "\r\n";
	}

	public static final function HEADER(){
		$content = '<?php'.self::LN().'#ä'.self::LN();
		return $content;
	}

	public static final function COMMENT($classname = null){
		$content = '/**'.self::LN();
		$content .= ' * '.$classname.self::LN();
		$content .= ' * @author '.implode(', ',self::$builder_author).self::LN();
		$content .= ' * @version '.self::$builder_version.self::LN();
		$content .= ' */'.self::LN();
		return $content;
	}

	public static final function FOOTER(){
		// deprecated
		/*return '}'.self::LN().'?>';*/
		return '}'.self::LN();
	}

	public static final function write($path, $content){
		self::createPath($path);
		echo  'write: '.$path."<br>";
		return file_put_contents($path, $content);
	}

	protected static final function createPath($realpath){
		#mkdir($path, 0770, true);
		#chmod($path, 0770);
		$path = '';
		for($i=0;$i<strlen($realpath);$i++){
			$char = substr($realpath, $i, 1);
			$path .= $char;
			if( $char == '/' AND !is_dir($path) ){
				@mkdir($path, self::$chmod_dir, true);
				@chmod($path, self::$chmod_dir);
			}
		}

	}

	/**
	 * check php types
	 * @param unknown_type $type
	 */
	public static final function checkTypes( $type ){
		return ( in_array($type, array('string', 'integer', 'boolean', 'float', 'double')) );
	}

	/**
	 * check php types
	 * @param string $type
	 */
	public static final function getPHPType($type){
		switch (strtolower($type)){
			case 'str':
			case 'string':
			case 'varchar':
			case 'char':
			case 'set':
			case 'enum':
			case '':
			case 'text':
				return 'string';
				break;
			case 'int':
			case 'tinyint':
			case 'integer':
			case 'time':
			case 'timestamp':
			case 'date':
			case 'numeric':
				return 'integer';
				break;
			case 'bol':
			case 'boolean':
			case 'bool':
				return 'bool';
				break;
			case 'double':
			case 'dbl':
				return 'double';
				break;
			case 'flt':
			case 'float':
			case 'decimal':
				return 'float';
				break;
			default:
				return $type;
				break;
		}
	}

	/**
	 * Ersten Buchstabe groß
	 * @param unknown_type $string
	 */
	public static final function formatName($string){
		return strtoupper(substr($string,0,1)).substr(strtolower($string),1);
	}

	public static final function formatAttributename($colName) {
		$attName = strtolower($colName);
		$firstChar = strtoupper( substr($attName,0,1) );
		$attName = implode('', array_map('ucfirst', explode('_', $attName))); // underscores entfernen und Teilworte gross schreiben
		$attName = substr_replace($attName, $firstChar, 0, 1);
		return $attName;
	}

	public static function checkDefaultValue($value){
		$value = trim($value);
		$check = true;
		if(strlen($value) == 0)
			$check = false;
		if($value == 'CURRENT_TIMESTAMP')
			$check = false;
		return $check;
	}

	public static function makeClassName($name){
		$name = str_replace(array('new_', 'tbl_'), '', strtolower($name));
		$name = self::formatAttributename($name);
		return $name;
	}

	public static function makeRefName($name){
		$name = str_replace(array('new_', 'tbl_'), '', strtolower($name));
		if(strpos($name, '_') == 0 )
			return $name;
		$pieces = explode('_', $name);
		$name = '';
		for($i=1;$i<count($pieces); $i++){
			$name .= $pieces[$i];
		}
		return $name;
	}

}
?>