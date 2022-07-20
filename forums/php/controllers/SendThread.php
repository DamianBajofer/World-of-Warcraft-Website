<?php
session_start();
if(!class_exists("Forums")){
	include($_SERVER["DOCUMENT_ROOT"]."/forums/php/models/Forum.class.php");
}
if(!isset($_SESSION["USERNAME"])){
	return false;
}
extract($_POST);
$ForumAccessLevel = $Forum -> GetForumRank($category, $section);
$content = str_replace("<", "&#60;", $content);
$content = str_replace(">", "&#62;", $content);
$request = $Forum -> SendThread($icon, $title, $content, $_SESSION["USERNAME"], $category, $section);
echo $request;
?>