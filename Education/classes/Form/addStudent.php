<?php

namespace Educ\Form;

class addStudent
{
    public $print = null;
    public $ok = false;
    private $maxMoSize=1;
    public $error= [
        "nom" => "Vous n'avez pas saisi le nom de l'élève." ,
        "prenom" => "Vous n'avez pas saisi le prénom de l'élève." ,
        "photo" => "Vous n'avez pas chargé de photo." , "L'extension du fichier n'est pas autorisée.","Le fichier est trop volumineux!",
        "age" => "Vous n'avez pas renseigné la date de naissance de l'élève.",
        "hijack" =>  "Aucun pirate ne peut pénétrer cette application! Abandonnez maintenant!" ,
        "studExist" => "Un élève inscrit porte déjà ce nom! Choisissez en un autre."
    ];
    private $extensions = [
        'image/gif' => 'gif',
        'image/png' => 'png',
        'image/jpeg' => 'jpg',
        'image/svg+xml' => 'svg'
    ];
    public function __construct() {
        $this->memory();
        if (isset($_POST['send'])) {
            $this->check();
        }
    }
    private function memory() {
        if (!empty($_POST['nom'])) {
            $_SESSION['student']['nom'] = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
        }
        if (!empty($_POST['prenom'])) {
            $_SESSION['student']['prenom'] = filter_var($_POST['prenom'], FILTER_SANITIZE_STRING);
        }
        if (!empty($_POST['age'])) {
            $_SESSION['student']['age'] = filter_var($_POST['age'], FILTER_SANITIZE_STRING);
        }
        if (!empty($_FILES['photo'])) {
            $newName = $this->getNewName($_FILES['photo']['tmp_name']);
            $_SESSION['student']['photo'] = $newName;
        }  else {$this->print .= $this->error['photo'][0];}
    }
    private function check() {
        $test = new \Educ\Entity\eleveRepository();
        $tableCheck = filter_input_array(INPUT_POST, [
            'nom' => ['filter' => FILTER_SANITIZE_STRING],
            'prenom' => ['filter' => FILTER_SANITIZE_STRING],
            'age' => ['filter' => FILTER_SANITIZE_STRING]
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
       $tempName = $_FILES['photo']['tmp_name'];
        if(!empty($tableCheck['photo'])  && !$this->checkExtension($tempName)) {
            $this->print .= $this->error['photo'][1] . '<br />';
        }
        // élève existe ?
        $name[0] = $_SESSION['student']['prenom'];
        $name[1] = $_SESSION['student']['nom'];
       if ($test->getId(53, $name) != null) {$this->print .= $this->error['studExist'] . '<br>';}

        if (empty($this->print)) {
            $this->ok = true;
            $this->upload();
        }
    }
    private function getNewName($temporyFile) {
        $newName = bin2hex(openssl_random_pseudo_bytes(16));
        return $newName . '.' . $this->getExtension($temporyFile);
    }
    private function checkSize($size) {
        if ($size <= ($this->maxMoSize*1024*1024) ) {
            return true;
        }  else  {return false;}
    }
    private function checkExtension($temporyFile) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $temporyFile);
        if(array_key_exists($mimeType, $this->extensions)){
            return true;
        } else{
            return false;
        }
    }
    private function getExtension($temporyFile) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $temporyFile);
        return $this->extensions[$mimeType];
    }
    private function upload() {
        $_SESSION['photopath'] = 'upload/' .$_SESSION['student']['photo'];
        $Response = move_uploaded_file($_FILES['photo']['tmp_name'], $_SESSION['photopath']);
        if ($Response) {$this->print .= 'transfert réussi<br/>';}
        else {$this->print .= 'échec du transfert<br/>';}
    }
}