<?php


	header('Content-Type: text/html; charset=utf-8');
	require_once "HTML/Template/IT.php";
	session_set_cookie_params(0);
	session_start();

	if(isset($_SESSION['name']) && isset($_SESSION['id'])){
		header("Location: index.php");
		die();
	}


	$email=$_GET['email'];
	
	$template = new HTML_Template_IT('.'); 
	$template->loadTemplatefile('login_template.html',true, true); 

	$template->setCurrentBlock("LOGINFORM");




	$template->setVariable('EMAIL', $email);

	$template->setVariable('MESSAGE_HIDDEN',"");
	$message="";


	if(isset($_SESSION['error'])){
			
		switch($_SESSION['error']){
			case 1:
				$message="Incorrect Password";
			break;
			
			case 2:
				$message="Email does not exist in the database";
			break;

			default:
			$template->setVariable('MESSAGE_HIDDEN',"hidden");

		}
	}
	$template->setVariable('MESSAGE', $message);
	$template->parseCurrentBlock();

	$template->show();

?>