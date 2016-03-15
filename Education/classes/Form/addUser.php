<?php

namespace Educ\Form;

class addUser {

    public $userClass = null;
    public $print = null;
    public $ok = false;
    public $error= [
        "pseu" => "Vous n'avez pas saisi l'identifiant.",
        "pass" => "Vous n'avez pas saisi le mot de passe." ,
        "hijack" =>  "Aucun pirate ne peut pénétrer cette application! Abandonnez maintenant ou faites face aux conséquences!"
    ];

    public function __construct() {
        $this->memory();
        if (isset($_POST['send'])) {
            $this->check();
        }
    }

    private function memory() {
        if (!empty($_POST['pseu'])) {
            $_SESSION['user']['pseu']= filter_var($_POST['pseu'], FILTER_SANITIZE_STRING);
        }
        if (!empty($_POST['pass'])) {
            $_SESSION['user']['pass'] = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
        }
    }

    private function check() {
        $tableCheck = filter_input_array(INPUT_POST, [
            'pseu' => ['filter' => FILTER_SANITIZE_STRING],
            'pass' => ['filter' => FILTER_SANITIZE_STRING]
        ]);
        foreach ($tableCheck as $key => $value) {
            if (!$value) {
                $this->print .= $this->error[$key];
                $_SESSION['user'][$key]='';
            }
            if  ($_POST[$key] != $value) {
                $this->print = $this->error['hijack'];
            }
        }
        if (empty($this->print)) {
            $this->ok = true;
            $pass = password_hash($_SESSION['user']['pass'], PASSWORD_BCRYPT);
            $newUser = new \Educ\Entity\utilisateur();
            $newUser->setName($_SESSION['user']['pseu']);
            $newUser->setPass($pass);
            $newUser->setState(0);
            $this->userClass = $newUser;
        }
    }
}