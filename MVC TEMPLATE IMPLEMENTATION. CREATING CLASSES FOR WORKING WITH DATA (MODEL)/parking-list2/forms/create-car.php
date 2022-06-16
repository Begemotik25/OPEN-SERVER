<?php
include(__DIR__ . "/../auth/check-auth.php");

if($_POST) {
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/edit-car-form-style.css">
    <title>Додавання машин</title>
</head>
<body>
    <a href="../index.php?parking=<?php echo $_GET['parking']; ?>">На головну</a>
    <form name='create-car' method="post">
    <div>
        <label for='car_number'>Номер машини: </label>
        <input type="text" name="car_number">
    </div>
    <div>
        <label for='car_brand'>Марка машини: </label>
        <input type="text" name="car_brand">
    </div>
    <div>
        <label for='car_str'>Страховка машини: </label>
        <select name="car_str">
            <option disabled>Страховка машини</option>
            <option value="Insured">Insured</option>
            <option value="Uninsured">Uninsured</option>
        </select>
    </div>
    <div>
        <label for='car_number_of_parking'>Номер місця на стоянці: </label>
        <input type="text" name="car_number_of_parking">
    </div>
    <div>
        <label for='car_data'>Дата: </label>
        <input type="date" name="car_data" >
    </div>
    <div>
        <input type="checkbox" name="car_rozm" value="1"> Розмитнена
    </div>
    <div>
        <input type="submit" name="Ok" value="Додати">
    </div>
    </form>
</body>
</html>