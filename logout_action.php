<?php

session_start();


header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: private, no-store, max-age=0, no-cache, must-revalidate, post-check=0, pre-check=0");
//header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Connection: close");
header('Refresh: 5; url=index.php');

require_once "HTML/Template/IT.php";



$template = new HTML_Template_IT('.'); 
$template->loadTemplatefile('message_template.html',true, true); 

$template->setCurrentBlock("SUCESSFORM");





/*
echo $referer.PHP_EOL;
echo "-----".PHP_EOL;
print_r($domain);

echo PHP_EOL.basename($domain[path]).PHP_EOL*/
if(isset($_SESSION['id']) || isset($_SESSION['name'])) {

	session_destroy();
	$_SESSION = array();

	$template->setVariable('MSGBACKGROUND', 'success' );
	$name=$_GET['name'];
	$template->setVariable('MESSAGE',"User $name has logged out sucessfully");
	unset($_COOKIE['rememberMe']);
    setcookie('rememberMe', '', time() - 3600, '/'); 
}
else{
	$template->setVariable('MSGBACKGROUND', 'danger' );
	$template->setVariable('MESSAGE',"You are not supposed to be here.");
}




$template->parseCurrentBlock();

$template->show();




?>