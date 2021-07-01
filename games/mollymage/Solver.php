<?php

namespace MollyMage;

use GameSolver;

class Solver implements GameSolver
{

    public function answer(string $message): string
    {
        $board = new Board($message);
        print "Board \n" . $board->__toString() . "\n";
        $action = $this->nextAction($board);
        print "\nAnswer: " . $action . "\n";
        print "-------------------------------------------------------------\n";
        return $action;
    }

    private function nextAction(Board $board): string
    {
        // TODO: write your code here
        return Action::ACT;
    }
}