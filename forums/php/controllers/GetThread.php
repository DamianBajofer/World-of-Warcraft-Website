<?php
@session_start();
if(!class_exists("Forums")){
	include($_SERVER["DOCUMENT_ROOT"]."/forums/php/models/Forum.class.php");
}
if(!isset($_SESSION["USERNAME"])){
	return false;
}
extract($_GET);
$Thread = $Forum -> GetThread($id);
if($Thread){
	$Update = $Forum -> UpdateViews($Thread["id"]);
	$id = $Thread["id"];
	$category = $Thread["category"];
	$section = $Thread["section"];
	$title = $Thread["title"];
	$content = $Thread["content"];
	$icon = $Thread["icon"];
	$author = $Thread["author"];
	$date = $Thread["date"];
	$views = $Thread["views"];
	$answers = $Thread["answers"];
	$avatar = $Thread["avatar"];
	$UserThreads = $Thread["UserThreads"];
	$UserAnswers = $Thread["UserAnswers"];
	$UserReputation = $Thread["UserReputation"];
	$ForumName = $Thread["ForumName"];
	$Domain = Config::$SiteData["Domain"];
	$content = str_replace("\n", "<br>", $content);
	$content = str_replace("[emoji='", "<img class='emoji' src='/images/icons/emojis/", $content);
	$content = str_replace("'/]", "'>", $content);
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
	<div class='current-thread'>
		<div id='direction'>
			<div class='dir1'><a href='$Domain'>Customizacion-WoW</a> <span class='right-arrow'>»</span> <a href='$Domain/forums/'>Forums</a> <span class='right-arrow'>»</span> <a href='$Domain/forums/forum/$category/$section'>$ForumName</a></div>
			<div class='dir2'>$title - $date</div>
		</div>
		<div class='left-section'>
			<div class='user-info'>
				<div class='avatar' style='background-image:url($Domain/forums/images/avatars/$avatar);'></div>
				<div class='user'>$author</div>
				<div class='threads'>$UserThreads Hilos</div>
				<div class='answers'>$UserAnswers Respuestas</div>
			</div>
		</div>
		<div class='right-section'>
			<div class='title'>» $title - $date<div class='button-style001 answer-thread' onclick=forum.ShowAnswerArea('$author');>RESPONDER</div></div>
			<div class='content'>$content</div>
		</div>
	</div>";
}
?>