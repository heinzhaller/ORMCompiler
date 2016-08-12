<?php
#ä
abstract class WebsiteManager
{
	const LAYER_GAME = 'intra';
	const LAYER_PUBLIC = 'public';
	const LAYER_IMAGES = 'images';

	const PUBLIC_MAIN = 'start/index';
	const PUBLIC_REGISTER = 'start/register';
	const PUBLIC_SUPPORT = 'support';
	const PUBLIC_IMPRINT = 'imprint';
	const PUBLIC_PASSWORD = 'imprint';
	const PUBLIC_LOGOUT = 'logout';

	const MAX_IDLE_TIME = 3; // 3 minutes

	public static $translationlist = array();

	protected static $timer = 0;
	protected static $error_messages = array();
	public static $page;
	public static $layer;
	public static $params = array();
	protected static $user_online;
	protected static $websitetitle;
	public static $meta_description;

	
	protected static $pagetitles = array
	(
		self::LAYER_PUBLIC => array
		(
			self::PUBLIC_IMPRINT => 'LANG_IMPRINT',
		),
	);

	protected static $meta_descriptions = array
	(
		self::LAYER_PUBLIC => array
		(
			self::PUBLIC_MAIN => 'LANG_META_DESCRIPTION_MAIN',
			self::PUBLIC_REGISTER => 'LANG_META_DESCRIPTION_REGISTER',
			//self::PUBLIC_LOGIN => 'LANG_META_DESCRIPTION_LOGIN',
			self::PUBLIC_PASSWORD => 'LANG_META_DESCRIPTION_PASSWORD',
		),
	);

	protected static $meta_tags = array
	(
		self::LAYER_PUBLIC => array
		(

		),
		self::LAYER_GAME => array
		(

		),
	);

	public static final function initSession()
	{
		self::$timer = microtime(true);
#		session_set_cookie_params(0, '/', '.' . $_SERVER['HTTP_HOST']);
		session_start();
		if(!isset($_SESSION['config']))
		{
			$_SESSION['config'] = array();
			$language = 'de';
			$_SESSION['config']['country'] = 'de';
			$_SESSION['config']['language'] = $language;
		}
	}
	
	public static function getHostname()
	{
		return str_replace('www.', '', $_SERVER['HTTP_HOST']);
	}

	public static function getLayer()
	{
		return self::$layer;
	}

	public static function getPage()
	{
		return self::$page;
	}

	public static function getParams()
	{
		$myParams = $_GET;
		unset($myParams['layer']);
		unset($myParams['page']);
		unset($myParams['tutorial']);
		unset($myParams['pagenr']);
		if( isset($_GET['inline']) )
		{
			unset($myParams['inline']);
			unset($myParams['ajax']);
			unset($myParams['tab']);
		}

		return $myParams;
	}

	public static function getCountry()
	{
		return $_SESSION['config']['country'];
	}

	public static function getLanguage()
	{
		return strtoupper($_SESSION['config']['language']);
	}

	public static function setLanguage($languageiso2)
	{
		$languageiso2 = strtoupper($languageiso2);
		if( in_array($languageiso2, array('AR', 'DE', 'ES', 'EN', 'FR', 'IT', 'PL', 'TR', 'RU', 'SV', 'NO', 'NL', 'CN', 'JA', 'PT')) )
			$_SESSION['config']['language'] = $languageiso2;
	}

	public static final function setDebugMode($boolean)
	{
		$_SESSION['debugmode'] = $boolean;
	}

	public static final function getDebugMode()
	{
		return isset($_SESSION['debugmode']) ? $_SESSION['debugmode'] : null;
	}

	public static final function redirect($path, $header_redirect = false)
	{
		if($header_redirect == FALSE){
			self::showContentBox(getTrans('LANG_REDIRECT'), self::getRedirectLink($path,2));
		}else{
			@ob_end_clean();
			header('location: '.$path);
			exit();
		}
	}

	/**
	 * check login username and password - return false if login fails
	 * @param string $username
	 * @param string $password
	 * @param string $remote_addr
	 * @return boolean
	 */
	public static final function checkLogin($username, $password, $remote_addr)
	{
		
	}

	public static final function showDuration($time)
	{
		if(self::getDebugMode() == true)
			echo '<div align="center" class="ladezeit">Ladezeit: '.$time.' Sekunden</div>';
	}

	public static final function doRedirect($path)
	{
		DBConnection::commit();

		$path = str_replace('&amp;', '&', $path); // wieder auf normale URL stellen
		if( isset($_GET['inline']) AND $_GET['inline'] == true ){
			echo '
			Deine Einstellungen werden gespeichert ...
			<script>window.location.href = "'.self::makeLink(self::LAYER_GAME, self::GAME_MAIN).'";</script>';
		}
		else
		{
			header('location: '.$path);
		}
		exit();
	}

	public static final function showErrorBox(array $myArray){
		foreach ($myArray as $key => $item)
			$myArray[$key] = ' - '.$item;
		echo '
		<div class="errorbox">
			<div class="title error">'.getTrans('LANG_ERROR').':</div>
			<div class="error">
				'.implode('<br>', $myArray).'
			</div>
		</div>
		';
	}

	/**
	 * Overlay
	 *  - zum Anzeigen von Hinweisen und Fehler
	 * @param array $myArray
	 */
	public static final function showInfo(array $myArray){
		if(empty($myArray))
			return false;
		foreach ($myArray as $key => $item)
			$myArray[$key] = ' - '.$item;
		echo '
		<div class="info-overlay-bg"></div>
		<div class="info-overlay">
			<div class="close"><a href="">&nbsp;</a></div>
			<div class="title">Fehlermeldung:</div>
			<div class="message">
				'.implode('<br>', $myArray).'
			</div>
		</div>
		';
	}

	public static final function showExceptions(array $myExceptions){
		echo '
		<div class="wide">
			<div class="box">
				<h1 class="box_title">
					<img src="/assets/images/custom/ingame/icons/notice.png" class="icon" alt="[]" />
					<span class="error">Error</span>
				</h1>
				<div class="box_content">
		';

		if( $myExceptions[0]->getCode() == ExceptionKeys::ERROR_FILE_NOT_FOUND )
		{
			echo '
				Page not found!<br />
				<a href="/">Click here for start page!</a>
				</div>
			</div>
			';
			return true;
		}

		foreach( $myExceptions as $myException){
			$hash = md5($myException->getMessage().$myException->getFile().$myException->getLine());
			$_SESSION['exception_last'] = array(
					'hash' =>	$hash,
					'time' => time()
			);
			echo '<div class="error">Sorry - Es ist ein Fehler aufgetreten: <br /><b>Fehlercode: <u>'.$hash.'</u></b></div>';

			if( $myException instanceof Exception ){
				//var_dump($myException);
				#echo '<br> - ['.strtoupper($myException->getType()).' '.$myException->getCode().'] '.$myException->getMessage().'<br>Line: '.$myException->getLine().'<br>FILE: '.$myException->getFile();
			}else
				echo "";
		}
		echo '
				<p>
					Um uns zu helfen kannst du uns einfach ein Support-Ticket mit den Informationen zu diesem Fehler senden.<br />
					Hilfreiche Tickets werden mit Gegenständen belohnt!
				</p>

				Das müssen wir wissen:<br />
				- Welche Schritte führen zu diesem Fehler?<br />
				- Tritt der Fehler nach einem reloggen nochmals auf?<br />
				<br />

				<a class="overlay" href="'. self::makeLink( WebsiteManager::getManager() ? WebsiteManager::LAYER_GAME : WebsiteManager::LAYER_PUBLIC, self::PUBLIC_SUPPORT, array('action' => 'error')).'">Support-Ticket senden und Belohnung kassieren!</a>

				</div>
			</div>
		</div>
		';
	}

	public static final function makeLink($layer, $page, array $params = NULL, array $extend_params = NULL )
	{
		$myLink = '';
		if( !empty($layer) AND $layer != self::LAYER_PUBLIC )
			$myLink .= '/'.$layer;
#		if( !self::getManager() AND !empty($page) AND $page == self::PUBLIC_MAIN )
#                       $page = '';
		if( !empty($page)  )
			$myLink .= '/'.$page;

		############################################################
		// check for language switch
		############################################################
/*		if( !self::getManager() )
		{
			if( self::isProductiveServer() )
				if( isset($params['lang']) AND strtolower($params['lang']) != 'de' )
					$myLink = 'http://'.strtolower($params['lang']). '.onlineboxingmanager.com' . $myLink;
				elseif( isset($params['lang']) AND strtolower($params['lang']) == 'de' )
					$myLink = 'http://www.onlineboxingmanager.de' . $myLink;
			if( self::isProductiveServer() AND isset($params['lang']) )
				unset($params['lang']);
		}
*/
		############################################################

		if( is_null($params) AND !empty($extend_params) )
			$params =  array_merge(array(), $extend_params);

		if( !empty($params) )
			$myLink .= '/';
		if( empty($myLink) )
			$myLink = '/';

		$param_string = '';
		if( !empty($params) ){
			foreach ($params as $key => $value){
				$param_string .= '&'.$key.'='.$value;
			}
			$param_string = '?' . substr($param_string, 1);
		}
		$url = $myLink.$param_string;
		$url = str_replace('&', '&amp;', $url);
		return $url;
	}

	public static final function makeSeoLink($url)
	{
		$url = trim($url);

		$search = array("Ä", "Ö", "Ü", "ä", "ö", "ü", "ß", "´");
		$replace = array("Ae", "Oe", "Ue", "ae", "oe", "ue", "ss", "");
		$url = str_replace($search, $replace, $url);

		$url = str_replace(' / ', ' ', $url);

		$url = preg_replace('/[^A-z0-9\s\-\/]+/i', '', $url);
		$url = ucwords($url);
		$url = trim($url);
		$url = str_replace(' ', '-', $url);
		$url = '/' . $url;
		$url = str_replace('//', '/', $url);
		$url = str_replace('--', '-', $url);
		return $url;
	}

	public static final function formatValue($value){
		Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_CURRENCY());
		return CurrencyManager::formatValue($value);
	}

	public static final function formatCurrency($value, $currencychar = false){
		Library::requireLibrary(LibraryKeys::SYSTEM_UTILITIES_CURRENCY());
		return CurrencyManager::formatCurrency($value, $currencychar);
	}

	public static final function formatTimestamp($value,$his = true, $own_format = null )
	{
		if( empty($value) )
			return '';
		$format = 'd.m.Y '.($his ? 'H:i:s' : null);
		if($own_format)
			$format = $own_format;
		return date($format, $value);
	}

	// vllt auch als logout function
	public static final function logout()
	{
		unset($_SESSION['user']);
		return self::doRedirect('/');
	}

	/**
	 * @param int $count_total
	 * @param int $limit
	 * @param array $link_params
	 * @param boolean $show_nr
	 * @param boolean $is_overlay
	 * @param string $layer
	 * @param string $pagename
	 * @param array $custom_names
	 * @param boolean $is_tab
	 */
	public static final function sideBar($count_total, $limit, $link_params, $show_nr = true, $is_overlay = false, $layer = null, $pagename = null, array $custom_names = null, $is_tab = false, $force_show = false ){
		if( $count_total < $limit AND $force_show == false )
			return false;

		$url_params = self::getParams();

		$overlay = '';
		if( $is_overlay OR isset($_GET['inline']) )
			$overlay = 'overlay';
		if( $is_tab OR !empty($_GET['tab']) )
			$overlay = 'tab';

		$paramname_offset = 'offset';
		$paramname_limit = 'limit';
		if( !empty($custom_names) )
		{
			$paramname_offset = $custom_names[0];
			$paramname_limit = $custom_names[1];
		}

		$selected_limit = ( isset($url_params[$paramname_limit]) ? $url_params[$paramname_limit] : $limit );
		$offset = ( isset($url_params[$paramname_offset]) ? $url_params[$paramname_offset] : 0 );

		if(!$layer)
			$layer = self::getLayer();
		if(!$pagename)
			$pagename = self::getPage();

		$navigationpanel_row = 0; // count pagehits (cnt / limit)
		$maxpage = 0;
		$page = array();
		for($i = 0; $i < $count_total; $i++) {
			if( ( $i % $limit ) == 0){
				$navigationpanel_row++;
				$count_total < $limit ? $i = 0: $i;
				$page[$navigationpanel_row] = $i;
				$maxpage = $maxpage + $limit;
			}
		}

		$number = @($offset  / $limit);
		$max_pages = 10;
		if ( $number < $max_pages ){
			$start = 1; $end = $max_pages - $number;
		}else{
			$start = $number - $max_pages;  $end = $max_pages;
		}

		$myPages = array();
		$currentpage = 1;
		for($i = $start; $i <= $number + $end; $i++ ){
			if( isset($page[$i]) AND strlen($page[$i]) > 0 ){
				$link_params[$paramname_offset] = $page[$i];
				if( $page[$i] == $offset )
					$currentpage = $i;
				$myPages[] = '<a class="'.$overlay.' '.( $page[$i] == $offset ? 'selected' : '' ).'" href="'.self::makeLink(  $layer, $pagename, $link_params).'"> '.$i.'</a>';
			}
		}
		$sidebar = '';
		if( $show_nr )
			$sidebar = implode(' | ', $myPages);

		$link_params[$paramname_offset] = 0; // für limit anzeige

		unset($link_params['tab']);
		?>

		<div class="sidebar">
			<div class="actions"><?=getTrans('LANG_PAGE')?> <?=$currentpage?> <?=getTrans('LANG_FROM')?> <?=count($page)?></div>
			<div class="limit grey">
				<?=getTrans('LANG_SIDEBAR_VIEWSEARCHSITE')?>:
				<a href="<?$link_params[$paramname_limit] = 15; echo self::makeLink($layer, $pagename, $link_params)?>" class="<?=($selected_limit == 15 ? 'selected' : '')?><?=$overlay?>">15</a> |
				<a href="<?$link_params[$paramname_limit] = 25; echo self::makeLink($layer, $pagename, $link_params)?>" class="<?=($selected_limit == 25 ? 'selected' : '')?><?=$overlay?>">25</a> |
				<a href="<?$link_params[$paramname_limit] = 50; echo self::makeLink($layer, $pagename, $link_params)?>" class="<?=($selected_limit == 50 ? 'selected' : '')?><?=$overlay?>">50</a> |
				<a href="<?$link_params[$paramname_limit] = 100; echo self::makeLink($layer, $pagename, $link_params)?>" class="<?=($selected_limit == 100 ? 'selected' : '')?><?=$overlay?>">100</a>
			</div>
			<div class="pages grey"><?=getTrans('LANG_PAGE')?>: <?=$sidebar?></div>
			<div class="clear"></div>
		</div>

		<?
	}

	/* ingame <title> */
	public static function getPageTitle()
	{
		$return = 'OBM';
		if ( isset(self::$pagetitles[self::LAYER_GAME][self::getPage()]) AND !empty(self::$pagetitles[self::LAYER_GAME][self::getPage()]) )
			$return = getTrans(self::$pagetitles[self::LAYER_GAME][self::getPage()], true);

		return $return;
	}

	public static function setWebsiteTitle($title)
	{
		self::$websitetitle = $title;
	}

	/* public <title> */
	public static function getWebsiteTitle()
	{
		$prefix = 'Online Boxing Manager - ';
		$default = 'LANG_WEBSITE_TITLE';
		if( !empty(self::$websitetitle) )
			return $prefix . self::$websitetitle;

		$return = getTrans($default, true);
		if ( isset(self::$pagetitles[self::LAYER_PUBLIC][self::getPage()]) AND !empty(self::$pagetitles[self::LAYER_PUBLIC][self::getPage()]) )
			$return = $prefix . getTrans(self::$pagetitles[self::LAYER_PUBLIC][self::getPage()], true);

		return $return;
	}

	public static function getMetaTags()
	{
		$return = 'LANG_META_TAGS';
		if ( isset(self::$meta_tags[self::getLayer()][self::getPage()]) AND !empty(self::$meta_tags[self::getLayer()][self::getPage()]) )
			$return = self::$meta_tags[self::getLayer()][self::getPage()];
		$return = getTrans($return, true);
		return $return;
	}

	public static function setMetaDescription($string)
	{
		self::$meta_description = $string;
	}

	public static function getMetaDescription()
	{
		if( !empty(self::$meta_description) )
			return self::$meta_description;

		$return = 'LANG_META_DESCRIPTION_MAIN';
		if ( isset(self::$meta_descriptions[self::getLayer()][self::getPage()]) AND !empty(self::$meta_descriptions[self::getLayer()][self::getPage()]) )
			$return = self::$meta_descriptions[self::getLayer()][self::getPage()];

		$return = getTrans($return, true);
		if( preg_match('/^LANG_/', $return) )
			$return = getTrans('LANG_META_DESCRIPTION_MAIN', true);

		return trim($return);
	}

	public static function isProductiveServer(){
		return !self::isTestServer();
	}

	public static function isTestServer()
	{
		$is_local  = preg_match( '/^192\.168\./', $_SERVER['SERVER_ADDR']);
		$is_testserver  = preg_match( '/^test\./i', $_SERVER['HTTP_HOST']);
		return ( $is_local OR $is_testserver );
	}

	/**
	 * load translation placeholders from disk
	 * @param string $templatename
	 * @return bool
	 */
	public static final function loadTranslation($templatename = '_default')
	{
		$filename = strtoupper('TRANSLATION_'.$templatename.'_'.self::getLanguage()).'.tpl.json';
		$file = GLOBAL_CACHE . '/translations/'.$filename;
		$time = microtime(true);

		if( !file_exists($file) )
			return true;

		$file = file_get_contents($file);
		$file = json_decode($file, true);

		foreach( $file as $placeholder => $content )
			self::$translationlist[$placeholder] = $content;

		$time_used = microtime(true) - $time;

		return true;
	}

	public static final function loadTranslationAPC($templatename = '_default')
	{
		$key = strtoupper('TRANSLATION_'.$templatename.'_'.self::getLanguage());
		$time = microtime(true);
		if ( !CacheManager::loadConstants($key) )
		{
			// Platzhalter neu erzeugen
			Library::requireLibrary(LibraryKeys::APPLICATION_TRANSLATION_TEMPLATE());
			TranslationTemplateManager::cacheTranslationsAPC();
			CacheManager::loadConstants($key);
		}

		$time_used = microtime(true) - $time;

		return true;
	}

}

define('TRANSLATION_MODE_RAWHTML', 2);
define('TRANSLATION_MODE_PLAINTEXT', true);

function getTrans($platzhalter, $mode = false )
{
	$platzhalter = trim(strtoupper($platzhalter));
	if( !isset(WebsiteManager::$translationlist[$platzhalter]) OR !empty($_REQUEST['showplaceholder']) )
		return $platzhalter;

	$output = WebsiteManager::$translationlist[$platzhalter];

	#if( $is_plaintext == false )
		#$output = nl2br($output);

	if( $mode === false )
	{
		$output = str_replace(">\n\n", '><br /><br />', $output); // workaround html
		$output = str_replace(">\n", '><br />', $output); // workaround html
		$output = str_replace( array("\r\n", "\n", "\r"), '<br />', $output);
	}

	elseif( $mode === TRANSLATION_MODE_RAWHTML )
	{

	}

	else
	{
		$output = strip_tags($output);
	}

	return $output;
}
