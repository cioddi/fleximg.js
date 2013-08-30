<?php 

include 'lib/Fleximg.class.php';

$fleximgObj = new Fleximg(array(
	'steps' => 100
));
$fleximgObj->generate();

?>
