<?php

###
# #%L
# Codenjoy - it's a dojo-like platform from developers to developers.
# %%
# Copyright (C) 2012 - 2022 Codenjoy
# %%
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as
# published by the Free Software Foundation, either version 3 of the
# License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public
# License along with this program.  If not, see
# <http://www.gnu.org/licenses/gpl-3.0.html>.
# #L%
###

use Sample\Solver;

require_once('../../../engine/Direction.php');
require_once('../../../engine/GameSolver.php');
require_once('../../../engine/GameBoard.php');
require_once('../../../engine/Point.php');
require_once('../../../games/sample/Solver.php');
require_once('../../../games/sample/Board.php');
require_once('../../../games/sample/Element.php');

class SolverTest extends PHPUnit\Framework\TestCase
{

    public function test_answer()
    {
        $message = "board=" .
            "☼☼☼☼☼" .
            "☼   ☼" .
            "☼ ☺ ☼" .
            "☼   ☼" .
            "☼☼☼☼";
        $solver = new Solver();
        $this->assertEquals("ACT", $solver->answer($message));
    }
}
