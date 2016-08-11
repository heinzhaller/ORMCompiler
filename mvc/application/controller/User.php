<?php
#ä
// example controller
class UserController extends Controller
{

	public function index()
	{

	}

	public function menu()
	{
		// translations
		WebsiteManager::loadTranslation('user_menu');
		
		// view
		$this->Layout()->load('user/menu');
		$this->Layout()->show();
	}

	public function register()
	{
		// translations
		WebsiteManager::loadTranslation('register');

		$myUser = new User();
		$success = false;
		$error = array();

		// view
		$this->Layout()->load('user/register');

		if(!empty($_POST))
		{
			// email
			if(empty($_POST['email']) )
				$error[] = getTrans('LANG_ERROR_EMAIL_NOVALUE');
			elseif( !preg_match("/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i", $_POST['email']) OR !isValidEmail($_POST['email']) )
				$error[] = getTrans('LANG_ERROR_EMAIL_VALID');
			elseif( UserManager::getUserByEmail($_POST['email']) != NULL )
				$error[] = getTrans('LANG_ERROR_EMAIL_INUSE');
			elseif(!empty($_POST['email']) )
			{
				$myQuery = new UserQuery();
				$myQuery->add( UserQuery::STATUSNAME, Criteria::EQUAL, 'enabled' );
				$myQuery->add( UserQuery::EMAIL, Criteria::EQUAL, strtolower($_POST['email']) );
				$myList = $myQuery->find();
				if( $myList AND $myList->count() > 0 )
					$error[] = getTrans('LANG_ERROR_EMAIL_UNAVAILABLE');
			}
			if(!empty($_POST['email']))
				$myUser->setEmail(strtolower($_POST['email']));

			if(empty($_POST['username']) )
				$error[] = getTrans('LANG_ERROR_MANAGER_NOVALUE');
			elseif( UserManager::getUserByUsername($_POST['username']) != NULL )
				$error[] = getTrans('LANG_ERROR_MANAGER_INUSE');
			if(!empty($_POST['username']))
				$myUser->setUsername($_POST['username']);

			if(empty($_POST['password']) )
				$error[] = getTrans('LANG_ERROR_PASSWORD_NOVALUE');
			elseif(  strlen($_POST['password']) < 5){
				$error[] = getTrans('LANG_ERROR_PASSWORD_TOSHORT');
			}
			else
			{
				$myUser->setPassword(md5($_POST['password']));
				if(!empty($_POST['password']) AND $_POST['password'] != $_POST['password2'] )
					$error[] = getTrans('LANG_ERROR_PASSWORD_VALID');
			}

			if( !isset($_SESSION['captcha']['register']) )
				if( empty($_POST['captcha']) )
					$error[] = getTrans('LANG_ERROR_CAPTCHA_NOVALUE');
				elseif( !isset($_POST['captcha']) OR $_SESSION['captcha_spam'] != strtoupper($_POST['captcha']) )
					$error[] = getTrans('LANG_ERROR_CAPTCHA_VALID');
				else
					$_SESSION['captcha'] = array( 'register' => true );

			if(empty($error))
			{
				try
				{
					UserManager::saveOnly($myUser);
					UserManager::sendActivationMail($myUser, GLOBAL_REGISTER_DOUBLEOPTIN);
					DBConnection::commit();

					$success = true;
					$_SESSION['captcha_spam'] = null;
					unset($_SESSION['captcha']['register']); // catcha flag resetten

					// login user
					WebsiteManager::setUser($myUser);

					return WebsiteManager::doRedirect('/');

				}catch (Exception $e){
					throw $e;
				}
			}
		}

		$this->Layout()->assign('errorlist', $error);
		$this->Layout()->assign('success', $success);
		$this->Layout()->assign('user', $myUser);
		$this->Layout()->show();
	}

	public function logout()
	{
		return WebsiteManager::logout();
	}

	public function login()
	{
		// translations
		WebsiteManager::loadTranslation('login');

		$error = array();
		if( $this->getPost('password') AND ( $this->getPost('username') OR $this->getPost('email') ) )
		{
			$username = $this->getPost('username') ?  $this->getPost('username') : $this->getPost('email');
			$password = $this->getPost('password');

			$myUser = UserManager::getUserByLoginAndPassword($username, $password);
			if( $myUser AND ( $myUser->getStatusname() == 'enabled' OR $myUser->getStatusname() == 'inactive' ) )
			{
				WebsiteManager::setUser($myUser);
				//self::setLanguage($myUser->getLanguageiso2()); // einstellung vom User verwenden
				WebsiteManager::doRedirect('/');
			}

			if( !$myUser )
				$error[] = getTrans('LANG_LOGIN_ACCOUNT_NOT_EXISTS');
			if( $myUser AND $myUser->getStatusname() == 'disabled' )
				$error[] = getTrans('LANG_LOGIN_ACCOUNT_DISABLED');
		}

		// view
		$this->Layout()->load('user/login');
		$this->Layout()->assign('errorlist', $error);
		$this->Layout()->show();
	}

	public function password()
	{
		// translations
		WebsiteManager::loadTranslation('login');

		// view
		$this->Layout()->load('user/password');
		$this->Layout()->assign('title', 'title test');
		$this->Layout()->show();
	}

	public function activation()
	{
		if( $this->getInput('id') AND $this->getInput('hash') )
		{
			Library::requireLibrary(LibraryKeys::APPLICATION_USER());

			$myUser = UserManager::getUserByUserid( (int) $this->getInput('id') );
			if( isset($myUser) AND $myUser->getStatusname() == 'registered' AND $this->getInput('hash') == md5('1aT+'.$myUser->getUserid().$myUser->getEmail().'+!a') )
			{
				$myUser->setStatusname('enabled');
				$myUser->setTstampConfirmed(time());
				UserManager::saveOnly($myUser);

				// login
				WebsiteManager::setUser($myUser);

				WebsiteManager::doRedirect('/User/Menu');
			}
		}

		// redirect to main
		WebsiteManager::doRedirect('/');
	}

	public function profil()
	{
		// translations
		WebsiteManager::loadTranslation('user');

		// view
		$this->Layout()->load('user/profil');
		$this->Layout()->show();
	}

}