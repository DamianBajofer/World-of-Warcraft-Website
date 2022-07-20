<?php
if(!class_exists("Config")){
	include("$_SERVER[DOCUMENT_ROOT]/server/config.class.php");
}
class Slideshow extends Config{

	private $MySQL;
	private $SQL, $Prepare, $Result;
	private $images = array();

	public function __CONSTRUCT(){
		if(!class_exists("DBC")){
			include("$_SERVER[DOCUMENT_ROOT]/server/connect.class.php");
		}
		$this -> MySQL = DBC::Connect();
		$this -> MySQL -> select_db(Config::GetData("DBWebsite"));
	}

	public function GetImages(){
		$this -> SQL = "SELECT `image` FROM `slideshow` ORDER BY(`id`) ASC";
		$this -> Prepare = $this -> MySQL -> prepare($this -> SQL);
		$this -> Prepare -> execute();
		$this -> Prepare -> bind_result($image);
		while($this -> Prepare -> fetch()){
			array_push($this -> images, "modules/Slideshow/images/$image");
		}
		$this -> Prepare -> free_result();
		$this -> MySQL -> close();
		return $this -> images;
	}

}
?>