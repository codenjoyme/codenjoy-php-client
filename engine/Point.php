<?php

###
# #%L
# Codenjoy - it's a dojo-like platform from developers to developers.
# %%
# Copyright (C) 2012 - 2022 Codenjoy
# %%
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as
# published by the Free Software Foundation, either version 3 of the
# License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public
# License along with this program.  If not, see
# <http://www.gnu.org/licenses/gpl-3.0.html>.
# #L%
###

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

    public static function stepRight(Point $pt): Point
    {
        return new Point($pt->x() + 1, $pt->y());
    }

    public static function stepLeft(Point $pt): Point
    {
        return new Point($pt->x() - 1, $pt->y());
    }

    public static function stepUp(Point $pt): Point
    {
        return new Point($pt->x(), $pt->y() + 1);
    }

    public static function stepDown(Point $pt): Point
    {
        return new Point($pt->x(), $pt->y() - 1);
    }
}