<?php
if(!class_exists("DBC")){ include("$_SERVER[DOCUMENT_ROOT]/server/connect.class.php"); }
class Modules{

	private $MODULES = array("TOP" => array(), "LEFT" => array(), "RIGHT" => array());

	// Obtiene todos los modulos a utilizar.
	public function GetModules(){
		$mysql = DBC::Connect();
		$mysql -> select_db(Config::GetData("DBWebsite"));
		$SQL = "SELECT * FROM `modules` ORDER BY(`order`) ASC";
		$Prepare = $mysql -> prepare($SQL);
		$Prepare -> execute();
		$Prepare -> bind_result($id, $name, $position, $visible, $order);
		while($Prepare -> fetch()){
			if ($visible == "OFFLINE") { $visible = 0; }
			if ($visible == "ONLINE")  { $visible = 1; }
			if ($visible == "ALL")     { $visible = 2; }
			array_push($this -> MODULES[$position], array(
				"id" => $id,
				"name" => $name,
				"path" => "$_SERVER[DOCUMENT_ROOT]/modules/$name/index.php",
				"position" => $position,
				"visible" => $visible,
				"order" => $order
			));
		}
		$Prepare -> free_result();
		$mysql -> close();
		return $this -> MODULES;
	}

}
?>