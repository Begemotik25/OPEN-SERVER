<?php
namespace Controller;

//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);


use Model\Data;
use View\ParkingListView;

class ParkingListApp {

    private $model;
    private $view;

    public function __construct($modelType, $viewType) {
        session_start();
        $this->model = Data::makeModel($modelType);
        $this->view = ParkingListView::makeView($viewType);
    }

    public function checkAuth(){
        if ($_SESSION['user']) {
            $this->model->setCurrentUser($_SESSION['user']);
            $this->view->setCurrentUser($this->model->getCurrentUser());
        } else {
            header('Location: ?action=login');
        }
    }

    public function run() {
        if (!in_array($_GET['action'], array('login','checkLogin'))) {
            $this->checkAuth();
        }
        if ($_GET['action']) {
            switch ($_GET['action']) {
                case 'login':
                    $this->showLoginForm();
                    break;
                case 'checkLogin':
                    $this->checkLogin();
                    break;
                case 'logout':
                    $this->logout();
                    break;
                case 'create-parking':
                    $this->createParking();
                    break;
                case 'edit-parking-form':
                    $this->showEditParkingForm();
                    break;
                case 'edit-parking':
                    $this->editParking();
                    break;
                case 'delete-parking':
                    $this->deleteParking();
                    break;
                case 'create-car-form':
                    $this->showCreateCarForm();
                    break;
                case 'create-car':
                    $this->createCar();
                    break;
                case 'edit-car-form':
                    $this->showEditCarForm();
                    break;
                case 'edit-car':
                    $this->editCar();
                    break;
                case 'delete-car':
                    $this->deleteCar();
                    break;
                case 'admin':
                    $this->adminUsers();
                    break;
                case 'edit-user-form':
                    $this->showEditUserForm();
                    break;
                case 'edit-user':
                    $this->editUser();
                    break;
                default:
                    $this->showMainForm();
            }
        } else {
            $this->showMainForm();
        }
    }

    private function showLoginForm() {
        $this->view->showLoginForm();
    }

    private function checkLogin() {
        if ($user = $this->model->readUser($_POST['username'])) {
            if ($user->checkPassword($_POST['password'])) {
                session_start();
                $_SESSION['user'] = $user->getUserName();
                header('Location: index.php');
            }
        }
    }

    private function logout() {
        unset($_SESSION['user']);
        header('Location: ?action=login');
    }

    private function showMainForm() {
        $parkings = array();
        if($this->model->checkRight('parking', 'view')) {
            $parkings = $this->model->readParkings();
        }
        $parking = new \Model\Parking();
        if($_GET['parking'] && $this->model->checkRight('parking', 'view')) {
            $parking = $this->model->readParking($_GET['parking']);
        }
        $cars = array();
        if($_GET['parking'] && $this->model->checkRight('car', 'view')) {
            $cars = $this->model->readCars($_GET['parking']);
        }

        $this->view->showMainForm($parkings, $parking, $cars);
    }

    private function createParking() {
        if (!$this->model->addParking()) {
            die($this->model->getError());
        } else {
            header('Location: index.php');
        }
    }

    private function showEditParkingForm() {
        if (!$parking = $this->model->readParking($_GET['parking']) ) {
            die($this->model->getError());
        }
        $this->view->showParkingEditForm($parking);
    }

    private function editParking() {
        if (!$this->model->writeParking((new \Model\Parking())
            ->setId($_GET['parking'])
            ->setAdress($_POST['adress'])
            ->setDirector($_POST['director'])
        )) {
            die($this->model->getError());
        } else {
            header('Location: index.php?parking=' . $_GET['parking']);
        } 
    }

    private function deleteParking() {
        if(!$this->model->removeParking($_GET['parking'])) {
            die($this->model->getError());
        } else {
            header('Location: index.php');
        }
    }

    private function showEditCarForm() {
        $car = $this->model->readCar($_GET['parking'], $_GET['file']); 
        $this->view->showCarEditForm($car);
    }

    private function editCar() {
        $car = (new \Model\Car())
            ->setId($_GET['file'])
            ->setParkingId($_GET['parking'])
            ->setNumber($_POST['car_number'])
            ->setBrand($_POST['car_brand'])
            ->setNumber_Parking($_POST['car_number_of_parking'])
            ->setData(new \DateTime($_POST['car_data']))
            ->setRozm($_POST['car_rozm'])
            ->setUninsuredStr();
        if($_POST['car_str'] == 'Insured') {
            $car->setInsuredStr();
        }
        if(!$this->model->writeCar($car)){
            die($this->model->getError());
        } else {
            header('Location: index.php?parking=' . $_GET['parking']);
        } 
    }

    private function showCreateCarForm() {
        $this->view->showCarCreateForm();
    }

    private function createCar() {
        $car = (new \Model\Car())
            ->setParkingId($_GET['parking'])
            ->setNumber($_POST['car_number'])
            ->setBrand($_POST['car_brand'])
            ->setNumber_Parking($_POST['car_number_of_parking'])
            ->setData(new \DateTime($_POST['car_data']))
            ->setRozm($_POST['car_rozm'])
            ->setUninsuredStr();
        if($_POST['car_str'] == 'Insured') {
            $car->setInsuredStr();
        }
        if(!$this->model->addCar($car)){
            die($this->model->getError());
        } else {
            header('Location: index.php?parking=' . $_GET['parking']);
        }
    }

    private function deleteCar() {
        $car = (new \Model\Car())->setId($_GET['file'])->setParkingId($_GET['parking']);
        if (!$this->model->removeCar($car)) {
            die($this->model->getError());
        } else {
            header('Location: index.php?parking=' . $_GET['parking']);
        }
    }

    private function adminUsers() {
        $users = $this->model->readUsers();
        $this->view->showAdminForm($users);
    }

    private function showEditUserForm() {
        if(!$user = $this->model->readUser($_GET['username'])) {
            die($this->model->getError());
        }
        $this->view->showUserEditForm($user);
    }
    
    private function editUser() {
        $rights = "";
        for($i=0; $i<9; $i++) {
            if ($_POST['right' . $i]) {
                $rights .= "1";
            } else {
                $rights .= "0";
            }
        }
        $user = (new \Model\User())
            ->setUserName($_POST['user_name'])
            ->setPassword($_POST['user_pwd'])
            ->setRights($rights);
        if (!$this->model->writeUser($user)) {
            die($this->model->getError());
        } else { 
            header('Location: ?action=admin ');
        }
    }
}