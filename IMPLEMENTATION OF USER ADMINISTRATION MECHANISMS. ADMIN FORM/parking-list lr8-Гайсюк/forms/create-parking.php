<?php
include(__DIR__ . "/../auth/check-auth.php");
if(!CheckRight('parking', 'create')) {
    die('Ви не маєте прав на виконання даної операції !');
}
    //визначаємо останню папку парковки
    $nameTpl = '/^parking-\d\d\z/';
    $path = __DIR__. "/../data/";
    $conts = scandir($path);
    $i = 0;
    foreach($conts as $node) {
        if(preg_match($nameTpl, $node)) {
            $last_parking = $node;
        }
    }
    //отримуємо індекс останньої папки та збільшуємо на 1
    $parking_index = (String)(((int)substr($last_parking, -1, 2)) + 1);
    if (strlen($parking_index) == 1) {
        $parking_index = "0" . $parking_index;
    }
    //формуємо ім'я нової папки
    $newParkingName = "parking-" . $parking_index;
    
    mkdir(__DIR__."/../data/" . $newParkingName);
    $f = fopen(__DIR__. "/../data/" . $newParkingName . "/parking.txt","w");
    fwrite($f, "New; ;");
    fclose($f);
    header('Location: ../index.php?parking=' . $newParkingName);

