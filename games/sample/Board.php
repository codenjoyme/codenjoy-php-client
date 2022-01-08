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

    public function getAt(Point $pt): string
    {
        if (!$pt->isValid($this->board->getSize())) {
            return Element::$elements['WALL'];
        }
        return $this->board->getAt($pt);
    }

    public function findHero(): Point
    {
        $points = $this->board->find(
            Element::$elements['HERO'],
            Element::$elements['HERO_DEAD']
        );

        if (count($points) == 0) {
            throw new UnexpectedValueException("Hero element has not been found");
        }
        return $points[0];
    }

    public function isGameOver(): bool
    {
        return $this->board->findFirst(Element::$elements['HERO_DEAD']) != null;
    }

    public function findOtherHeroes(): array
    {
        return $this->board->find(
            Element::$elements['OTHER_HERO'],
            Element::$elements['OTHER_HERO_DEAD'],
        );
    }

    public function findBarriers(): array
    {
        $points = array();
        $points = array_merge($points, $this->findWalls());
        $points = array_merge($points, $this->findBombs());
        $points = array_merge($points, $this->findOtherHeroes());
        usort($points, array("Point", "compare"));
        return array_values(array_unique($points));
    }

    public function findWalls(): array
    {
        return $this->board->find(Element::$elements['WALL']);
    }

    public function findBombs(): array
    {
        return $this->board->find(Element::$elements['BOMB']);
    }

    public function findGold(): array
    {
        return $this->board->find(Element::$elements['GOLD']);
    }

    public function __toString(): string
    {
        return $this->board->__toString() .
            "\nHero at: " . $this->findHero() .
            "\nOther heroes at: " . implode($this->findOtherHeroes()) .
            "\nBombs at: " . implode($this->findBombs()) .
            "\nGold at: " . implode($this->findGold());
    }
}