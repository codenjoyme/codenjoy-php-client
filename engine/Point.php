<?php

class Point
{
    private int $x;
    private int $y;

    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function x(): int
    {
        return $this->x;
    }

    public function y(): int
    {
        return $this->y;
    }

    public function isValid(int $boardSize): bool
    {
        return ($this->x >= 0 && $this->x < $boardSize) && ($this->y >= 0 && $this->y < $boardSize);
    }

    public static function compare($a, $b): int
    {
        return strcmp($a->__toString(), $b->__toString());
    }

    public function __toString(): string
    {
        return sprintf("[%d,%d]", $this->x, $this->y);
    }
}