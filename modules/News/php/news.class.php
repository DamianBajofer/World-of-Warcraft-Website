<?php
class News{

	private $MySQL;
	private $SQL, $Prepare;
	private $News = array();

	public function __CONSTRUCT(){
		if(!class_exists("DBC")){
			include($_SERVER["DOCUMENT_ROOT"]."/server/connect.class.php");
		}
		$this -> MySQL = DBC::Connect();
	}

	public function GetNews(){
		$this -> MySQL -> select_db(Config::GetData("DBWebsite"));
		$this -> SQL = "SELECT * FROM `news` ORDER BY(`id`) ASC LIMIT 5";
		$this -> Prepare = $this -> MySQL -> prepare($this -> SQL);
		$this -> Prepare -> execute();
		$this -> Prepare -> bind_result($id, $title, $content, $author, $date, $comments);
		$this -> Prepare -> store_result();
		$this -> Rows = $this -> Prepare -> num_rows;
		$this -> Prepare -> fetch();
		$this -> Keys = array("{ID}" => $id, "{TITLE}" => $title, "{CONTENT}" => $content, "{AUTHOR}" => $author, "{DATE}" => $date);
		$this -> Template = file_get_contents("$_SERVER[DOCUMENT_ROOT]/modules/News/templates/article.tpl");
		$this -> Prepare -> free_result();
		for($i = 0; $i < $this -> Rows; $i++){
			$tpl = $this -> Template;
			foreach($this -> Keys as $key => $value) {
				if($key === "{CONTENT}"){
					$value = str_replace("\n", "<br>", $value);
				}
				$tpl = str_replace($key, $value, $tpl);
			}
			array_push($this -> News, $tpl);
		}
		$this -> MySQL -> close();
		return json_encode($this -> News);
	}

}
?>