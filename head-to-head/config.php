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

$vehicles = array(
	1 => array(
		'Vehicle' => 'silver.png',
		'Quote' => 'quote1.png',
	),
	2 => array(
		'Vehicle' => 'gold.png',
		'Quote' => 'quote2.png',
	),
	3 => array(
		'Vehicle' => 'red.png',
		'Quote' => 'quote3.png',
	),
	4 => array(
		'Vehicle' => 'green.png',
		'Quote' => 'quote4.png',
	),
	5 => array(
		'Vehicle' => 'red_top.png',
		'Quote' => 'quote5.png',
	),
	6 => array(
		'Vehicle' => 'silver.png',
		'Quote' => 'quote6.png',
	),
	7 => array(
		'Vehicle' => 'red_back.png',
		'Quote' => 'quote7.png',
	),
	8 => array(
		'Vehicle' => 'gray.png',
		'Quote' => 'quote8.png',
	),
	9 => array(
		'Vehicle' => 'gold.png',
		'Quote' => 'quote9.png',
	),
	10 => array(
		'Vehicle' => 'red_top.png',
		'Quote' => 'quote10.png',
	),
	11 => array(
		'Vehicle' => 'red.png',
		'Quote' => 'quote11.png',
	),
	12 => array(
		'Vehicle' => 'silver.png',
		'Quote' => 'quote12.png',
	),
);


$games = array(
	1 => array('143|9','130|167','233|527'),
	2 => array('175|2', '163|284', '187|530'),
	3 => array('27|334','192|206','104|367'),
	4 => array('146|205','100|282','68|498'),
	5 => array('258|18','66|527','317|429'),
	6 => array('11|245','176|160','368|494'),
	7 => array('15|444','49|152','207|510'),
	8 => array('67|529','12|264','47|27'),
	9 => array('235|-14px','134|176','153|486'),
	10 => array('0|5','192|404','374|51'),
	11 => array('-2|205','133|260','243|9'),
	12 => array('87|35','140|495','219|48'),
);



?>