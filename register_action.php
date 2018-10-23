<?php

include 'db.php';
$name=$_POST['name'];
$email=$_POST['email'];
$password=$_POST['password'];
$password2=$_POST['passwordConfirmation'];


/*echo "<script type='text/javascript'>alert('password:".$password.":');</script>";
echo "<script type='text/javascript'>alert('password2:".$password2.":');</script>";
echo "<script type='text/javascript'>alert('email:".$email.":');</script>";
echo "<script type='text/javascript'>alert('empty(password):".empty($password).":');</script>";
echo "<script type='text/javascript'>alert('empty(password2):".empty($password2).":');</script>";
echo "<script type='text/javascript'>alert('strcmp(password,password2):".strcmp($password,$password2).":');</script>";
*/


if(strlen($name)<=0) {
	header("Location: register.php?error=1&email=$email");//ERROR1 BAD NAME
}else
if(strlen($email)<=0 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
	header("Location: register.php?error=2&name=$name&email=$email");//ERROR2 BAD EMAIL
}else
if(strlen($password)<=0 || strlen($password2)<=0 || strcmp($password,$password2)!=0)
	header("Location: register.php?error=3&name=$name&email=$email");//ERROR3 BAD PASSWORDCONFIRMATION
else{
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////CHECK FOR PASSWORD LENGTH



	//header("Location: register_success.html"); //TO REMOVE




// ligação à base de dados
$db = dbconnect($hostname,$db_name,$db_user,$db_passwd);
// criar query numa string
$query = "SELECT email FROM users WHERE email='$email'";

//echo "<script type='text/javascript'>alert('SELECT count(*) FROM users WHERE email=\'".$email."\'');</script>";
// executar a query
$result = @mysql_query($query,$db); 
//var_dump($result);
$nrows = mysql_num_rows($result); 
	
if($nrows==0)
{
	$query = "INSERT INTO users (name,email,created_at,updated_at,password_digest,remember_digest,admin) VALUES ('$name','$email',NOW(),NOW(),'$password','$password2',0)";	
	$result=@mysql_query($query,$db);

	if($result)
		header("Location: register_success.php"); 
	else
		header("Location:register.php?error=4&name=$name&email=$email");//ERROR4 COULDN'T UPDATE THE DATABASE TRY AGAIN
}else
	header("Location:register.php?error=5&name=$name&email=$email");//ERROR5 EMAIL ALREADY IN USE


//header("Location:register.php?error=1&name=".$name."&email=".$email);

}
?>