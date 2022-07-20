<div id='comment-area'>
	<form method='POST' id='answer-thread' autocomplete='off'>
		<div class='box'>
			<?php include($_SERVER["DOCUMENT_ROOT"]."/forums/php/views/Toolbar.php"); ?>
			<input type='text' id='thread-id' name='threadID' value="<?php echo $_GET['id']; ?>">
			<textarea class='answer-content' name='AnswerContent' placeholder='Escribe una respuesta para este tema.'></textarea>
			<div class='button-style001 comment-thread' onclick='forum.SendAnswer();'>ENVIAR RESPUESTA</div>
		</div>
		<div class='comments-box'>
			<?php include($_SERVER["DOCUMENT_ROOT"]."/forums/php/controllers/GetAnswers.php"); ?>
		</div>
	</form>
</div>
<script>forum.Toolbar(".answer-content");</script>