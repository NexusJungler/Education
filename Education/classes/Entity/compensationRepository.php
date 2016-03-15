<?php

namespace Educ\Entity;


class compensationRepository {
    private $connection;
    public function __construct() {
        $base= new \Educ\Utils\Database();
        $this->connection = $base->connect();
    }
    public function getAll () {
        $sql = '
                    SELECT compensation.acronyme
                    FROM education.compensation
                ';
        $query = $this->connection->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_NUM);
        return $result;
    }
}