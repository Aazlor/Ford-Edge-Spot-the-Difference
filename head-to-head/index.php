<?
error_reporting(0);
session_save_path(getcwd().'/SESSIONS');

date_default_timezone_set('America/Detroit');

if(!function_exists(pre)){
	function pre($array){
		echo '<pre>';
		print_r($array);
		echo '</pre>';
	}
}

if(!function_exists(parse)){
	function parse($string){
		$x = explode('{{}}', $string);
		foreach($x as $v){
			if($v != ''){
				$s = explode('(())', $v);
				if($s != ''){
					$parsed_data[$s[0]] = $s[1];
				}
			}
		}
		return($parsed_data);
	}
}

session_start();
foreach($_SESSION as $k => $v){
	$_SESSION[$k] = '';
}
session_write_close();


?>

<link rel="stylesheet" href="ford-fonts/ford-fonts.css" />
<link rel="stylesheet" href="site/fonts/stylesheet.css" />

<link rel="stylesheet" href="style.css" />
<!-- 	<link rel="stylesheet" type="text/css" media="only screen and (max-width: 1080px)" href="style-mobile.css" />
-->
<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>

<script type="text/javascript" src="js/jquery-ui/jquery-ui.js"></script>
<link rel="stylesheet" href="js/jquery-ui/jquery-ui.css" />

<script type="text/javascript" src="js/datetimepicker/jquery.datetimepicker.js"></script>
<link rel="stylesheet" href="js/datetimepicker/jquery.datetimepicker.css" />

<script type="text/javascript" src="js/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="js/jquery.formatter.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){

		$('.p1, .p2').css({
			'margin': (($(window).outerWidth() / 2) - 1280) / 2,
		});

		var p1TimeOut = 0;
		var p2TimeOut = 0;

		$('.PlayNow').mousedown(function(){
			$(this).addClass('active');
			$(this).closest('.Home').fadeOut('fast', function(){
				var FullWrapper = $(this).closest('#FullWrapper');
				$(this).remove();

				var player = $(FullWrapper).data('player');

				$.ajax({
					type: "POST",
					url: "ajax.php",
					data: {page: 'loading', player: player},
				}).done(function(msg) {
					$(FullWrapper).html(msg);
					$(FullWrapper).find('.Car').animate({
						'left': '30%',
					}, 1000);
					$(FullWrapper).find('.Quote').delay(300).slideDown('slow');
					$(FullWrapper).data('status', 'ready');
					if($('.p1').data('status') == $('.p2').data('status')){
						loadingScreen();
					}
				});
			});
		});

		function loadingScreen(){
			$('.loading1').fadeOut('fast');
			$('.loading2').fadeIn('fast');

			var countdown = setInterval(function() {
				$('.Loading').find('.empty:eq(0)').animate({
					'background-color': 'rgba(255,255,255,1)',
				}, 500).removeClass('empty');
			}, 550);

			setTimeout(function() {
				clearInterval(countdown);
				$.ajax({
					type: "POST",
					url: "ajax.php",
					data: {page: 'ready,set,go'},
				}).done(function(msg) {
					readySetGo(msg);
				});
			}, 5000);
		}

		function readySetGo(msg){

			$('.ready, .set, .go').css('height', 0);

			$('.p1, .p2').html(msg);
			$('.ready').fadeIn('500', function(){
				$(this).fadeOut('500', function(){
					$('.set').fadeIn('250', function(){
						$(this).fadeOut('250', function(){
							$('.go').fadeIn('125');
						});
					});
				});
			});

			$('.ready img').animate({
				'height' : '76px',
			}, 500, function(){
				$(this).animate({
					'height': 0,
				}, 500, function(){
					$('.set img').animate({
						'height': '76px',
					}, 250, function(){
						$(this).animate({
							'height': 0,
						}, 250, function(){
							$('.go img').animate({
								'height': '109px',
							}, 125);
						});
					});
				});
			});

			setTimeout(function(){
				gameStart();
			}, 2000);

		}

		function gameStart(){
			$.ajax({
				type: "POST",
				url: "ajax.php",
				data: {page: 'game'},
			}).done(function(msg) {
				$('.p1, .p2').html(msg);
				setTimeout(function(){
					window.location.href = './';
				}, 65000);
				setTimeout(function(){
					timeUp();
				}, 60000);
			});
		}

		$('body').on('click', '.Left, .Right', function(e){

			var FullWrapper = $(this).closest('#FullWrapper');
			if($(e.target).hasClass('Spot')){
				if($(e.target).hasClass('AlreadyFound')){
					var spotNum = $(e.target).data('spot');
					$(FullWrapper).find($('.Spot[data-spot="'+spotNum+'"]')).each(function(){
						$(this).fadeOut('fast', function(){
							$(this).fadeIn('fast');
						});
					});
				}
				else{
					var spotNum = $(e.target).data('spot');
					console.log(spotNum);
					console.log($(FullWrapper).find($('.Spot[data-spot="'+spotNum+'"]')));

					$(FullWrapper).find($('.Spot[data-spot="'+spotNum+'"]')).each(function(){
						$(this).css('border', '6px solid rgba(232,28,36,1)');
						$(this).addClass('AlreadyFound');
						console.log($(this));
					});

					$(FullWrapper).find('.Found .inactive').first().animate({
						'opacity' : 1,
					}, 200, function(){
						$(this).removeClass('inactive');
					});

					$(FullWrapper).find('.Found .Count img').first().animate({
						'margin-top': '-17px',
					}, 200, function(){
						$(FullWrapper).find('.Found .Count img').first().remove();
					});

					$(FullWrapper).find('.Found').data().count++;
				}
			}
			else{
				$(FullWrapper).find('.Left, .Right').addClass('blueify');
				$(FullWrapper).find('.Incorrect').css('display', 'block');

				setTimeout( function(){
					$(FullWrapper).find('.Incorrect').css('display', 'none');
					$(FullWrapper).find('.Left, .Right').removeClass('blueify');
				}, 500);

				$(FullWrapper).find('.Missed .inactive').first().animate({
					'opacity' : 1,
				}, 200, function(){
					$(this).removeClass('inactive');
				});

				$(FullWrapper).find('.Missed .Count img').first().animate({
					'margin-top': '-17px',
				}, 200, function(){
					$(FullWrapper).find('.Missed .Count img').first().remove();
				});

				$(FullWrapper).find('.Missed').data().count++;
				console.log($(FullWrapper).find('.Missed').data('count'));
			}

			if($(FullWrapper).find('.Found').data('count') == 3){
				winner(FullWrapper);
			}
			else if($(FullWrapper).find('.Missed').data('count') == 3){
				$.ajax({
					type: "POST",
					url: "ajax.php",
					data: {page: 'game_over', end_screen: 'struck_out'},
				}).done(function(msg) {
					$(FullWrapper).html(msg);

					if($('.p1').find('.Missed').data('count') == $('.p2').find('.Missed').data('count')){
						setTimeout(function(){
							window.location.href = './';
						}, 5000);							
					}
				});
			}


		});

		function timeUp(){
			$('.p1, .p2').each(function(){
				var FullWrapper = $(this);
				if($(this).find('.SpotTheDifference').length > 0){
					$.ajax({
						type: "POST",
						url: "ajax.php",
						data: {page: 'game_over', end_screen: 'time_up'},
					}).done(function(msg) {
						$(FullWrapper).html(msg);
					});
				}
			});
		}

		function winner(winner){
			$('.p1, .p2').each(function(){
				var FullWrapper = $(this);
				if($(winner)[0] == $(this)[0]){
					$.ajax({
						type: "POST",
						url: "ajax.php",
						data: {page: 'game_over', end_screen: 'winner'},
					}).done(function(msg) {
						$(FullWrapper).html(msg);
						setTimeout(function(){
							window.location.href = './';
						}, 5000);	
					});
				}
				else if($(this).find('.SpotTheDifference').length > 0){
					$.ajax({
						type: "POST",
						url: "ajax.php",
						data: {page: 'game_over', end_screen: '2nd_place'},
					}).done(function(msg) {
						$(FullWrapper).html(msg);
					});
				}
			});
		}

	});
</script>

<div id="FullWrapper" class="p1" data-player="1">

	<div class="Home">
		<div class="PlayNow"></div>
	</div>

</div><div id="FullWrapper" class="p2" data-player="2">

	<div class="Home">
		<div class="PlayNow"></div>
	</div>

</div>