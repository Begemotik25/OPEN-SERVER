<?php
include(__DIR__ . "/../auth/check-auth.php");

require_once '../model/autorun.php';
$myModel = Model\Data::makeModel(Model\Data::FILE);
$myModel->setCurrentUser($_SESSION['user']);

if($_POST) {
    $car = (new \Model\Car())
        ->setId($_GET['file'])
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
    if(!$myModel->writeCar($car)){
        die($myModel->getError());
    } else {
        header('Location: ../index.php?parking=' . $_GET['parking']);
    } 
}
    $car = $myModel->readCar($_GET['parking'], $_GET['file']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/edit-car-form-style.css">
    <title>Редагування машин</title>
</head>
<body>
    <a href="../index.php?parking=<?php echo $_GET['parking'];?>">На головну</a>
    <form name='edit-car' method="post">
    <div>
        <label for='car_number'>Номер машини: </label>
        <input type="text" name="car_number" value = '<?php echo $car->getNumber(); ?>'>
    </div>
    <div>
        <label for='car_brand'>Марка машини: </label>
        <input type="text" name="car_brand" value='<?php echo $car->getBrand(); ?>'>
    </div>
    <div>
        <label for='car_str'>Страховка машини: </label>
        <select name="car_str">
            <option disabled>Страховка машини</option>
            <option <?php echo($car->isStrInsured())?"selected":""; ?> value="Insured">Insured</option>
            <option <?php echo($car->isStrUninsured())?"selected":""; ?> value="Uninsured">Uninsured</option>
        </select>
    </div>
    <div>
        <label for='car_number_of_parking'>Номер місця на стоянці: </label>
        <input type="text" name="car_number_of_parking" value="<?php echo $car->getNumber_Parking(); ?>">
    </div>
    <div>
        <label for='car_data'>Дата: </label>
        <input type="date" name="car_data" value = "<?php echo $car->getData()->format('Y-m-d'); ?>">
    </div>
    <div>
        <input type="checkbox" <?php echo ($car->isRozm())?"checked":""; ?> name = "car_rozm" value = "1"> Розмитнена
    </div>
    <div>
        <input type="submit" name="Ok" value="Змінити">
    </div>
    </form>
</body>
</html>