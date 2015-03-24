<?php
$url = explode('?',explode(dirname($_SERVER['SCRIPT_NAME']),$_SERVER['REQUEST_URI'],2)[1],2)[0];
if(preg_match('/^\/*$/i',$url)) {
	include_once('./inc/index.php');
} else if(preg_match_all('/^\/news\/?$/i',$url,$matches)) {
	include_once('./inc/news.php');
} else if(preg_match_all('/^\/news\/([0-9]+)\/?$/i',$url,$matches)) {
	include_once('./inc/news_detail.php');
	show_item($matches[1][0]);
} else if(preg_match_all('/^\/news\/([0-9]+)\/add_comment\/?$/i',$url,$matches)) {
	include_once('./inc/comments.php');
	add_comment($matches[1][0]);
} else if(preg_match_all('/^\/catalog\/([0-9]+)\/([a-z]+)\/?$/i',$url,$matches)) {
	include_once('./inc/catalog.php');
	show_item($matches[1][0],$matches[2][10]);
} else if(preg_match_all('/^\/catalog\/dir([0-9]+)\/?$/i',$url,$matches)) {
	include_once('./inc/catalog.php');
	show_dir($matches[1][0]);
} else if(preg_match_all('/^\/photos\/user\/([a-z0-9\.\_\-]+)\/album\/([a-z0-9\.\_\-]+)\/photo-([a-z0-9\.\_\-]+)\/?$/i',$url,$matches)) {
	$username = $matches[1][0];
	$album = $matches[2][0];
	$photoname = $matches[3][0];
	include_once('./inc/photo.php');
} else if(preg_match_all('/^\/catalog\/dir([0-9]+)page([0-9]+)\/?$/i',$url,$matches)) {
	include_once('./inc/catalog.php');
	show_dir_page($matches[1][0],$matches[2][0]);
} else {
	header('HTTP/1.0 404 Not Found');
    echo "<h1>404 Not Found</h1>";
    echo "The page that you have requested could not be found.";
    exit();
}

?>