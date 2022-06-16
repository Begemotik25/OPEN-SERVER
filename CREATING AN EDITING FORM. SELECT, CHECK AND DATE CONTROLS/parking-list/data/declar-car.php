<?php
$f= fopen($path . "/" . $node,"r");
$rowStr=fgets($f);
$rowArr=explode(";",$rowStr);
$car["file"] = $node;
$car["number"] = $rowArr[0];
$car["brand"] = $rowArr[1];
$car["pad"] = $rowArr[2];
$car["cost"] = $rowArr[3];
fclose($f);

return $car; 