<?php
/**
 * @author Aleksey Verin
 * @date 11.07.2022
 * @version 0.1
 */

define('CACHE_PATH', 'images/');
define('BASE', 'https://baltrosgroup.ru/upload/3d/panodata');
$url = $_SERVER['REQUEST_URI'];
if (!$url)
	return;


$ext = substr($url, -4);
switch ($ext) {
	case '.jpg':
	case '.png':
		$url     = str_replace("/pano/", "/", $url);
		$url     = BASE . $url;
		$hash    = sha1($url);
		$newFile = CACHE_PATH . $hash . $ext;
		if (saveFile($url, $newFile))
			showFile($newFile, substr($ext, 1));

		break;
}

function saveFile($url, $file) {
	if (file_exists($file)) {
		return true;
	}

	file_put_contents($file, file_get_contents($url));

	return true;
}

function showFile($file, $type) {
	header('Content-Type: image/' . $type);
	echo file_get_contents($file);
}