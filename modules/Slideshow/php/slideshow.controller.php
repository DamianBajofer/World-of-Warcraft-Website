<?php
if(!class_exists("Slideshow")){
	include($_SERVER["DOCUMENT_ROOT"]."/modules/Slideshow/php/slideshow.class.php");
}
$slides = new Slideshow();
echo json_encode($slides -> GetImages());
?>