<?php
include(__DIR__ . "/../auth/check-auth.php");

if($_POST) 
{
    require_once '../model/autorun.php';
    $myModel = Model\Data::makeModel(Model\Data::FILE);
    $myModel->setCurrentUser($_SESSION['user']);

    $car = (new \Model\Car())
        ->setParkingId($_GET['parking'])
        ->setNumber($_POST['car_number'])
        ->setBrand($_POST['car_brand'])
        ->setNumber_Parking($_POST['car_number_of_parking'])
        ->setData(new DateTime($_POST['car_data']))
        ->setRozm($_POST['car_rozm'])
        ->setUninsuredStr();
    if($_POST['car_str'] == 'Insured') {
        $car->setInsuredStr();
    }
    if(!$myModel->addCar($car)){
        die($myModel->getError());
    } else {
        header('Location: ../index.php?parking=' . $_GET['parking']);
    }
}

    require_once '../view/autorun.php';
    $myView = \View\ParkingListView::makeView(\View\ParkingListView::SIMPLEVIEW);

    $myView->showCarCreateForm();


