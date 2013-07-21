<?php 

$file = $_SERVER['REQUEST_URI'];
$file = explode('/',$file);
$filename = $file[(count($file)-1)];

$original_file = $_SERVER['REQUEST_URI'];
$original_file = explode('img/scale/',$original_file);
$original_file = $original_file[(count($original_file)-1)];

$original_file = explode('/',$original_file);

$width = $original_file[0];
$height = $original_file[1];
unset($original_file[1]);
unset($original_file[0]);
$original_file = '/'.implode('/',$original_file);


unset($file[(count($file)-1)]);

$path = getcwd().implode('/',$file);

if(!is_dir($path)){
mkdir($path,0766,true);
}



$scaled_filepath = $path.'/'.$filename;
if(!is_file($scaled_filepath)){
	$orig_filepath = getcwd().$original_file;


	$image = new Imagick($orig_filepath);

	$image->thumbnailImage(intval($width),0);

	$image->writeImage($scaled_filepath);

}
?>