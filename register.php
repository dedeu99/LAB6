<?php

header('Content-Type: text/html; charset=utf-8');
require_once "HTML/Template/IT.php";


$name=$_GET['name'];
$email=$_GET['email'];
$error=$_GET['error'];
//{MESSAGE_HIDDEN}

// Cria um novo objecto template
$template = new HTML_Template_IT('.'); 
$template->loadTemplatefile('register_template.html',true, true); 

$template->setCurrentBlock("REGISTERFORM");

$template->setVariable('NAME', $name );
$template->setVariable('EMAIL', $email);

$template->setVariable('MESSAGE_HIDDEN',"");
$message="";

switch($error){
	case 1:
		$message="Please fill in your name";
	break;
	
	case 2:
		$message="Please insert a valid email";
	break;

	case 3:
		$message="Please make sure your password is filled and the confirmation matches";
	break;

	case 4:
		$message="Database error, couldn't create a new user. Please try again later";
	break;

	case 5:
		$message="Email is already in use. Please check the email used and, if it really is yours, recover your password";
	break;

	default:
	$template->setVariable('MESSAGE_HIDDEN',"hidden");

}
$template->setVariable('MESSAGE', $message);
$template->parseCurrentBlock();

$template->show();
?>