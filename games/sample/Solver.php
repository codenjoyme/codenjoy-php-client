<?php

namespace MollyMage;

use GameSolver;
use Direction;

class Solver implements GameSolver
{

    public function answer(string $message): string
    {
        $board = new Board($message);
        print "Board \n" . $board->__toString() . "\n";
        $action = $this->nextAction($board);
        print "\nAnswer: " . $action . "\n";
        print "-------------------------------------------------------------\n";
        return $action->__toString();
    }

    private function nextAction(Board $board): Direction
    {
        // TODO: write your code here
        global $ACT;
        return $ACT;
    }
}