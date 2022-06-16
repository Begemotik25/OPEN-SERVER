<?php

$nameTpl = '/^car-\d\d.txt\z/';
$path = __DIR__ . "/" . $parkingFolder;
$conts = scandir($path);

$i=0;
foreach($conts as $node){
	if(preg_match($nameTpl, $node)) {
		$data['cars'][$i] = require __DIR__ . "/declare-car.php";
		$i++;
	}
}