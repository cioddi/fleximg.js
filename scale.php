<?php 

include 'lib/Fleximg.class.php';

$fleximgObj = new Fleximg();
$fleximgObj->generate();
$fleximgObj->redirect();

?>
