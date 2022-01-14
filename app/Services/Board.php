<?php
namespace App\Services;

class Board
{
    protected $currentPosition;

    protected $positions;

    protected $movements;

    protected $trayectory;

    protected $board;

    protected $count = 0;

    protected $dimensions = [
        'x' => 3,
        'y' => 3
    ];

    public function __construct()
    {
        $this->positions = [
            'U' => new Position('UP', ['y' => -1, 'x' => 0]),
            'D' => new Position('DOWN', ['y' => 1, 'x' => 0]),
            'L' => new Position('LEFT', ['y' => 0, 'x' => -1]),
            'R' => new Position('RIGHT', ['y' => 0, 'x' => 1])
        ];

        $this->board = $this->generateBoard();
    }

    // generate a list of movements between 5 and 7 elements of the array with values: UP, DOWN, LEFT, RIGHT
    public function generateMovements()
    {
        $movements = [];
        $numberOfMovements = rand(5, 7);

        while (count($movements) < $numberOfMovements) {
            $movements[] = $this->positions[array_rand($this->positions)]->name;
        }

        return $movements;
    }

    public function generateBoard()
    {
        $board = [];

        for ($i = 0; $i < $this->dimensions['y']; $i++) {
            for ($j = 0; $j < $this->dimensions['x']; $j++) {
                $board[$i][$j] = 0;
            }
        }

        return $board;
    }

    public function setInitialPosition()
    {
        $this->board[$this->currentPosition[1]][$this->currentPosition[0]] = 1;
    }

    public function down()
    {
        
        if ($this->checkIfIsInOfBounds($this->positions['D']->y + $this->currentPosition[0])) {
            $this->board[$this->positions['D']->y + $this->currentPosition[0]][$this->currentPosition[1]] = ++$this->count;
            $this->currentPosition[0] = $this->positions['D']->y + $this->currentPosition[0];
        }

        $this->trayectory[] = $this->currentPosition;

        return $this->trayectory;
    }

    public function up()
    {
       
        if ($this->checkIfIsInOfBounds($this->positions['U']->y + $this->currentPosition[0])) {
            $this->board[$this->positions['U']->y + $this->currentPosition[0]][$this->currentPosition[1]] = ++$this->count;
            $this->currentPosition[0] = $this->positions['U']->y + $this->currentPosition[0];
        }

        $this->trayectory[] = $this->currentPosition;

        return $this->trayectory;
    }

    public function left()
    {
       
        if ($this->checkIfIsInOfBounds($this->positions['L']->x + $this->currentPosition[1])) {
            $this->board[$this->currentPosition[0]][$this->positions['L']->x + $this->currentPosition[1]] = ++$this->count;
            $this->currentPosition[1] = $this->positions['L']->x + $this->currentPosition[1];
        }

        $this->trayectory[] = $this->currentPosition;

        return $this->trayectory;
    }

    public function right()
    {
        
        if ($this->checkIfIsInOfBounds($this->positions['R']->x + $this->currentPosition[1])){
            $this->board[$this->currentPosition[0]][$this->positions['R']->x + $this->currentPosition[1]] = ++$this->count;
            $this->currentPosition[1] = $this->positions['R']->x + $this->currentPosition[1];
        }
        
        $this->trayectory[] = $this->currentPosition;

        return $this->trayectory;
    }

    public function getFinalPosition($initial, $movements)
    {
        $this->currentPosition = $initial;
        $this->movements = $movements;
        $this->setInitialPosition();

        foreach ($this->movements as $movement) {


            $status = match($movement) {
                'U' => $this->up(),
                'D' => $this->down(),
                'L' => $this->left(),
                'R' => $this->right(),
                default => throw new \Exception('Unsupported'),
            };

        }

        return $status;
    }

    public function checkIfIsInOfBounds($axis)
    {
        return ($axis >= 0 && $axis <= 2);
    }
}
