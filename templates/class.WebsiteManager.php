<?php
#ä

abstract class WebsiteManager {
	
	public static $manager;
	public static $timer = 0;
	public static $error_messages = array();
	
	public function getCountry(){
		return $_SESSION['config']['country'];
	}
	
	public function getLanguage(){
		return $_SESSION['config']['language'];
	}
		
	public static final function setDebugMode($boolean){
		$_SESSION['debugmode'] = $boolean;
	}
		
	public static final function getDebugMode(){
		return isset($_SESSION['debugmode']) ? $_SESSION['debugmode'] : null;
	}
	
	/**
	 * @return Manager
	 */
	public static final function getManager(){
		Library::includeLibrary(LibraryKeys::APPLICATION_MANAGER());
		if(is_null(self::$manager) AND isset($_SESSION['manager']))
			self::$manager = unserialize($_SESSION['manager']);
		return self::$manager;
	}
	
	public static final function setManager(Manager &$myManager){
		$_SESSION['manager'] = serialize($myManager);
		self::$manager = $myManager;
	}
	
	public static final function bodyInit(){
		self::$timer = microtime(true);
		include_once $_SERVER['DOCUMENT_ROOT'].'/include/bodyInit.php';
	}
	
	public static final function bodyExit(){
		include_once $_SERVER['DOCUMENT_ROOT'].'/include/bodyExit.php';
		self::showDuration(round(microtime(true) - self::$timer, 4));
	}
	
	public static final function redirect($path, $header_redirect = false){
		if(file_exists($_SERVER['DOCUMENT_ROOT'].$path)){
			if($header_redirect == FALSE){
				self::showContentBox('Weiterleitung', self::getRedirectLink($path,2));
			}else{
				header('location: '.$path);
				exit();
			}
		}else{
			throw new ExceptionObject(ExceptionKeys::ERROR_PAGE_NOT_FOUND);
		}
	}
	
	/**
	 * check login username and password - return false if login fails
	 * @param string $username
	 * @param string $password
	 * @param string $remote_addr
	 * @return boolean
	 */
	public static final function checkLogin($username, $password, $remote_addr){
		// get Manager
		Library::requireLibrary(LibraryKeys::APPLICATION_MANAGER());
		$myManager = ManagerManager::getManagerByLoginAndPassword($username,$password);
		if($myManager){
			ManagerManager::createLoginHistory($myManager,$remote_addr);
			self::setManager($myManager);
			return true;
		}
		return false;
	}
	
	public static final function showDuration($time){
		if(self::getDebugMode() == true)
			echo '<div align="center" class="ladezeit">Ladezeit: '.$time.' Sekunden</div>';
	}
	
	public static final function showContentBox($title, $content){
		// prepare content - replace \n\r whit <br>
		$content = str_replace("\n", '<br>', $content);
		#$content = htmlentities($content);
		#$content = htmlspecialchars($content);
		
		echo '
		<div class="contentbox">
			<div class="title">'.$title.'</div>
			<div class="content">
				'.$content.'
			</div>
		</div>
		';
	}
	
	public static final function getRedirectLink($path, $seconds_to_wait = 0){
		return '
		<meta http-equiv="refresh" content="'.$seconds_to_wait.'; url='.$path.'">
		<div class="redirect">
			Sie werden automatisch in '.$seconds_to_wait.' Sekunden umgeleitet.<br><a href="'.$path.'">Klicken Sie hier wenn die Weiterleitung nicht funktioniert.</a>
		</div>';
	}
	
	public static final function showErrorBox(array $myArray){
		foreach ($myArray as $key => $item)
			$myArray[$key] = ' - '.$item;
		echo '
		<div class="errorbox">
			<div class="title error">Fehlermeldung:</div>
			<div class="error">
				'.implode('<br>', $myArray).'
			</div>
		</div>
		';
	}
	
	public static final function showExceptions(array $myExceptions){
		echo '
		<div class="contentbox">
			<div class="title error">Sorry - Es ist ein Fehler aufgetreten</div>
			<div class="content error">
				';
		foreach( $myExceptions as $myException){
			if( $myException instanceof ExceptionObject )
				echo '<br> - ['.strtoupper($myException->getType()).' '.$myException->getCode().'] '.$myException->getMessage().'<br>Line: '.$myException->getLine().'<br>FILE: '.$myException->getFile();
			else
				var_dump($myException);
		}
		echo '
			</div>
		</div>
		';
	}
	
	public static final function makeLink($layer, $page, array $params = NULL){
		$myLink = '/'.$layer.'/'.$page.'/';
		if(!empty($params))
		foreach ($params as $key => $value){
			$myLink .= $key.'/'.$value.'/';
		}
		return $myLink;
	}
	
	public static final function getModule($modulename){
		$path = $_SERVER['DOCUMENT_ROOT'].'/include/modules/'.$modulename.'.php';
		if(file_exists($path))
			include_once $path;
	}
	
	public static final function formatValue($value){
		Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_CURRENCY());
		return CurrencyManager::formatValue($value);
	}
	
	public static final function formatTimestamp($value,$his = true){
		return date('d.m.Y '.($his ? 'H:i:s' : null), $value);
	}
	
	
	public static final function initSession(){
		session_start();
		if(!isset($_SESSION['config'])){
			$_SESSION['config'] = array();
			$_SESSION['config']['country'] = 'de';
			$_SESSION['config']['language'] = 'de';
		}
	}
	
	// vllt auch als logout function
	public static final function logout(){
		$_SESSION['manager'] = null;
		unset($_SESSION['manager']);
	}
	
}
?>