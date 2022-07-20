<?php
if(!class_exists("ServerInfo")){
	include("server.class.php");
}

$ServerInfo = new ServerInfo();
$TotalAccounts = $ServerInfo -> GetAccounts();
$TotalCharacters = $ServerInfo -> GetCharacters();
$OnlineCharacters = $ServerInfo -> GetOnlineCharacters();
$GMS = $ServerInfo -> GetGMS();

$template = file_get_contents("$_SERVER[DOCUMENT_ROOT]/modules/ServerInfo/templates/ServerInfo.tpl");
$template = str_replace("{CREATED_ACCOUNTS}", $TotalAccounts, $template);
$template = str_replace("{CREATED_CHARS}", $TotalCharacters, $template);
$template = str_replace("{ONLINE_CHARS}", $OnlineCharacters, $template);
$template = str_replace("{GAME_MASTERS}", $GMS["TOTAL"], $template);
$template = str_replace("{ONLINE_MJS}", $GMS["ONLINE"], $template);
echo $template;
$ServerInfo -> close();
unset($template, $ServerInfo);
?>