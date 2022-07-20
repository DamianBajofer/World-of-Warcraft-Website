<?php
if(!class_exists("Modules")){ include("$_SERVER[DOCUMENT_ROOT]/server/modules.class.php"); }
$modules = new Modules();
$list = $modules -> GetModules();
$index = 1;
foreach($list["LEFT"] as $key => $value){
	if(file_exists($value["path"])){
		include($value["path"]);
	}else{
		$px = $index."vmin";
		echo "<div id='module-error' style='top:$px;'>El modulo <span style='color:#ffa100;'>$value[name]</span> no existe o esta dañado, verifique su existencia o estado en la ubicacion: <span style='color:rgba(255,255,255,0.8);'>$value[path]</span></div>";
	}
	$index += 8;
}
?>