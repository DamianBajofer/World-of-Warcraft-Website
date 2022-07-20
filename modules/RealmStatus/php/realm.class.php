<?php
class RealmStatus{

	private $MySQL;
	private $SQL, $Prepare, $Result;
	private $Data = array();
	private $AcctIds = array(array(), array());

	public function __CONSTRUCT(){
		if(!class_exists("DBC")){
			include($_SERVER["DOCUMENT_ROOT"]."/server/connect.class.php");
		}
		$this -> MySQL = DBC::Connect();
		$this -> MySQL -> select_db(Config::GetData("DBAuth"));
	}

	public function GetRealms(){
		$this -> SQL = "SELECT `id`, `name`, `address` FROM `realmlist` ORDER BY(`id`) ASC";
		$this -> Prepare = $this -> MySQL -> prepare($this -> SQL);
		$this -> Prepare -> execute();
		$this -> Prepare -> bind_result($id, $name, $address);
		while($this -> Prepare -> fetch()){
			array_push($this -> Data, array(
				"id" => $id,
				"name" => $name,
				"address" => $address,
				"accounts" => 0,
				"characters" => array("alliances" => 0, "hordes" => 0, "total" => 0),
				"onlines" => array("alliances" => 0, "hordes" => 0)
			));
		}
		$this -> GetAcctsPerRealm();
		$this -> GetOnlineChars();
		$this -> Prepare -> free_result();
		$this -> MySQL -> close();
		return $this -> Data;
	}

	private function GetAcctsPerRealm(){
		for($i = 0; $i < count($this -> Data); $i++){
			$sql = "SELECT `numchars`, `acctid` FROM `realmcharacters` WHERE `realmid` = ?";
			$prepare = $this -> MySQL -> prepare($sql);
			$prepare -> bind_param("i", $this -> Data[$i]["id"]);
			$prepare -> execute();
			$prepare -> bind_result($chars, $acctid);
			while($prepare -> fetch()){
				$this -> Data[$i]["accounts"] += 1;
				$this -> Data[$i]["characters"]["total"] += $chars;
				array_push($this -> AcctIds[$i], $acctid);
			}
			$prepare -> free_result();
		}
	}

	private function GetOnlineChars(){
		$this -> MySQL -> select_db(Config::GetData("DBChar"));
		for($i = 0; $i < count($this -> Data); $i++){

			for($c = 0; $c < count($this -> AcctIds[$i]); $c++){
				$acc = $this -> AcctIds[$i][$c];
				$sql = "SELECT `account`, `race`, `online` FROM `characters` WHERE `account` = '$acc'";
				$prepare = $this -> MySQL -> prepare($sql);
				$prepare -> execute();
				$prepare -> bind_result($account, $race, $online);
				while($prepare -> fetch()){
					if($race == 2 || $race == 5 || $race == 6 || $race == 8 || $race == 10){
						if($online){
							$this -> Data[$i]["onlines"]["hordes"] += 1;
						}
						$this -> Data[$i]["characters"]["hordes"] += 1;
					}else{
						if($online){
							$this -> Data[$i]["onlines"]["alliances"] += 1;
						}
						$this -> Data[$i]["characters"]["alliances"] += 1;
					}
				}
				$prepare -> free_result();
			}

		}
	}

}
?>