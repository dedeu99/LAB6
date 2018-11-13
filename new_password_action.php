<?php

require_once "HTML/Template/IT.php";
session_start();

if(isset($_SESSION['name']) && isset($_SESSION['id'])){
	header("Location: index.php");
	die();
}
include 'db.php';
$min_password_length = 7;
$password=$_POST['password'];
if(strlen($password)<=0){
	$_SESSION['error']=3;
	header("Location: new_password.php");
	die();
}

if(strlen($password)<$min_password_length){
	$_SESSION['error']=5;
	header("Location: new_password.php?chars=$min_password_length");
	die();
}
$password2=$_POST['passwordConfirmation'];
if(strlen($password2)<=0){
	$_SESSION['error']=4;
	header("Location: new_password.php");
	die();
}


if(strcmp($password,$password2)!=0){
	$_SESSION['error']=2;
	header("Location: new_password.php");
	die();
}



//verifica se o token recebido existe na base de dados
$db = dbconnect($hostname,$db_name,$db_user,$db_passwd);
$token=$_POST['token'];
$query = "SELECT * FROM users WHERE reset_digest=\"$token\"";
$result = @ mysql_query($query,$db );
$nrows = mysql_num_rows($result); 
if($nrows>0){
/*• em caso de sucesso e se não passou mais de uma hora entre a hora
actual e a hora de envio do email*/
	$tuple = mysql_fetch_array($result,MYSQL_ASSOC);
	$reset_at = tuple['reset_at'];
	echo(time());

	echo(time($reset_at));


//o encripta e actualiza a password na base de dados

	
	
	

//o faz redirect para message.php?code=2*/
	header("Location:  message.php?code=2");
}else
//• em caso de insucesso
	header("Location:  message.php?code=3");












?>