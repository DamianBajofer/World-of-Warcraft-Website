<?php
if(!class_exists("News")){
	include($_SERVER["DOCUMENT_ROOT"]."/modules/News/php/news.class.php");
}
$news = new News();
echo $news -> GetNews();
?>