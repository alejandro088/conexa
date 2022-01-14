<?php
namespace App\Services;

class EarthService
{
    public $positions;

    public $board;

    public function __construct()
    {
        $this->board = new Board();
    }

    public function generateMovements()
    {
        return $this->board->generateMovements();
    }

    public function getFinalPosition($movements, $initial)
    {
        // get the initial position from the request, example: [0,0]
        
        return $this->board->getFinalPosition($initial, $movements);
    }
}
