<?php
@session_start();
if(!class_exists("Forums")){
	include($_SERVER["DOCUMENT_ROOT"]."/forums/php/models/Forum.class.php");
}
if(!isset($_SESSION["USERNAME"])){
	return false;
}
extract($_POST);
$ForumCategory = $Forum -> GetThreadCategory($threadID);
$AnswerContent = str_replace("\n", "<br>", $AnswerContent);
$AnswerContent = str_replace("<", "&#60;", $AnswerContent);
$AnswerContent = str_replace(">", "&#62;", $AnswerContent);
$Sending = $Forum -> SendAnswer($ForumCategory["category"], $ForumCategory["section"], $threadID, $AnswerContent, $_SESSION["USERNAME"]);
if($Sending){
	$AnswerContent = str_replace("&#60;", "<", $AnswerContent);
	$AnswerContent = str_replace("&#62;", ">", $AnswerContent);
	$AnswerContent = str_replace("[USER]", "<span class='user'>", $AnswerContent);
	$AnswerContent = str_replace("[/USER]", "</span>", $AnswerContent);
	$AnswerContent = str_replace("[B]", "<span class='bold'>", $AnswerContent);
	$AnswerContent = str_replace("[/B]", "</span>", $AnswerContent);
	$AnswerContent = str_replace("[LANG:", "<pre><code class='language-", $AnswerContent);
	$AnswerContent = str_replace(";]", "'>", $AnswerContent);
	$AnswerContent = str_replace("[/LANG]", "</code></pre>", $AnswerContent);
	$AnswerContent = str_replace("[C:", "<span class='color' style='color:", $AnswerContent);
	$AnswerContent = str_replace(";]", ";'>", $AnswerContent);
	$AnswerContent = str_replace("[/C]", "</span>", $AnswerContent);
	$AnswerContent = str_replace("[I]", "<span class='italic'>", $AnswerContent);
	$AnswerContent = str_replace("[/I]", "</span>", $AnswerContent);
	$AnswerContent = str_replace("[CENTER]", "<div class='center'>", $AnswerContent);
	$AnswerContent = str_replace("[/CENTER]", "</div>", $AnswerContent);
	$AnswerContent = str_replace("[LEFT]", "<div class='left'>", $AnswerContent);
	$AnswerContent = str_replace("[/LEFT]", "</div>", $AnswerContent);
	$AnswerContent = str_replace("[RIGHT]", "<div class='right'>", $AnswerContent);
	$AnswerContent = str_replace("[/RIGHT]", "</div>", $AnswerContent);
	$AnswerContent = str_replace("[UL]", "<ul class='ul'>", $AnswerContent);
	$AnswerContent = str_replace("[/UL]", "</ul>", $AnswerContent);
	$AnswerContent = str_replace("[LI]", "<li class='list'>", $AnswerContent);
	$AnswerContent = str_replace("[/LI]", "</li>", $AnswerContent);
	$AnswerContent = str_replace("[U]", "<span class='underline'>", $AnswerContent);
	$AnswerContent = str_replace("[/U]", "</span>", $AnswerContent);
	$AnswerContent = str_replace("[IMG]", "<img class='img' src='", $AnswerContent);
	$AnswerContent = str_replace("[/IMG]", "'>", $AnswerContent);
	$AnswerContent = str_replace("[LINK:", "<a class='link' target='_blank' href='", $AnswerContent);
	$AnswerContent = str_replace(";]", "'>", $AnswerContent);
	$AnswerContent = str_replace("[/LINK]", "</a>", $AnswerContent);
	echo "
	<div class='comment'>
		<div class='user-info'>
			<div class='avatar' style='background-image:url(/images/avatars/".$_SESSION["avatar"].");'></div>
			<div class='user'>".$_SESSION["USERNAME"]."</div>
			<div class='threads'>".$_SESSION["forum_threads"]." Hilos</div>
			<div class='answers'>".$_SESSION["forum_answers"]." Respuestas</div>
		</div>
		<div class='answer-box'>
			<div class='answer'>
				$AnswerContent
			</div>
		</div>
	</div>";
}
?>