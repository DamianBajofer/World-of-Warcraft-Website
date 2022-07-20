<?php
session_start();
//error_reporting(0);
include($_SERVER["DOCUMENT_ROOT"]."/server/config.class.php");
$Description = Config::$SiteData["Description"];
$Keywords = Config::$SiteData["Keywords"];
if(isset($_SESSION['USERNAME'])){
	echo $_SESSION['USERNAME'] . "Bienvenido!";
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8'>
	<meta name='description' content="<?php echo $Description; ?>" />
	<meta name='keywords' content="<?php echo $Keywords; ?>" />
	<meta name='author' content='Damian VanHoffer' />
	<meta name='copyright' content='Damian VanHoffer &copy; 2015 - 2021' />
	<meta http-equiv="expires" content="86400" />
	<title><?php echo Config::$SiteData["Title"]; ?></title>
	<link rel='shortcut icon' type='ico/png' href='icon.png'>
	<link rel='stylesheet' href='css/reset.css'>
	<link rel='stylesheet' href='css/main.css'>
	<script src='js/libs/jquery.js'></script>
	<script src='js/libs/jquery-ui.min.js'></script>
</head>
<body>

	<?php include("$_SERVER[DOCUMENT_ROOT]/server/connect.class.php"); ?>

	<div id='page'>
		
		<div id='container'>

			<?php include("$_SERVER[DOCUMENT_ROOT]/server/modules.controller.php"); ?>

			<div id='left'>
				<?php include("$_SERVER[DOCUMENT_ROOT]/server/page_selector.php"); ?>
			</div>

			<div id='right'>
				<?php include("$_SERVER[DOCUMENT_ROOT]/server/right_modules.controller.php"); ?>
			</div>

		</div>

		<div id='footer'><?php echo Config::$SiteData["Copyright"]; ?></div>

	</div>
	<script src='js/main.js'></script>
</body>
</html>