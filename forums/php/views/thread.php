<div id='forum'>
	<div id='thread'>
		<?php include($_SERVER["DOCUMENT_ROOT"]."/forums/php/controllers/GetThread.php"); ?>
	</div>
	<?php include($_SERVER["DOCUMENT_ROOT"]."/forums/php/views/CommentArea.php"); ?>
	<?php include($_SERVER["DOCUMENT_ROOT"]."/forums/php/views/Comments.php"); ?>
</div>
<script>
	$(window).on("load", function(){
		$("#forum .current-thread .left-section").height($("#forum #thread").height()-$("#forum #direction").height());
		$("#forum .current-thread .right-section").height($("#forum #thread .left-section").height());
	});
</script>