<?php

    namespace Educ\Entity;


    class eleve {
        public $id = null;
        public $nom = null;
        public $prenom = null;
        public $photo = null;                    // Attention à l'ordre des déclarations déterminant pour la fonction Insert (conversion de l'objet  en string)
        public $age = null;
        public $voie = null;
        public $num = null;
        public $complement = null;
        public $cpost = null;
        public $ville = null;
        public $FKclasse = null;

        public function __construct() {}
        public function getIdentity() {return $this->id;}
        public function getName() {return $this->nom;}
        public function setName($nom) {$this->nom = $nom;}
        public function getLastName() {return $this->prenom;}
        public function setLastName($prenom) {$this->prenom = $prenom;}
        public function getBirth() {return $this->age;}
        public function setBirth($age) {$this->age = $age;}
        public function getPicture() {return $this->photo;}
        public function setPicture($photo) {$this->photo = $photo;}
        public function getRoad() {return $this->voie;}
        public function setRoad($voie) {$this->voie = $voie;}
        public function getNumber() {return $this->num;}
        public function setNumber($nbr) {$this->num = $nbr;}
        public function getComplement() {return $this->complement;}
        public function setComplement($compt) {$this->complement = $compt;}
        public function getPost() {return $this->cpost;}
        public function setPost($code) {$this->cpost = $code;}
        public function getCity() {return $this->ville;}
        public function setCity($city) {$this->ville = $city;}
        public function getClass() {return $this->FKclasse;}
        public function setClass($classe) {$this->FKclasse = $classe;}
    }