<?php
class ServerInfo{

	private $MySQL, $ERROR_MESSAGE;
	private $SERVER = array("REALMS" => array(), "MJS" => array());

	public function __construct(){
		if(!class_exists("DBC")){
			include("$_SERVER[DOCUMENT_ROOT]/server/connect.class.php");
		}
		$this -> MySQL = DBC::Connect();
	}

	public function GetAccounts(){
		if(!$this -> MySQL -> select_db(Config::GetData("DBAuth"))){
			$this -> ERROR_MESSAGE = "ERROR AL CAMBIAR DE BASE DE DATOS.";
			return false;
		}
		$this -> SQL = "SELECT COUNT(*) FROM `account`";
		$this -> Prepare = $this -> MySQL -> prepare($this -> SQL);
		$this -> Prepare -> execute();
		$this -> Result = $this -> Prepare -> get_result() -> fetch_row()[0];
		$this -> SERVER["TOTAL_ACCOUNTS"] = $this -> Result;
		$this -> Prepare -> free_result();
		return $this -> SERVER["TOTAL_ACCOUNTS"];
	}

	public function GetCharacters(){
		if(!$this -> MySQL -> select_db(Config::GetData("DBChar"))){
			$this -> ERROR_MESSAGE = "ERROR AL CAMBIAR DE BASE DE DATOS.";
			return false;
		}
		$this -> SQL = "SELECT COUNT(*) FROM `characters`";
		$this -> Prepare = $this -> MySQL -> prepare($this -> SQL);
		$this -> Prepare -> execute();
		$this -> Result = $this -> Prepare -> get_result() -> fetch_row()[0];
		$this -> SERVER["TOTAL_CHARACTERS"] = $this -> Result;
		$this -> Prepare -> free_result();
		return $this -> SERVER["TOTAL_CHARACTERS"];
	}

	public function GetOnlineCharacters(){
		if(!$this -> MySQL -> select_db(Config::GetData("DBChar"))){
			$this -> ERROR_MESSAGE = "ERROR AL CAMBIAR DE BASE DE DATOS.";
			return false;
		}
		$online = 1;
		$this -> SQL = "SELECT COUNT(*) FROM `characters` WHERE `online` = ?";
		$this -> Prepare = $this -> MySQL -> prepare($this -> SQL);
		$this -> Prepare -> bind_param("i", $online);
		$this -> Prepare -> execute();
		$this -> Result = $this -> Prepare -> get_result() -> fetch_row()[0];
		$this -> SERVER["TOTAL_ONLINE"] = $this -> Result;
		$this -> Prepare -> free_result();
		unset($online);
		return $this -> SERVER["TOTAL_ONLINE"];
	}

	public function GetGMS(){
		if(!$this -> MySQL -> select_db(Config::GetData("DBAuth"))){
			$this -> ERROR_MESSAGE = "ERROR AL CAMBIAR DE BASE DE DATOS.";
			return false;
		}
		$this -> SQL = "SELECT `id`, `gmlevel` FROM `account_access`";
		$this -> Prepare = $this -> MySQL -> prepare($this -> SQL);
		$this -> Prepare -> execute();
		$this -> Prepare -> bind_result($GMID, $GMLEVEL);
		$this -> Prepare -> store_result();
		$this -> SERVER["MJS"]["ONLINE"] = 0;
		$this -> SERVER["MJS"]["TOTAL"] = 0;
		for($i = 0; $i < $this -> Prepare -> num_rows; $i++){
			$ID;
			$LEVEL;
			while($this -> Prepare -> fetch()){
				$ID 	= $GMID;
				$LEVEL  = $GMLEVEL;
			}
			array_push($this -> SERVER["MJS"], array("ID" => $ID, "GMLEVEL" => $LEVEL));
			$this -> SERVER["MJS"]["TOTAL"] += 1;
			$this -> GetOnlineGMS($ID, 1);
		}
		$this -> Prepare -> free_result();
		return $this -> SERVER["MJS"];
	}

	private function GetOnlineGMS($AccountID, $online){
		if(!$this -> MySQL -> select_db(Config::GetData("DBChar"))){
			$this -> ERROR_MESSAGE = "ERROR AL CAMBIAR DE BASE DE DATOS.";
			return false;
		}
		$this -> SQL = "SELECT COUNT(*) FROM `characters` WHERE `account` = ? && `online` = ?";
		$this -> Prepare = $this -> MySQL -> prepare($this -> SQL);
		$this -> Prepare -> bind_param("ii", $AccountID, $online);
		$this -> Prepare -> execute();
		$this -> Result = $this -> Prepare -> get_result() -> fetch_row()[0];
		if($this -> Result){
			$this -> SERVER["MJS"]["ONLINE"] += 1;
		}
		$this -> Prepare -> free_result();
	}

	public function close(){
		$this -> MySQL -> close();
	}

}
?>