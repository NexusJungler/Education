<?php
/**
 * Created by PhpStorm.
 * User: Reddington
 * Date: 18/03/2016
 * Time: 18:04
 */

namespace Educ\Entity;


class classeRepository
{
    private $connection;
    private $baseName;
    public function __construct() {
        $base = new \Educ\Utils\Database();
        $this->connection = $base->connect();
        $this->baseName = $base->baseName;
    }
    public function insert($class)
    {
        $pool = get_object_vars($class);
        $push = array_values($pool);
        $fields = implode("','", $push);
        $fields = substr($fields, 2) . "'";
        $sql = '
                INSERT INTO education.classe
                VALUES (NULL, ' . $fields . ')';
        var_dump($sql);
        $query = $this->connection->prepare($sql);
        $query->execute();
    }
    public function getAll($user)
    {
        $sql = '
                    SELECT classe.nom
                    FROM education.classe
                    WHERE classe.FKuser = :prmUser
                ';
        $query = $this->connection->prepare($sql);
        $query->execute(
            ['prmUser' => $user]
        );
        $result = $query->fetchAll(\PDO::FETCH_COLUMN);
        return $result;
    }
}