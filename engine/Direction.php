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

class Direction
{

    private string $name;
    private int $value;
    private int $dx;
    private int $dy;

    public function __construct($name, $value, $dx, $dy)
    {
        $this->name = $name;
        $this->value = $value;
        $this->dx = $dx;
        $this->dy = $dy;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function changeX(int $x): int
    {
        return $x + $this->dx;
    }

    public function changeY(int $y): int
    {
        return $y + $this->dy;
    }

    public function inverted(): Direction
    {
        if ($this->name == "LEFT") {
            global $RIGHT;
            return $RIGHT;
        }
        if ($this->name == "RIGHT") {
            global $LEFT;
            return $LEFT;
        }
        if ($this->name == "UP") {
            global $DOWN;
            return $DOWN;
        }
        if ($this->name == "DOWN") {
            global $UP;
            return $UP;
        }
        throw new InvalidArgumentException("Cant invert for: " . $this->name);
    }

    public function __toString(): string
    {
        return $this->name;
    }
}

$LEFT = new Direction("LEFT", 0, -1, 0);
$RIGHT = new Direction("RIGHT", 1, 1, 0);
$UP = new Direction("UP", 2, 0, 1);
$DOWN = new Direction("DOWN", 3, 0, -1);
$ACT = new Direction("ACT", 4, 0, 0);
$STOP = new Direction("STOP", 5, 0, 0);
