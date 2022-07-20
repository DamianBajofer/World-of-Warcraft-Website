<?php
class Social{

	private $MySQL, $SOCIAL = array();

	public function __construct(){
		if(!class_exists("DBC")){
			include("$_SERVER[DOCUMENT_ROOT]/server/connect.class.php");
		}
		$this -> MySQL = DBC::Connect();
		$this -> MySQL -> select_db(Config::GetData("DBWebsite"));
	}

	public function GetLinks(){
		$this -> SQL = "SELECT `icon`,`link`,`name` FROM `social` ORDER BY(`order`) ASC";
		$this -> Prepare = $this -> MySQL -> prepare($this -> SQL);
		$this -> Prepare -> execute();
		$this -> Prepare -> bind_result($icon, $link, $name);
		while($this -> Prepare -> fetch()){
			array_push($this -> SOCIAL, array("ICON" => $icon, "LINK" => $link, "NAME" => $name));
		}
		$this -> Prepare -> free_result();
		$this -> MySQL -> close();
		return $this -> SOCIAL;
	}

}
?>