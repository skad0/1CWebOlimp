<?

header('Content-type: text/plain; charset=utf-8');

$N = 1000;

array_map(function($v) {
	echo $v.' ';
},primeGenerate($N));

function primeGenerate($N) {
	$f = array_fill(2,$N-2,0);
	$g = array();
	$k = 0;
	for($i=2;$i<=$N;$i++) {
		if($f[$i] == 0) {
			$f[$i] = $i;
			$g[$k++] = $i;
		}
		for($j=0; $j<$k && $g[$j]<=$f[$i] && $i*$g[$j]<=$N;$j++) {
			$f[$i * $g[$j]] = $g[$j];
		}
	}
	return $g;
}