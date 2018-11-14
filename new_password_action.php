<?php

require_once "HTML/Template/IT.php";
session_start();

if(isset($_SESSION['name']) && isset($_SESSION['id'])){
	header("Location: index.php");
	die();
}
include 'db.php';
$min_password_length = 7;

if(strlen($_POST['password'])<=0){
	$_SESSION['error']=3;
	header("Location: new_password.php".(isset($_POST['token'])?"?token=".$_POST['token']:""));
	die();
}

if(strlen($_POST['password'])<$min_password_length){
	$_SESSION['error']=5;
	header("Location: new_password.php?chars=$min_password_length".(isset($_POST['token'])?"&&token=".$_POST['token']:""));
	die();
}
if(strlen($_POST['passwordConfirmation'])<=0){
	$_SESSION['error']=4;
	header("Location: new_password.php".(isset($_POST['token'])?"?token=".$_POST['token']:""));
	die();
}


if(strcmp($_POST['password'],$_POST['passwordConfirmation'])!=0){
	$_SESSION['error']=2;
	header("Location: new_password.php".(isset($_POST['token'])?"?token=".$_POST['token']:""));
	die();
}



//verifica se o token recebido existe na base de dados
$db = dbconnect($hostname,$db_name,$db_user,$db_passwd);
$token=$_POST['token'];
$query = "SELECT email,reset_sent_at FROM users WHERE reset_digest=\"$token\"";
$result = @ mysql_query($query,$db );
$nrows = mysql_num_rows($result); 
if($nrows>0){
/*• em caso de sucesso e se não passou mais de uma hora entre a hora
actual e a hora de envio do email*/
	$tuple = mysql_fetch_array($result,MYSQL_ASSOC);
	$reset_at = $tuple['reset_sent_at'];
	
	$seconds = time()-strtotime($reset_at) ;

	$password=hash('sha512',$_POST['password']);
	$email=$tuple['email'];

	if($seconds<60*60){//LESS THAN 1 HOUR
		//o encripta e actualiza a password na base de dados		
		$query = "UPDATE users SET password_digest=\"$password\",reset_digest=NULL, reset_sent_at=NULL WHERE email=\"$email\"";
		$result = @ mysql_query($query,$db );
		
		if($result)//o faz redirect para message.php?code=2*/
			header("Location:  message.php?code=2");
		else
			header("Location:  message.php?code=-1");
	}else	
		header("Location:  message.php?code=3");//TOKEN EXPIRED
	
	
		
}else //• em caso de insucesso
	header("Location:  message.php?code=3");//WRONG TOKEN



?>