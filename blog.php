<?php

header('Content-Type: text/html; charset=utf-8');

require_once "HTML/Template/IT.php";
include 'db.php';
session_start(); 

 
if(!isset($_SESSION['name']) || !isset($_SESSION['id'])){
	header("Location: login.php");
	die();
}
$userid=$_SESSION['id'];
unset($_SESSION['postid']);


$db = dbconnect($hostname,$db_name,$db_user,$db_passwd);

$message="";
$action="newblog_action.php";

if(isset($_GET['POST_ID'])){
	$action="updateblog_action.php";
	$postid=$_GET['POST_ID'];
	$query = "SELECT content FROM microposts WHERE id=$postid";
	$result = @ mysql_query($query,$db );
	$nrows = mysql_num_rows($result); 
	if($nrows>0){
		$tuple = mysql_fetch_array($result,MYSQL_ASSOC);
		$message =  $tuple['content'] ;
		$_SESSION['postid']=$postid;
	}
}

$template = new HTML_Template_IT('.'); 
$template->loadTemplatefile('blog_template.html',true, true); 

$template->setVariable('USERNAME',$_SESSION['name']);

if(file_exists ( "img/user$userid.jpg" ))
	$template->setVariable('USER_ID',$userid);
else
	$template->setVariable('USER_ID',"");


$template->setVariable('MESSAGE',$message);
$template->setVariable('ACTION',$action);



 
$template->show();
mysql_close($db);
?>

