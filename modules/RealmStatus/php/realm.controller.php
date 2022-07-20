<?php
if(!class_exists("RealmStatus")){
	include($_SERVER["DOCUMENT_ROOT"]."/modules/RealmStatus/php/realm.class.php");
}

$realm = new RealmStatus();
$realms = $realm -> GetRealms();

?>