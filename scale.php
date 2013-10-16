<?php 

include 'lib/Fleximg.class.php';

$fleximgObj = new Fleximg(array(
	'steps' => 50,
	'jpeg_compression' => 75
));
$fleximgObj->generate();

?>
