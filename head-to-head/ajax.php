<?

include('config.php');
session_start();

if($_SESSION['loading'] == ''){

	$loading = $vehicles[array_rand($vehicles)];

	$_SESSION['loading'] = '

	<div class="Loading">
		<div class="Car"><img src="./site/'.$loading[Vehicle].'"></div>
		<div class="Quote"><img src="./site/'.$loading[Quote].'"></div>

		<div class="loading1">
			<div class="Circles"><div class="circle"></div><div class="circle1"></div></div>
			<div><img src="./site/loading-waiting-text.png"></div>
		</div>
		<div class="loading2">
			<div class="dots">
				<span class="empty"></span>
				<span class="empty"></span>
				<span class="empty"></span>
				<span class="empty"></span>
				<span class="empty"></span>
				<span class="empty"></span>
				<span class="empty"></span>
				<span class="empty"></span>
			</div>
			<div><img src="./site/loading-ready-text.png"></div>
		</div>
	</div>
	';
}

if($_POST[page] == 'loading'){
	$_SESSION[$_POST[player]] = 'ready';

	if($_SESSION[1] == $_SESSION[2]){
		echo 'START THE GAME';
	}
	else{
		echo $_SESSION['loading'];
	}
}

if($_POST[page] == 'ready,set,go'){
	?>
	<div class="Ready-Set-Go">
		<div class="Ready"><img src="./site/ready.png"></div>
		<div class="Set"><img src="./site/set.png"></div>
		<div class="Go"><img src="./site/go.png"></div>
	</div>
	<?
}

if($_POST[page] == 'game'){
	$curr_game = file_get_contents('game.txt');
	$curr_game = $curr_game + 1;
	if($curr_game > 12){
		$curr_game = 1;
	}
	file_put_contents('game.txt', $curr_game);
	$coordinates = $games[$curr_game];

	$x=0;
	foreach($coordinates as $v){
		$xy = explode('|', $v);
		$spots .= '<div class="Spot" data-spot="'.$x.'" style="top: '.$xy[0].'px; left: '.$xy[1].'px;"></div>';
		$x++;
	}

	?>
	<div class="SpotTheDifference">
		<div class="Game">
			<div class="Left" style="background-image: url(./site/stds/<?= $curr_game ?>-l.png)">
				<?= $spots ?>
			</div>
			<div class="Right" style="background-image: url(./site/stds/<?= $curr_game ?>-r.png)">
				<?= $spots ?>
			</div>
			<div class="Clear"></div>

			<div class="Incorrect"><img src="./site/incorrect.png"></div>
		</div>

		<div class="Timer"><img src="./site/221x221_countdown_clock2.gif?<?= date("Ymdgis") ?>"></div>

		<div class="Missed" data-count="0">
			<img src="./site/missed.png" class="inactive">
			<img src="./site/missed.png" class="inactive">
			<img src="./site/missed.png" class="inactive">
			<img src="./site/missed-text.png" class="text">
			<div class="Count">
				<img src="./site/count-0.png">
				<img src="./site/count-1.png">
				<img src="./site/count-2.png">
				<img src="./site/count-3.png">
			</div>
		</div>

		<div class="Found" data-count="0">
			<img src="./site/found.png" class="inactive">
			<img src="./site/found.png" class="inactive">
			<img src="./site/found.png" class="inactive">
			<img src="./site/found-text.png" class="text">
			<div class="Count">
				<img src="./site/count-0.png">
				<img src="./site/count-1.png">
				<img src="./site/count-2.png">
				<img src="./site/count-3.png">
			</div>
		</div>
	</div>
	<?
}

if($_POST[page] == 'game_over'){
	?>
	<div class="GameOver">
		<div class="Message">
			<img src="./site/<?= $_POST[end_screen] ?>.png">
		</div>
	</div>
	<?
}

session_write_close();

?>