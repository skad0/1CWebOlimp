<?

//header('Content-type: text/plain; charset=utf-8');
header('Content-type: image/png; charset=utf-8');

const WIDTH  = 250;
const HEIGHT = 250;
const FORMAT = 24;
const FONT   = 'OpenSans-Regular.ttf';

$numerics = readNumerics();
$time = time();

echo getCaptcha($numerics, $time);

function getCaptcha($numerics, $time) {
	$time = getSplitedTime($time);
	$text = getNumericTime($numerics, $time);
	$angle = getAngles($time);

	$img = imagecreatetruecolor(WIDTH, HEIGHT);
    $textcolor = imagecolorallocate($img, 255, 255, 255);
    $color = array(
        'h' => imagecolorallocate($img, 255, 0, 255),
        'm' => imagecolorallocate($img, 51, 255, 51),
        's' => imagecolorallocate($img, 204, 153, 0),
    );
    $color_line = array(
        imagecolorallocate($img, 255, 0, 255),
        imagecolorallocate($img, 51, 255, 51),
        imagecolorallocate($img, 204,153,  0),
        imagecolorallocate($img, 255, 51, 51),
    );
    $bg = imagecolorallocate($img, 0, 0, 0);
	imagefill($img, 0, 0, $bg);
    imageellipse($img, WIDTH/2, HEIGHT/2, 30, 30, $textcolor);
    imagettftext($img,18,-$angle['h']+90,WIDTH/2,HEIGHT/2,$color['h'],FONT,''.$text['h']);
    imagettftext($img,18,-$angle['m']+90,WIDTH/2,HEIGHT/2,$color['m'],FONT,''.$text['m']);
    imagettftext($img,18,-$angle['s']+90,WIDTH/2,HEIGHT/2,$color['s'],FONT,''.$text['s']);

    for($i=0;$i<=50;$i++) {
        imageline($img,rand(0,WIDTH),rand(0,HEIGHT),rand(0,WIDTH),rand(0,HEIGHT),$color_line[array_rand($color_line)]);
    }

	return imagepng($img);
}

function getAngles($time) {
	$time['h'] = $time['h']%12;
	return array(
		'h' => $time['h']*30 + $time['m']*0.5,
		'm' => $time['m']*6 + $time['s']*0.1,
		's' => $time['s']*6,
	);
}

function getNumericTime($numerics, $time) {
	return array(
		'h' => getNumeric($numerics, $time['h']),
		'm' => getNumeric($numerics, $time['m']),
		's' => getNumeric($numerics, $time['s']),
	);
}

function getSplitedTime($time) {
	return array(
		'h' => ltrim(date(FORMAT == 24 ? 'H' : 'h',$time),'0'),
		'm' => ltrim(date('i',$time),'0'),
		's' => ltrim(date('s',$time),'0'),
	);
}

function getNumeric($numerics, $n) {
	return $numerics[$n][array_rand($numerics[$n])];
}

function readNumerics() {
	$numerics = array();
	$handle = fopen("d.in", "r");
	if($handle) {
	    while(($line = fgets($handle)) !== false) {
            $line = str_replace("\n","",$line);
            $line = str_replace("\r","",$line);
	        $numerics[] = explode(';',$line);
	    }
	    fclose($handle);
	} else {
		echo 'Couldn`t open file'.PHP_EOL;
	}
	return $numerics;
}

/*
header('Content-type: text/plain; charset=utf-8');

$a = array(
	'ноль',
	'один',
	'два',
	'три',
	'четыре',
	'пять',
	'шесть',
	'семь',
	'восемь',
	'девять',
);
$b = array(
	'двадцать',
	'тридцать',
	'сорок',
	'пятдесят',
	'sixty',
);
$f = array();
for($i = 20;$i<=60;$i++) {
	$f[$i] = $b[floor($i/10)-2].(($i%10 != 0) ? ' '.$a[$i%10] : '');
}
array_map(function($v) {
	echo $v.PHP_EOL;
},$f);


*/