<?php
include_once '/home/workspace/webglobal/tools.php';
include_once 'class.MailqueueAPI.php';

// start from curl [post]
if(isset($_REQUEST['mailbody']) AND isset($_REQUEST['recipient'])){
	echo MailqueueAPI::sendMailqueueFromCurlSession($_REQUEST['mailbody'], $_REQUEST['recipient']);
}
?>