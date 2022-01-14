<?php
namespace App\Services;


class Position {
    public $name;
    public $direction;

    public function __construct($name, $direction)
    {
        $this->name = $name;
        $this->x = $direction['x'];
        $this->y = $direction['y'];
    }
}