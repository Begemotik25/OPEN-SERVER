<?php
include(__DIR__ . "/../auth/check-auth.php");

require_once '../model/autorun.php';
$myModel = Model\Data::makeModel(Model\Data::FILE);
$myModel->setCurrentUser($_SESSION['user']);

$car = (new \Model\Car())->setId($_GET['file'])->setParkingId($_GET['parking']);
if (!$myModel->removeCar($car)) {
    die($myModel->getError());
} else {
    header('Location: ../index.php?parking=' . $_GET['parking']);
}




