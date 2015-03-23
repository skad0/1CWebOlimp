<?php
ini_set('memory_limit','2M');

if(isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
	$path = pathinfo($_FILES['file']['name']);
	$ext = $path['extension'];
	$in = fopen($_FILES['file']['tmp_name'],'r');
	$out = fopen('out.'.$ext,'w');
	fseek($in,-1,SEEK_END);
	do {
		$tmp = fread($in,1);
		fwrite($out,$tmp);
	} while(fseek($in,-2,SEEK_CUR) == 0);
	fclose($in);
	fclose($out);
}

?>