<?php

namespace Model;

class Hike extends Model {

    public function __construct($id, $name, $region, $distance, $difference, $difficulty, $description, $link) {

        $this->properties['id'] = $id;
        $this->properties['name'] = $name;
        $this->properties['region'] = $region;
        $this->properties['distance'] = $distance;
        $this->properties['different'] = $difference;
        $this->properties['difficulty'] = $difficulty;
        $this->properties['link'] = $link;
        $this->properties['description'] = $description;
    }

}