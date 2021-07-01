<?php

require_once('../../../engine/Solver.php');
require_once('../../../engine/Board.php');
require_once('../../../engine/Point.php');
require_once('../../../games/mollymage/MollyMageSolver.php');
require_once('../../../games/mollymage/MollyMageBoard.php');
require_once('../../../games/mollymage/MollyMageElement.php');
require_once('../../../games/mollymage/MollyMageAction.php');

class MollyMageSolverTest extends PHPUnit\Framework\TestCase
{

    public function test_answer()
    {
        $message = "board="
            . "☼☼☼☼☼"
            . "☼   ☼"
            . "☼ ☺ ☼"
            . "☼   ☼"
            . "☼☼☼☼";
        $solver = new MollyMageSolver();
        $this->assertEquals("ACT", $solver->answer($message));
    }
}
