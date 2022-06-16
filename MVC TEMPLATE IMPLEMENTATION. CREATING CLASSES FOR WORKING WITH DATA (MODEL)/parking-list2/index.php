<?php
require('auth/check-auth.php');

require_once 'model/autorun.php';
$myModel = Model\Data::makeModel(Model\Data::FILE);
$myModel->setCurrentUser($_SESSION['user']);

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
    <div class="user-info">
        <span>Hello <?php echo $_SESSION['user']; ?>!</span>
        <?php if($myModel->CheckRight('user', 'admin')): ?>
            <a href="admin/index.php">Адміністрування</a>
        <?php endif; ?>
        <a href="auth/logout.php">Logout</a>
    </div>
    <?php if($myModel->CheckRight('parking', 'view')): ?>
        <?php $data['parkings'] = $myModel->readParkings(); ?>
        <form method='get' name='parking-form'>
            <label for="parking">Адреса</label>
            <select name="parking">
                <option value=""></option>
                <?php
                    foreach($data['parkings'] as $curparking) {
                        echo "<option " . (($_GET['parking'] == $curparking->getId())?"selected":"") .  " value=" . $curparking->getId(). ">" . $curparking->getAdress() ."</option>";
                    }
                ?>
            </select>
            <input type="submit" value="Ok">
            <?php if($myModel->CheckRight('parking', 'create')): ?>
                <a href="forms/create-parking.php">Додати парковку</a>
            <?php endif; ?>
        </form>
        <?php if($_GET['parking']): ?>
            <?php 
                $data['parking'] = $myModel->readParking($_GET['parking']);  
            ?>
         <h1>Адреса: <span class="parking-adress"><?php echo $data['parking']->getAdress(); ?></span></h1>
        <h2>Директор: <span class="parking-director"><?php echo $data['parking']->getDirector(); ?></span></h2>
        <div class="control">
            <?php if($myModel->CheckRight('parking', 'edit')): ?>
                <a href="forms/edit-parking.php?parking=<?php echo $_GET['parking']; ?>">Редагувати парковку</a>
            <?php endif; ?>
            <?php if($myModel->CheckRight('parking', 'delete')) :?>
                <a href="forms/delete-parking.php?parking=<?php echo $_GET['parking']; ?>">Видалити парковку</a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    <?php endif; ?> 
</header>
    <?php if($myModel->CheckRight('car','view')): ?>
        <?php $data['cars'] = $myModel->readCars($_GET['parking']); ?>
        <section>
            <?php if ($_GET['parking']): ?> 
                <?php if($myModel->CheckRight('car', 'create')):?>
                    <div class="control">
                        <a href="forms/create-car.php?parking=<?php echo $_GET['parking']; ?>">Додати авто</a>
                    </div>
                <?php endif; ?>
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
            <th>Страховка</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php if (count($data['cars']) > 0): ?>
        <?php foreach ($data['cars'] as $key => $car): ?>
            <?php if(!$_POST['car_name_filter'] || stristr($car->getBrand(), $_POST['car_name_filter'])): ?>
            <?php
            $row_class = "row";
            if ($car->isStrInsured()) {
                $row_class = "car-first";
            }
            if ($car->isStrUninsured()) {
                $row_class = "car-second";
            }
            ?>
        	<tr class = "<?php echo $row_class; ?>">
                <td><?php echo ($key+1); ?></td>
                <td><?php echo $car->getNumber(); ?></td>
                <td><?php echo $car->getBrand(); ?></td>
                <td><?php echo $car->getNumber_Parking(); ?></td>
                <td>
                    <?php
                    echo date_format($car->getData(),'Y');
                    ?>
                </td>
                <td><?php echo $car->isStrInsured()? 'Insured':'Uninsured'; ?></td>
                <td>
                <?php if($myModel->CheckRight('car','edit')):?>
                        <a href="forms/edit-car.php?parking=<?php echo $_GET['parking']; ?>&file=<?php echo $car->getId();?>">Редагувати</a>
                    <?php endif; ?>
                    <?php if($myModel->CheckRight('car','delete')):?>
                        <a href="forms/delete-car.php?parking=<?php echo $_GET['parking']; ?>&file=<?php echo $car->getId();?>">Видалити</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endif; ?>
            <?php endforeach; ?>
            <?php endif; ?>
             </tbody>
            </table>
            <?php endif; ?>
        </section>
    <?php endif; ?>
</body>
</html>



