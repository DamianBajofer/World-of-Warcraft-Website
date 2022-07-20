<?php
session_start();
if(!class_exists("TopMenu")){
	include($_SERVER["DOCUMENT_ROOT"]."/modules/TopMenu/php/menu.class.php");
}
$topmenu = new TopMenu();
echo json_encode($topmenu -> GetItems(array(isset($_SESSION["USERNAME"]), 2)));
?>