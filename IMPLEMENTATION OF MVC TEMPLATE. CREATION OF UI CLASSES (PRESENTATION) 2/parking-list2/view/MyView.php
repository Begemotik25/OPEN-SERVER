<?php

namespace View;

class MyView extends ParkingListView {
    private function showParkings($parkings) {
        ?>
        <form method='get' name='parking-form'>
            <label for="parking">Стоянка</label>
            <select name="parking">
                <option value=""></option>
                <?php
                    foreach($parkings as $curparking) {
                        echo "<option " . (($_GET['parking'] == $curparking->getId())?"selected":"") .  " value=" . $curparking->getId(). ">" . $curparking->getAdress() ."</option>";
                    }
                ?>
            </select>
            <input type="submit" value="Ok">
            <?php if($this->checkRight('parking', 'create')): ?>
                <a href="forms/create-parking.php">Додати парковку</a>
            <?php endif; ?>
        </form>
        <?php
    }

    private function showParking(\Model\Parking $parking) {
        ?>
        <h1>Адреса: <span class="parking-adress"><?php echo $parking->getAdress(); ?></span></h1>
        <h2>Директор: <span class="parking-director"><?php echo $parking->getDirector(); ?></span></h2>
        <div class="control">
            <?php if($this->checkRight('parking', 'edit')): ?>
                <a href="forms/edit-parking.php?parking=<?php echo $_GET['parking']; ?>">Редагувати парковку</a>
            <?php endif; ?>
            <?php if($this->checkRight('parking', 'delete')) :?>
                <a href="forms/delete-parking.php?parking=<?php echo $_GET['parking']; ?>">Видалити парковку</a>
            <?php endif; ?>
        </div>
        <?php
    }

    private function showCars($cars) {
        ?>
        <section>
            <?php if ($_GET['parking']): ?> 
                <?php if($this->checkRight('car', 'create')):?>
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
        <?php if (count($cars) > 0): ?>
        <?php foreach ($cars as $key => $car): ?>
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
                <?php if($this->checkRight('car','edit')):?>
                        <a href="forms/edit-car.php?parking=<?php echo $_GET['parking']; ?>&file=<?php echo $car->getId();?>">Редагувати</a>
                    <?php endif; ?>
                    <?php if($this->checkRight('car','delete')):?>
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
     <?php 
    }


    public function showMainForm($parkings, \Model\Parking $parking, $cars) {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Список машин</title>
            <link rel="stylesheet" type="text/css" href="css/main-style.css">
            <link rel="stylesheet" type="text/css" href="css/car-style.css">
            <link rel="stylesheet" type="text/css" href="css/parking-choose-style.css">
        </head>
        <body>
        <header>
            <div class="user-info">
                <span>Hello <?php echo $_SESSION['user']; ?>!</span>
                <?php if($this->checkRight('user', 'admin')): ?>
                    <a href="admin/index.php">Адміністрування</a>
                <?php endif; ?>
                <a href="auth/logout.php">Logout</a>
            </div>
            <?php 
            if($this->checkRight('parking', 'view')) {
                $this->showParkings($parkings);
                if($_GET['parking']) {
                    $this->showParking($parking);
                }
            }
            ?>
        </header>
        <?php
        if($this->checkRight('car','view')) {
            $this->showCars($cars);
        }
        ?>
        </body>
        </html>
        <?php 
    }

    public function showParkingEditForm(\Model\Parking $parking) {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Редагування автостоянки</title>
            <link rel="stylesheet" type="text/css" href="../css/edit-parking-form-style.css">
        </head>
        <body>
        <a href="../index.php?parking=<?php echo $_GET['parking'];?>">На головну</a>
        <form name="edit-parking" method="post">
            <div>
                <label for="adress">Адреса: </label>
                <input type="text" name="adress" value="<?php echo $parking->getAdress(); ?>">
            </div>
            <div>
                <label for="director">Директор: </label>
                <input type="text" name="director" value="<?php echo $parking->getDirector(); ?>">
            </div>
            <div>
                <input type="submit" name="ok" value="Змінити">
            </div>
        </form>
        </body>
        </html>
        <?php
    }

    public function showCarEditForm(\Model\Car $car) {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <link rel="stylesheet" text="text/css" href="../css/edit-car-form-style.css">
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
        <?php
    }

    public function showCarCreateForm() {
        ?>
        <!DOCTYPE html>
        <html>
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
        <?php
    }
    public function showLoginForm() {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <link rel="stylesheet" href="../css/login-style.css">
            <title>Аутентифікація</title>
        </head>
        <body>
        <form method="post">
            <p>
                <input type="text" name="username" placeholder="username">
            </p>
            <p>
                <input type="password" name="password" placeholder="password">
            </p>
            <p>
                <input type="submit" value="login">
            </p>
        </form>
        </body>
        </html>
        <?php
    }

    public function showAdminForm($users) {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Адміністрування</title>
        </head>
        <body>
        <header>
            <a href="../index.php">На головну</a>
            <h1>Адміністрування користувачів</h1>
            <link rel="stylesheet" type="text/css" href="../css/main-style.css">
        </header>
        <section>
            <table>
                <thead>
                <tr>
                    <th>Користувач</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($users as $user): ?>
                    <?php if($user->getUserName() != $_SESSION['user'] && $user->getUserName() != "admin" && trim($user->getUserName()) != '' ): ?>
                        <tr> 
                            <td><a href="edit-user.php?username=<?php echo $user->getUserName(); ?>"><?php echo $user->getUserName(); ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
    </body>
    </html>
    <?php
    }

    public function showUserEditForm(\Model\User $user) {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Редагування користувача</title>
            <link rel="stylesheet" type="text/css" href="admin.css">
        </head>
        <body>
        <a href="index.php">До списку користувачів</a>
        <form name='edit-user' method='post'>
            <div class='tbl'>
                <div>
                    <label for="user_name">Username: </label>
                    <input readonly type="text" name="user_name" value = '<?php echo $user->getUserName(); ?>'>
                </div>
                <div>
                    <label for="user_pwd">Password: </label>
                    <input readonly type="text" name="user_pwd" value = '<?php echo $user->getPassword(); ?>'>
                </div>
            </div>
            <div><p>Парковка: </p> 
                <input type="checkbox" <?php echo ("1" == $user->getRight(0))?"checked":""; ?> name="right0" value="1"><span>Перегляд</span>
                <input type="checkbox" <?php echo ("1" == $user->getRight(1))?"checked":""; ?> name="right1" value="1"><span>Створення</span>
                <input type="checkbox" <?php echo ("1" == $user->getRight(2))?"checked":""; ?> name="right2" value="1"><span>Редагування</span>
                <input type="checkbox" <?php echo ("1" == $user->getRight(3))?"checked":""; ?> name="right3" value="1"><span>Видалення</span>
            </div>
            <div><p>Авто: </p> 
                <input type="checkbox" <?php echo ("1" == $user->getRight(4))?"checked":""; ?> name="right4" value="1"><span>Перегляд</span>
                <input type="checkbox" <?php echo ("1" == $user->getRight(5))?"checked":""; ?> name="right5" value="1"><span>Створення</span>
                <input type="checkbox" <?php echo ("1" == $user->getRight(6))?"checked":""; ?> name="right6" value="1"><span>Редагування</span>
                <input type="checkbox" <?php echo ("1" == $user->getRight(7))?"checked":""; ?> name="right7" value="1"><span>Видалення</span>
            </div>
            <div><p>Користувачі: </p> 
                <input type="checkbox" <?php echo ("1" == $user->getRight(8))?"checked":""; ?> name="right8" value="1" ><span>Адміністрування</span>
            </div>
            <div><input type="submit" name="ok" value="Змінити"></div>
        </form>
        </body>
        </html>
        <?php
    }
}
