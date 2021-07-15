<?php

namespace MollyMage;

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
            Element::$elements['POTION_HERO'],
            Element::$elements['DEAD_HERO']);
        if (count($points) == 0) {
            throw new UnexpectedValueException("hero element has not been found");
        }
        return $points[0];
    }

    public function isGameOver(): bool
    {
        return $this->board->findFirst(Element::$elements['DEAD_HERO']) != null;
    }

    public function findOtherHeroes(): array
    {
        return $this->board->find(
            Element::$elements['OTHER_HERO'],
            Element::$elements['OTHER_POTION_HERO'],
            Element::$elements['OTHER_DEAD_HERO'],
        );
    }

    public function findEnemyHeroes(): array
    {
        return $this->board->find(
            Element::$elements['ENEMY_HERO'],
            Element::$elements['ENEMY_POTION_HERO'],
            Element::$elements['ENEMY_DEAD_HERO'],
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
            Element::$elements['POTION_HERO'],
            Element::$elements['OTHER_POTION_HERO'],
            Element::$elements['ENEMY_POTION_HERO']);
    }

    public function findBlasts(): array
    {
        return $this->board->find(Element::$elements['BOOM']);
    }

    public function predictFutureBlasts(): array
    {
        // TODO: implement
        return array();
    }

    public function findPerks(): array
    {
        return $this->board->find(
            Element::$elements['POTION_COUNT_INCREASE'],
            Element::$elements['POTION_REMOTE_CONTROL'],
            Element::$elements['POTION_IMMUNE'],
            Element::$elements['POTION_BLAST_RADIUS_INCREASE']);
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