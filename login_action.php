<?php
//FALTA VERIFICAR PASSWORD VAZIA OU NAO

include 'db.php';
	$email=$_POST['email'];
	$password=hash('sha512',$_POST['password']);



	// ligação à base de dados
$db = dbconnect($hostname,$db_name,$db_user,$db_passwd);
// criar query numa string
$query = "SELECT id,name,password_digest FROM users WHERE email='$email'";


//echo "<script type='text/javascript'>alert('SELECT count(*) FROM users WHERE email=\'".$email."\'');</script>";
// executar a query
$result = mysql_query($query,$db); 
//var_dump($result);

$nrows = mysql_num_rows($result); 
if($nrows>0){
 	$tuple = mysql_fetch_array($result,MYSQL_ASSOC);
 	if(strcmp($password,$tuple['password_digest'])==0){
 		
 		$_SESSION['id']=$tuple['id'];
 		$_SESSION['name']=$tuple['name'];
 		header("Location:index.php");
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