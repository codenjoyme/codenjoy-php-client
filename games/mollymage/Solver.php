<?php

namespace MollyMage;

use GameSolver;

class Solver implements GameSolver
{

    public function answer(string $message): string
    {
        $board = new Board($message);
        print "GameBoard \n" . $board->__toString() . "\n";
        $action = $this->nextAction($board);
        print "\nAnswer: " . $action . "\n";
        print "-------------------------------------------------------------" . "\n";
        return $action;
    }

    private function nextAction(Board $board): string
    {
        return Action::ACT;
    }
}