<?php

namespace DetectiveClifford;

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
            Element::$elements['HERO_LEFT'],
            Element::$elements['HERO_RIGHT'],
            Element::$elements['HERO_CRACK_LEFT'],
            Element::$elements['HERO_CRACK_RIGHT'],
            Element::$elements['HERO_LADDER'],
            Element::$elements['HERO_FALL_LEFT'],
            Element::$elements['HERO_FALL_RIGHT'],
            Element::$elements['HERO_PIPE_LEFT'],
            Element::$elements['HERO_PIPE_RIGHT'],
            Element::$elements['HERO_DIE'],

            Element::$elements['HERO_MASK_LEFT'],
            Element::$elements['HERO_MASK_RIGHT'],
            Element::$elements['HERO_MASK_CRACK_LEFT'],
            Element::$elements['HERO_MASK_CRACK_RIGHT'],
            Element::$elements['HERO_MASK_LADDER'],
            Element::$elements['HERO_MASK_FALL_LEFT'],
            Element::$elements['HERO_MASK_FALL_RIGHT'],
            Element::$elements['HERO_MASK_PIPE_LEFT'],
            Element::$elements['HERO_MASK_PIPE_RIGHT'],
            Element::$elements['HERO_MASK_DIE']);
        if (count($points) == 0) {
            throw new UnexpectedValueException("hero element has not been found");
        }
        return $points[0];
    }

    public function findOtherHeroes(): array
    {
        return $this->board->find(
            Element::$elements['OTHER_HERO_DIE'],
            Element::$elements['OTHER_HERO_CRACK_LEFT'],
            Element::$elements['OTHER_HERO_CRACK_RIGHT'],
            Element::$elements['OTHER_HERO_LADDER'],
            Element::$elements['OTHER_HERO_LEFT'],
            Element::$elements['OTHER_HERO_RIGHT'],
            Element::$elements['OTHER_HERO_FALL_LEFT'],
            Element::$elements['OTHER_HERO_FALL_RIGHT'],
            Element::$elements['OTHER_HERO_PIPE_LEFT'],
            Element::$elements['OTHER_HERO_PIPE_RIGHT'],
            Element::$elements['OTHER_HERO_MASK_DIE'],

            Element::$elements['OTHER_HERO_MASK_CRACK_LEFT'],
            Element::$elements['OTHER_HERO_MASK_CRACK_RIGHT'],
            Element::$elements['OTHER_HERO_MASK_LADDER'],
            Element::$elements['OTHER_HERO_MASK_LEFT'],
            Element::$elements['OTHER_HERO_MASK_RIGHT'],
            Element::$elements['OTHER_HERO_MASK_FALL_LEFT'],
            Element::$elements['OTHER_HERO_MASK_FALL_RIGHT'],
            Element::$elements['OTHER_HERO_MASK_PIPE_LEFT'],
            Element::$elements['OTHER_HERO_MASK_PIPE_RIGHT']
        );
    }

    public function findEnemyHeroes(): array
    {
        return $this->board->find(
            Element::$elements['ENEMY_HERO_DIE'],
            Element::$elements['ENEMY_HERO_CRACK_LEFT'],
            Element::$elements['ENEMY_HERO_CRACK_RIGHT'],
            Element::$elements['ENEMY_HERO_LADDER'],
            Element::$elements['ENEMY_HERO_LEFT'],
            Element::$elements['ENEMY_HERO_RIGHT'],
            Element::$elements['ENEMY_HERO_FALL_LEFT'],
            Element::$elements['ENEMY_HERO_FALL_RIGHT'],
            Element::$elements['ENEMY_HERO_PIPE_LEFT'],
            Element::$elements['ENEMY_HERO_PIPE_RIGHT'],
            Element::$elements['ENEMY_HERO_MASK_DIE'],

            Element::$elements['ENEMY_HERO_MASK_CRACK_LEFT'],
            Element::$elements['ENEMY_HERO_MASK_CRACK_RIGHT'],
            Element::$elements['ENEMY_HERO_MASK_LADDER'],
            Element::$elements['ENEMY_HERO_MASK_LEFT'],
            Element::$elements['ENEMY_HERO_MASK_RIGHT'],
            Element::$elements['ENEMY_HERO_MASK_FALL_LEFT'],
            Element::$elements['ENEMY_HERO_MASK_FALL_RIGHT'],
            Element::$elements['ENEMY_HERO_MASK_PIPE_LEFT'],
            Element::$elements['ENEMY_HERO_MASK_PIPE_RIGHT']
        );
    }

    public function findRobbers(): array
    {
        return $this->board->find(
            Element::$elements['ROBBER_LADDER'],
            Element::$elements['ROBBER_LEFT'],
            Element::$elements['ROBBER_RIGHT'],
            Element::$elements['ROBBER_PIPE_LEFT'],
            Element::$elements['ROBBER_PIPE_RIGHT'],
            Element::$elements['ROBBER_PIT_LEFT'],
            Element::$elements['ROBBER_PIT_RIGHT']
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

    public function __toString(): string
    {
        return $this->board->__toString() .
            "\nHero at: " . $this->findHero() .
            "\nOther heroes at: " . implode($this->findOtherHeroes()) .
            "\nEnemy heroes at: " . implode($this->findEnemyHeroes()) .
            "\nRobbers at: " . implode($this->findRobbers()) .
            "\nMask potions at: " . implode($this->findPotions());
    }
}