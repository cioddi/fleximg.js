<?php 

include 'lib/Fleximg.class.php';

$fleximgObj = new Fleximg(array(
	'steps' => 50
));
$fleximgObj->generate();

?>
