<?php


    namespace Educ\Entity;


    class competenceRepository
    {
        private $connection;
        private $baseName;

        public function __construct()
        {
            $base = new \Educ\Utils\Database();
            $this->connection = $base->connect();
            $this->baseName = $base->baseName;
        }

        public function getAll($table)
        {
            $sql = 'SELECT ' . $table . '.* FROM ' . $this->baseName . '.' . $table;
            $query = $this->connection->prepare($sql);
            $query->execute();
            $result = $query->fetchAll(\PDO::FETCH_CLASS, '\Educ\Entity\competence');
            return $result;
        }

        public function getCompetence($dspl, $ctgr, $ajax = false)
        {
            $sql = '
                    SELECT competence.id, competence.intitule
                    FROM education.competence
                    JOIN education.discipline
                    JOIN education.categorie
                    ON  categorie.id = competence.FKcategorie
                    AND categorie.FKdiscipline = discipline.id
                    AND categorie.FKdiscipline = :prmDspl
                    WHERE competence.FKcategorie = :prmCtgr
                ';
            $query = $this->connection->prepare($sql);
            $query->execute(
                ['prmCtgr' => $ctgr, 'prmDspl' => $dspl]
            );
            if ($ajax) {
                $result = $query->fetchAll(\PDO::FETCH_ASSOC);
            } else {
                $result = $query->fetchAll(\PDO::FETCH_CLASS, '\Educ\Entity\competence');
            }
            return $result;
        }
        public function getCategorie($dspl)
        {
            $sql = '
                    SELECT categorie.id, categorie.intitule
                    FROM education.categorie
                    WHERE categorie.FKdiscipline = :prmDspl
                ';
            $query = $this->connection->prepare($sql);
            $query->execute(
                ['prmDspl' => $dspl]
            );
            $result = $query->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        }
        public function getVal($id)
        {
            $sql = '
                    SELECT competence.intitule
                    FROM education.competence
                    WHERE competence.id = :prmId
                ';
            $query = $this->connection->prepare($sql);
            $query->execute(
                ['prmId' => $id]
            );
            $result = $query->fetchColumn();
            return $result;
        }
        public function getDiscipline($comp)
        {
            $sql = '
                    SELECT categorie.FKdiscipline
                    FROM education.categorie
                    JOIN education.competence
                    ON competence.FKcategorie = categorie.id
                    AND competence.id = :prmComp
                ';
            $query = $this->connection->prepare($sql);
            $query->execute(
                ['prmComp' => $comp]
            );
            $result = $query->fetch(\PDO::FETCH_NUM);
            return $result;
        }
        public function getNbrCompetence()
        {
            $sql = '
                    SELECT competence.id
                    FROM education.competence
                ';
            $query = $this->connection->prepare($sql);
            $query->execute();
            $result = $query->fetchAll(\PDO::FETCH_NUM);
            return count($result);
        }
    }
