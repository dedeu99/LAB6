<?php

include 'db.php';
$name=$_POST['name'];
$email=$_POST['email'];
$password=$_POST['password'];
$password2=$_POST['passwordConfirmation'];

$min_password_length=7;


if(strlen($name)<=0) {
	header("Location: register.php?error=1&email=$email");//ERROR1 BAD NAME
	die();
}
if(!ctype_alnum($name)) {
	header("Location: register.php?error=6&email=$email");//ERROR6
	die();
}






if(strlen($email)<=0 ) {
	header("Location: register.php?error=7&name=$name");//ERROR7
	die();
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	header("Location: register.php?error=2&name=$name&email=$email");//ERROR2 BAD EMAIL
	die();
}

$db = dbconnect($hostname,$db_name,$db_user,$db_passwd);
$query = "SELECT email FROM users WHERE email='$email'";
$result = @mysql_query($query,$db); 
$nrows = mysql_num_rows($result); 
	
if($nrows!=0){
	header("Location:register.php?error=5&name=$name&email=$email");//ERROR5 EMAIL ALREADY IN USE
	die();
}






if(strlen($password)<=0){
	header("Location: register.php?error=8&name=$name&email=$email");//ERROR8
	die();
}

if(strlen($password)<$min_password_length){
	header("Location: register.php?error=10&name=$name&email=$email&chars=$min_password_length");//ERROR10
	die();
}

if(strlen($password2)<=0){
	header("Location: register.php?error=9&name=$name&email=$email");//ERROR9
	die();
}


if(strcmp($password,$password2)!=0){
	header("Location: register.php?error=3&name=$name&email=$email");//ERROR3 BAD PASSWORDCONFIRMATION
	die();
}




$query = "INSERT INTO users (name,email,created_at,updated_at,password_digest,remember_digest,admin) VALUES ('$name','$email',NOW(),NOW(),'$password','$password2',0)";	
$result=@mysql_query($query,$db);

if($result)
	header("Location: register_success.php?name=$name"); 
else
	header("Location:register.php?error=4&name=$name&email=$email");//ERROR4 COULDN'T UPDATE THE DATABASE TRY AGAIN

?>