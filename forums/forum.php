<?php
@session_start();
if(!class_exists("DBC")){
	include($_SERVER["DOCUMENT_ROOT"]."/server/connect.class.php");
}
if(!isset($_SESSION["USERNAME"])){
	header("Location: ".Config::$SiteData["Domain"]);
}
$__DIR = Config::$SiteData["Domain"];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset='utf8'>
	<meta name='description' content='Crea un nuevo hilo en el foro para obtener soporte en el area que necesitas.'>
	<title><?php echo Config::$SiteData["Name"]; ?> | Foros - Nuevo Hilo</title>
	<link rel='shortcut icon' href='<?php echo $__DIR; ?>/favicon.png'>
	<link rel='stylesheet' href='<?php echo $__DIR; ?>/forums/css/reset.css'>
	<link rel='stylesheet' href='<?php echo $__DIR; ?>/forums/css/main.css'>
	<link rel='stylesheet' href='<?php echo $__DIR; ?>/forums/css/auth.css'>
	<link rel='stylesheet' href='<?php echo $__DIR; ?>/forums/css/prism.css'>
	<script src='<?php echo $__DIR; ?>/js/libs/jquery.js'></script>
	<script src='<?php echo $__DIR; ?>/js/libs/jquery-ui.min.js'></script>
	<script src='<?php echo $__DIR; ?>/forums/js/WebInterface.js'></script>
	<script src='<?php echo $__DIR; ?>/forums/js/auth.js'></script>
</head>
<body>
	<!-- Forum -->
	<div id='page'>
		<?php include($_SERVER["DOCUMENT_ROOT"]."/forums/php/views/forum.php"); ?>
	</div>
	<!-- Sonidos y Efectos -->
	<audio id='success' style='display:none;' src='/sounds/success.wav'></audio>
	<audio id='failed' style='display:none;' src='/sounds/failed.wav'></audio>
</body>
</html>