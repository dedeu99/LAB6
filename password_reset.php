<?php


require_once "HTML/Template/IT.php";
session_start();

if(isset($_SESSION['name']) && isset($_SESSION['id'])){
	header("Location: index.php");
	die();
}



$email=$_POST['email'];


$template = new HTML_Template_IT('.'); 
$template->loadTemplatefile('password_reset_template.html',true, true); 

$template->setCurrentBlock("RESETFORM");




$template->setVariable('EMAIL', $email);

$template->setVariable('MESSAGE_HIDDEN',"");
$message="";


if(isset($_SESSION['error'])){
		
	switch($_SESSION['error']){
		case 3:
			$message="Error: email does not exist";
		break;
		
		default:
		$template->setVariable('MESSAGE_HIDDEN',"hidden");

	}
	unset($_SESSION['error']);
}
$template->setVariable('MESSAGE', $message);


$template->parseCurrentBlock();

$template->show();


?>