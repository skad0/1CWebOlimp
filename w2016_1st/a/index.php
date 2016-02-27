<?php
// get string representation of double
function floatToFrac($value)
{
	$result = '';
	$accuracy = 1E-7;

	$value = explode('.', trim($value));

	if ($value[0] > 0) {
		$result .= $value[0] . " ";
	}

	if (isset($value[1])) {
		$num = '0.' . $value[1];
		$den = 1;
		
		while(abs($num - round($num)) > $accuracy)
		{
			$num *= 10;
			$den *= 10;
		}
		if ($den % $num === 0)
			$result .= "1/" . $den/$num;
		else
			$result .= "$num/$den";
	}

	return $result;
}

// grab info from file
$in = file_get_contents('in.txt');
// specify output file name
$out = 'out.txt';
// clear file
file_put_contents($out, '');
// get string of input data
$inStrs = explode("\n", $in);

foreach ($inStrs as $k => $val) {
	$result = floatToFrac($val);
	file_put_contents($out, $result . "\n", FILE_APPEND);
}
