<?php
@session_start();
if(!class_exists("Forums")){
	include($_SERVER["DOCUMENT_ROOT"]."/forums/php/models/Forum.class.php");
}
if(!isset($_SESSION["USERNAME"])){
	return false;
}
extract($_GET);
$answers = $Forum -> GetAnswers($id);
if($answers){
	for($a = 0; $a < count($answers); $a++){
		$id = $answers[$a]["id"];
		$category = $answers[$a]["category"];
		$section = $answers[$a]["section"];
		$thread = $answers[$a]["thread"];
		$content = $answers[$a]["content"];
		$author = $answers[$a]["author"];
		$date = $answers[$a]["date"];
		$avatar = $Forum -> GetAvatar($author);
		$AuthorInfo = $Forum -> GetUserInfo($author);
		$threads = $AuthorInfo["threads"];
		$TotalAnswers = $AuthorInfo["answers"];
		$content = str_replace("\n", "<br>", $content);
		$content = str_replace("&#60;", "<", $content);
		$content = str_replace("&#62;", ">", $content);
		$content = str_replace("[USER]", "<span class='user'>", $content);
		$content = str_replace("[/USER]", "</span>", $content);
		$content = str_replace("[B]", "<span class='bold'>", $content);
		$content = str_replace("[/B]", "</span>", $content);
		$content = str_replace("[LANG:", "<pre><code class='language-", $content);
		$content = str_replace(";]", "'>", $content);
		$content = str_replace("[/LANG]", "</code></pre>", $content);
		$content = str_replace("[C:", "<span class='color' style='color:", $content);
		$content = str_replace(";]", ";'>", $content);
		$content = str_replace("[/C]", "</span>", $content);
		$content = str_replace("[I]", "<span class='italic'>", $content);
		$content = str_replace("[/I]", "</span>", $content);
		$content = str_replace("[CENTER]", "<div class='center'>", $content);
		$content = str_replace("[/CENTER]", "</div>", $content);
		$content = str_replace("[LEFT]", "<div class='left'>", $content);
		$content = str_replace("[/LEFT]", "</div>", $content);
		$content = str_replace("[RIGHT]", "<div class='right'>", $content);
		$content = str_replace("[/RIGHT]", "</div>", $content);
		$content = str_replace("[UL]", "<ul class='ul'>", $content);
		$content = str_replace("[/UL]", "</ul>", $content);
		$content = str_replace("[LI]", "<li class='list'>", $content);
		$content = str_replace("[/LI]", "</li>", $content);
		$content = str_replace("[U]", "<span class='underline'>", $content);
		$content = str_replace("[/U]", "</span>", $content);
		$content = str_replace("[IMG]", "<img class='img' src='", $content);
		$content = str_replace("[/IMG]", "'>", $content);
		$content = str_replace("[LINK:", "<a class='link' target='_blank' href='", $content);
		$content = str_replace(";]", "'>", $content);
		$content = str_replace("[/LINK]", "</a>", $content);
		echo "
		<div class='comment'>
			<div class='user-info'>
				<div class='avatar' style='background-image:url(/images/avatars/$avatar);'></div>
				<div class='user'>$author</div>
				<div class='threads'>$threads Hilos</div>
				<div class='answers'>$TotalAnswers Respuestas</div>
			</div>
			<div class='answer-box'>
				<div class='answer'>
					$content
				</div>
			</div>
		</div>";
	}
}
?>