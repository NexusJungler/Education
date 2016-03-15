<?php

namespace Educ\Entity;

class validation{
    public $id = null;
    public $FKeleve = null;
    public $FKcompetence = null;
    public $first = null;
    public $second = null;
    public $last = null;
    public $FKetat= null;
    public $FKcompensation= null;

    public function getId() {
        return $this->id;
    }
    public function getFKeleve() {
        return $this->FKeleve;
    }
    public function setFKeleve($FKeleve) {
        $this->FKeleve = $FKeleve;
    }
    public function getFKcompetence() {
        return $this->FKcompetence;
    }
    public function setFKcompetence($FKcompetence) {
        $this->FKcompetence = $FKcompetence;
    }
    public function getFirst() {
        return $this->first;
    }
    public function setFirst($first) {
        $this->first = $first;
    }
    public function getSecond() {
        return $this->second;
    }
    public function setSecond($second) {
        $this->second = $second;
    }
    public function getLast() {
        return $this->last;
    }
    public function setLast($last) {
        $this->last = $last;
    }
    public function getFKetat() {
        return $this->FKetat;
    }
    public function setFKetat($FKetat) {
        $this->FKetat = $FKetat;
    }
    public function getFKcompensation() {
        return $this->FKcompensation;
    }
    public function setFKcompensation($FKcompensation) {
        $this->FKcompensation = $FKcompensation;
    }
}