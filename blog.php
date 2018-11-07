<?php

header('Content-Type: text/html; charset=utf-8');

require_once "HTML/Template/IT.php";
include 'db.php';
session_start(); 

 
if(!isset($_SESSION['name']) || !isset($_SESSION['id'])){
	header("Location: login.php");
	die();
}



$db = dbconnect($hostname,$db_name,$db_user,$db_passwd);

$message="";
if(isset($_POST['POST_ID'])){
	$postid=$_POST['POST_ID'];
	$query = "SELECT * FROM microposts WHERE ID=$postid";
	$result = @ mysql_query($query,$db );
	$nrows = mysql_num_rows($result); 
	if($nrows>0){
		$tuple = mysql_fetch_array($result,MYSQL_ASSOC);
		$message =  $tuple['content'] ;
	}
	for($i=0; $i<$nrows; $i++) {	 	
		$query = "SELECT name FROM users where id=".$tuple['user_id'];
		$result2 = @mysql_query($query,$db ); 
		$tuple2 = mysql_fetch_array($result2,MYSQL_ASSOC);
		message= $_POST['MESSAGE'];
	}
}
$template->setVariable('USERNAME',$_SESSION['name']);

if(file_exists ( "img/user$_SESSION['id'].jpg" ))
	$template->setVariable('USER_ID',"$_SESSION['id']");
else
	$template->setVariable('USER_ID',"");


$template->setVariable('MESSAGE',$message);
$template->setVariable('ACTION',$message);



 
$template->show();
mysql_close($db);
?>

