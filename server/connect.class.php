<?php
if(!class_exists("Config")){
	include("$_SERVER[DOCUMENT_ROOT]/server/config.class.php");
}
class DBC{

	private static $MySQL;
	private static $Date = "";

	public static function Connect(){
		self::$MySQL = @new mysqli(Config::GetData("Host"), Config::GetData("User"), Config::GetData("Pass"));
		if(self::$MySQL -> connect_errno){
			throw new Exception("Error al conectar con el servidor ", 1);
		}
		return self::$MySQL;
	}

	public static function GetDate($dates, $separator){
		for($i = 0; $i < count($dates); $i++){
			self::$Date .= date($dates[$i])."$separator";
		}
		self::$Date = substr(self::$Date, 0, strlen(self::$Date)-1);
		return self::$Date;
	}

	public static function GetIP(){
		if(isset($_SERVER["HTTP_CLIENT_IP"])){
		 	return $_SERVER["HTTP_CLIENT_IP"];
		}else if(isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
		 	return $_SERVER["HTTP_X_FORWARDED_FOR"];
		}else if(isset($_SERVER["HTTP_X_FORWARDED"])){
		 	return $_SERVER["HTTP_X_FORWARDED"];
		}else if(isset($_SERVER["HTTP_FORWARDED_FOR"])){
			 return $_SERVER["HTTP_FORWARDED_FOR"];
		}else if(isset($_SERVER["HTTP_FORWARDED"])){
		 	return $_SERVER["HTTP_FORWARDED"];
		}else{
			return $_SERVER["REMOTE_ADDR"];
		}
	}

}
?>