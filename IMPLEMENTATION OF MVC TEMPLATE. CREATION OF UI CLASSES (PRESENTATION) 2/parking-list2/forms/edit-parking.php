<?php
include(__DIR__ . "/../auth/check-auth.php");

require_once '../model/autorun.php';
$myModel = Model\Data::makeModel(Model\Data::FILE);
$myModel->setCurrentUser($_SESSION['user']);

if($_POST){
    if (!$myModel->writeParking((new \Model\Parking())
    ->setId($_GET['parking'])
    ->setAdress($_POST['adress'])
    ->setDirector($_POST['director'])
    )) {
        die($myModel->getError());
    } else {
        header('Location: ../index.php?parking=' . $_GET['parking']);
    } 
}
if (!$parking = $myModel->readParking($_GET['parking'])) {
    die($myModel->getError());
}
require_once '../view/autorun.php';
$myView = \View\ParkingListView::makeView(\View\ParkingListView::SIMPLEVIEW);
$myView->setCurrentUser($myModel->getCurrentUser());

$myView->showParkingEditForm($parking);