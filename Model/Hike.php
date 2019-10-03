<?php

namespace Model;

class Hike extends Model {

    public function __construct($id, $name, $zone, $difference, $difficulty){

        $this->properties['id'] = $id;
        $this->properties['name'] = $name;
        $this->properties['zone'] = $zone;
        $this->properties['difference'] = $difference;
        $this->properties['difficulty'] = $difficulty;

    }

}