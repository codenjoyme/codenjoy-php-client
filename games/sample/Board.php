<?php

namespace Sample;

use GameBoard;
use Point;
use UnexpectedValueException;

class Board
{

    private GameBoard $board;

    public function __construct(string $message)
    {
        $this->board = new GameBoard(Element::$elements, $message);
    }

    public function isGameOver(): bool
    {
        return $this->board->findFirst(Element::$elements['DEAD_HERO']) != null;
    }


    public function __toString(): string
    {
        return $this->board->__toString();
    }
}