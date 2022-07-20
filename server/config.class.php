<?php
declare(strict_types = 1);
class Config{
	
	/**
	 * Establece el tipo de cifrado que utiliza tu servidor
	 * 
	 * @param int 1 = SHA_PASS_HASH  (SHA1) @deprecated at 2017
	 * @param int 2 = SALT, VERIFIER (SRP6) @see (https://github.com/TrinityCore/TrinityCore/issues/25157)
	 **/
	public static $CoreCodified = 1;

	/**
	 * Configuracion del servidor MySQL
	 * 
	 * @param string Host 		= (local) localhost / 127.0.0.1 || (remoto) IP de tu VPS
	 * @param string Port 		= Puerto del servidor MySQL
	 * @param string User 		= Usuario de MySQL
	 * @param string Pass 		= Password de MySQL
	 * @param string DBAuth 	= Base de datos auth o realm
	 * @param string DBChar 	= Base de datos characters
	 * @param string DBWorld 	= Base de datos world
	 **/
	private static $MySQLData = array(
		"Host" => "127.0.0.1",
		"Port" => "3306",
		"User" => "root",
		"Pass" => "",
		"DBAuth" => "auth",
		"DBChar" => "characters",
		"DBWorld" => "world",
		"DBWebsite" => "webwow"
	);
	/**
	 * Configuracion basica del sitio web
	 * 
	 * @param string Domain 		= Dominio de tu sitio web EJ: http://MiSitioWebWoW.com/
	 * @param string Name 			= Nombre de tu sitio web ¿como se llama?
	 * @param string Title 			= Titulo que aparece en tu sitio web y en la pestaña del navegador
	 * @param string Description 	= Descripcion de tu sitio web, cuentales que tipo de servidor es
	 * @param string Keywords 		= Etiquetas que serviran para encontrar tu sitio web EJ: Server 3.3.5, Instant 80 custom, etc
	 * @param string Copyright 		= Copyright que aparece en el pie de pagina (footer)
	 * @param string LimitPlayers 	= Limite de jugadores por reino
	 **/
	public static $SiteData = array(
		"Domain" => "http://localapps.com",
		"Name" => "Mi Server WoW",
		"Title" => "Customizacion-WoW | 3.3.5a Custom Server",
		"Description" => "Servidor wow 3.3.5 instant 80 semi custom!",
		"Keywords" => "servidor custom, 3.3.5a, instant 80 custom, Mi Server WoW",
		"Copyright" => "customizacion-wow &copy; 2015 - 2021",
		"LimitPlayers" => 500
	);

	public static function GetData(string $data) : string{
		return self::$MySQLData[$data];
	}
}
?>