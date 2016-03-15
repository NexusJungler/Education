<?php

    namespace Educ\Entity;


    class competence {
        public $id = null;
        public $intitule = null;
        public $acronyme = null;
        public $FKcategorie = null;
        public $FKpallier = null;

        public function __construct() {}
        public function getIdentity() {return $this->id;}
        public function getIntitule() {return $this->intitule;}
        public function setIntitule($intitule) {$this->intitule = $intitule;}
        public function getAcronyme() {return $this->acronyme;}
        public function setAcronyme($acronyme) {$this->acronyme = $acronyme;}
        public function getCategorie() {return $this->FKcategorie;}
        public function setCategorie($categorieID) {$this->FKcategorie = $categorieID;}
        public function getPallier() {return $this->FKpallier;}
        public function setPallier($pallierID) {$this->FKpallier = $pallierID;}
    }


