<?php
$outfile_path = __DIR__.'/';
var_dump($_FILES);
function getExtension($path) {
	return pathinfo($path, PATHINFO_EXTENSION);
}

if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
	$file = $_FILES['file'];
	//var_dump($file);
	$outfile_name = 'out';
	if ($ext = getExtension($file['name'])) {
		$outfile_name .= '.'.$ext;
	}
	//var_dump($outfile_name);
	if (!$out_handler = fopen($outfile_name,'wb')) {
		die('Smth wrong with creating file');
	}
	
	// working with recerse
	if (!$tmp_handle = fopen($file['tmp_name'],'rb')) {
		die('Error while opening tmp');
	}
	$offset = -1;
	while (fseek($tmp_handle, $offset, SEEK_END) != -1) {
		$data = fread($tmp_handle,1);
		if (FALSE === $data) {
			die('Error while reading tmp file');
		}
		fwrite($out_handler,$data);
		$offset-=1;
	}
	fclose($tmp_name);
	fclose($out_handler);
}
?>