<?php

header('Content-Type: text/html; charset=utf-8');

require_once "HTML/Template/IT.php";
include 'db.php';
session_start(); 


// Cria um novo objecto template
$template = new HTML_Template_IT('.'); 
$loggedin=false;
 
if(isset($_SESSION['name']) && isset($_SESSION['id'])){
	$loggedin= true;
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





// ligação à base de dados
$db = dbconnect($hostname,$db_name,$db_user,$db_passwd);
 // criar query numa string
 $query = "SELECT * FROM microposts ORDER BY created_at DESC";
 // executar a query
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
	// Faz o parse do bloco FILMES
 	$template->parseCurrentBlock();
} // end for
// Mostra a tabela 

  // Mostra a tabela
  $template->show();
 // fecha a ligação à base de dados
 mysql_close($db);
?>

