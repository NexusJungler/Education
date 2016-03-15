<?php

namespace Educ\Entity;

class validationRepository {
    private $connection;
    public function __construct() {
        $base = new \Educ\Utils\Database();
        $this->connection = $base->connect();
    }
    public function insert ($validation) {
        $pool = get_object_vars($validation);
        $push = array_values($pool);
        $fields = implode ("','" , $push);
        $fields = substr($fields, 2)  . "'";
        $sql = '
                INSERT INTO education.validation
                VALUES (NULL, ' . $fields . ')';
        $query = $this->connection->prepare($sql);
        $result = $query->execute();
    }
    public function getState($eleve, $comp)
    {
        $sql = '
                    SELECT validation.FKetat
                    FROM education.validation
                    WHERE validation.FKcompetence = :prmComp
                    AND validation.FKeleve = :prmStud
                ';
        $query = $this->connection->prepare($sql);
        $query->execute(
            ['prmComp' => $comp, 'prmStud' => $eleve]
        );
     //   $result = $query->fetchAll(\PDO::FETCH_ASSOC);
        $result = intval($query->fetchColumn());
        if (empty($result)) {$result=1;}
        return $result;
    }
    public function getOne($eleve, $comp)
    {
        $sql = '
                    SELECT validation.first, validation.second, validation.last
                    FROM education.validation
                    WHERE validation.FKcompetence = :prmComp
                    AND validation.FKeleve = :prmStud
                ';
        $query = $this->connection->prepare($sql);
        $query->execute(
            ['prmComp' => $comp, 'prmStud' => $eleve]
        );
        $result = $query->fetchAll(\PDO::FETCH_NUM);
        $dates= [];
        foreach($result[0] as $value) {
            if($value!='0000-00-00') {array_push($dates, $value);}
        }
        var_dump($dates);
        return $dates;
    }
    public function update($date, $eleve, $comp)
    {
        $state = $this->getState($eleve, $comp);
        if($state == 2) {$colon='second';} else {$colon= 'last';}
        $sql = '
                    UPDATE education.validation
                    SET  validation.'  . $colon . ' = :prmDate, validation.FKetat = '. ($state+1).'
                    WHERE validation.FKeleve = :prmStud
                    AND validation.FKcompetence = :prmComp
                ';
        $query = $this->connection->prepare($sql);
        $query->execute(
            ['prmDate' => $date, 'prmStud' => $eleve, 'prmComp' => $comp]
        );
    }
    public function getAll($eleve, $cat)
    {
        $sql = '
                    SELECT validation.*
                    FROM education.validation
                    JOIN education.categorie
                    JOIN education.competence
                    ON  competence.id = validation.FKcompetence
                    AND competence.FKcategorie = categorie.id
                    AND competence.FKcategorie = :prmCat
                    WHERE validation.FKeleve = :prmStud
                ';
        $query = $this->connection->prepare($sql);
        $query->execute(
            ['prmCat' => $cat, 'prmStud' => $eleve]
        );
        $result = $query->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }
    public function getCount($stud, $dscp)
    {
        $sql = '
                    SELECT competence.id
                    FROM education.competence
                    JOIN education.categorie
                    ON categorie.id = competence.FKcategorie
                    AND categorie.FKdiscipline = :prmDscp
                    JOIN education.validation
                    ON validation.FKcompetence = competence.id
                    AND validation.FKeleve = :prmStud
                ';
        $query = $this->connection->prepare($sql);
        $query->execute(
            ['prmStud' => $stud, 'prmDscp' => $dscp]
        );
        $result = $query->fetchAll(\PDO::FETCH_NUM);
        return count($result);
    }
    public function getChartData($stud) {
        $result = [];
        for($i=0; $i<7; $i++) {
            $result[$i] = $this->getCount($stud, $i+1);
        }
        return $result;
    }
    public function getSuccess($stud) {
        $result = null;
        $query = new \Educ\Entity\competenceRepository();
        $nbrComp = $query->getNbrCompetence();
        $work = $this->getChartData($stud);
        foreach($work as $value) {
            $result += $value;
        }
        $result /= $nbrComp;
        return (int)($result);
    }
    public function getValidationDate($eleve, $comp)
    {
        $sql = '
                    SELECT validation.first, validation.second, validation.last
                    FROM education.validation
                    WHERE validation.FKeleve = :prmStud
                    AND validation.FKcompetence = :prmComp
                ';
        $query = $this->connection->prepare($sql);
        $query->execute(
            ['prmComp' => $comp, 'prmStud' => $eleve]
        );
        $result = $query->fetchAll(\PDO::FETCH_ASSOC);
        return $result[0];
    }
}