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

namespace Mollymage;

use GameBoard;
use Point;
use UnexpectedValueException;

define("BLAST_RANGE", 3);

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
            Element::$elements['HERO_POTION'],
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
            Element::$elements['OTHER_HERO_POTION'],
            Element::$elements['OTHER_HERO_DEAD'],
        );
    }

    public function findEnemyHeroes(): array
    {
        return $this->board->find(
            Element::$elements['ENEMY_HERO'],
            Element::$elements['ENEMY_HERO_POTION'],
            Element::$elements['ENEMY_HERO_DEAD'],
        );
    }

    public function findBarriers(): array
    {
        $points = array();
        $points = array_merge($points, $this->findWalls());
        $points = array_merge($points, $this->findGhosts());
        $points = array_merge($points, $this->findTreasureBoxes());
        $points = array_merge($points, $this->findPotions());
        $points = array_merge($points, $this->findOtherHeroes());
        $points = array_merge($points, $this->findEnemyHeroes());
        usort($points, array("Point", "compare"));
        return array_values(array_unique($points));
    }

    public function findWalls(): array
    {
        return $this->board->find(Element::$elements['WALL']);
    }

    public function findGhosts(): array
    {
        return $this->board->find(Element::$elements['GHOST']);
    }

    public function findTreasureBoxes(): array
    {
        return $this->board->find(Element::$elements['TREASURE_BOX']);
    }

    public function findPotions(): array
    {
        return $this->board->find(
            Element::$elements['POTION_TIMER_1'],
            Element::$elements['POTION_TIMER_2'],
            Element::$elements['POTION_TIMER_3'],
            Element::$elements['POTION_TIMER_4'],
            Element::$elements['POTION_TIMER_5'],
            Element::$elements['HERO_POTION'],
            Element::$elements['OTHER_HERO_POTION'],
            Element::$elements['ENEMY_HERO_POTION']);
    }

    public function findBlasts(): array
    {
        return $this->board->find(Element::$elements['BLAST']);
    }

    public function predictFutureBlasts(): array
    {
        $blasts = array();
        foreach ($this->board->find(Element::$elements['POTION_TIMER_1']) as $potion) {
            $blasts = array_merge($blasts, $this->predictBlastsForOneSide($potion, function ($pt) {
                return Point::stepLeft($pt);
            }));
            $blasts = array_merge($blasts, $this->predictBlastsForOneSide($potion, function ($pt) {
                return Point::stepRight($pt);
            }));
            $blasts = array_merge($blasts, $this->predictBlastsForOneSide($potion, function ($pt) {
                return Point::stepUp($pt);
            }));
            $blasts = array_merge($blasts, $this->predictBlastsForOneSide($potion, function ($pt) {
                return Point::stepDown($pt);
            }));
        }
        return $blasts;
    }

    public function predictBlastsForOneSide($pt, $nextStep): array
    {
        $barriers = $this->findBarriers();
        $points = array();
        for ($i = 0; $i < BLAST_RANGE; $i++) {
            $pt = $nextStep($pt);
            if (!$pt->isValid($this->board->getSize())) {
                break;
            }
            if (in_array($pt, $barriers)) {
                break;
            }
            array_push($points, $pt);
        }
        return $points;
    }

    public function findPerks(): array
    {
        return $this->board->find(
            Element::$elements['POTION_COUNT_INCREASE'],
            Element::$elements['POTION_REMOTE_CONTROL'],
            Element::$elements['POTION_IMMUNE'],
            Element::$elements['POTION_BLAST_RADIUS_INCREASE'],
            Element::$elements['POISON_THROWER'],
            Element::$elements['POTION_EXPLODER']);
    }

    public function __toString(): string
    {
        return $this->board->__toString() .
            "\nHero at: " . $this->findHero() .
            "\nOther heroes at: " . implode($this->findOtherHeroes()) .
            "\nEnemy heroes at: " . implode($this->findEnemyHeroes()) .
            "\nGhosts at: " . implode($this->findGhosts()) .
            "\nPotions at: " . implode($this->findPotions()) .
            "\nBlasts at: " . implode($this->findBlasts()) .
            "\nExpected blasts at: " . implode($this->predictFutureBlasts());
    }
}