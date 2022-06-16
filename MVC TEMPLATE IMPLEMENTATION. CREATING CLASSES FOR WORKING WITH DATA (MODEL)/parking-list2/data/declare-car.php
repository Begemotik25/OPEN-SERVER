<?php
$f = fopen($path. "/" . $node,"r");

$rowStr = fgets($f); 
$rowArr = explode(";",$rowStr);
$car['file']= $node;
$car['number']= $rowArr[0];
$car['brand']= $rowArr[1];
$car['number_parking']= $rowArr[2];
$car['data']= $rowArr[3];
$car['str']= $rowArr[4];
$car['rozm']= $rowArr[5];

fclose($f);

return $car;