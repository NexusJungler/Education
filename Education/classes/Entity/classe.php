<?php

namespace Educ\Entity;


class classe
{
    public $id = null;
    public $nom = null;
    public $annee = null;
    public $FKuser = null;

    public function getId() {
        return $this->id;
    }
    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }
    public function getAnnee()
    {
        return $this->annee;
    }
    public function setAnnee($annee)
    {
        $this->annee = $annee;
    }
    public function getFKuser()
    {
        return $this->FKuser;
    }
    public function setFKuser($FKuser)
    {
        $this->FKuser = $FKuser;
    }
}