<?php


require_once "HTML/Template/IT.php";
session_start();

if(isset($_SESSION['name']) && isset($_SESSION['id'])){
	header("Location: index.php");
	die();
}



include 'db.php';

$email=$_POST['email'];
/*
$db = dbconnect($hostname,$db_name,$db_user,$db_passwd);
$query = "SELECT email FROM users WHERE email=$email";
$result = @ mysql_query($query,$db );
$nrows = mysql_num_rows($result); 
if($nrows>0){


}

header("Location: password_reset.php");
die();*/


$template = new HTML_Template_IT('.'); 
$template->loadTemplatefile('login_template.html',true, true); 

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
}
$template->setVariable('MESSAGE', $message);


$template->parseCurrentBlock();

$template->show();


?>