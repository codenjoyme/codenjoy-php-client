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

class GameBoard
{

    private array $elements;
    private int $len;
    private int $size;

    public function __construct(array $supportedElements, string $message)
    {
        $message = str_replace("board=", "", $message);
        $this->initElementsArray($supportedElements, $message);
        $this->len = count($this->elements);
        $this->size = sqrt($this->len);
    }

    private function initElementsArray(array $supportedElements, string $message)
    {
        $this->elements = array();
        for ($i = 0; $i < mb_strlen($message); $i++) {
            $nextElement = mb_substr($message, $i, 1, 'UTF-8');
            if (array_search($nextElement, $supportedElements) === false) {
                throw new InvalidArgumentException("invalid element: " . $nextElement);
            } else {
                array_push($this->elements, $nextElement);
            }
        }
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getAt(Point $pt): string
    {
        if (!$pt->isValid($this->size)) {
            throw new InvalidArgumentException("invalid point: " . $pt);
        }
        return $this->elements[$this->pointToIndex($pt)];
    }

    public function find(string...$wanted): array
    {
        $points = array();
        for ($i = 0; $i < $this->len; $i++) {
            if (in_array($this->elements[$i], $wanted)) {
                array_push($points, $this->indexToPoint($i));
            }
        }
        usort($points, array("Point", "compare"));
        return $points;
    }

    public function findFirst(string...$wanted): ?Point
    {
        for ($i = 0; $i < $this->len; $i++) {
            if (in_array($this->elements[$i], $wanted)) {
                return $this->indexToPoint($i);
            }
        }
        return null;
    }

    public function isAt(Point $pt, string...$wanted): bool
    {
        if (!$pt->isValid($this->size)) {
            return false;
        }
        return in_array($this->getAt($pt), $wanted);
    }

    public function findNear(Point $pt): array
    {
        $elements = array();

        $right = new Point($pt->x() + 1, $pt->y());
        if ($right->isValid($this->size)) {
            array_push($elements, $this->getAt($right));
        }
        $left = new Point($pt->x() - 1, $pt->y());
        if ($left->isValid($this->size)) {
            array_push($elements, $this->getAt($left));
        }
        $up = new Point($pt->x(), $pt->y() + 1);
        if ($up->isValid($this->size)) {
            array_push($elements, $this->getAt($up));
        }
        $down = new Point($pt->x(), $pt->y() - 1);
        if ($down->isValid($this->size)) {
            array_push($elements, $this->getAt($down));
        }

        return $elements;
    }

    public function countNear(Point $pt, string...$wanted): int
    {
        return count(array_intersect($this->findNear($pt), $wanted));
    }

    public function isNear(Point $pt, string...$wanted): bool
    {
        foreach ($wanted as $el) {
            if ($this->countNear($pt, $el) != 0) {
                return true;
            }
        }
        return false;
    }

    private function pointToIndex(Point $pt): int
    {
        return ($this->size - 1 - $pt->y()) * $this->size + $pt->x();
    }

    private function indexToPoint(int $index): Point
    {
        $x = $index % $this->size;
        $y = ceil($this->size - 1 - $index / $this->size);
        return new Point($x, $y);
    }

    public function __toString(): string
    {
        $str = "";
        for ($y = $this->size - 1; $y >= 0; $y--) {
            for ($x = 0; $x < $this->size; $x++) {
                $index = $this->pointToIndex(new Point($x, $y));
                $str .= $this->elements[$index];
            }
            $str .= "\n";
        }
        return $str;
    }
}