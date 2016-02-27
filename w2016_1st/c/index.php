<?php
/**
 * this function find primes for O(n)
 * @param int $value - maximum value
 * @return array - array of primes 
 */
function takeSieves($value) {
	$lp = array();
	$pr = array();
	for ($i=2; $i<=$value; $i++) {
		if ($lp[$i] == 0) {
			$lp[$i] = $i;
			$pr[] = $i;
		}
	for ($j = 0; $j < count($pr) && $pr[$j] <= $lp[$i] && $i * $pr[$j] <= $value; $j++)
		$lp[$i * $pr[$j]] = $pr[$j];
	}
	return $pr;
}
/**
 * Function prints an array
 * @param array $input 
 */
function printArray($input) {
	if (!is_array($input)) {
		exit('Must be array');
	}
	$lastElement = array_pop($input);
	foreach ($input as $value) {
		echo $value . ' ';
	}
	echo $lastElement;
}
/**
 * @var input value
 */
$inputValue = 10;

printArray(takeSieves($inputValue));
