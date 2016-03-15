<?php
    namespace Educ\Entity;
    class utilisateur {
        public $id;
        public $pseudo;
        public $password;
        public $statut;
        public function __construct() {}
        public function getIdentity() {return $this->id;}
        public function getName() {return $this->pseudo;}
        public function setName($name) {$this->pseudo = $name;}
        public function getPass() {return $this->password;}
        public function setPass($pass) {$this->password= $pass;}
        public function getState() {return $this->statut;}
        public function setState($state) {$this->statut=$state;}
    }

