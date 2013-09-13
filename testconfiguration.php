<?php

$tests = array(
	'imagick' 									=> array(
		'value' 					=> false,
		'title'						=> 'ImageMagick',
		'success_message'	=> 'The ImageMagick Apache is installed and working.',
		'failure_message'	=> 'The ImageMagick Apache module is not installed on this server.'
		),
	'gd' 												=> array(
		'value' 					=> false,
		'title'						=> 'GD Lib',
		'success_message'	=> 'The GD Lib Apache is installed and working.',
		'failure_message'	=> 'The GD Lib Apache module is not installed on this server.'
		),
	'image_folder'							=> array(
		'value' 					=> false,
		'title'						=> 'Image folder exists',
		'success_message'	=> 'The target image folder \'_document_root/img/fleximg_scale\' was found.',
		'failure_message'	=> 'The target image folder \'_document_root/img/fleximg_scale\' was not found. Please create the folders /img/fleximg_scale in your servers document root and make sure it is writable',
		),
	'image_folder_writable'			=> array(
		'value' 					=> false,
		'title'						=> 'Image folder writable',
		'depends_on' 			=> 'image_folder',
		'success_message'	=> 'The target image folder \'_document_root/img/fleximg_scale\' is writable.',
		'failure_message'	=> 'The target image folder \'_document_root/img/fleximg_scale\' is not writable. Please make sure to give your apache user read and write access to /img/fleximg_scale in your servers document root'
		),
	'modrewrite'								=> array(
		'value' 					=> false,
		'title'						=> 'mod rewrite',
		'success_message'	=> 'The mod_rewrite Apache is installed and working.',
		'failure_message'	=> 'The mod_rewrite Apache module is not installed on this server.'
		),
	'htaccess_file_exists'			=> array(
		'value' 					=> false,
		'title'						=> '.htaccess file exists',
		'success_message'	=> 'Your .htaccess file was found in the right place.',
		'failure_message'	=> 'No .htaccess file found. Please create a file named .htaccess in your servers document root.'
		),
	'htaccess_fleximgcfg_exists'=> array(
		'value' 					=> false,
		'title'						=> 'fleximg.js .htaccess config',
		'depends_on' 			=> 'htaccess_file_exists',
		'success_message'	=> 'Fleximg.js configuration was found in your .htaccess file and seems to be correct.',
		'failure_message'	=> 'Fleximg.js configuration has not been not found in your .htaccess file.'
		),
	'htaccess_scale_php_found'	=> array(
		'value' 					=> false,
		'title'						=> 'fleximg.js .htaccess config: scale.php found',
		'depends_on' 			=> 'htaccess_fleximgcfg_exists',
		'success_message'	=> 'The file scale.php you are referencing to from the .htaccess file was found in the right place.',
		'failure_message'	=> 'The file scale.php you are referencing to from the .htaccess file was not found. Please make sure scale.php exists at _var_ on your server'
		)
	);

// get server document root
$doc_root = $_SERVER['DOCUMENT_ROOT'];
if(substr($doc_root, -1) !== '/')$doc_root = $doc_root.'/';

// IMAGEMAGICK is loaded
if (extension_loaded('imagick')){
	$tests['imagick']['value'] = true;
}

// GD LIB is loaded
if (extension_loaded('gd')){
	$tests['gd']['value'] = true;
}

// Image folder is in place
if(file_exists($doc_root.'img/fleximg_scale/')){
	$tests['image_folder']['value'] = true;
}

// Image folder is writable
touch($doc_root.'img/fleximg_scale/testfile');
if(file_exists($doc_root.'img/fleximg_scale/testfile')){
	unlink($doc_root.'img/fleximg_scale/testfile');
	$tests['image_folder_writable']['value'] = true;
}

// mod_rewrite is loaded
if (function_exists('apache_get_modules')) {
	if(in_array('mod_rewrite', apache_get_modules())){
		$tests['modrewrite']['value'] = true;	
	}
}


// check .htaccess config
$htaccess_contents = file_get_contents($doc_root.'.htaccess');

if($htaccess_contents){

	$tests['htaccess_file_exists']['value'] = true;
	
	if(strpos($htaccess_contents, 'RewriteRule img/fleximg_scale/. ')){
		$tests['htaccess_fleximgcfg_exists']['value'] = true;

		$tmp_htaccess = explode('RewriteRule img/fleximg_scale/. ',$htaccess_contents);
		$tmp_htaccess = $tmp_htaccess[1];


		$tmp_htaccess = explode('\n',$tmp_htaccess);
		$tmp_htaccess = $tmp_htaccess[0];
		$tmp_htaccess = explode(' ',$tmp_htaccess);
		$tmp_htaccess = $tmp_htaccess[0];

		// echo substr($doc_root, 0, (strlen($doc_root)-1)).$tmp_htaccess;
		$tests['htaccess_scale_php_found']['var'] = $tmp_htaccess;
		if(file_exists(substr($doc_root, 0, (strlen($doc_root)-1)).$tmp_htaccess)){
			$tests['htaccess_scale_php_found']['value'] = true;
		}
	}
}


// print_r($tests);

// print_r($_SERVER);

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Configuration</title>
</head>
<body>
	<style>
		.container{
			width:800px;
			margin:0 auto;
			font-family: sans-serif;
			color:#fff;

		}

		.container > div{
			width: 100%;
			border-radius:5px;
			padding: 10px;
			margin-top: 10px;
		}
		.container h2{
			margin-top: 0px;
		}
		.container .success{
			border: 2px solid green;
			background-color: rgba(100,200,100,0.7);
			text-shadow: 2px 2px 0px green;
		}
		.container .failure{
			border: 2px solid red;
			background-color: rgba(200,100,100,0.7);
			text-shadow: 2px 2px 0px red;
		}

	</style>
	<div class="container">
		<?php 
			foreach($tests as $key => $test){
				$class = 'failure';
				if($test['value'])$class = 'success';


				if(isset($test['var']) && strpos($test[$class.'_message'], '_var_')){

					$test[$class.'_message'] = str_replace('_var_', $test['var'], $test[$class.'_message']);
				}
				echo '<div class="'.$class.'">
				<h2>'.$test['title'].'</h2>
				'.$test[$class.'_message'].'</div>';
			}
		?>

	</div>
	
</body>
</html>