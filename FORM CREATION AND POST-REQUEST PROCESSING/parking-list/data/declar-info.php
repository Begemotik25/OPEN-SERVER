<?php
$f = fopen(__DIR__. "/parking.txt","r");
$grStr = fgets($f);
$grArr = explode(";",$grStr);
fclose($f);

$data['info'] = array(
	'adress'=> $grArr[0],
	'director'=> $grArr[1],
);

