<?php
@session_start();
if(!class_exists("Forums")){
	include($_SERVER["DOCUMENT_ROOT"]."/forums/php/models/Forum.class.php");
}
if(!isset($_SESSION["USERNAME"])){
	return false;
}
extract($_GET);
if($Forum -> GetForumRank($section, $order)){
	echo "<div id='new-thread-button' onclick=forum.NewThread($section+'/'+$order);>NUEVO HILO</div>";
}
?>