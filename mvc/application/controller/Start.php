<?php
#ä
// example controller
class StartController extends Controller
{

	public function index()
	{
		$this->Layout()->load('start/partial');
		$partial = $this->Layout()->show(true); // return as string

		$this->Layout()->load('start/index');
		//$this->Layout()->assign('partial', $partial);
		
		$this->Layout()->assign('text', 'Hello World!');
		$this->Layout()->show();
	}

	public function error_404()
	{
		header("Status: 404 Not Found");
		header('HTTP/1.0 404 Not Found');

		$this->Layout()->load('start/error_404');
		$this->Layout()->show();
	}

	public function captcha()
	{
		include_once GLOBAL_ASSETS . 'captcha.php';
		exit();
	}

	public function register()
	{
		$this->Layout()->load('start/register');
		$this->Layout()->show();
	}

	public function password()
	{
		$this->Layout()->load('start/password');
		$this->Layout()->show();
	}

}