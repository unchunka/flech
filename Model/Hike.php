<?php

namespace Model;

class Hike extends Model {

    public static function load() {

        $pdo = PDOManager::getInstance()->getPDO();

        $stmt = $pdo->prepare('SELECT * FROM hike');
        $stmt->execute();

        return $stmt->fetchObject(__CLASS__);

    }


}