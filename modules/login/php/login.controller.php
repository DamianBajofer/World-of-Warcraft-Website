<?php
if(!class_exists("Login")){
	include("login.class.php");
}
$login = new Login();
if(Config::$CoreCodified == 1){
	echo $login -> SHA_PASS_HASH($_POST["login_username"], $_POST["login_password"]);
}else{
	echo $login -> SRP6($_POST["login_username"], $_POST["login_password"]);
}

$login -> close();

?>