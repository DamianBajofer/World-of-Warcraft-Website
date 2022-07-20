<?php
@session_start();
if(!class_exists("Config")){
	include($_SERVER["DOCUMENT_ROOT"]."/server/config.class.php");
}
if(!class_exists("Forums")){
	include($_SERVER["DOCUMENT_ROOT"]."/forums/php/models/Forum.class.php");
}
if(!isset($_SESSION["USERNAME"])){
	return false;
}
$__DIR = Config::$SiteData["Domain"];
extract($_POST);
$Threads = $Forum -> GetThreads($section, $order);
if($Threads){
	for($a = 0; $a < count($Threads); $a++){
		$id = $Threads[$a]["id"];
		$title = $Threads[$a]["title"];
		$icon = $Threads[$a]["icon"];
		$author = $Threads[$a]["author"];
		$date = $Threads[$a]["date"];
		$views = $Threads[$a]["views"];
		$answers = $Threads[$a]["answers"];
		if($icon){
			$icon = "<div class='icon' style='background-image:url($__DIR/forums/images/icons/$icon);'></div>";
		}else{
			$icon = "";
		}
		echo "
		<table class='thread' id='$id' onclick=window.location.href=window.location.origin+'/forums/thread/'+id+'/';>
			<td width='49.6%' align='left'>$icon$title</td>
			<td width='0.1%' align='center'></td>
			<td width='15%' align='center'>$author</td>
			<td width='0.1%' align='center'></td>
			<td width='15%' align='center'>$date</td>
			<td width='0.1%' align='center'></td>
			<td width='10%' align='center'>$views</td>
			<td width='0.1%' align='center'></td>
			<td width='10%' align='center'>$answers</td>
		</table>";
	}
}
?>