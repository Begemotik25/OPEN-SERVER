<?php
if($_POST){
    $f = fopen("../data/" . $_GET['parking'] . "/" . $_GET['file'], "w");
    $rozm = 0;
    if($_POST['car_rozm'] == 1){
        $rozm = 1;
    }
    $grArr = array(
        $_POST['car_number'], 
        $_POST['car_brand'],
        $_POST['car_number_of_parking'], 
        $_POST['data'], 
        $rozm,
    );
    $grStr = implode(";", $grArr);
    fwrite($f,$grStr);
    fclose($f);
    header('Location: ../index.php?parking=' . $_GET['parking']);
}
$path = __DIR__ . "/../data/" . $_GET['parking'];
$node = $_GET['file'];
$car = require __DIR__ . '/../data/declare-car.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/edit-car-form-style.css">
    <title>Редагування машин</title>
</head>
<body>
    <a href="../index.php">На головну</a>
    <form name='edit-car' method="post">
    <div>
        <label for='car_number'>Номер машини: </label>
        <input type="text" name="car_number" value='<?php echo $car['number']; ?>'>
    </div>
    <div>
        <label for='car_brand'>Марка машини: </label>
        <select name="car_brand">
            <option disabled>Марка машини</option>
            <option <?php echo("Bugatti" == $car['brand'])?"selected":""; ?> value="Bugatti">Bugatti</option>
            <option <?php echo("Mercedes-Benz" == $car['brand'])?"selected":""; ?> value="Mercedes-Benz">Mercedes-Benz</option>
            <option <?php echo("Bentley" == $car['brand'])?"selected":""; ?> value="Bentley">Bentley</option>
            <option <?php echo("Hyundai" == $car['brand'])?"selected":""; ?> value="Hyundai">Hyundai</option>
            <option <?php echo("Land Rover" == $car['brand'])?"selected":""; ?> value="Land Rover">Land Rover</option>
        </select>
    </div>
    <div>
        <label for='car_number_of_parking'>Номер місця на стоянці: </label>
        <input type="text" name="car_number_of_parking" value="<?php echo $car["number_parking"]; ?>">
    </div>
    <div>
        <label for='data'>Дата: </label>
        <input type="date" name="data" value="<?php echo date_format(new Datetime($car["data"]),'Y-m-d'); ?>">
    </div>
    <div>
        <input type="checkbox" <?php echo ("1" == $car['rozm'])?"checked":""; ?> name = "car_rozm" value = "1"> Розмитнена
    </div>
    <div>
        <input type="submit" name="Ok" value="Змінити">
    </div>
    </form>
</body>
</html>