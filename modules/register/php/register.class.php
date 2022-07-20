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
class Register{

	public function __construct(){
		if(!class_exists("DBC")){ include("$_SERVER[DOCUMENT_ROOT]/server/connect.class.php"); }
		$this -> MySQL = DBC::Connect();
		$this -> MySQL -> select_db(Config::GetData("DBAuth"));
	}

	/**
	 * Registra un nuevo usuario con cifrado SHA1
	 * para versiones anteriores de TrinityCore y AzerothCore
	 * 
	 * @since 		(PHP 4 >= 4.3.0, PHP 5, PHP 7, PHP 8)
	 * @deprecated  Desde 2017
	 * @param 		string $user = Usuario de la cuenta
	 * @param 		string $pass = Contraseña de la cuenta
	 * @return 		string response = Mensaje de exito o error
	 * **/
	public function SHA_PASS_HASH(string $username, string $password, string $email) : string {
		if($this -> ExistsData($username, $email)){
			return "Usuario o correo en uso.";
		}
		$password = strtoupper(sha1("$username:$password"));
		$SQL = "INSERT INTO `account`(`username`,`sha_pass_hash`,`email`) VALUES(?,?,?)";
		$prepare = $this -> MySQL -> prepare($SQL);
		$prepare -> bind_param("sss", $username, $password, $email);
		$prepare -> execute();
		return $prepare -> affected_rows ? "Registro exitoso!" : "Algo salio mal!";
	}

	/**
	 * Registra un nuevo usuario con cifrado SRP6 (Actual TrinityCore & AzerothCore)
	 * 
	 * @param 		string $username = Usuario de la cuenta
	 * @param 		string $password = Contraseña de la cuenta
	 * @return 		boolean true (si es correcto) o false en caso contrario
	 * **/
	public function SRP6(string $username, string $password, string $email) : string {
		if($this -> ExistsData($username, $email)){
			return "Usuario o correo en uso.";
		}
		$AccountData = $this -> GetRegisterData($username, $password);
		$SQL = "INSERT INTO `account`(`username`,`salt`,`verifier`,`email`) VALUES(?,?,?,?)";
		$prepare = $this -> MySQL -> prepare($SQL);
		$prepare -> bind_param("ssss", $username, $AccountData["salt"], $AccountData["verifier"], $email);
		$prepare -> execute();
		return $prepare -> affected_rows ? "Registro exitoso!" : "Algo salio mal!";
	}

	/**
	 * Comprueba la existencia de un usuario o correo
	 * 
	 * @param  string $username = Nombre de usuario
	 * @param  string $email    = Correo electronico
	 * @return boolean true (si existe) o false en caso contrario
	 **/
	private function ExistsData(string $username, string $email) : bool {
		$SQL = "SELECT `username`, `email` FROM `account` WHERE `username` = ? || `email` = ?";
		$prepare = $this -> MySQL -> prepare($SQL);
		$prepare -> bind_param("ss", $username, $email);
		$prepare -> execute();
		$prepare -> store_result();
		return $prepare -> num_rows ? true : false;
	}

	/**
	 * Obtiene la salt y verifier con los datos del formulario
	 * 
	 * @see      random_bytes function
	 * @since 	 (PHP 7, PHP 8)
	 * @return   Array (salt, verifier)
	 **/
	private function GetRegisterData(string $username, string $password) : array {
		$salt = random_bytes(32);
		$verifier = $this -> SRP6Verifier($username, $password, $salt);
		return array("salt" => $salt, "verifier" => $verifier);
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
}