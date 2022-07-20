<?php
if(!class_exists("Social")){
	include("social.class.php");
}
$social = new Social();
$social = $social -> GetLinks();
foreach($social as $k => $v){
	$template = file_get_contents("$_SERVER[DOCUMENT_ROOT]/modules/Social/templates/social.tpl");
	$template = str_replace("{MODULE}", "modules/Social", $template);
	$template = str_replace("{ICON}", $v["ICON"], $template);
	$template = str_replace("{LINK}", $v["LINK"], $template);
	$template = str_replace("{NAME}", $v["NAME"], $template);
	echo $template;
}
unset($social);
?>