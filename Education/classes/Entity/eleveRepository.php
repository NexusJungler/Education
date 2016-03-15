<?php

    namespace Educ\Entity;


    class eleveRepository {
        private $connection;
        public function __construct() {
            $base= new \Educ\Utils\Database();
            $this->connection = $base->connect();
        }
        public function getAll ($class) {
            $sql = '
                    SELECT eleve.*
                    FROM education.eleve
                    WHERE eleve.FKclasse = :prmClass
                ';
            $query = $this->connection->prepare($sql);
            $query->execute(
                ['prmClass' => $class]
            );
            $result= $query->fetchAll(\PDO::FETCH_CLASS, '\Educ\Entity\eleve');
            return $result;
        }
        public function getId ($class, $name) {
            $sql = '
                    SELECT eleve.id
                    FROM education.eleve
                    WHERE eleve.prenom = :prmFirst AND eleve.nom = :prmLast AND eleve.FKclasse = :prmClass
                ';
            $query = $this->connection->prepare($sql);
            $query->execute([
                'prmLast' => $name[1],
                'prmFirst' => $name[0],
                'prmClass' => $class
            ]);
            $result = intval($query->fetchColumn());
            return $result;
        }
        public function getPrimaryKeysOrdered ($class) {
        $sql = '
                    SELECT eleve.id
                    FROM education.eleve
                    WHERE eleve.FKclasse = :prmClass
                    ORDER BY eleve.nom ASC
                ';
        $query = $this->connection->prepare($sql);
        $query->execute(
            ['prmClass' => $class]
        );
        $result= $query->fetchAll(\PDO::FETCH_NUM);
        return $result;
    }
        public function getOne ($class, $id) {
            $sql = '
                    SELECT eleve.*
                    FROM education.eleve
                    WHERE eleve.id = :prmID AND eleve.FKclasse = :prmClass
                ';
            $query = $this->connection->prepare($sql);
            $query->execute([
                'prmID' => $id,
                'prmClass' => $class
            ]);
            $result = $query->fetchObject('\Educ\Entity\eleve');
            return $result;
        }
        public function insert ($student) {
            $pool = get_object_vars($student);
            $push = array_values($pool);
            $fields = implode ("','" , $push);
            $fields = substr($fields, 2)  . "'";
            $sql = '
                INSERT INTO education.eleve
                VALUES (NULL, ' . $fields . ')';
            $query = $this->connection->prepare($sql);
            $result = $query->execute();
        }
    }