<?php  
    if($_POST){
        $f = fopen("../data/cars/" . $_GET['file'], 'w');
        $cost=0;
        if ($_POST['car_cost'] == 1){
            $cost=1;
        }
        $grArr = array(
            $_POST ['car_number'],
            $_POST['car_brand'], 
            $_POST['car_pad'], 
            $cost,
        );
        $grStr =  implode(";",$grArr);
        fwrite($f,$grStr);
        fclose($f);
        header('Location: ../index.php');
    }
    $path = __DIR__ . "/../data/cars";
    $node = $_GET['file'];
    $car = require __DIR__. '/../data/declar-car.php';
	var_dump($car);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редагування машин</title>
    <link rel="stylesheet" type="text/css" href="../css/edit-carS-form-style.css">
</head>
<body> 
    <a href="../index.php">На головну</a>
    <form name ='edit-car' method='post'>
        <div>
            <label for='car_number'>Номер :</label>
            <input type="text" name="car_number" value=<?php echo $car['number']; ?>> 
        </div>
        <div>
            <label for='car_brand'>Марка :</label>
            <select name="car_brand">
                <option disabled>Марка</option>
                <option <?php echo ("Ferrari" == $car['brand'])?"selected":""; ?> value ="Ferrari">Ferrari</option>
                <option <?php echo ("Mercedes-Benz" == $car['brand'])?"selected":"" ; ?> value ="Mercedes-Benz">Mercedes-Benz</option>
                <option <?php echo ("Rolls-Royce" == $car['brand'])?"selected":"" ; ?> value ="Rolls-Royce">Rolls-Royce</option>
                <option <?php echo ("Bugatti"== $car['brand'])?"selected":"" ; ?> value ="Bugatti">Bugatti</option>
                <option <?php echo ("Chevrolet"== $car['brand'])?"selected":"" ; ?> value ="Chevrolet">Chevrolet</option>
            </select>
        </div>
        <div>
            <label for='car_pad'>Дата :</label>
            <input type="date" name="car_pad" value='<?php echo $car['pad']; ?>'>
        </div>
        <div>
            <input type="checkbox" <?php echo ("1" == $car['cost'])?"checked":""; ?> name="car_cost" value=1> Ціна(у дол.)
        </div>
        <div>
            <input type="submit" name="ok" value="змінити">
        </div>
    </form>
</body>
</html>