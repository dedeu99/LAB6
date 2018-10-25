<?php

header('Content-Type: text/html; charset=utf-8');
require_once "HTML/Template/IT.php";


$name=$_GET['name'];
$email=$_GET['email'];
$error=$_GET['error'];

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

	case 6:
		$message="name must only contain letters and numbers";
	break;

	case 7:
		$message="Please fill in your email";
	break;

	case 8:
		$message="Please fill in your password";
	break;

	case 9:
		$message="Please fill in your password confirmation";
	break;

	case 10:
		$i=$_GET['chars'];
		$message="Your password must be at least $i characters long";
	break;

	case 11:
		$message="Name is already in use.Please choose a diferent one";
	break;

	default:
	$template->setVariable('MESSAGE_HIDDEN',"hidden");

}
$template->setVariable('MESSAGE', $message);
$template->parseCurrentBlock();

$template->show();
?>