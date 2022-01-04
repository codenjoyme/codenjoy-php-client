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

namespace Clifford;

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
        return $this->board->findFirst(
                Element::$elements['HERO_DIE'],
                Element::$elements['HERO_MASK_DIE']) != null;
    }

    public function findHero(): Point
    {
        $points = $this->board->find(
            Element::$elements['HERO_DIE'],
            Element::$elements['HERO_LADDER'],
            Element::$elements['HERO_LEFT'],
            Element::$elements['HERO_RIGHT'],
            Element::$elements['HERO_FALL'],
            Element::$elements['HERO_PIPE'],
            Element::$elements['HERO_PIT'],

            Element::$elements['HERO_MASK_DIE'],
            Element::$elements['HERO_MASK_LADDER'],
            Element::$elements['HERO_MASK_LEFT'],
            Element::$elements['HERO_MASK_RIGHT'],
            Element::$elements['HERO_MASK_FALL'],
            Element::$elements['HERO_MASK_PIPE'],
            Element::$elements['HERO_MASK_PIT']
        );

        if (count($points) == 0) {
            throw new UnexpectedValueException("Hero element has not been found");
        }
        return $points[0];
    }

    public function findOtherHeroes(): array
    {
        return $this->board->find(
            Element::$elements['OTHER_HERO_DIE'],
            Element::$elements['OTHER_HERO_LADDER'],
            Element::$elements['OTHER_HERO_LEFT'],
            Element::$elements['OTHER_HERO_RIGHT'],
            Element::$elements['OTHER_HERO_FALL'],
            Element::$elements['OTHER_HERO_PIPE'],
            Element::$elements['OTHER_HERO_PIT'],

            Element::$elements['OTHER_HERO_MASK_DIE'],
            Element::$elements['OTHER_HERO_MASK_LADDER'],
            Element::$elements['OTHER_HERO_MASK_LEFT'],
            Element::$elements['OTHER_HERO_MASK_RIGHT'],
            Element::$elements['OTHER_HERO_MASK_FALL'],
            Element::$elements['OTHER_HERO_MASK_PIPE'],
            Element::$elements['OTHER_HERO_MASK_PIT']
        );
    }

    public function findEnemyHeroes(): array
    {
        return $this->board->find(
            Element::$elements['ENEMY_HERO_DIE'],
            Element::$elements['ENEMY_HERO_LADDER'],
            Element::$elements['ENEMY_HERO_LEFT'],
            Element::$elements['ENEMY_HERO_RIGHT'],
            Element::$elements['ENEMY_HERO_FALL'],
            Element::$elements['ENEMY_HERO_PIPE'],
            Element::$elements['ENEMY_HERO_PIT'],

            Element::$elements['ENEMY_HERO_MASK_DIE'],
            Element::$elements['ENEMY_HERO_MASK_LADDER'],
            Element::$elements['ENEMY_HERO_MASK_LEFT'],
            Element::$elements['ENEMY_HERO_MASK_RIGHT'],
            Element::$elements['ENEMY_HERO_MASK_FALL'],
            Element::$elements['ENEMY_HERO_MASK_PIPE'],
            Element::$elements['ENEMY_HERO_MASK_PIT']
        );
    }

    public function findRobbers(): array
    {
        return $this->board->find(
            Element::$elements['ROBBER_LADDER'],
            Element::$elements['ROBBER_LEFT'],
            Element::$elements['ROBBER_RIGHT'],
            Element::$elements['ROBBER_FALL'],
            Element::$elements['ROBBER_PIPE'],
            Element::$elements['ROBBER_PIT']
        );
    }

    public function findBarriers(): array
    {
        return $this->board->find(
            Element::$elements['BRICK'],
            Element::$elements['STONE']
        );
    }

    public function findPits(): array
    {
        return $this->board->find(
            Element::$elements['CRACK_PIT'],
            Element::$elements['PIT_FILL_1'],
            Element::$elements['PIT_FILL_2'],
            Element::$elements['PIT_FILL_3'],
            Element::$elements['PIT_FILL_4']
        );
    }

    public function findClues(): array
    {
        return $this->board->find(
            Element::$elements['CLUE_KNIFE'],
            Element::$elements['CLUE_GLOVE'],
            Element::$elements['CLUE_RING']
        );
    }

    public function findBackways(): array
    {
        return $this->board->find(Element::$elements['BACKWAY']);
    }

    public function findPotions(): array
    {
        return $this->board->find(Element::$elements['MASK_POTION']);
    }

    public function findDoors(): array
    {
        return $this->board->find(
            Element::$elements['OPENED_DOOR_GOLD'],
            Element::$elements['OPENED_DOOR_SILVER'],
            Element::$elements['OPENED_DOOR_BRONZE'],
            Element::$elements['CLOSED_DOOR_GOLD'],
            Element::$elements['CLOSED_DOOR_SILVER'],
            Element::$elements['CLOSED_DOOR_BRONZE']
        );
    }

    public function findKeys(): array
    {
        return $this->board->find(
            Element::$elements['KEY_GOLD'],
            Element::$elements['KEY_SILVER'],
            Element::$elements['KEY_BRONZE']
        );
    }

    public function __toString(): string
    {
        return $this->board->__toString() .
            "\nHero at: " . $this->findHero() .
            "\nOther heroes at: " . implode($this->findOtherHeroes()) .
            "\nEnemy heroes at: " . implode($this->findEnemyHeroes()) .
            "\nRobbers at: " . implode($this->findRobbers()) .
            "\nMask potions at: " . implode($this->findPotions()) .
            "\nKeys at: " . implode($this->findKeys());
    }
}