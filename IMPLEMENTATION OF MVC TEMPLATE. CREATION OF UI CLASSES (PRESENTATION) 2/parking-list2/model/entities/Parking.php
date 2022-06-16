<?php

namespace Model;

class Parking {
    private $id;
    private $adress;
    private $director;

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    public function getAdress() {
        return $this->adress;
    }
    public function setAdress($adress) {
        $this->adress = $adress;
        return $this;
    }
    public function getDirector() {
        return $this->director;
    }
    public function setDirector($director) {
        $this->director = $director;
        return $this;
    }










}