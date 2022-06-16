<?php
$f= fopen(__DIR__. "/cars.txt","r");
$i=0;
while(!feof($f)){
	$rowStr=fgets($f);
	$rowArr=explode(";",$rowStr);
	$data['cars'][$i]["number"] = $rowArr[0];
	$data['cars'][$i]["brand"] = $rowArr[1];
	$data['cars'][$i]["parking"] = $rowArr[2];
	$i++;	
}
fclose($f);