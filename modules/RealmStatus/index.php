<link rel='stylesheet' href='modules/RealmStatus/css/realm.css'>
<?php
	include($_SERVER["DOCUMENT_ROOT"]."/modules/RealmStatus/php/realm.controller.php");
?>
<div class='section'>
	<div class='title'>Estado de los reinos</div>
	<?php
		for($i = 0; $i < count($realms); $i++){
			$alliances = $realms[$i]["onlines"]["alliances"];
			$hordes = $realms[$i]["onlines"]["hordes"];
			$onlines = $alliances+$hordes;
			if($onlines == 0){
				$percentA = 50;
				$percentH = 50;
			}else{
				$percentA = $alliances*100/$onlines;
				$percentH = $hordes*100/$onlines;
			}
			echo "<div class='box'>
					<div class='top'>
						<div class='name'>".$realms[$i]["name"]."</div>
						<div class='onlines'>".$onlines." / ".Config::$SiteData["LimitPlayers"]."</div>
					</div>
				<div class='progress'>
					<div class='fill'>
						<div class='bar alliance' style='width:".$percentA."%;'></div>
						<div class='bar horde' style='width:".$percentH."%;'></div>
					</div>
				</div>
				<div class='bottom'>
					<div class='alliances'>".$realms[$i]["characters"]["alliances"]."</div>
					<div class='hordes'>".$realms[$i]["characters"]["hordes"]."</div>
				</div>
				<div class='realmlist'>set realmlist ".$realms[$i]["address"]."</div>
			</div>";
		}
	?>
	<div class='divider'></div>
</div>