<div id='forum'>
	<div id='threads-box'>
		<div class='current-thread'>
			<?php include($_SERVER["DOCUMENT_ROOT"]."/forums/php/controllers/Directions/Threads.php"); ?>
			<?php include($_SERVER["DOCUMENT_ROOT"]."/forums/php/controllers/GetNewThreadButton.php"); ?>
		</div>
		<table class='thread-reference'>
			<tr>
				<td width="49.6%" align="left">ASUNTO</td>
				<td width="0.1%" align="center">|</td>
				<td width="15%" align="center">AUTOR</td>
				<td width="0.1%" align="center">|</td>
				<td width="15%" align="center">FECHA</td>
				<td width="0.1%" align="center">|</td>
				<td width="10%" align="center">VISITAS</td>
				<td width="0.1%" align="center">|</td>
				<td width="10%" align="center">RESPUESTAS</td>
			</tr>
		</table>
		<?php //include($_SERVER["DOCUMENT_ROOT"]."/forums/php/controllers/GetThreads.php"); ?>
	</div>
</div>
<script>forum.GetThreads(<?php echo $_GET["section"]; ?>, <?php echo $_GET["order"]; ?>);</script>