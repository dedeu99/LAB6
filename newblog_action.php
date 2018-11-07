<?php
header('Content-Type: text/html; charset=utf-8');
include 'db.php';
session_start();
if(!isset($_SESSION['name']) || !isset($_SESSION['id'])){
	header("Location: login.php");
	die();
}

$userid=$_SESSION['id'];
$content=$_POST['message'];


$db = dbconnect($hostname,$db_name,$db_user,$db_passwd);
$query = "INSERT INTO microposts  (content,user_id,created_at,updated_at) VALUES (\"$content\",$userid, NOW(),NOW())";

$result = @ mysql_query($query,$db );
//$nrows = mysql_num_rows($result); 
header("Location:index.php");
?>