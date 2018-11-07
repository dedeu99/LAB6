<?php

header('Content-Type: text/html; charset=utf-8');

require_once "HTML/Template/IT.php";
include 'db.php';
session_start(); 







// Cria um novo objecto template
$template = new HTML_Template_IT('.'); 
$loggedin=false;
$db = dbconnect($hostname,$db_name,$db_user,$db_passwd); 
if(isset($_SESSION['name']) && isset($_SESSION['id'])){
	$loggedin= true;
}else if(isset($_COOKIE["rememberMe"])) {
	
	$cookie=$_COOKIE["rememberMe"];
	$query = "SELECT id,name FROM users WHERE remember_digest=$cookie";
	$result = @mysql_query($query,$db);
	$nrows = mysql_num_rows($result);
	if($nrows>0){
		$loggedin= true;
		$tuple = mysql_fetch_array($result,MYSQL_ASSOC);
		$_SESSION['name']=$tuple['name'];
		$_SESSION['id']=$tuple['id'];
	} 
}else{
    unset($_COOKIE['rememberMe']);
    setcookie('rememberMe', '', time() - 3600, '/'); // empty value and old timestamp
}

// Carrega o template Filmes2_TemplateIT.tpl
$template->loadTemplatefile('index_template.html',true, true); 

$template->setVariable('hidden',$loggedin?'':'hidden');
$template->setVariable('hidden2',$loggedin?'hidden':'');
$template->setVariable('USERNAME',$loggedin?$_SESSION['name']:'');
if(file_exists ( "img/user$userid.jpg" ))
	$template->setVariable('USER_ID',$userid);
else
	$template->setVariable('USER_ID',"");





 $query = "SELECT * FROM microposts ORDER BY created_at DESC";
 $result = @ mysql_query($query,$db );
$nrows = mysql_num_rows($result); 
for($i=0; $i<$nrows; $i++) {
 	$tuple = mysql_fetch_array($result,MYSQL_ASSOC);

	$query = "SELECT name FROM users where id=".$tuple['user_id'];
	$result2 = @mysql_query($query,$db ); 
	$tuple2 = mysql_fetch_array($result2,MYSQL_ASSOC);
	// This is in the PHP file and sends a Javascript alert to the client
	$message =  $tuple2['name'] ;
	//echo "<script type='text/javascript'>alert('$message');</script>";
 	// trabalha com o bloco FILMES do template
 	$template->setCurrentBlock("POSTS");

 	if($_SESSION['id']==$tuple['user_id']){
 		$template->setVariable('UPDATEHIDDEN', '');
 		$template->setVariable('MICROID',$tuple[id]);
 	}else
 	{
 		$template->setVariable('UPDATEHIDDEN', 'hidden');
 		$template->setVariable('MICROID','-1');
 	}



 	$template->setVariable('USER', $tuple2['name'] );

 	if(file_exists ( "img/user$userid.jpg" ))
		$template->setVariable('USER_ID',$userid);
	else
		$template->setVariable('USER_ID',"");

 	$template->setVariable('UPDATED', $tuple['updated_at']);
 	$template->setVariable('CREATED', $tuple['created_at']);
	$template->setVariable('MICROPOST', $tuple['content']);
	
 	$template->parseCurrentBlock();
} 
$template->show();

mysql_close($db);
?>

