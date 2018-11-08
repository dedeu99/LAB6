<?php
session_start();
include 'db.php';
session_start();

if(isset($_SESSION['name']) && isset($_SESSION['id'])){
	header("Location: index.php");
	die();
}
$email=$_POST['email'];
$password=hash('sha512',$_POST['password']);



$db = dbconnect($hostname,$db_name,$db_user,$db_passwd);


$query = "SELECT id,name,password_digest FROM users WHERE email='$email'";



$result = mysql_query($query,$db); 


$nrows = mysql_num_rows($result); 
if($nrows>0){
 	$tuple = mysql_fetch_array($result,MYSQL_ASSOC);
 	if(strcmp($password,$tuple['password_digest'])==0){
 		
 		$_SESSION['id']=$tuple['id'];
 		$_SESSION['name']=$tuple['name'];


 		if(isset($_POST['autologin'])){
			$query = "INSERT INTO users (remember_digest)VALUES (substr(md5(time()),0,32))";
			$result = mysql_query($query,$db); 
			setcookie("rememberMe", substr(md5(time()),0,32), time() + (3600 * 24 * 30), "/"); 
 		}else{
    		unset($_COOKIE['rememberMe']);
    		setcookie('rememberMe', '', time() - 3600, '/');
		}




 		header("Location:index.php?autologin=".isset($_POST['autologin']));
 	}else
 	{
 		$_SESSION['error']=1;
 		header("Location:login.php?email=$email");
 	}
}else
{
	$_SESSION['error']=2;
	header("Location:login.php?email=$email");
}

?>