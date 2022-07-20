<?php
/**
 * Obtener todos los modulos principales para el sistema de
 * selector de paginas
 **/
$Page = @$_GET["page"] ? $_GET["page"] : "news";
$Page = strtoupper($Page);
$Exists = false;
for($i = 0; $i < count($list["LEFT"]); $i++){
	if(strtoupper($list["LEFT"][$i]["name"]) === $Page){
		$Exists = true;
		if(file_exists($list["LEFT"][$i]["path"])){
			include($list["LEFT"][$i]["path"]);
		}else{
			echo "El modulo ".$list["LEFT"][$i]["name"]." no existe o esta dañado.";
		}
	}
}
if(!$Exists){
	include("$_SERVER[DOCUMENT_ROOT]/modules/PageError/index.php");
}
?>