<?php
#ä
abstract class CronjobBaseClass
{

	protected $pid = 0;
	protected $mode = 'shell';
	protected $basepath = '';
	protected $debugmode = false;
	protected $log_file_path = './obm_cronjob_log.txt';

	protected $timer;

	protected final function timerStart()
	{
		$this->timer = microtime(true);
	}

	protected final function timerStop()
	{
		$this->timer = microtime(true) - $this->timer;
		$this->showLine('[ Total Time: ' . round($this->timer, 4) . ' sec. ]');
	}

	protected final function start()
	{
		$this->timerStart();

		file_put_contents($this->log_file_path, date('Y-m-d H:i:s') . "\r\n");

		// generate pid
		$this->pid = rand(1000, 9999);

		// set mode - http or shell
		if (isset($_SERVER['DOCUMENT_ROOT']) AND !isset($_SERVER['PWD'])) {
			$this->mode = 'http';
			$this->basepath = $_SERVER['DOCUMENT_ROOT'];
		} else {
			$this->basepath = $_SERVER['PWD'];
		}
		$this->showLine('<hr>Cronjob started!<hr>');
	}


	protected final function stop()
	{
		$this->showLine('<hr>Cronjob stopped!<hr>');
		$this->timerStop();
	}

	protected final function finish()
	{
		$this->showLine('<hr>Cronjob finished!<hr>');
		$this->timerStop();
	}

	protected final function getDuration()
	{
		return $this->timer;
	}

	/**
	 * print line to shell whitout html tags OR show html line on http
	 * @param string $line
	 */
	protected final function showLine($line)
	{
		if ($this->mode == 'shell') {
			$line = preg_replace('/(<\/?)(\w+)([^>]*>)/e', '', $line);
			$line = str_replace(array("\r\n", '<br>'), array(''), $line);
		}
		print $line . "\r\n";

		// differenz seit start
		$time = ' ( Diff '.round(microtime(true) - $this->timer, 4).' sec )';
		file_put_contents($this->log_file_path, $line . $time . "\n", FILE_APPEND);
	}

	/**
	 * extended http flush
	 */
	protected final function flush()
	{
		if ($this->mode != 'http')
			return true;
		$this->showLine((str_repeat(' ', 256)));
		// check that buffer is actually set before flushing
		if (ob_get_length()) {
			@ob_flush();
			@flush();
			@ob_end_flush();
		}
		@ob_start();
	}
}
