<?php

namespace Model;

class Car {
    const INSURED = 0;
    const UNINSURED = 1; 

    private $id;
    private $number;
    private $brand;
    private $number_parking;
    private $data;
    private $str;
    private $rozm;
    private $parkingId;

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    public function getNumber() {
        return $this->number;
    }
    public function setNumber($number) {
        $this->number = $number;
        return $this;
    }
    public function getBrand() {
        return $this->brand;
    }
    public function setBrand($brand) {
        $this->brand = $brand;
        return $this;
    }
    public function getData() {
        return $this->data;
    }
    public function setData($data) {
        $this->data = $data;
        return $this;
    }
    public function isStrInsured() {
        return ($this->str == self::INSURED);
    }
    public function isStrUninsured() {
        return !($this->isStrInsured());
    }
    public function setInsuredStr() {
        $this->str = SELF::INSURED;
        return $this;
    }
    public function setUninsuredStr() {
        $this->str = SELF::UNINSURED;
        return $this;
    }
    public function getNumber_Parking() {
        return $this->number_parking;
    }
    public function setNumber_Parking($number_parking) {
        $this->number_parking = $number_parking;
        return $this;
    }
    public function isRozm() {
        return $this->rozm;
    }
    public function setRozm($rozm) {
        $this->rozm = $rozm;
        return $this;
    }
    public function getParkingId() {
        return $this->parkingId;
    }
    public function setParkingId($parkingId) {
        $this->parkingId = $parkingId;
        return $this;
    }
}