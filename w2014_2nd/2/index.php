<?php
//$url = stri_replace( , '', $_SERVER['REQUEST_URI'], 1 );
$url = explode( dirname( $_SERVER['SCRIPT_NAME'] ), $_SERVER['REQUEST_URI'], 2 )[1];
$url = explode ( '?', $url, 2 )[0];
//var_dump( $url );

$news_id_regexp = '/^(\/news\/)[\d]+(\/)?$/i';
$news_id_comments_regexp = '/^(\/news\/)[\d]+(\/)(add_comment)(\/)?$/i';
$catalog_params_regexp = '/^\/catalog\/([\d]+)\/([a-z]+)\/?$/i';
$catalog_dir_regexp = '/^\/catalog\/dir([\d]+)\/?$/i';
$photos_regexp = '/^\/photos\/user\/([a-z0-9]+)\/album\/([a-z0-9_]+)\/photo-([a-z0-9_])\/?$/i';
$finding = array();
if ( $url == '/' ) {
	include_once 'inc/index.php';
} else if ( trim($url,'/') == 'news' ) {
	include_once 'inc/news.php';
} else if ( preg_match( $news_id_regexp, $url ) ) {
	include_once 'inc/news_detail.php';
} else if ( preg_match( $news_id_comments_regexp, $url ) ) {
	include_once 'inc/comments.php';
} else if ( preg_match_all( $catalog_params_regexp, $url,  $finding ) ) {
	$param1 = $finding[1][0];
	$param2 = $finding[2][0];
	include_once 'inc/catalog.php';
	show_item($param1, $param2);
} else if ( preg_match_all( $catalog_dir_regexp, $url, $finding ) ) {
	$id = $finding[1][0];
	include_once 'inc/catalog.php';
	show_dir($id);
} else if ( preg_match_all( $photos_regexp, $url, $finding ) ) {
	var_dump($finding);
}
?>