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
$query = "SELECT name FROM users WHERE email=\"$email\"";
$result = @ mysql_query($query,$db );
$nrows = mysql_num_rows($result); 
if($nrows>0){
	$reset_digest = substr(md5(time()),0,32);
	$name=tuple['name'];
	$query = "UPDATE users SET reset_digest=$reset_digest, reset_sent_at=$reset_digest WHERE email=\"$email\"";

	$msg="Olá Sr.(a) $name
Para obter uma nova password clique no link

http://all.deei.fct.ualg.pt/~a62362/Lab8/new_password.php?token=$reset_digest

Este link tem a validade de uma hora.
Se NÃO pediu uma nova password IGNORE este email.


Cumprimentos,
webmaster!
Página Web: http://intranet.deei.fct.ualg.pt/~a62362/Lab8/
E-mail: a62362@deei.fct.ualg.pt
NOTA: Não responda a este email, não vai obter resposta!";
	mail($email,"Password Reset",$msg);
	header("Location:  message.php?code=1");

}
else{
	$_SESSION['error']=3;
	header("Location: password_reset.php");
}


?>