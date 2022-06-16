<?php
    require 'data/config.php';   
    require 'controller/autorun.php';
    $controller = new \Controller\ParkingListApp(Config::$modelType, Config::$viewType);
    $controller->run();

    

