<?php
if(!class_exists("Forums")){
	include($_SERVER["DOCUMENT_ROOT"]."/forums/php/models/Forum.class.php");
}
$ForumName = $Forum -> GetForumName($_GET["section"],$_GET["order"]);
$Domain = Config::$SiteData["Domain"];
$Name = Config::$SiteData["Name"];
if($ForumName){
	echo "
	<div id='direction'>
		<div class='dir1'><a href='$Domain'>$Name</a> <span class='right-arrow'>»</span> <a href='$Domain/forums/'>Forums</a> <span class='right-arrow'>»</span> <a href='$Domain/forums/forum/".$_GET["section"]."/".$_GET["order"]."'>$ForumName</a></div>
		<div class='dir2'> · Hablando sobre $ForumName</div>
	</div>";
}
?>