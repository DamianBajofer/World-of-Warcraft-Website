<div id='forum'>
	<div class='current-thread'>
		<?php include($_SERVER["DOCUMENT_ROOT"]."/forums/php/controllers/Directions/NewThread.php"); ?>
		<form method='post' id='NewThreadForm' autocomplete='off'>
			<table>
				<tr>
					<td><input id='ThreadTitle' type='text' name='title' size='50' placeholder='Titulo descriptivo del tema.'><div class='icon' onclick="WI.overlay().load('forums/php/views/icons.html')"></div></td>
				</tr>
				<tr style='display:none;'>
					<td><input id='ThreadIcon' type='text' name='icon' value='0'></td>
					<td><input id='Category' type='text' name='category' value="<?php echo $_GET['section']; ?>"></td>
					<td><input id='Section' type='text' name='section' value="<?php echo $_GET['order']; ?>"></td>
				</tr>
				<tr>
					<td><?php include($_SERVER["DOCUMENT_ROOT"]."/forums/php/views/Toolbar.php"); ?></td>
				</tr>
				<tr>
					<td><textarea id='ThreadContent' name='content' placeholder='Escribe tus dudas, problemas, aportes o lo que necesitas compartir con los demas usuarios.'></textarea></td>
				</tr>
			</table>
		</form>
		<input type='button' value='PUBLICAR HILO' onclick='forum.SendThread();'>
	</div>
</div>
<script>
	forum.Toolbar("#ThreadContent");
</script>