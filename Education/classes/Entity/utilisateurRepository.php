<?php

    namespace Educ\Entity;

    class utilisateurRepository
    {
        private $connection;

        public function __construct()
        {
            $base = new \Educ\Utils\Database();
            $this->connection = $base->connect();
        }

        public function getAll()
        {
            $sql = '
                SELECT utilisateurs.*
                FROM education.utilisateurs
            ';
            $query = $this->connection->prepare($sql);
            $query->execute();
            $result = $query->fetchAll(\PDO::FETCH_CLASS, '\Educ\Entity\utilisateur');
            return $result;
        }

        public function find($name)
        {
            $sql = '
                SELECT utilisateurs.*
                FROM education.utilisateurs
                WHERE utilisateurs.pseudo = :prmName
            ';
            $query = $this->connection->prepare($sql);
            $query->execute(
                ['prmName' => $name]
            );
            $result = $query->fetchObject('\Educ\Entity\utilisateur');
            return $result;
        }

        public function insert($user)
        {
            $pool = get_object_vars($user);     // Attention, seules les propri�tes publiques de l'objet seront retourn�es...
            $push = array_values($pool);
            $fields = implode("','", $push);
            $fields = substr($fields, 2) . "'";
            $sql = '
                INSERT INTO education.utilisateurs
                VALUES (NULL, ' . $fields . ')';
            $query = $this->connection->prepare($sql);
            $result = $query->execute();
        }
        public function getName($id)
        {
            $sql = '
                SELECT utilisateurs.pseudo
                FROM education.utilisateurs
                WHERE utilisateurs.id = :prmId
            ';
            $query = $this->connection->prepare($sql);
            $query->execute(
                ['prmId' => $id]
            );
            $result = $query->fetch(\PDO::FETCH_NUM);
            return $result[0];
        }
    }
