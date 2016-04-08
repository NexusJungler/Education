<?php

namespace Educ\Form;


class addClass
{
    public $Class = null;
    public $print = null;
    public $ok = false;
    public $error= [
        "name" => "Vous n'avez pas saisi le nom de la classe.",
        "time" => "Vous n'avez pas saisi l'année correspondante." ,
        "hijack" =>  "La saisie n'est pas conforme. Veuillez recommencer!"
    ];
    public function __construct() {
        $this->memory();
        if (isset($_POST['send'])) {
            $this->check();
        }
    }

    private function memory() {
        if (!empty($_POST['name'])) {
            $_SESSION['class']['name']= filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        }
        if (!empty($_POST['time'])) {
            $_SESSION['class']['time'] = filter_var($_POST['time'], FILTER_SANITIZE_STRING);
        }
    }

    private function check() {
        $tableCheck = filter_input_array(INPUT_POST, [
            'name' => ['filter' => FILTER_SANITIZE_STRING],
            'time' => ['filter' => FILTER_SANITIZE_STRING]
        ]);
        foreach ($tableCheck as $key => $value) {
            if (!$value) {
                $this->print .= $this->error[$key].'<br>';
            }
            if  ($_POST[$key] != $value) {
                $this->print = $this->error['hijack'];
                break;
            }
        }
        if (empty($this->print)) {
            $this->ok = true;
            $newClass = new \Educ\Entity\classe();
            $newClass->setNom($_SESSION['class']['name']);
            $time = substr($_SESSION['class']['time'], 2, 2);
            $newClass->setAnnee($time);
            $newClass->setFKuser($_SESSION['login']['alpha']);
            $this->Class = $newClass;
        }
    }
}