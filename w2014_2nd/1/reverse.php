<?php
phpinfo();
$outfile_path = __DIR__.'/';
var_dump($_FILES);
function getExtension($path) {
	return pathinfo($path, PATHINFO_EXTENSION);
}

if (isset($_FILES['file']) && !empty($_FILES['file'])) {
	$file = $_FILES['file'];
	//var_dump($file);
	$outfile_name = 'out';
	if ($ext = getExtension($file['name'])) {
		$outfile_name .= '.'.$ext;
	}
	//var_dump($outfile_name);
	if (!$out_handler = fopen($outfile_name,'w')) {
		die('Smth wrong with creating file');
	}
	
	// working with recerse
	$tmp_handle = fopen($file['tmp_name']);
	$offset = 0;
	while (fseek($tmp_handle, $offset, SEEK_END) != -1) {
		if (!$data = fread($tmp_handle,1)) {
			die('Error while reading tmp file');
		}
		fwrite($out_handler,$data);
	}
	fclose($tmp_name);
	fclose($out_handler);
}
?>