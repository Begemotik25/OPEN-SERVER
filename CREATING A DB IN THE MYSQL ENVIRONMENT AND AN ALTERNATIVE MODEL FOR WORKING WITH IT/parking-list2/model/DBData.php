<?php

namespace Model;

class DBData extends Data {
    private $db;
    public function __construct(MySQLdb $db) {
        $this->db = $db;
        $this->db->connect();
    }

    protected function getCars($parkingId) {
            $Cars = array();
            if ($car_arr = $this->db->getArrFromQuery("select id, number, brand, number_parking, data, pr_id, rozm, str from cars where 
            pr_id=" . $parkingId)) {
                foreach($car_arr as $car_row){
                    $Car = (new Car()) 
                        ->setId($car_row['id'])
                        ->setNumber($car_row['number'])
                        ->setBrand($car_row['brand'])
                        ->setNumber_Parking($car_row['number_parking'])
                        ->setData(new \DateTime($car_row['data']))
                        ->setParkingId($car_row['pr_id'])
                        ->setRozm($car_row['rozm']);
                    if($car_row['str'] == 'Insured') {
                        $Car->setInsuredStr();
                    } else {
                        $Car->setUninsuredStr();
                    } 
                    $Cars[] = $Car;
                }
            }
            return $Cars;
    }

    protected function getCar($parkingId, $id) {
        $Car = new Car();
        if ($car_arr = $this->db->getArrFromQuery("select id, number, brand, number_parking, data, pr_id, rozm, str from cars where id=" . $id)) {
            if(count($car_arr) > 0) {
                $car_row = $car_arr[0];
                $Car 
                    ->setId($car_row['id'])
                    ->setNumber($car_row['number'])
                    ->setBrand($car_row['brand'])
                    ->setNumber_Parking($car_row['number_parking'])
                    ->setData(new \DateTime($car_row['data']))
                    ->setParkingId($car_row['pr_id'])
                    ->setRozm($car_row['rozm']);
                if($car_row['str'] == 'Insured') {
                    $Car->setInsuredStr();
                } else {
                    $Car->setUninsuredStr();
                } 
           }
        }
        return $Car;
    }

    protected function getParkings() {
        $parkings = array();
        if ($prk_arr = $this->db->getArrFromQuery("select id, adress, director from parkings")) {
            foreach($prk_arr as $prk_row) {
                $parking = (new Parking()) 
                    ->setId($prk_row['id'])
                    ->setAdress($prk_row['adress'])
                    ->setDirector($prk_row['director']);
                $parkings[] = $parking;
            }
        }
        return $parkings;
    }


    protected function getParking($id) {
        $parking = new Parking();
        if ($prk_arr = $this->db->getArrFromQuery("select id, adress, director from parkings 
        where id=". $id)) {
            if(count($prk_arr) > 0) {
                $prk_row = $prk_arr[0];
                $parking 
                    ->setId($prk_row['id'])
                    ->setAdress($prk_row['adress'])
                    ->setDirector($prk_row['director']);
            }
        }
        return $parking;
    }

    protected function getUsers() {
        $users = array();
        if ($usr_arr = $this->db->getArrFromQuery("select id, username, passwd, rights from users")) {
            foreach($usr_arr as $usr_row) {
                $user = (new User()) 
                    ->setUserName($usr_row['username'])
                    ->setPassword($usr_row['passwd'])
                    ->setRights($usr_row['rights']);
                $users[] = $user;
            }
        }
        return $users;
    }

    protected function getUser($id) {
        $user = new User();
        if($usr_arr = $this->db->getArrFromQuery("select id, username, passwd, rights from users where username='" . $id . "'")) {
            if(count($usr_arr) > 0) {
                $usr_row = $usr_arr[0];
                 $user 
                    ->setUserName($usr_row['username'])
                    ->setPassword($usr_row['passwd'])
                    ->setRights($usr_row['rights']);
            }
        }
        return $user;
    }

    protected function setCar(Car $car) {
        $rozm = 0;
        if($car->isRozm()) {
            $rozm = 1;
        }
        $str = 'Insured';
        if ($car->isStrUninsured()) {
            $str = 'Uninsured';
        }

        $sql = "update cars set number = '" . $car->getNumber() . "', brand = '" . $car->getBrand() . "', number_parking = '" . $car->getNumber_Parking() . "', data = '" . $car->getData()->format('Y-m-d') . "', pr_id = " . $car->getParkingId() . ", rozm = " .  $rozm . ", str = '" . $str . "' where id = " . $car->getId();  

        $this->db->runQuery($sql);
    }

    protected function delCar(Car $car) {
        $sql = "delete from cars where id = " . $car->getId();
        $this->db->runQuery($sql);
    }

    protected function insCar(Car $car) {
        $rozm = 0;
        if($car->isRozm()) {
            $rozm = 1;
        }
        $str = 'Insured';
        if ($car->isStrUninsured()) {
            $str = 'Uninsured';
        }

        $sql = "insert into cars(number, brand, number_parking, data, pr_id, rozm, str) values('" . $car->getNumber() . "', '" . $car->getBrand() . "', '" . $car->getNumber_Parking() . "', '" . $car->getData()->format('Y-m-d') . "', " . $car->getParkingId() . ", " .  $rozm . ", '" . $str . "')"; 
        
        //. $car->getNumber() . "' , '" . $car->getBrand() . "' , '"  . $car->getNumber_Parking() . "' , '" . 
        //$car->getData()->format('Y-m-d') . "' ," . $str . " , '" . $rozm  . " , " . $car->getParkingId() . "')";  
        //var_dump($sql);
        $this->db->runQuery($sql);
    }

    protected function setParking(Parking $parking) {
        $sql = "update parkings set adress='" . $parking->getAdress() . "',
        director='" . str_replace("'", "\'", $parking->getDirector())  . "' where id =" . $parking->getId();
        $this->db->runQuery($sql);
    }

    protected function setUser(User $user) {
        $sql = "update users set rights='" . $user->getRights() . "', passwd= '"
        . $user->getPassword() . "' where username='" . $user->getUserName(). "'";
        $this->db->runQuery($sql);
    }

    protected function delParking($parkingId) {
        $sql = "delete from parkings where id = " . $parkingId;
        $this->db->runQuery($sql);
    }

    protected function insParking() {
        $sql = "insert into parkings(adress,director)
             values('New','')"; 
        $this->db->runQuery($sql);
    }
}
