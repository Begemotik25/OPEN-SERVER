<?php
$nameTpl = '/^parking-\d\d\z/';
    $path = __DIR__;
    $conts = scandir($path);

    $i = 0;
    foreach($conts as $node) {
        if(preg_match($nameTpl, $node)) {
            $parkingFolder = $node;
            require(__DIR__ . '/declare-parking.php');

            $data['parkings'][$i]['adress'] = $data['parking']['adress'];
            $data['parkings'][$i]['file'] = $parkingFolder;
            $i++;
        }
    }