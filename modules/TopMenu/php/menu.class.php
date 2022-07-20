<?php
class TopMenu{

	private $MySQL;
	private $SQL, $Prepare;
	private $Items = array();

	public function __CONSTRUCT(){
		if(!class_exists("DBC")){
			include($_SERVER["DOCUMENT_ROOT"]."/server/connect.class.php");
		}
		$this -> MySQL = DBC::Connect();
	}

	public function GetItems($status){
		$this -> MySQL -> select_db(Config::GetData("DBWebsite"));
		$this -> SQL = "SELECT `name`, `link`  FROM `top_menu` WHERE `status` = ? || `status` = ? ORDER BY(`id`) ASC";
		$this -> Prepare = $this -> MySQL -> prepare($this -> SQL);
		$this -> Prepare -> bind_param("ii", $status[0], $status[1]);
		$this -> Prepare -> execute();
		$this -> Prepare -> bind_result($name, $link);
		while($this -> Prepare -> fetch()){
			array_push($this -> Items, array("name" => $name, "link" => $link));
		}
		$this -> Prepare -> free_result();
		$this -> MySQL -> close();
		return $this -> Items;
	}

}
?>