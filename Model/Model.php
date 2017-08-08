<?php

namespace Model;

abstract class Model {

    protected $properties = [];

    public function __construct() {}

    public function get($property) {

        if (array_key_exists($property,$this->properties)) {
            return $this->properties[$property];
        }

        return null;

    }

    public function set($property, $value) {

        if (array_key_exists($property,$this->properties)) {
            $this->properties[$property] = $value;
        }

        return $this;

    }

    public function update() {

        $className = self::getFormattedClassName();

        $pdo = PDOManager::getInstance()->getPDO();

        $values = [];
        $valuesBinding = [];

        foreach ($this->properties as $property => $value) {
            $values[$property] = $value;
            $valuesBinding[] = $property." = :".$property;
        }
        $valuesBinding = implode(',',$valuesBinding);

        $stmt = $pdo->prepare("UPDATE $className SET ".$valuesBinding." WHERE id = :id");

        $result = $stmt->execute($values);

        return $result;

    }

    public function save() {

        $className = self::getFormattedClassName();

        $pdo = PDOManager::getInstance()->getPDO();

        $values = [];
        $valuesBinding = [];
        $properties = [];

        foreach ($this->properties as $property => $value) {
            if ($property == 'id') continue;
            $values[$property] = $value;
            $valuesBinding[] = ":".$property;
            $properties[] = $property;
        }
        $valuesBinding = implode(',',$valuesBinding);

        $propertiesStr = implode(',',$properties);

        $stmt = $pdo->prepare("INSERT INTO $className (".$propertiesStr.") VALUES (".$valuesBinding.")");

        $result = $stmt->execute($values);

        return $result;

    }

    public function delete() {

        $className = self::getFormattedClassName();

        $pdo = PDOManager::getInstance()->getPDO();

        $stmt = $pdo->prepare("DELETE FROM $className WHERE id = :id");

        $result = $stmt->execute(['id' => $this->get('id')]);

        return $result;

    }

    public static function find($id) {

        $className = self::getFormattedClassName();

        $pdo = PDOManager::getInstance()->getPDO();

        $stmt = $pdo->prepare("SELECT * FROM $className WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(\PDO::FETCH_NUM);

        return self::getObjectFromArrayResult($result);

    }

    public static function findAll() {

        $className = self::getFormattedClassName();

        $pdo = PDOManager::getInstance()->getPDO();

        $stmt = $pdo->prepare("SELECT * FROM $className");
        $stmt->execute();
        $results = $stmt->fetchAll(\PDO::FETCH_NUM);

        $objects = [];
        foreach($results as $result) {
            $objects[] = self::getObjectFromArrayResult($result);
        }

        return $objects;

    }


    private static function getFormattedClassName() {

        $explodedClassName = explode('\\',get_called_class());
        return lcfirst(end($explodedClassName));

    }

    private static function getObjectFromArrayResult($result) {

        $reflector = new \ReflectionClass(get_called_class());
        return $reflector->newInstanceArgs($result);

    }

}