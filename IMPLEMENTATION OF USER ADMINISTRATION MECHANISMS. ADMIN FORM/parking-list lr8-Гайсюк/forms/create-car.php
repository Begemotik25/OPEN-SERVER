<?php
include(__DIR__ . "/../auth/check-auth.php");
if(!CheckRight('car', 'edit')) {
    die('Ви не маєте прав на виконання даної операції !');
}
if($_POST) {
    //визначаємо останній файл авто на стоянці
    $nameTpl = '/^car-\d\d.txt\z/';
    $path = __DIR__. "/../data/" . $_GET['parking'];
    $conts = scandir($path);
    $i = 0;
    foreach($conts as $node) {
        if(preg_match($nameTpl, $node)) {
            $last_file = $node;
        }
    }
    //отримуємо індекс останнього файлу та збільшуємо на 1
    $file_index = (String)(((int)substr($last_file, -6, 2)) + 1);
    if (strlen($file_index) == 1) {
        $file_index = "0" . $file_index;
    }
    //формуємо ім'я нового файлу
    $newFileName = "car-" . $file_index . ".txt";
    //зберігаємо дані у файл
    $f = fopen ("../data/". $_GET['parking'] . "/" . $newFileName , "w");
    $rozm = 0;
    if($_POST['car_rozm'] == 1) {
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/edit-car-form-style.css">
    <title>Додавання машин</title>
</head>
<body>
    <a href="../index.php">На головну</a>
    <form name='create-car' method="post">
    <div>
        <label for='car_number'>Номер машини: </label>
        <input type="text" name="car_number">
    </div>
    <div>
        <label for='car_brand'>Марка машини: </label>
        <select name="car_brand">
            <option disabled>Марка машини</option>
            <option value="Bugatti">Bugatti</option>
            <option value="Mercedes-Benz">Mercedes-Benz</option>
            <option value="Bentley">Bentley</option>
            <option value="Hyundai">Hyundai</option>
            <option value="Land Rover">Land Rover</option>
        </select>
    </div>
    <div>
        <label for='car_number_of_parking'>Номер місця на стоянці: </label>
        <input type="text" name="car_number_of_parking" >
    </div>
    <div>
        <label for='data'>Дата: </label>
        <input type="date" name="data" >
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