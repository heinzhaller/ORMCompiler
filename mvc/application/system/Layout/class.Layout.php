<?php
#ä

class Layout
{
	protected $view_modus = 'full';
	protected $language = 'de'; // default
	protected $assign_list = array();

	protected $layout = 'indexmain';
	public $view = 'start/index';

	public function __construct()
	{

	}

	private function _parse()
	{
		$view = GLOBAL_VIEWS . $this->view . '.php';
		if(!file_exists($view))
			throw new Exception('View not exists: '.$view);

		$cachefile = GLOBAL_CACHE . $this->_hash() . '.php';
		#if( file_exists($cachefile) AND time() - filemtime($cachefile) < 86400 )
		#	return false;

		$myView = file_get_contents( $view );

		// replace foreach
		$regexp_foreach = '/({foreach [a-z0-9]+ as [a-z0-9]+ \=\> [a-z0-9]+}.*{[a-z0-9\(\)\.]+}+.*{\/foreach})+/is';
		$hits = array();
		preg_match($regexp_foreach, $myView, $hits);
		foreach( $hits as $html )
		{
			$foreach_block = $html;
			$foreach_block = preg_replace('/\{foreach ([a-z0-9]+) as ([a-z0-9]+) \=\> ([a-z0-9]+)\}/i', '<? if(!empty($data[\'\1\'])) foreach( $data[\'\1\'] as $\2 => $\3 ){ ?>', $foreach_block);
			$foreach_block = preg_replace('/\{\/foreach\}/', '<? } ?>', $foreach_block);
			$foreach_block = preg_replace('/{(\w+) ([\=\<\>\!]+) (.+) \? ([\'\w.*]+) \: ([\'\w]+)}/i', '<?=( $\1 \2 \3 ? \4 : \5 )?>', $foreach_block);
			$foreach_block = preg_replace('/{(\w+)\.([\w]+) ([\=\<\>\!]+) (.+) \? ([\'\w]+) \: ([\'\w]+)}/i', '<?=( $\1->get\2() \3 \4 ? \5 : \6 )?>', $foreach_block);
			/*$foreach_block = preg_replace('/{(\w+)\.([\w]+) ([\=\<\>\!]+) (\w+)\.(\w+) \? ([\'\w]+) \: ([\'\w]+)}/i', '<?=( $\1->get\2() \3 $\4->get\5() ? \6 : \7 )?>', $foreach_block);*/
			$foreach_block = preg_replace('/\{([a-z0-9]+)\}/i', '<?=$\1?>', $foreach_block);
			$foreach_block = preg_replace('/\{([a-z0-9]+\()?([\w]+)\.([\w]+)(\))?\}/i', '<?=\1$\2->get'.'\3'.'()\4?>', $foreach_block);
			$foreach_block = preg_replace('/{(\w+)\.(\w+) ([\=\<\>\!]+) (\w+) \? (\w+) \: (\w+)}/i', '<?=( $\1->get'.'\2'.'() \3 \4 ? \5 : \6 )?>', $foreach_block);

			// if
			$foreach_block = preg_replace('/\{if ([\!a-z0-9]+\()?([a-z0-9]+)(\))?\}/i', '<? if ( \1$data\2()\3 ){ ?>', $foreach_block);

			//
			$foreach_block = preg_replace('/ ([\w]+)\.([\w]+) /i', ' $data[\'\1\']->get\2() ', $foreach_block);

			$myView = preg_replace($regexp_foreach, $foreach_block, $myView, 1);
		}

		// if statement
		$myView = preg_replace('/\{if ([\!a-z0-9]+\()?([a-z0-9]+)(\))?\}/i', '<? if ( \1$data[\'\2\']\3 ){ ?>', $myView);

		/*$myView = preg_replace('/\{if ([\!a-z0-9\(\)]+)\}/i', '<? if ( $\1){ ?>', $myView);*/
		$myView = preg_replace('/\{\/if}/i', '<? } ?>', $myView);
		$myView = preg_replace('/\{else}/i', '<? } else { ?>', $myView);

		// vars
		foreach($this->assign_list as $placeholder => $assign)
		{
			if( is_array($assign) OR is_object($assign) )
				continue;

			$myView = preg_replace('/\{'.$placeholder.'\}/i', '<?=\''.$assign.'\';?>', $myView);
		}
		$myView = preg_replace('/\{([\w]+)\}/i', '', $myView); // raus mit dem rest
		$myView = preg_replace('/\{([\w]+)\.([\w]+)}/i', '<?=$data[\'\1\']->get'.'\2'.'()?>', $myView);

		// save parsed template
		file_put_contents( $cachefile, $myView);
	}

	private function _read()
	{
		ob_start();
		$data = $this->assign_list;
		include GLOBAL_CACHE . $this->_hash(). '.php';
		return ob_get_clean();
	}

	private function _hash()
	{
		//return md5( serialize($this->assign_list) . $this->view . md5(file_get_contents(GLOBAL_VIEWS . $this->view . '.php')) );
		return md5( serialize($this->view) );
	}

	public function load($view, $layout = 'indexmain' )
	{
		$this->view = $view;
		$this->layout = $layout;
		return $this;
	}

	public function assign($placeholder, $value)
	{
		$this->assign_list[$placeholder] = $value;
		return $this;
	}

	public function show($return = false)
	{
		$this->_parse();
		$output = $this->_read();

		if( $return )
			return $output;

		// show full
		include_once GLOBAL_VIEWS . $this->layout . '.php';
	}

}