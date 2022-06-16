<?php

namespace View;

class BootstrapView extends ParkingListView {
    const ASSETS_FOLDER = "view/bootstrap-view/";

    private function showUserInfo() {
        ?>
        <div class="container user-info">
            <div class="row">
                <div class="col-12 col-sm-10 offset-sm-2 col-md-8 offset-md-40 text-center lead">
                    <span>Hello <?php echo $_SESSION['user']; ?>!</span>
                <?php if ($this->checkRight('user', 'admin')): ?>
                    <a class="btn btn-warning" href="?action=admin">Адміністрування</a>
                <?php endif; ?>
                    <a class="btn btn-secondary" href="?action=logout">Logout</a>
                </div>
            </div>
        </div>
        <?php
    }

    private function showParkings($parkings) {
        ?>
        <div class="container parking-list">
            <div class="row">
                <form name="parking-form" method="get" class="offset-2 col-8 offset-sm-3 col-sm-6">
                    <div class="form-parking">
                        <label for="parking">Стоянка: </label>
                            <select name="parking" class="form-control" onchange="document.forms['parking-form'].submit();">
                            <option value=""></option>
                            <?php
                                foreach($parkings as $curparking) {
                                    echo "<option " . (($_GET['parking'] == $curparking->getId())?"selected":"") .  " value=" . $curparking->getId(). ">" . $curparking->getAdress() ."</option>";
                                }
                            ?>
                        </select>
                    </div>
                </form>
                <?php if($this->checkRight('parking', 'create')): ?>
                <div class="parking-control col-xs-12 text-center">
                    <a class="btn btn-success" href="?action=create-parking">Додати парковку</a>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    private function showParking(\Model\Parking $parking) {
        ?>
        <div class="container parking-info"> 
            <div class="row text-center">
                <h1 class="col-xs-12">Адреса: <span class="text-warning"><?php echo $parking->getAdress(); ?></span></h1>
                <h2 class="col-xs-12">Директор: <span class="text-secondary"><?php echo $parking->getDirector(); ?></span></h2>
                <div class="parking-control col-xs-12">                 
                    <?php if($this->checkRight('parking', 'edit')): ?>
                        <a class="btn btn-warning" href="?action=edit-parking-form&parking=<?php echo $_GET['parking']; ?>">Редагувати стоянку</a>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  
                    <?php endif; ?>
                    <?php if($this->checkRight('parking', 'delete')): ?>
                        <a class="btn btn-secondary" href="?action=delete-parking&parking=<?php echo $_GET['parking']; ?>">Видалити стоянку</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    }
    private function showCars($cars) {
        ?>
        <section class="container cars">
            <div class="row text-center"> 
            <?php if ($_GET['parking']): ?> 
                <?php if($this->checkRight('car', 'create')):?>
                    <div class="col-xs-12 col-md-2 col-md-offset-1 text-left add-car">
                        <a class="btn btn-success" href="?action=create-car-form&parking=<?php echo $_GET['parking']; ?>">Додати авто</a>
                    </div>
                <?php endif; ?>
                <div class="col-xs-12 col-md-8"> 
                <form method="post" name="cars-filter">
                    <div class="col-xs-12">
                    <label for="car_name_filter">Фільтрувати за назвою</label>
                    </div>
                    <div class="col-xs-12">
                    <input class="form-control" type="text" name="car_name_filter" value = '<?php echo $_POST['car_name_filter']; ?>'>
                    </div>
                    <div class="parking-control col-xs-12">
                    <input class="btn btn-success" type="submit" value = "Фільтрувати">
                    </div>
                </form>
            </div>
            </div>
            <div class="row text-center table-cars">
            <table class="table col-xs-12">
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
            $row_class = '';
            if ($car->isStrInsured()) {
                $row_class = "bg-light";
            }
            if ($car->isStrUninsured()) {
                $row_class = "bg-warning";
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
                        <a class= "btn btn-success btn-sm" href="?action=edit-car-form&parking=<?php echo $_GET['parking']; ?>&file=<?php echo $car->getId();?>">Редагувати</a>
                    <?php endif; ?>
                    <?php if($this->checkRight('car','delete')):?>
                        <a class= "btn btn-secondary btn-sm" href="?action=delete-car&parking=<?php echo $_GET['parking']; ?>&file=<?php echo $car->getId();?>">Видалити</a>
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
            <meta charset="UTF-8">
            <title>Список машин</title>
            <link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/bootstrap.min.css">
            <link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/main.css">
            <script src="<?php echo self::ASSETS_FOLDER; ?>js/jquery.min.js"></script>
            <script src="<?php echo self::ASSETS_FOLDER; ?>js/bootstrap.min.js"></script>
        </head>
        <body>
            <header>
                <?php 
                $this->showUserInfo();
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
            <link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/bootstrap.min.css">
            <script src="<?php echo self::ASSETS_FOLDER; ?>js/jquery.min.js"></script>
            <script src="<?php echo self::ASSETS_FOLDER; ?>js/bootstrap.min.js"></script>
        </head>
        <body>
        <div class="container"> 
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4"> 
                <form name="edit-parking" method="post" action="?action=edit-parking&parking=<?php
                echo $_GET['parking']; ?>">
                <div class="form-parking"><label for="adress">Адреса: </label>
                <input class="form-control" type="text" name="adress" value="<?php echo $parking->getAdress(); ?>">
            </div>
            <div class="form-parking"><label for="director">Директор: </label>
                <input class="form-control" type="text" name="director" value="<?php echo $parking->getDirector(); ?>">
            </div>
            <button type="submit" class="btn btn-success pull-right">Змінити</button>
            <a class="btn btn-info btn-sm pull-left" href="index.php?parking=<?php echo $_GET['parking']; ?>"> На головну</a>
        </form>
        </div>
        </div>
        </div>
        </body>
        </html>
        <?php
    }
    public function showCarEditForm(\Model\Car $car) {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <link rel="stylesheet" text="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/bootstrap.min.css">
            <link rel="stylesheet" text="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/bootstrap.min.css">
            <script src="<?php echo self::ASSETS_FOLDER; ?>js/jquery.min.js"></script>
            <script src="<?php echo self::ASSETS_FOLDER; ?>js/bootstrap.min.js"></script>
            <title>Редагування машин</title>
        </head>
        <body>
        <div class="container"> 
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4"> 
                    <form name='edit-car' method="post" action="?action=edit-car&file=<?php echo $_GET['file']; ?> 
                    &parking=<?php echo $_GET['parking']; ?>">
                        <div class="form-parking">
                            <label for='car_number'>Номер машини: </label>
                            <input class="form-control" type="text" name="car_number" value = '<?php echo $car->getNumber(); ?>'>
                        </div>
                        <div class="form-parking">
                            <label for='car_brand'>Марка машини: </label>
                            <input class="form-control" type="text" name="car_brand" value='<?php echo $car->getBrand(); ?>'>
                        </div>
                        <div class="form-parking">
                            <label for='car_str'>Страховка машини: </label>
                            <select class="form-control" name="car_str">
                                <option disabled>Страховка машини</option>
                                <option <?php echo($car->isStrInsured())?"selected":""; ?> value="Insured">Insured</option>
                                <option <?php echo($car->isStrUninsured())?"selected":""; ?> value="Uninsured">Uninsured</option>
                            </select>
                        </div>
                        <div class="form-parking">
                            <label for='car_number_of_parking'>Номер місця на стоянці: </label>
                            <input class="form-control" type="text" name="car_number_of_parking" value="<?php echo $car->getNumber_Parking(); ?>">
                        </div>
                        <div class="form-parking">
                            <label for='car_data'>Дата: </label>
                            <input class="form-control" type="date" name="car_data" value = "<?php echo $car->getData()->format('Y-m-d'); ?>">
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" <?php echo ($car->isRozm())?"checked":""; ?> name = "car_rozm" value = "1"> Розмитнена
                            </label>
                        </div>
                        <button type="submit" class="btn btn-success pull-right">Змінити</button>
                        <a class="btn btn-info btn-sm pull-left" href="index.php?parking=<?php echo $_GET['parking']; ?>"> На головну</a>
        </form>
        </div>
        </div>
        </div>
        </body>
        </html>
        <?php

    }
    public function showCarCreateForm() {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <link rel="stylesheet" text="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/bootstrap.min.css">
            <link rel="stylesheet" text="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/bootstrap.min.css">
            <script src="<?php echo self::ASSETS_FOLDER; ?>js/jquery.min.js"></script>
            <script src="<?php echo self::ASSETS_FOLDER; ?>js/bootstrap.min.js"></script>
            <title>Додавання машин</title>
        </head>
        <body>
        <div class="container"> 
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4"> 
                    <form name='edit-car' method="post" action="?action=create-car&parking=<?php echo $_GET['parking']; ?>">
                    <div class="form-parking">  
                        <label for='car_number'>Номер машини: </label>
                        <input class="form-control" type="text" name="car_number">
                    </div>
                    <div class="form-parking">
                        <label for='car_brand'>Марка машини: </label>
                        <input class="form-control" type="text" name="car_brand">
                    </div>
                    <div class="form-parking">
                        <label for='car_str'>Страховка машини: </label>
                        <select class="form-control" name="car_str">
                            <option disabled>Страховка машини</option>
                            <option value="Insured">Insured</option>
                            <option value="Uninsured">Uninsured</option>
                        </select>
                    </div>
                    <div class="form-parking">
                        <label for='car_number_of_parking'>Номер місця на стоянці: </label>
                        <input class="form-control" type="text" name="car_number_of_parking">
                    </div>
                    <div class="form-parking">
                        <label for='car_data'>Дата: </label>
                        <input class="form-control" type="date" name="car_data">
                    </div>
                    <div class="checkbox"> 
                        <label>
                            <input type="checkbox" name="car_rozm" value="1"> Розмитнена
                        </label>
                    </div>
                    <button type="submit" class="btn btn-success pull-right">Змінити</button>
                    <a class="btn btn-info btn-sm pull-left" href="index.php?parking=<?php echo $_GET['parking']; ?>"> На головну</a>
        </form>
        </div>
        </div>
        </div>
        </body>
        </html>
        <?php

    }
    public function showLoginForm() {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/bootstrap.min.css">
            <link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/login.css">
            <script src="<?php echo self::ASSETS_FOLDER; ?>js/jquery.min.js"></script>
            <script src="<?php echo self::ASSETS_FOLDER; ?>js/bootstrap.min.js"></script>
            <title>Аутентифікація</title>
        </head>
        <body>
        <form method="post" action="?action=checkLogin">
        <div class="container">
            <div class="row text-center">
                <div class="col-sm-6 col-md-4 col-lg-3 offset-3 offset-md-4">
                    <div class="form-parking">
                        <input type="text" class="form-control" name="username" placeholder="Username">
                    </div>
                    <div class="form-parking">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>
                        <button type="submit" class="btn btn-default">Login</button>
                </div>
            </div>
        </div>
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
            <link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/bootstrap.min.css">
            <link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/login.css">
            <script src="<?php echo self::ASSETS_FOLDER; ?>js/jquery.min.js"></script>
            <script src="<?php echo self::ASSETS_FOLDER; ?>js/bootstrap.min.js"></script>
            <title>Адміністрування</title>
        </head>
        <body>
        <header>
            <a class="btn btn-primary btn-sm" href="index.php?parking=<?php echo $_GET['parking']; ?>"> На головну</a>
            <h1>Адміністрування користувачів</h1>
            <link rel="stylesheet" type="text/css" href="css/main-style.css">
        </header>
        <section class="container cars">
            <table class="col-sm-2">
                <thead>
                <tr>
                    <th>Користувач</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($users as $user):?>
                    <?php if($user->getUserName() != $_SESSION['user'] && $user->getUserName() != "admin" && trim($user->getUserName()) != '' ): ?>
                        <tr> 
                            <td><a class= "btn btn-primary btn-sm" 
                            href="?action=edit-user-form&username=<?php echo $user->getUserName(); ?>">
                            <?php echo $user->getUserName(); ?></td>
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
            <link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/bootstrap.min.css">
            <link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/login.css">
            <script src="<?php echo self::ASSETS_FOLDER; ?>js/jquery.min.js"></script>
            <script src="<?php echo self::ASSETS_FOLDER; ?>js/bootstrap.min.js"></script>
        </head>
        <body>
        <a href="?action=admin" class="btn btn-success pull-right">До списку користувачів</a>
        <div class="container"> 
            <div class="row">
                <div class="table col-xs-12 col-md-2">
                <form name='edit-user' method='post' action="?action=edit-user&user=<?php echo $_GET['user']; ?>">
                <div class='tbl'>
                <div class="form-parking">
                    <label for="user_name">Username: </label>
                    <input class="form-control" readonly type="text" name="user_name" value = '<?php echo $user->getUserName(); ?>'>
                </div>
                <div class="form-parking" >
                    <label for="user_pwd">Password: </label>
                    <input class="form-control" readonly type="text" name="user_pwd" value = '<?php echo $user->getPassword(); ?>'>
                </div>
            </div>
            <div class="checkbox" ><p>Парковка: </p> 
                <input type="checkbox" <?php echo ("1" == $user->getRight(0))?"checked":""; ?> name="right0" value="1"><span>Перегляд</span>
                <input type="checkbox" <?php echo ("1" == $user->getRight(1))?"checked":""; ?> name="right1" value="1"><span>Створення</span>
                <input type="checkbox" <?php echo ("1" == $user->getRight(2))?"checked":""; ?> name="right2" value="1"><span>Редагування</span>
                <input type="checkbox" <?php echo ("1" == $user->getRight(3))?"checked":""; ?> name="right3" value="1"><span>Видалення</span>
            </div>
            <div class="checkbox" ><p>Авто: </p> 
                <input type="checkbox" <?php echo ("1" == $user->getRight(4))?"checked":""; ?> name="right4" value="1"><span>Перегляд</span>
                <input type="checkbox" <?php echo ("1" == $user->getRight(5))?"checked":""; ?> name="right5" value="1"><span>Створення</span>
                <input type="checkbox" <?php echo ("1" == $user->getRight(6))?"checked":""; ?> name="right6" value="1"><span>Редагування</span>
                <input type="checkbox" <?php echo ("1" == $user->getRight(7))?"checked":""; ?> name="right7" value="1"><span>Видалення</span>
            </div>
            <div class="checkbox"><p>Користувачі: </p> 
                <input type="checkbox" <?php echo ("1" == $user->getRight(8))?"checked":""; ?> name="right8" value="1" ><span>Адміністрування</span>
            </div>
            <button type="submit" class="btn btn-success pull-right">Змінити</button>
            <a class="btn btn-success pull-right" href="index.php?parking=<?php echo $_GET['parking']; ?>"> На головну</a>
        </form>
        </body>
        </html>
        <?php

    }




}