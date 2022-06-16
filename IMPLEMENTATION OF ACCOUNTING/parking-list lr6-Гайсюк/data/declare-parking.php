<?php
$f = fopen(__DIR__ . "/" . $parkingFolder . "/parking.txt","r");
$grStr = fgets($f); 
$grArr = explode (";",$grStr);
fclose($f);

$data['parking'] = array(
	'adress' => $grArr[0],
	'director' => $grArr[1],
);