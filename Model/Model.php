<?php

namespace Model;

abstract class Model {

    protected $properties = [];

    public function __construct() {

        $className = $this->getFormattedClassName();

        $pdo = PDOManager::getInstance()->getPDO();
        $stmt = $pdo->prepare("DESCRIBE $className");
        $stmt->execute();

        $this->properties = $stmt->fetchAll(\PDO::FETCH_COLUMN);

    }

    public function get($property) {

        foreach($this->properties as $theProperty) {
            if ($theProperty == $property) {
                return $this->$property;
            }
        }

        return null;

    }

    public function set($property, $value) {

        foreach($this->properties as $theProperty) {
            if ($theProperty == $property) {
                $this->$property = $value;
                return $this;
            }
        }

        return null;

    }

    public function update() {

        $className = $this->getFormattedClassName();

        $pdo = PDOManager::getInstance()->getPDO();

        $values = [];
        foreach ($this->properties as $property) {
            $values[$property] = $this->$property;
        }

        $updateArray = [];
        for ($i = 0 ; $i < count($this->properties) ; ++$i) {
            $updateArray[] = $this->properties[$i]." = :".$this->properties[$i];
        }
        $updateStr = implode(',',$updateArray);

        $stmt = $pdo->prepare("UPDATE $className SET ".$updateStr." WHERE id = :id");

        $result = $stmt->execute($values);

        return $result;

    }

    public function save() {

        $className = $this->getFormattedClassName();

        $pdo = PDOManager::getInstance()->getPDO();

        $values = [];
        foreach ($this->properties as $property) {
            $values[] = $this->$property;
        }

        $propertiesStr = implode(',',$this->properties);

        $valuesStr = substr(str_repeat('?,',count($this->properties)),0,count($this->properties)-1);

        $stmt = $pdo->prepare("INSERT INTO $className (".$propertiesStr.") VALUES (".$valuesStr.")");

        $result = $stmt->execute($values);

        return $result;

    }

    public function delete() {

        $className = $this->getFormattedClassName();

        $pdo = PDOManager::getInstance()->getPDO();

        $stmt = $pdo->prepare("DELETE FROM $className WHERE id = ".$this->get('id'));

        $result = $stmt->execute([]);

        return $result;

    }

    private function getFormattedClassName() {

        return lcfirst(end(explode('\\',get_called_class())));

    }

}