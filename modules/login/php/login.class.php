<?php
declare(strict_types = 1);
/**
 * @version 	PHP 8.0.7
 * @author 		Customizacion-WoW
 * @author 		TrinityTools
 * @author 		Programas-TrinityCore
 * @link 		Facebook:	https://www.facebook.com/damian.vanhoffer
 * @link 		Facebook:	https://www.facebook.com/customizacionwow
 * @link 		Facebook:	https://www.facebook.com/customizacionwow2
 * @link 		YouTube:	https://www.youtube.com/channel/UC5QW4tPVSyUTPkmQcatmrdQ
 * @copyright	Copyright © 2015 - 2021 - Todos los derechos reservados.
 **/
session_start();
class Login{

	private $MySQL;

	public function __construct(){
		if(!class_exists("DBC")){
			include("$_SERVER[DOCUMENT_ROOT]/server/connect.class.php");
		}
		$this -> MySQL = DBC::Connect();
		$this -> MySQL -> select_db(Config::GetData("DBAuth"));
	}

	/**
	 * Inicia sesion con el cifrado SHA1 (Anterior TrinityCore)
	 * 
	 * @since 		(PHP 4 >= 4.3.0, PHP 5, PHP 7, PHP 8)
	 * @deprecated  Desde 2017
	 * @param 		string $user = Usuario de la cuenta
	 * @param 		string $pass = Contraseña de la cuenta
	 * @return 		boolean true (si es correcto) o false en caso contrario
	 * **/
	public function SHA_PASS_HASH(string $user, string $pass) : bool{
		$hash = $this -> password = sha1(strtoupper("$user:$pass"));
		$SQL = "SELECT `id`, `username`, `email`, `joindate`, `last_ip`, `last_attempt_ip`, `locked`, `last_login`, `online`, `expansion` FROM `account` WHERE `username` = ? && `sha_pass_hash` = ?";
		$prepare = $this -> MySQL -> prepare($SQL);
		$prepare -> bind_param("ss", $user, $hash);
		$prepare -> execute();
		$prepare -> bind_result($id, $username, $email, $joindate, $last_ip, $last_attempt_ip, $locked, $last_login, $online, $expansion);
		$prepare -> fetch();
		if($username){
			$_SESSION['ID']				= $id;
			$_SESSION['USERNAME']		= $username;
			$_SESSION['EMAIL']			= $email;
			$_SESSION['JOIN_DATE']		= $joindate;
			$_SESSION['LAST_IP']		= $last_ip;
			$_SESSION['LAST_ATTEMP_IP']	= $last_attempt_ip;
			$_SESSION['LOCKED']			= $locked;
			$_SESSION['LAST_LOGIN']		= $last_login;
			$_SESSION['ONLINE']			= $online;
			$_SESSION['EXPANSION']		= $expansion;
		}
		return $username ? true : false;
	}

	/**
	 * Inicia sesion con el cifrado SRP6 (Actual TrinityCore & AzerothCore)
	 * 
	 * @param 		string $username = Usuario de la cuenta
	 * @param 		string $password = Contraseña de la cuenta
	 * @return 		boolean true (si es correcto) o false en caso contrario
	 * **/
	public function SRP6(string $username, string $password) : bool {
		$AccData = $this -> GetAccountData(strtoupper($username));
		if(count($AccData) <= 0) { return false; }
		$verifier = $this -> SRP6Verifier($username, $password, $AccData["salt"]);
		return ($verifier === $AccData["verifier"]);
	}

	/**
	 * Obtiene la salt y verifier con los datos de la cuenta dada
	 * 
	 * @return   Array (salt, verifier) o array ()
	 **/
	private function GetAccountData(string $username) : array {
		$SQL = "SELECT `salt`, `verifier` FROM `account` WHERE `username` = ?";
		$prepare = $this -> MySQL -> prepare($SQL);
		$prepare -> bind_param("s", $username);
		$prepare -> execute();
		$prepare -> bind_result($salt, $verifier);
		$prepare -> fetch();
		$prepare -> free_result();
		return $salt ? array("salt" => $salt, "verifier" => $verifier) : array();
	}

	/**
	 * Convierte la informacion dada en cifrado SRP6
	 * @see 	gmp_init function
	 * @since   (PHP 4 >= 4.0.4, PHP 5, PHP 7, PHP 8)
	 * @param 	string $username = Usuario de cuenta
	 * @param 	string $password = Contraseña de cuenta
	 * @param 	string $salt 	 = random_bytes(32)
	 * @return  string Verifier
	 **/
	private function SRP6Verifier(string $username, string $password, string $salt) : string {
		$g = gmp_init(7);
		$N = gmp_init('894B645E89E1535BBDAD5B8B290650530801B18EBFBF5E8FAB3C82872A3E9BB7', 16);
		$h1 = sha1(strtoupper("$username:$password"), TRUE);
		$h2 = sha1($salt.$h1, TRUE);
		$h2 = gmp_import($h2, 1, GMP_LSW_FIRST);
		$verifier = gmp_powm($g, $h2, $N);
		$verifier = gmp_export($verifier, 1, GMP_LSW_FIRST);
		$verifier = str_pad($verifier, 32, chr(0), STR_PAD_RIGHT);
		return $verifier;
	}

	/**
	 * Cierra la conexion al servidor
	 **/
	public function close() : void{
		$this -> MySQL -> close();
	}

}
?>