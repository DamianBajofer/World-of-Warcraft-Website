<?php
@session_start();
if(!class_exists("Forums")){
	include($_SERVER["DOCUMENT_ROOT"]."/forums/php/models/Forum.class.php");
}
if(!isset($_SESSION["USERNAME"])){
	return false;
}
$ForumCategories = $Forum -> GetCategories();
if($ForumCategories){
	for($a = 0; $a < count($ForumCategories); $a++){
		echo "
		<div id='".$ForumCategories[$a]["id"]."' class='category'>
			<div class='title'>".$ForumCategories[$a]["name"]."</div>
			<div class='sections'>";
		$ForumSections = $Forum -> GetSections($ForumCategories[$a]["id"]);
		for($b = 0; $b < count($ForumSections); $b++){
			$SectionID = $ForumSections[$b]["id"];
			$SectionOrder = $ForumSections[$b]["order"];
			$style = "background-image:url(images/".$ForumSections[$b]["image"].");";
				echo "
				<div id='$SectionID/$SectionOrder' class='section' style='$style'>
					<div class='name'>".$ForumSections[$b]["name"]."</div>
					<div class='description'>".$ForumSections[$b]["description"]."</div>
				</div>";
		}
		echo "</div></div>";
	}
}
?>