<?php

class MollyMageBoard
{
    private Board $board;

    public function __construct(string $message)
    {
        $this->board = new Board(MollyMageElement::$elements, $message);
    }

    public function getAt(Point $pt): string
    {
        if (!$pt->isValid($this->board->getSize())) {
            return MollyMageElement::$elements['WALL'];
        }
        return $this->board->getAt($pt);
    }

    public function findHero(): Point
    {
        $points = $this->board->find(
            MollyMageElement::$elements['HERO'],
            MollyMageElement::$elements['POTION_HERO'],
            MollyMageElement::$elements['DEAD_HERO']);
        if (count($points) == 0) {
            throw new UnexpectedValueException("hero element has not been found");
        }
        return $points[0];
    }

    public function isGameOver(): bool
    {
        $points = $this->board->find(MollyMageElement::$elements['DEAD_HERO']);
        return count($points) != 0;
    }

    public function findOtherHeroes(): array
    {
        return $this->board->find(
            MollyMageElement::$elements['OTHER_HERO'],
            MollyMageElement::$elements['OTHER_POTION_HERO'],
            MollyMageElement::$elements['OTHER_DEAD_HERO'],
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
        usort($points, array("Point", "compare"));
        return $points;
    }

    public function findWalls(): array
    {
        return $this->board->find(MollyMageElement::$elements['WALL']);
    }

    public function findGhosts(): array
    {
        return $this->board->find(MollyMageElement::$elements['GHOST']);
    }

    public function findTreasureBoxes(): array
    {
        return $this->board->find(MollyMageElement::$elements['TREASURE_BOX']);
    }

    public function findPotions(): array
    {
        return $this->board->find(
            MollyMageElement::$elements['POTION_TIMER_1'],
            MollyMageElement::$elements['POTION_TIMER_2'],
            MollyMageElement::$elements['POTION_TIMER_3'],
            MollyMageElement::$elements['POTION_TIMER_4'],
            MollyMageElement::$elements['POTION_TIMER_5'],
            MollyMageElement::$elements['POTION_HERO'],
            MollyMageElement::$elements['OTHER_POTION_HERO']);
    }

    public function findBlasts(): array
    {
        return $this->board->find(MollyMageElement::$elements['BOOM']);
    }

    public function predictFutureBlasts(): array
    {
        // TODO: implement
        return array();
    }

    public function findPerks(): array
    {
        return $this->board->find(
            MollyMageElement::$elements['POTION_COUNT_INCREASE'],
            MollyMageElement::$elements['POTION_REMOTE_CONTROL'],
            MollyMageElement::$elements['POTION_IMMUNE'],
            MollyMageElement::$elements['POTION_BLAST_RADIUS_INCREASE']);
    }

    public function __toString(): string
    {
        return $this->board->__toString() .
            "\nHero at: " . $this->findHero() .
            "\nOther heroes at: " . implode($this->findOtherHeroes()) .
            "\nGhosts at: " . implode($this->findGhosts()) .
            "\nPotions at: " . implode($this->findPotions()) .
            "\nBlasts at: " . implode($this->findBlasts()) .
            "\nExpected blasts at: " . implode($this->predictFutureBlasts());
    }
}