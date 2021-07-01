<?php

use MollyMage\Solver;

require_once('../../../engine/GameSolver.php');
require_once('../../../engine/GameBoard.php');
require_once('../../../engine/Point.php');
require_once('../../../games/mollymage/Solver.php');
require_once('../../../games/mollymage/Board.php');
require_once('../../../games/mollymage/Element.php');
require_once('../../../games/mollymage/Action.php');

class SolverTest extends PHPUnit\Framework\TestCase
{

    public function test_answer()
    {
        $message = "board="
            . "☼☼☼☼☼"
            . "☼   ☼"
            . "☼ ☺ ☼"
            . "☼   ☼"
            . "☼☼☼☼";
        $solver = new Solver();
        $this->assertEquals("ACT", $solver->answer($message));
    }
}
