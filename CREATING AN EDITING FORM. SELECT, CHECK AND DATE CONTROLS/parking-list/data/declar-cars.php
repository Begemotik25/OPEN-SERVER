<?php

 $path = __DIR__. '/cars';
 $conts = scandir($path);

 $nameTpl = "/^car-\d\d.txt\z/";

 $i = 0;
 foreach($conts as $node){
	 if(preg_match($nameTpl, $node)){
		$data['cars'][$i] = require __DIR__. '/declar-car.php';
		$i++;
	}
 }