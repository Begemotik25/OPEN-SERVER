<?php
if($_POST){
// визначаємо останній файл студента в групі
$nameTpl = '/^car-\d\d.txt\z/';
$path = __DIR__ . "/../data/cars";
$conts = scandir($path);
$i=0;
foreach($conts as $node){
    if(preg_match($nameTpl,$node)){
        $last_file = $node;
    }
}

//отримуємо індекс останнього файлу та збільшуємо на 1
$file_index = (String)(((int)substr($last_file, -6, 2)) +1);
if (strlen($file_index) == 1) {
    $file_index = "0" . $file_index;
}
//формуємо ім'я нового файлу
$newFileName = "car-" . $file_index . ".txt";
//зберігаємо дані у файл
$f = fopen("../data/cars/" . $newFileName,"w");
$cost = 0;
if($_POST['car_cost'] == 1){
    $cost = 1;
}
$grArr = array($_POST['car_number'], $_POST['car_brand'], $_POST['car_pad'], $_POST['car_pad'], $cost,);
$grStr = implode (";",$grArr);
fwrite($f,$grStr);
fclose($f);
header('Location: ../index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Додавання машин</title>
    <link rel="stylesheet" type="text/css" href="../css/edit-carS-form-style.css">
</head>
<body> 
    <a href="../index.php">На головну</a>
    <form name ='create-car' method='post'>
        <div>
            <label for='car_number'>Номер :</label>
            <input type="text" name="car_number">
        </div>
        <div>
            <label for='car_brand'>Марка :</label>
            <select name="car_brand">
                <option disabled>Марка</option>
                <option value ="Ferrari">Ferrari</option>
                <option value ="Mercedes-Benz">Mercedes-Benz</option>
                <option value ="Rolls-Royce">Rolls-Royce</option>
                <option value ="Bugatti">Bugatti</option>
                <option value ="Chevrolet">Chevrolet</option>
            </select>
        </div>
        <div>
            <label for='car_pad'>Дата :</label>
            <input type="date" name="car_pad">
        </div>
        <div>
            <input type="checkbox" name="car_cost" value=1> Ціна(у дол.)
        </div>
        <div>
            <input type="submit" name="ok" value="Додати">
        </div>
    </form>
</body>
</html>