<?php

require_once '../controller/autorun.php';
require_once '../data/config.php';

$db = new \Model\MySQLdb();
$db->connect();
$db->runQuery("delete from cars");
$db->runQuery("delete from parkings");
$db->runQuery("delete from users");

$fileModel = \Model\Data::makeModel(\Model\Data::FILE);
$fileModel->setCurrentUser('admin');

$users = $fileModel->readUsers();
foreach($users as $user) {
    $db->runQuery("insert into users(username,passwd,rights) values('" . $user->getUserName() . "', '" . 
    $user->getPassword() . "', '" . $user->getRights() . "')");
}

$dbModel = \Model\Data::makeModel(\Model\Data::DB);
$dbModel->setCurrentUser('admin');

$parkings = $fileModel->readParkings();

foreach($parkings as $parking) {
    $sql = "insert into parkings(adress, director) 
    values ('" . $parking->getAdress() . "' , '" . $parking->getDirector() . "')";
     
    $db->runQuery($sql); 
    $res = $db->getArrFromQuery('select max(id) id from parkings');

    $prk_id = $res[0]['id'];
    $cars = $fileModel->readCars($parking->getId());
    foreach ($cars as $car) {
        $car->setParkingId($prk_id);
        $dbModel->addCar($car);

    }
}

$db->disconnect();
