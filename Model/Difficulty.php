<?php

namespace Model;

class Difficulty extends Model {

    public function __construct($id, $name){

        $this->properties['id'] = $id;
        $this->properties['name'] = $name;

    }

}