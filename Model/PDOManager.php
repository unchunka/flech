<?php

namespace Model;

class PDOManager {

    private static $instance;

    private $pdo;

    private function __construct() {

        $dbConfig = \Symfony\Component\Yaml\Yaml::parse(file_get_contents(__DIR__.'/../config/db.yml'));

        $this->pdo = new \PDO("mysql:host=".$dbConfig['host'].";dbname=".$dbConfig['dbname'].";charset=utf8", $dbConfig['user'], $dbConfig['password']);

        $this->pdo->beginTransaction();

    }

    public function getPDO() {

        return $this->pdo;

    }

    static public function getInstance() {

        if (self::$instance) {
            return self::$instance;
        }
        else {
            return new PDOManager();
        }

    }

}