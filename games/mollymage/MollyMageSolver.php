<?php

class MollyMageSolver implements Solver
{

    public function answer(string $message): string
    {
        $board = new MollyMageBoard($message);
        print "Board \n" . $board->__toString() . "\n";
        $action = $this->nextAction($board);
        print "\nAnswer: " . $action . "\n";
        print "-------------------------------------------------------------" . "\n";
        return $action;
    }

    private function nextAction(MollyMageBoard $board): string
    {
        return MollyMageAction::ACT;
    }
}