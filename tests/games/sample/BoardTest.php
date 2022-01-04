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

use Sample\Board;
use Sample\Element;

require_once('../../../engine/GameSolver.php');
require_once('../../../engine/GameBoard.php');
require_once('../../../engine/Point.php');
require_once('../../../games/sample/Solver.php');
require_once('../../../games/sample/Board.php');
require_once('../../../games/sample/Element.php');

class BoardTest extends PHPUnit\Framework\TestCase
{

    public function test_getAt_invalidPoint()
    {
        $board = new Board("☼☼☼" . "☼☼☼" . "☼☼☼");
        $this->assertEquals(Element::$elements['WALL'], $board->getAt(new Point(-1, -1)));
    }

    public function test_findHero()
    {
        $board = new Board("☼☺☼" . "☼☼☼" . "☼☼☼");
        $this->assertEquals(new Point(1, 2), $board->findHero());

        $board = new Board("☼☼☼" . "☼☺☼" . "☼☼☼");
        $this->assertEquals(new Point(1, 1), $board->findHero());

        $board = new Board("☼☼☼" . "☼☼☼" . "☼X☼");
        $this->assertEquals(new Point(1, 0), $board->findHero());

        $board = new Board("X☺☻" . "☼☼☼" . "☼☼☼");
        $this->assertEquals(new Point(0, 2), $board->findHero());
    }

    public function test_findHero_noResult()
    {
        $this->expectException(UnexpectedValueException::class);
        $board = new Board("☼☼☼" . "☼☼☼" . "☼☼☼");
        $board->findHero();
    }

    public function test_isGameOver()
    {
        $board = new Board("☼☼☼" . "☼☼☺" . "☼☼☼");
        $this->assertEquals(false, $board->isGameOver());

        $board = new Board("☼☼☼" . "X☼☼" . "☼☼☼");
        $this->assertEquals(true, $board->isGameOver());
    }

    public function test_findOtherHeroes()
    {
        $board = new Board("☼☻☼" . "☼Y☼" . "☼☻☼");
        $this->assertEquals(
            array(new Point(1, 0), new Point(1, 1), new Point(1, 2)),
            $board->findOtherHeroes());
    }

    public function test_findBarriers()
    {
        $board = new Board("☼☼☼" . "xxx" . "☻☻☻");
        $this->assertEquals(
            array(new Point(0, 0), new Point(0, 1), new Point(0, 2),
                new Point(1, 0), new Point(1, 1), new Point(1, 2),
                new Point(2, 0), new Point(2, 1), new Point(2, 2)),
            $board->findBarriers());
    }

    public function test_walls()
    {
        $board = new Board("   " . "☼  " . "☼  ");
        $this->assertEquals(
            array(new Point(0, 0), new Point(0, 1)),
            $board->findWalls());
    }

    public function test_gold()
    {
        $board = new Board("☼☼$" . "☼☼$" . "☼☼☼");
        $this->assertEquals(
            array(new Point(2, 1), new Point(2, 2)),
            $board->findGold());
    }

    public function test_bombs()
    {
        $board = new Board("☼☼x" . "☼☼x" . "☼☼☼");
        $this->assertEquals(
            array(new Point(2, 1), new Point(2, 2)),
            $board->findBombs());
    }

    public function test_report()
    {
        $board = new Board("board=" .
            "☼☼☼☼☼☼☼☼☼" .
            "☼ x☺  Y ☼" .
            "☼  x    ☼" .
            "☼ $  ☻  ☼" .
            "☼      x☼" .
            "☼ ☻     ☼" .
            "☼       ☼" .
            "☼ $ ☻ x ☼" .
            "☼☼☼☼☼☼☼☼☼");
        $this->assertEquals("" .
            /*8*/"☼☼☼☼☼☼☼☼☼\n" .
            /*7*/"☼ x☺  Y ☼\n" .
            /*6*/"☼  x    ☼\n" .
            /*5*/"☼ $  ☻  ☼\n" .
            /*4*/"☼      x☼\n" .
            /*3*/"☼ ☻     ☼\n" .
            /*2*/"☼       ☼\n" .
            /*1*/"☼ $ ☻ x ☼\n" .
            /*0*/"☼☼☼☼☼☼☼☼☼\n" .
                /*012345678*/
            "\n" .
            "Hero at: [3,7]\n" .
            "Other heroes at: [2,3][4,1][5,5][6,7]\n" .
            "Bombs at: [2,7][3,6][6,1][7,4]\n" .
            "Gold at: [2,1][2,5]", $board->__toString());
    }
}
