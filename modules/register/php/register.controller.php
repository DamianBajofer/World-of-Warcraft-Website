<?php
if(!class_exists("Register")){
	include("register.class.php");
}
$register = new Register();
extract($_POST);
if(Config::$CoreCodified == 1){
	echo $register -> SHA_PASS_HASH(strtoupper($register_username), $register_password, $register_email);
}else{
	echo $register -> SRP6(strtoupper($register_username), $register_password, $register_email);
}