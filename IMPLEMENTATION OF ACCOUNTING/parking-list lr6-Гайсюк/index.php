<?php
require('data/declare-parkings.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Список машин</title>
    <link rel="stylesheet" type="text/css" href="css/main-style.css">
    <link rel="stylesheet" type="text/css" href="css/car-style.css">
    <link rel="stylesheet" type="text/css" href="css/parking-choose-style.css">
    
</head>
<body>
    <header>
        <form method='get' name='parking-form'>
            <label for="parking">Адреса</label>
            <select name="parking">
                <option value=""></option>
                <?php
                foreach($data['parkings'] as $curparking) {
                    echo "<option " . (($_GET['parking']==$curparking['file'])?"selected":"") .  " value=" . $curparking['file'] . ">" . $curparking['adress'] ."</option>";
                }
                ?>
            </select>
            <input type="submit" value="Ok">
            <a href="forms/create-parking.php">Додати парковку</a>
        </form>
        <?php if ($_GET['parking']): ?>
            <?php 
            $parkingFolder = $_GET['parking'];
            require('data/declare-data.php');  
        ?>
        <h1>Адреса: <span class="parking-adress"><?php echo $data['parking']['adress']; ?></span></h1>
        <h2>Директор: <span class="parking-director"><?php echo $data['parking']['director']; ?></span></h2>
        <div class="control">
        <a href="forms/edit-parking.php?parking=<?php echo $_GET['parking']; ?>">Редагувати парковку</a>
        <a href="forms/delete-parking.php?parking=<?php echo $_GET['parking']; ?>">Видалити парковку</a>
        </div>
        <?php endif; ?>
    </header>
    <section>
    <?php if ($_GET['parking']): ?> 
    <div class="control">
        <a href="forms/create-car.php?parking=<?php echo $_GET['parking']; ?>">Додати авто</a>
    </div>
    <form method="post" name="car-filter">
    Фільтрувати за назвою <input type="text" name="car_name_filter" value = '<?php echo $_POST['car_name_filter']; ?>'>
    <input type="submit" value="Фільтрувати">
    </form>
        <table>
        <thead> 
        <tr>
            <th>№ п.п.</th>
            <th>Держ.номер</th>
            <th>Марка</th>
            <th>Номер місця</th>
            <th>Дата</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        	<?php foreach ($data['cars'] as $key => $car): ?>
            <?php
            $row_class = "row";
            if ($car['brand'] == "Bugatti") {
                $row_class = "car-first";
            }
            if ($car['brand'] == "Mercedes-Benz") {
                $row_class = "car-second";
            }
            if ($car['brand'] == "Bentley") {
                $row_class = "car-first";
            }
            if ($car['brand'] == "Hyundai") {
                $row_class = "car-second";
            }
            if ($car['brand'] == "Land Rover") {
                $row_class = "car-first";
            }
            ?>
            <?php if(!$_POST['car_name_filter'] || stristr($car['brand'], $_POST['car_name_filter'])): ?>
        	<tr class="<?php echo $row_class; ?>">
                <td><?php echo ($key+1); ?></td>
                <td><?php echo $car['number']; ?></td>
                <td><?php echo $car['brand']; ?></td>
                <td><?php echo $car['number_parking']; ?></td>
                <td>
                    <?php
                    $date=new Datetime($car['data']);
                    echo date_format($date,'Y');
                    ?>
                </td>
                <td>
                    <a href="forms/edit-car.php?parking=<?php echo $_GET['parking']; ?>&file=<?php echo $car['file'];?>">Редагувати</a>
                    <a href="forms/delete-car.php?parking=<?php echo $_GET['parking']; ?>&file=<?php echo $car['file'];?>">Видалити</a>
                </td>
            </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
        </table>
        <?php endif; ?>
    </section>
</body>
</html>
