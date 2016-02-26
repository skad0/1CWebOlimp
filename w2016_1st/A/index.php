<?

header('Content-type: text/plain; charset=utf-8');


$handle = fopen("a.in", "r");
if($handle) {
    while(($line = fgets($handle)) !== false) {
        echo getNormalForm($line).PHP_EOL;
    }
    fclose($handle);
} else {
	echo 'Couldn`t open file'.PHP_EOL;
}

function getNormalForm($str) {
	$parts = explode('.',$str);
	$left = (int) $parts[0];
	$a = (int) $parts[1];
	$b = pow(10,strlen($a));
	while(($gcd = gcd($a,$b)) > 1) {
		$a /= $gcd;
		$b /= $gcd;
	}
	$result = '';
	if($left != 0) {
		$result .= $left.' ';
	}
	if($a != 0) {
		$result .= $a.'/'.$b;
	}
	return empty($result) ? 0 : $result;
}

function gcd($a,$b) {
	while($b > 0) {
		$a %= $b;

		$tmp = $a;
		$a = $b;
		$b = $tmp;
	}
	return $a;
}