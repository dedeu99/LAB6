<?php
	session_start();
	$email=$_POST['email'];
	$password=$_POST['password'];



	$template = new HTML_Template_IT('.'); 
	$template->loadTemplatefile('login_template.html',true, true); 

	$template->setCurrentBlock("LOGINFORM");

	// ligação à base de dados
$db = dbconnect($hostname,$db_name,$db_user,$db_passwd);
// criar query numa string
$query = "SELECT id,name,password FROM users WHERE email='$email'";


//echo "<script type='text/javascript'>alert('SELECT count(*) FROM users WHERE email=\'".$email."\'');</script>";
// executar a query
$result = @mysql_query($query,$db); 
//var_dump($result);

$nrows = mysql_num_rows($result); 

if(nrows>0){

 	$tuple = mysql_fetch_array($result,MYSQL_ASSOC);
 	if(strcmp(hash('sha512',$password),$tuple['password'])==0){
 		
 		$_SESSION['id']=$tuple['id'];
 		$_SESSION['name']=$tuple['name'];
 		header("Location:index.php");
 	}else
 	{
 		$_SESSION['error']='1';
 		header("Location:login.php?email=$email");
 	}
}else
{
	$_SESSION['error']='2';
	header("Location:login.php?email=$email");
}



	$template->setVariable('EMAIL', $email);

	$template->setVariable('MESSAGE_HIDDEN',"");
	$message="";

	switch($error){
		case 1:
			$message="Please fill in your name";
		break;
		
		case 2:
			$message="Please insert a valid email";
		break;

		case 3:
			$message="Please make sure your password is filled and the confirmation matches";
		break;

		case 4:
			$message="Database error, couldn't create a new user. Please try again later";
		break;

		case 5:
			$message="Email is already in use. Please check the email used and, if it really is yours, recover your password";
		break;

		default:
		$template->setVariable('MESSAGE_HIDDEN',"hidden");

	}
	$template->setVariable('MESSAGE', $message);
	$template->parseCurrentBlock();

	$template->show();

?>