<?php
header('Content-Type: text/html; charset=utf-8');
include 'db.php';
session_start();
if(!isset($_SESSION['name']) || !isset($_SESSION['id'])){
	header("Location: login.php");
	die();
}


if(isset($_SESSION['postid']){
	$userid=$_SESSION['id'];
	$content=$_POST['message'];



	$db = dbconnect($hostname,$db_name,$db_user,$db_passwd);


	$query = "UPDATE microposts SET content=$content WHERE id=$_SESSION['postid'] AND user_id=$userid";

	$result = @ mysql_query($query,$db );


	unset($_SESSION['postid']);
}
//$nrows = mysql_num_rows($result); 
header("Location:index.php");
?>