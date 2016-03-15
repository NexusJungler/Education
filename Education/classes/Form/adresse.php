<?php

namespace Educ\Form;

class adresse {
    public $student = null;
    public $print = null;
    public $ok = false;
    public  $error = [
        "voie" => "Vous n'avez pas saisi la voie."  ,
        "num" => "Vous n'avez pas saisi le numero de voie."  ,
        "complement" =>  "Vous n'avez pas saisi le complément d'adresse.",
        "cpost" => "Vous n'avez pas saisi le code postal." ,
        "ville" => "Vous n'avez pas saisi la ville du domicile de l''élève.",
        "hijack" =>  "Aucun pirate ne peut pénétrer cette application! Abandonnez maintenant!"
    ];
    public function __construct() {
        $this->memory();
        if (isset($_POST['send'])) {
            $this->check();
        }
    }
    private function memory() {
        if (!empty($_POST['num'])) {
            $_SESSION['student']['num'] = filter_var($_POST['num'], FILTER_SANITIZE_STRING);
        }
        if (!empty($_POST['complement'])) {
            $_SESSION['student']['complement'] = filter_var($_POST['complement'], FILTER_SANITIZE_STRING);
        }
        if (!empty($_POST['ville'])) {
            $_SESSION['student']['ville'] = filter_var($_POST['ville'], FILTER_SANITIZE_STRING);
        }
        if (!empty($_POST['voie'])) {
            $_SESSION['student']['voie'] = filter_var($_POST['voie'], FILTER_SANITIZE_STRING);
        }
        if (!empty($_POST['cpost'])) {
            $_SESSION['student']['cpost'] = filter_var($_POST['cpost'], FILTER_SANITIZE_STRING);
        }
    }
    private function check() {
        $tableCheck = filter_input_array(INPUT_POST, [
            'num' => ['filter' => FILTER_SANITIZE_STRING],
            'voie' => ['filter' => FILTER_SANITIZE_STRING],
            'complement' => ['filter' => FILTER_SANITIZE_STRING],
            'cpost' => ['filter' => FILTER_SANITIZE_STRING],
            'ville' => ['filter' => FILTER_SANITIZE_STRING]
        ]);
        foreach ($tableCheck as $key => $value) {
            if (!$value) {
                $this->print .= $this->error[$key];
                $_SESSION['student'][$key]='';
            }
            if  ($_POST[$key] != $value) {
                $this->print = $this->error['hijack'];
            }
        }
        if (empty($this->print)) {
            if(isset($_SESSION['student'])) {
                $newStud = new \Educ\Entity\eleve();
                $newStud->setName($_SESSION['student']['nom']);
                $newStud->setLastName($_SESSION['student']['prenom']);
                $toto = str_replace('/', '-', $_SESSION['student']['age']);
                $birth = new \DateTime($toto);
                $newFormat = $birth->format('Y-m-d');
                $newStud->setBirth($newFormat);
                $newStud->setNumber($_SESSION['student']['num']);
                $newStud->setRoad($_SESSION['student']['voie']);
                $newStud->setComplement($_SESSION['student']['complement']);
                $newStud->setPost($_SESSION['student']['cpost']);
                $newStud->setCity($_SESSION['student']['ville']);
                $newStud->setPicture($_SESSION['student']['photo']);
                $newStud->setClass(53);
                $this->student = $newStud;
                $this->ok = true;
                var_dump($this->student);
            } else { echo 'la saisie de la première partie du formulaire n\'a pas été retrouvée!'; }
        }
    }
};