<?php

    namespace Educ\Utils;


    class Database{
        private $pdo= null;
        public $baseName='education';
        public $color='red';
        private $mess = null;
        public function __construct() {
            $this->pdo = new \PDO("mysql:host=localhost; dbname=". $this->baseName."; charset=utf8", "root", "XXXXXX");
        }
        public function connect() {return $this->pdo;}
        public function write ($table,$values) {
            $str = '"';     //repr�sente le d�but ou la fin d'une chaine de caract�res � l'int�rieur d'une variable elle-m�me de type string (n�cessaire � la pr�paration d'une requ�te SQL)
            $dot = "." ;
            $nbrCol = count($values);
            $colonnes = null;
            for ( $i=0; $i<$nbrCol; $i++) {
                if ($i != $nbrCol-1) { $separ = ',' ; } else { $separ = ')' ; }
                $colonnes .= $str . $values[$i] . $str . $separ;
            }
            $sql = 'INSERT INTO ' . $this->baseName . $dot . $table . ' VALUES (NULL, ' . $colonnes ;
            $query = $this->pdo->prepare($sql) ;
            if (!$query) {$this->mess = 'une erreur est survenue dans le processus d\'�criture de la base de donn�es' ;} else {$query->execute();}
        }
        public function read ($table) {
            $sql = 'SELECT  '  . $table . '.* FROM '  .  $this->baseName . '.' . $table;
            $query = $this->pdo->prepare($sql) ;
            $result= null;
            if (!$query) {$this->mess = 'une erreur est survenue dans le processus de lecture de la base de donn�es' ;} else {$query->execute();}
            $result = $query->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        }
}