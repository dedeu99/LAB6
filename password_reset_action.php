<?php

require_once "HTML/Template/IT.php";
session_start();

if(isset($_SESSION['name']) && isset($_SESSION['id'])){
	header("Location: index.php");
	die();
}
include 'db.php';

$email=$_POST['email'];

$db = dbconnect($hostname,$db_name,$db_user,$db_passwd);
$query = "SELECT email FROM users WHERE email=$email";
$result = @ mysql_query($query,$db );
$nrows = mysql_num_rows($result); 
if($nrows>0){


}
else{
	$_SESSION['error']=3;
	header("Location: password_reset.php?email=$email");

}


?>