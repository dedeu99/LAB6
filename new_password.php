<?php


	header('Content-Type: text/html; charset=utf-8');
	require_once "HTML/Template/IT.php";
	session_start();

	if(isset($_SESSION['name']) && isset($_SESSION['id'])){
		header("Location: index.php");
		die();
	}


	
	$template = new HTML_Template_IT('.'); 
	$template->loadTemplatefile('new_password_template.html',true, true); 

	$template->setCurrentBlock("PWRESETFORM");




	$template->setVariable('TOKEN', $_GET['token']);

	$template->setVariable('MESSAGE_HIDDEN',"");
	$message="";


	if(isset($_SESSION['error'])){
			
		switch($_SESSION['error']){
			case 1:
				$message="ERROR: WRONG TOKEN OR TOKEN EXPIRED, PASSWORD RESET FAILED!";
			break;
			
			case 2:
				$message="Password confirmation does not match password";
			break;

			case 3:
				$message="Please fill in your password";
			break;

			case 4:
				$message="Please fill in your password confirmation";
			break;

			case 5:
				$i=$_GET['chars'];
				$message="Your password must be at least $i characters long";
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