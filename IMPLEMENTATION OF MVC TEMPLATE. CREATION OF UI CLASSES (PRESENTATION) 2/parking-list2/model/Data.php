<?php

namespace Model;

abstract class Data {
    const FILE = 0;

    private $error;
    private $user;

    public function setCurrentUser($userName) {
        $this->user = $this->readUser($userName);
    }

    public function getCurrentUser() {
        return $this->user;
    }

    public function checkRight($object,$right) {
        return $this->user->checkRight($object,$right);
    }

    public function readCars($parkingId) {
        if($this->user->checkRight('car','view')) {
            $this->error = "";
            return $this->getCars($parkingId);
        } else {
            $this->error = "You have no permissions to view cars";
            return false;
        }
    }
    protected abstract function getCars($parkingId);
    
    public function readCar($parkingId,$id) {
        if($this->checkRight('car','view')) {
            $this->error = "";
            return $this->getCar($parkingId,$id);
        } else {
            $this->error = "You have no permissions to view car";
            return false;
        }
    }

    protected abstract function getCar($parkingId,$id);
    
    public function readParkings() {
        if($this->checkRight('parking','view')) {
            $this->error = "";
            return $this->getParkings();
        } else {
            $this->error = "You have no permissions to view parkings";
            return false;
        }
    }
    
    protected abstract function getParkings();
    
    public function readParking($id) {
        if($this->checkRight('parking','view')) {
            $this->error = "";
            return $this->getParking($id);
        } else {
            $this->error = "You have no permissions to view parking";
            return false;
        }
    }

    protected abstract function getParking($id);
    
    public function readUsers() {
        if($this->checkRight('user','admin')) {
            $this->error = "";
            return $this->getUsers();
        } else {
            $this->error = "You have no permissions to administrate users";
            return false;
        }
    }

    protected abstract function getUsers();
    
    public function readUser($id) {
        $this->error = "";
        return $this->getUser($id);
    }

    protected abstract function getUser($id);
    
    public function writeCar(Car $car) {
        if($this->checkRight('car','edit')) {
            $this->error = "";
            $this->setCar($car);
            return true;
        } else {
            $this->error = "You have no permissions to edit cars";
            return false;
        }
    }

    protected abstract function setCar(Car $car);
    
    public function writeParking(Parking $parking) {
        if($this->checkRight('parking','edit')) {
            $this->error = "";
            $this->setParking($parking);
            return true;
        } else {
            $this->error = "You have no permissions to edit cars";
            return false;
        }
    }

    protected abstract function setParking(Parking $parking);
    
    public function writeUser(User $user) {
        if($this->checkRight('user','admin')) {
            $this->error = "";
            $this->setUser($user);
            return true;
        } else {
            $this->error = "You have no permissions to administrate users";
            return false;
        }
    }

    protected abstract function setUser(User $user);
    
    public function removeCar(Car $car) {
        if($this->checkRight('car','delete')) {
            $this->error = "";
            $this->delCar($car);
            return true;
        } else {
            $this->error = "You have no permissions to delete cars";
            return false;
        }
    }

    protected abstract function delCar(Car $car);
    
    public function addCar(Car $car) {
        if($this->checkRight('car','create')) {
            $this->error = "";
            $this->insCar($car);
            return true;
        } else {
            $this->error = "You have no permissions to create cars";
            return false;
        }
    }

    protected abstract function insCar(Car $car);
    
    public function removeParking($parkingId) {
        if($this->checkRight('parking','delete')) {
            $this->error = "";
            $this->delParking($parkingId);
            return true;
        } else {
            $this->error = "You have no permissions to delete parkings";
            return false;
        }
    }

    protected abstract function delParking($parkingId);
    
    public function addParking() {
        if($this->checkRight('parking','create')) {
            $this->error = "";
            $this->insParking();
            return true;
        } else {
            $this->error = "You have no permissions to create parkings";
            return false;
        }
    }

    protected abstract function insParking();
    
    public function getError() {
        if($this->error) {
            return $this->error;
        } 
        return false;
    }

    public static function makeModel($type) {
        if($type == self::FILE) {
            return new FileData();
        }
        return new FileData();
    }

}