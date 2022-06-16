<?php

namespace Model;

class FileData extends Data {
    const DATA_PATH = __DIR__ . '/../data/';
    const CAR_FILE_TEMPLATE = '/^car-\d\d.txt\z/';
    const PARKING_FILE_TEMPLATE = '/^parking-\d\d\z/';

    protected function getCars($parkingId){
        $Cars = array();
        $conts = scandir(self::DATA_PATH . $parkingId);
        foreach ($conts as $node) {
            if(preg_match(self::CAR_FILE_TEMPLATE, $node)) {
                $Cars[] = $this->getCar($parkingId,$node);
            }
        }
        return $Cars;
    }

    protected function getCar($parkingId, $id) {
        $f = fopen(self::DATA_PATH . $parkingId . "/". $id,"r");
        $rowStr = fgets($f);
        $rowArr = explode(";", $rowStr);
        $Car = (new Car()) 
            ->setId($id)
            ->setNumber($rowArr[0])
            ->setBrand($rowArr[1])
            ->setNumber_Parking($rowArr[2])
            ->setData(new \DateTime($rowArr[3]))
            ->setRozm($rowArr[5]);
        if($rowArr[4] == 'Insured') {
            $Car->setInsuredStr();
        } else {
            $Car->setUninsuredStr();
        } 
        fclose($f);
        return $Car;
    }
    protected function getParkings() {
        $parkings = array();
        $conts = scandir(self::DATA_PATH);
        foreach ($conts as $node) {
            if(preg_match(self::PARKING_FILE_TEMPLATE, $node)) {
                $parkings[] = $this->getParking($node);
            }
        }
        return $parkings;
    }

    protected function getParking($id) {
        $f = fopen(self::DATA_PATH . $id . "/parking.txt","r");
        $grStr = fgets($f);
        $grArr = explode(";",$grStr);
        fclose($f);
        $parking = (new Parking()) 
            ->setId($id)
            ->setAdress($grArr[0])
            ->setDirector($grArr[1]);
        return $parking;
    }

    protected function getUsers(){
        $users = array();
        $f = fopen(self::DATA_PATH . "users.txt","r");
        while(!feof($f)) {
            $rowStr = fgets($f);
            $rowArr = explode(";",$rowStr);
            if(count($rowArr) == 3) {
                $user = (new User()) 
                    ->setUserName($rowArr[0])
                    ->setPassword($rowArr[1])
                    ->setRights(substr($rowArr[2],0,9));
                $users[] = $user;
            }
        }
        fclose($f);
        return $users;
    }

    protected function getUser($id) {
        $users = $this->getUsers();
        foreach($users as $user) {
            if ($user->getUserName() == $id) {
                return $user;
            }
        }
        return false;
    }

    protected function setCar(Car $car) {
        $f = fopen(self::DATA_PATH . $car->getParkingId() . "/" . $car->getId(), "w");
        $rozm = 0;
        if($car->isRozm()) {
            $rozm = 1;
        }
        $str = 'Insured';
        if ($car->isStrUninsured()) {
            $str = 'Uninsured';
        }
        $grArr = array($car->getNumber(),$car->getBrand(), $car->getNumber_Parking(), $car->getData()->format('Y-m-d'), $str, $rozm,);
        $grStr = implode(";",$grArr);
        fwrite($f,$grStr);
        fclose($f);
    }

    protected function delCar(Car $car) {
        unlink(self::DATA_PATH . $car->getParkingId() . "/" . $car->getId());
    }

    protected function insCar(Car $car) {
        //
        $path = self::DATA_PATH . $car->getParkingId();
        $conts = scandir($path);
        $i = 0;
        foreach ($conts as $node) {
            if (preg_match(self::CAR_FILE_TEMPLATE, $node)) {
                $last_file = $node;
            }
        }
        //
        $file_index = (String)(((int)substr($last_file, -6,2)) + 1);
        if (strlen($file_index) == 1) {
            $file_index = "0" . $file_index;
        }
        //
        $newFileName = "car-" . $file_index . ".txt";

        $car->setId($newFileName);
        $this->setCar($car);
    }
    protected function setParking(Parking $parking) {
        $f = fopen(self::DATA_PATH . $parking->getId() . "/parking.txt", "w");
        $grArr = array($parking->getAdress(), $parking->getDirector(), );
        $grStr = implode(";",$grArr);
        fwrite($f, $grStr);
        fclose($f);
    }
    protected function setUser(User $user) {
        $users = $this->getUsers();
        $found = false;
        foreach ($users as $key => $oneUser) {
            if ($user->getUserName() == $oneUser->getUserName()) {
                $found = true;
                break;
            }
        }
        if($found) {
            $users[$key] = $user;
            $f = fopen(self::DATA_PATH . "users.txt","w");
            foreach($users as $oneUser) {
                $grArr = array($oneUser->getUserName(), $oneUser->getPassword(), $oneUser->getRights() . "\r\n",);
                $grStr = implode(";",$grArr);
                fwrite($f, $grStr);
            }
            fclose($f);
        }
    }

    protected function delParking($parkingId) {
        $dirName = self::DATA_PATH . $parkingId;
        $conts = scandir($dirName);
        $i = 0;
        foreach($conts as $node) {
            @unlink($dirName . "/" . $node);
        }
        @rmdir($dirName);
    }


    protected function insParking() {
        //
        $path = self::DATA_PATH ;
        $conts = scandir($path);
        foreach ($conts as $node) {
            if (preg_match(self::PARKING_FILE_TEMPLATE, $node)) {
                $last_parking = $node;
            }
        }
        //
        $parking_index = (String)(((int)substr($last_parking, -1, 2)) + 1);
        if (strlen($parking_index) == 1) {
            $parking_index = "0" . $parking_index;
        }
        //
        $newParkingName = "parking-" . $parking_index;

        mkdir($path . $newParkingName);
        $f = fopen ($path . $newParkingName . "/parking.txt" , "w");
        fwrite($f,"New; ; ");
        fclose($f);
    } 
}