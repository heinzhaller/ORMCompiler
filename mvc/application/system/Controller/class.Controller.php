<?php
#ä
class Controller
{

	private $layout;

	/**
	 * @param \Layout $layout
	 * @return \Layout
	 */
	public function setLayout($layout)
	{
		$this->layout = $layout;
		return $this;
	}

	/**
	 * @return \Layout
	 */
	public function Layout()
	{
		return $this->layout;
	}

	public function getInput($name)
	{
		return ( !empty($_GET[$name]) ? $_GET[$name] : null );
	}

	public function getPost($name)
	{
		return ( !empty($_POST[$name]) ? $_POST[$name] : null );
	}

	public function hasPost()
	{
		return !empty($_POST);
	}

	public function __construct()
	{
		// Übersetzungen laden - für aktuelle Seite
		WebsiteManager::loadTranslation(WebsiteManager::getLayer() . '_' . WebsiteManager::getPage());

		// init new layout
		$this->layout = new Layout();
	}

}