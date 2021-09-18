<?php

use DetectiveClifford\Solver;

require_once('../../../engine/Direction.php');
require_once('../../../engine/GameSolver.php');
require_once('../../../engine/GameBoard.php');
require_once('../../../engine/Point.php');
require_once('../../../games/clifford/Solver.php');
require_once('../../../games/clifford/Board.php');
require_once('../../../games/clifford/Element.php');

class SolverTest extends PHPUnit\Framework\TestCase
{

    public function test_answer()
    {
        $message = "board=" .
            "☼☼☼☼☼" .
            "☼   ☼" .
            "☼ ⊳ ☼" .
            "☼   ☼" .
            "☼☼☼☼";
        $solver = new Solver();
        $this->assertEquals("ACT", $solver->answer($message));
    }
}
