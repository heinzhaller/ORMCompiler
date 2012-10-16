<?php
#ä

$dir_iterator = new RecursiveDirectoryIterator(ORMCOMPILER_PATH.'/Abstraction/');
$iterator = new RecursiveIteratorIterator($dir_iterator, RecursiveIteratorIterator::SELF_FIRST);
foreach ($iterator as $file) {
	if(preg_match('/class\.([A-z]+)\.php$/ui', $file->getFilename()))
    require_once $file->getPath().'/'.$file->getFilename();
}

$dir_iterator = new RecursiveDirectoryIterator(ORMCOMPILER_PATH.'/Builder/');
$iterator = new RecursiveIteratorIterator($dir_iterator, RecursiveIteratorIterator::SELF_FIRST);
foreach ($iterator as $file) {
	if(preg_match('/class\.([A-z]+)\.php$/ui', $file->getFilename()))
    require_once $file->getPath().'/'.$file->getFilename();
}

$dir_iterator = new RecursiveDirectoryIterator(ORMCOMPILER_PATH.'/DBClasses/');
$iterator = new RecursiveIteratorIterator($dir_iterator, RecursiveIteratorIterator::SELF_FIRST);
foreach ($iterator as $file) {
	if(preg_match('/class\.([A-z]+)\.php$/ui', $file->getFilename()))
    require_once $file->getPath().'/'.$file->getFilename();
}


class ORMBase {
	
	const DB_DRIVER_MYSQL = 'mysql';
	const DB_DRIVER_ORACLE = 'oracle';
	
}
?>