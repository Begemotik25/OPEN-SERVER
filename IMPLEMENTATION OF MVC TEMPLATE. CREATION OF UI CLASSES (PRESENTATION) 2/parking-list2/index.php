<?php
require('auth/check-auth.php');

require_once 'model/autorun.php';
$myModel = Model\Data::makeModel(Model\Data::FILE);
$myModel->setCurrentUser($_SESSION['user']);

require_once 'view/autorun.php';
$myView = \View\ParkingListView::makeView(\View\ParkingListView::SIMPLEVIEW);
$myView->setCurrentUser($myModel->getCurrentUser());

$parkings = array();
if($myModel->checkRight('parking', 'view')) {
    $parkings = $myModel->readParkings();
}

$parking = new \Model\Parking();
if($_GET['parking'] && $myModel->checkRight('parking', 'view')) {
    $parking = $myModel->readParking($_GET['parking']);
}

$cars = array();
if($_GET['parking'] && $myModel->checkRight('car', 'view')) {
    $cars = $myModel->readCars($_GET['parking']);
}

$myView->showMainForm($parkings, $parking, $cars);
