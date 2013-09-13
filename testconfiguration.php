<?php

$tests = array(
	'imagick' 									=> false,
	'gd' 												=> false,
	'image_folder'							=> false,
	'image_folder_writable'			=> false,
	'modrewrite'								=> false,
	'htaccess_file_exists'			=> false,
	'htaccess_fleximgcfg_exists'=> false,
	'htaccess_scale_php_found'	=> false
	);

// get server document root
$doc_root = $_SERVER['DOCUMENT_ROOT'];
if(substr($doc_root, -1) !== '/')$doc_root = $doc_root.'/';

// IMAGEMAGICK is loaded
if (extension_loaded('imagick')){
	$tests['imagick'] = true;
}

// GD LIB is loaded
if (extension_loaded('gd')){
	$tests['gd'] = true;
}

// Image folder is in place
if(file_exists($doc_root.'img/fleximg_scale/')){
	$tests['image_folder'] = true;
}

// Image folder is writable
touch($doc_root.'img/fleximg_scale/testfile');
if(file_exists($doc_root.'img/fleximg_scale/testfile')){
	unlink($doc_root.'img/fleximg_scale/testfile');
	$tests['image_folder_writable'] = true;
}

// mod_rewrite is loaded
if (function_exists('apache_get_modules')) {
	if(in_array('mod_rewrite', apache_get_modules())){
		$tests['modrewrite'] = true;	
	}
}


// check .htaccess config
$htaccess_contents = file_get_contents($doc_root.'.htaccess');

if($htaccess_contents){

	$tests['htaccess_file_exists'] = true;
	
	if(strpos($htaccess_contents, 'RewriteRule img/fleximg_scale/. ')){
		$tests['htaccess_fleximgcfg_exists'] = true;

		$tmp_htaccess = explode('RewriteRule img/fleximg_scale/. ',$htaccess_contents);
		$tmp_htaccess = $tmp_htaccess[1];


		$tmp_htaccess = explode('\n',$tmp_htaccess);
		$tmp_htaccess = $tmp_htaccess[0];
		$tmp_htaccess = explode(' ',$tmp_htaccess);
		$tmp_htaccess = $tmp_htaccess[0];

		echo substr($doc_root, 0, (strlen($doc_root)-1)).$tmp_htaccess;
		if(file_exists(substr($doc_root, 0, (strlen($doc_root)-1)).$tmp_htaccess)){
			$tests['htaccess_scale_php_found'] = true;
		}
	}
}


print_r($tests);

// print_r($_SERVER);

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Configuration</title>
</head>
<body>
	
</body>
</html>