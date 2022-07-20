<?php
@session_start();
class Forums{

	private $MySQL;
	private $SQL;
	private $Result;
	private $Date;

	public function Forums(){
		if(!class_exists("DBC")){
			include($_SERVER["DOCUMENT_ROOT"]."/server/connect.class.php");
		}
		$this -> MySQL = DBC::Connect();
		$this -> MySQL -> select_db(Config::GetData("DBWebsite"));
	}

	public function GetThreadCategory($thread){
		if(!class_exists("DBC")){
			include($_SERVER["DOCUMENT_ROOT"]."/server/connect.class.php");
		}
		$this -> MySQL = DBC::Connect();
		$this -> MySQL -> select_db(Config::GetData("DBWebsite"));
		$this -> SQL = "SELECT `category`,`section` FROM `forum_threads` WHERE `id` = ?";
		$this -> Prepare = $this -> MySQL -> prepare($this -> SQL);
		$this -> Prepare -> bind_param("i", $thread);
		$this -> Prepare -> execute();
		$this -> Prepare -> bind_result($category, $section);
		while($this -> Prepare -> fetch()){
			$this -> Prepare -> free_result();
			return array("category" => $category, "section" => $section);
		}
		$this -> Prepare -> free_result();
		return false;
	}

	public function SendAnswer($category, $section, $thread, $content, $author){
		$this -> Date = DBC::GetDate(array("d", "m", "Y"), "/");
		$this -> SQL = "INSERT INTO `forum_answers`(`category`, `section`, `thread`, `content`, `author`, `date`) VALUES(?,?,?,?,?,?)";
		$this -> Prepare = $this -> MySQL -> prepare($this -> SQL);
		$this -> Prepare -> bind_param("iiisss", $category, $section, $thread, $content, $author, $this -> Date);
		$this -> Prepare -> execute();
		if($this -> Prepare -> affected_rows){
			$this -> Prepare -> free_result();
			if($this -> UpdateThreadAnswer($thread)){
				if($this -> UpdateUserAnswer($author)){
					return true;
				}
			}
			return false;
		}
		$this -> Prepare -> free_result();
		return false;
	}

	public function UpdateThreadAnswer($thread){
		$this -> SQL = "UPDATE `forum_threads` SET `answers` = `answers`+1 WHERE `id` = ?";
		$this -> Prepare = $this -> MySQL -> prepare($this -> SQL);
		$this -> Prepare -> bind_param("s", $thread);
		$this -> Prepare -> execute();
		if($this -> Prepare -> affected_rows){
			$this -> Prepare -> free_result();
			return true;
		}
		$this -> Prepare -> free_result();
		return false;
	}

	public function UpdateUserAnswer($user){
		$this -> SQL = "UPDATE `users_info` SET `forum_answers` = `forum_answers`+1 WHERE `username` = ?";
		$this -> Prepare = $this -> MySQL -> prepare($this -> SQL);
		$this -> Prepare -> bind_param("s", $user);
		$this -> Prepare -> execute();
		if($this -> Prepare -> affected_rows){
			$this -> Prepare -> free_result();
			$_SESSION["forum_answers"] = $_SESSION["forum_answers"]+1;
			return true;
		}
		$this -> Prepare -> free_result();
		return false;
	}

	public function GetCategories(){
		$this -> MySQL = DBC::Connect();
		$this -> MySQL -> select_db(Config::GetData("DBWebsite"));
		$this -> SQL = "SELECT * FROM `forum_categories` ORDER BY(`order`) ASC";
		$this -> Prepare = $this -> MySQL -> prepare($this -> SQL);
		$this -> Prepare -> execute();
		$this -> Prepare -> bind_result($id, $name, $order);
		$this -> Result = array();
		while($this -> Prepare -> fetch()){
			array_push($this -> Result, array(
				"id" => $id,
				"name" => $name,
				"order" => $order
			));
		}
		$this -> Prepare -> free_result();
		if(isset($this -> Result)){
			return $this -> Result;
		}
		return false;
	}

	public function GetSections($id){
		$this -> SQL = "SELECT * FROM `forum_sections` WHERE `id` = ? ORDER BY(`order`) ASC";
		$this -> Prepare = $this -> MySQL -> prepare($this -> SQL);
		$this -> Prepare -> bind_param("i", $id);
		$this -> Prepare -> execute();
		$this -> Prepare -> bind_result($id, $name, $description, $image, $access, $order);
		$this -> Result = array();
		while($this -> Prepare -> fetch()){
			array_push($this -> Result, array(
				"id" => $id,
				"name" => $name,
				"description" => $description,
				"image" => $image,
				"access" => $access,
				"order" => $order
			));
		}
		$this -> Prepare -> free_result();
		if(isset($this -> Result)){
			return $this -> Result;
		}
		return false;
	}

	public function GetThreads($category, $section){
		if(!class_exists("DBC")){
			include($_SERVER["DOCUMENT_ROOT"]."/server/connect.class.php");
		}
		$this -> MySQL = DBC::Connect();
		$this -> MySQL -> select_db(Config::GetData("DBWebsite"));
		$this -> SQL = "SELECT `id`,`title`,`icon`,`author`,`date`,`views`,`answers` FROM `forum_threads` WHERE `category` = ? && `section` = ? ORDER BY(`id`) DESC";
		$this -> Prepare = $this -> MySQL -> prepare($this -> SQL);
		$this -> Prepare -> bind_param("ii", $category, $section);
		$this -> Prepare -> execute();
		$this -> Prepare -> bind_result($id, $title, $icon, $author, $date, $views, $answers);
		$this -> Result = array();
		while($this -> Prepare -> fetch()){
			array_push($this -> Result, array(
				"id" => $id,
				"title" => $title,
				"icon" => $icon,
				"author" => $author,
				"date" => $date,
				"views" => $views,
				"answers" => $answers
			));
		}
		if(isset($this -> Result)){
			return $this -> Result;
		}
		return false;
	}

	public function GetThread($thread){
		$this -> MySQL = DBC::Connect();
		$this -> MySQL -> select_db(Config::GetData("DBWebsite"));
		$this -> SQL = "SELECT * FROM `forum_threads` WHERE `id` = ?";
		$this -> Prepare = $this -> MySQL -> prepare($this -> SQL);
		$this -> Prepare -> bind_param("i", $thread);
		$this -> Prepare -> execute();
		$this -> Prepare -> bind_result($id, $category, $section, $title, $content, $icon, $author, $date, $views, $answers, $reputation, $reports);
		$this -> Result = array();
		while($this -> Prepare -> fetch()){
			$this -> Prepare -> free_result();
			$avatar = $this -> GetAvatar($author);
			$info = $this -> GetUserInformation($author);
			$ForumName = $this -> GetForumName($category, $section);
			$this -> Result = array(
				"id" => $id,
				"category" => $category,
				"section" => $section,
				"title" => $title,
				"content" => $content,
				"icon" => $icon,
				"author" => $author,
				"date" => $date,
				"views" => $views,
				"answers" => $answers,
				"reputation" => $reputation,
				"reports" => $reports,
				"avatar" => $avatar,
				"UserThreads" => $info["threads"],
				"UserAnswers" => $info["answers"],
				"UserReputation" => $info["reputation"],
				"ForumName" => $ForumName
			);
		}
		if(isset($this -> Result)){
			return $this -> Result;
		}
		return false;
	}

	public function SendThread($icon, $title, $content, $author, $category, $section){
		$this -> MySQL = DBC::Connect();
		$this -> MySQL -> select_db(Config::GetData("DBWebsite"));
		$this -> Date = DBC::GetDate(array("d","m","Y"), "/");
		$this -> SQL = "INSERT INTO `forum_threads`(`category`,`section`,`title`,`content`,`icon`,`author`,`date`) VALUES(?,?,?,?,?,?,?);";
		$this -> Prepare = $this -> MySQL -> prepare($this -> SQL);
		$this -> Prepare -> bind_param("iisssss", $category, $section, $title, $content, $icon, $author, $this -> Date);
		$this -> Prepare -> execute();
		if($this -> Prepare -> affected_rows){
			$this -> Prepare -> free_result();
			$this -> SQL = "SELECT `id` FROM `forum_threads` WHERE `title` = ? && `author` = ? && `date` = ?";
			$this -> Prepare = $this -> MySQL -> prepare($this -> SQL);
			$this -> Prepare -> bind_param("sss", $title, $author, $this -> Date);
			$this -> Prepare -> execute();
			$this -> Prepare -> bind_result($id);
			while($this -> Prepare -> fetch()){
				$this -> Prepare -> free_result();
				if($this -> UpdateUserThreads($author)){
					return DBC::$Domain."/forums/thread/$id/";
				}
			}
		}
		$this -> Prepare -> free_result();
		return false;
	}

	public function GetAnswers($thread){
		$this -> MySQL = DBC::Connect();
		$this -> MySQL -> select_db(Config::GetData("DBWebsite"));
		$this -> SQL = "SELECT * FROM `forum_answers` WHERE `thread` = ? ORDER BY(`id`) ASC";
		$this -> Prepare = $this -> MySQL -> prepare($this -> SQL);
		$this -> Prepare -> bind_param("i", $thread);
		$this -> Prepare -> execute();
		$this -> Prepare -> bind_result($id, $category, $section, $thread, $content, $author, $date);
		$this -> Result = array();
		while($this -> Prepare -> fetch()){
			array_push($this -> Result, array(
				"id" => $id,
				"category" => $category,
				"section" => $section,
				"thread" => $thread,
				"content" => $content,
				"author" => $author,
				"date" => $date
			));
		}
		$this -> Prepare -> free_result();
		if(isset($this -> Result)){
			return $this -> Result;
		}
		return false;
	}

	public function GetUserInfo($user){
		$this -> SQL = "SELECT * FROM `users_info` WHERE `username` = ?";
		$this -> Prepare = $this -> MySQL -> prepare($this -> SQL);
		$this -> Prepare -> bind_param("s", $user);
		$this -> Prepare -> execute();
		$this -> Prepare -> bind_result($id, $user, $threads, $answers, $rep, $videos, $followers);
		while($this -> Prepare -> fetch()){
			$this -> Prepare -> free_result();
			return array(
				"id" => $id,
				"user" => $user,
				"threads" => $threads,
				"answers" => $answers,
				"rep" => $rep,
				"videos" => $videos,
				"followers" => $followers
			);
		}
		$this -> Prepare -> free_result();
		return false;
	}

	public function UpdateUserThreads($username){
		$this -> SQL = "UPDATE `users_info` SET `forum_threads` = `forum_threads`+1 WHERE `username` = ?";
		$this -> Prepare = $this -> MySQL -> prepare($this -> SQL);
		$this -> Prepare -> bind_param("s", $username);
		$this -> Prepare -> execute();
		if($this -> Prepare -> affected_rows){
			$this -> Prepare -> free_result();
			$_SESSION["forum_threads"] = $_SESSION["forum_threads"]+1;
			return true;
		}
		$this -> Prepare -> free_result();
		return false;
	}

	public function UpdateViews($id){
		$this -> SQL = "UPDATE `forum_threads` SET `views` = `views`+1 WHERE `id` = $id";
		$this -> Prepare = $this -> MySQL -> prepare($this -> SQL);
		$this -> Prepare -> execute();
	}

	public function GetForumName($category, $section){
		$this -> MySQL = DBC::Connect();
		$this -> MySQL -> select_db(Config::GetData("DBWebsite"));
		$this -> SQL = "SELECT `name` FROM `forum_sections` WHERE `id` = ? && `order` = ?";
		$this -> Prepare = $this -> MySQL -> prepare($this -> SQL);
		$this -> Prepare -> bind_param("ii", $category, $section);
		$this -> Prepare -> execute();
		$this -> Prepare -> bind_result($name);
		while($this -> Prepare -> fetch()){
			$this -> Prepare -> free_result();
			return $name;
		}
		$this -> Prepare -> free_result();
		return false;
	}

	public function GetForumRank($section, $order){
		if(!class_exists("DBC")){ include("$_SERVER[DOCUMENT_ROOT]/server/connect.class.php"); }
		$this -> MySQL = DBC::Connect();
		$this -> MySQL -> select_db(Config::GetData("DBWebsite"));
		$this -> SQL = "SELECT `access` FROM `forum_sections` WHERE `id` = ? && `order` = ?";
		$this -> Prepare = $this -> MySQL -> prepare($this -> SQL);
		$this -> Prepare -> bind_param("ii", $section, $order);
		$this -> Prepare -> execute();
		$this -> Prepare -> bind_result($access);
		while($this -> Prepare -> fetch()){
			$this -> Prepare -> free_result();
			return $access;
		}
		$this -> Prepare -> free_result();
		return false;
	}

	public function GetUserInformation($user){
		$this -> Prepare -> free_result();
		$this -> SQL = "SELECT `forum_threads`,`forum_answers`,`forum_rep` FROM `users_info` WHERE `username` = ?";
		$this -> Prepare = $this -> MySQL -> prepare($this -> SQL);
		$this -> Prepare -> bind_param("s", $user);
		$this -> Prepare -> execute();
		$this -> Prepare -> bind_result($forum_threads, $forum_answers, $forum_rep);
		while($this -> Prepare -> fetch()){
			$this -> Prepare -> free_result();
			return array("threads" => $forum_threads, "answers" => $forum_answers, "reputation" => $forum_rep);
		}
		$this -> Prepare -> free_result();
		return false;
	}

	public function GetAvatar($user){
		$this -> MySQL = DBC::Connect();
		$this -> MySQL -> select_db(Config::GetData("DBWebsite"));
		$this -> SQL = "SELECT `avatar` FROM `accounts` WHERE `username` = ?";
		$this -> Prepare = $this -> MySQL -> prepare($this -> SQL);
		$this -> Prepare -> bind_param("s", $user);
		$this -> Prepare -> execute();
		$this -> Prepare -> bind_result($avatar);
		while($this -> Prepare -> fetch()){
			$this -> Prepare -> free_result();
			return $avatar;
		}
		return false;
	}

	public function close(){
		$this -> Prepare -> free_result();
		//$this -> MySQL -> close();
	}

}
$Forum = new Forums();
?>