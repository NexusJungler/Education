<?php

namespace Educ\Form;

class log {
    public $userClass = null;
    public $print = null;
    public $ok = false;
    public $error= [
        "pseu" => "Vous n'avez pas saisi votre identifiant.",
        "pass" => "Vous n'avez pas saisi votre mot de passe." ,
        "hijack" =>  "Les caractères spéciaux ne sont pas autorisés!"
    ];

    public function __construct() {
        $this->memory();
        if (isset($_POST['send'])) {
            $this->check();
        }
    }
    private function memory() {
       // var_dump($_SESSION);
        if (!empty($_POST['pseu'])) {
            $_SESSION['login']['pseu'] = filter_var($_POST['pseu'], FILTER_SANITIZE_STRING);
        }
        if (!empty($_POST['pass'])) {
            $_SESSION['login']['pass'] = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
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
                $_SESSION['login'][$key]='';
            }
            if  ($_POST[$key] != $value) {
                $this->print = $this->error['hijack'];
            }
        }
        if (empty($this->print)) {
            $this->ok = true;
        }
    }
}


