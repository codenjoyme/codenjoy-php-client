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

use Mollymage\Board;
use Mollymage\Element;

require_once('../../../engine/GameSolver.php');
require_once('../../../engine/GameBoard.php');
require_once('../../../engine/Point.php');
require_once('../../../games/mollymage/Solver.php');
require_once('../../../games/mollymage/Board.php');
require_once('../../../games/mollymage/Element.php');

class BoardTest extends PHPUnit\Framework\TestCase
{

    public function test_getAt_invalidPoint()
    {
        $board = new Board("###" . "###" . "###");
        $this->assertEquals(Element::$elements['WALL'], $board->getAt(new Point(-1, -1)));
    }

    public function test_findHero()
    {
        $board = new Board("#☺#" . "###" . "###");
        $this->assertEquals(new Point(1, 2), $board->findHero());

        $board = new Board("###" . "#☻#" . "###");
        $this->assertEquals(new Point(1, 1), $board->findHero());

        $board = new Board("###" . "###" . "#Ѡ#");
        $this->assertEquals(new Point(1, 0), $board->findHero());

        $board = new Board("Ѡ☺☻" . "###" . "###");
        $this->assertEquals(new Point(0, 2), $board->findHero());
    }

    public function test_findHero_noResult()
    {
        $this->expectException(UnexpectedValueException::class);
        $board = new Board("###" . "###" . "###");
        $board->findHero();
    }

    public function test_isGameOver()
    {
        $board = new Board("###" . "##☺" . "###");
        $this->assertEquals(false, $board->isGameOver());

        $board = new Board("###" . "Ѡ##" . "###");
        $this->assertEquals(true, $board->isGameOver());
    }

    public function test_findOtherHeroes()
    {
        $board = new Board("#♥#" . "#♠#" . "#♣#");
        $this->assertEquals(
            array(new Point(1, 0), new Point(1, 1), new Point(1, 2)),
            $board->findOtherHeroes());
    }

    public function test_findEnemyHeroes()
    {
        $board = new Board("#ö#" . "#Ö#" . "#ø#");
        $this->assertEquals(
            array(new Point(1, 0), new Point(1, 1), new Point(1, 2)),
            $board->findEnemyHeroes());
    }

    public function test_findBarriers()
    {
        $board = new Board("☼&#" . "123" . "♥♠♣");
        $this->assertEquals(
            array(new Point(0, 0), new Point(0, 1), new Point(0, 2),
                new Point(1, 0), new Point(1, 1), new Point(1, 2),
                new Point(2, 0), new Point(2, 1), new Point(2, 2)),
            $board->findBarriers());
    }

    public function test_walls()
    {
        $board = new Board("###" . "☼##" . "☼##");
        $this->assertEquals(
            array(new Point(0, 0), new Point(0, 1)),
            $board->findWalls());
    }

    public function test_ghosts()
    {
        $board = new Board("##&" . "##&" . "###");
        $this->assertEquals(
            array(new Point(2, 1), new Point(2, 2)),
            $board->findGhosts());
    }

    public function test_findTreasureBoxes()
    {
        $board = new Board("҉#҉" . "҉҉҉" . "҉#҉");
        $this->assertEquals(
            array(new Point(1, 0), new Point(1, 2)),
            $board->findTreasureBoxes());
    }

    public function test_findPotions()
    {
        $board = new Board("123" . "45#" . "☻♠#");
        $this->assertEquals(
            array(new Point(0, 0), new Point(0, 1), new Point(0, 2),
                new Point(1, 0), new Point(1, 1), new Point(1, 2), new Point(2, 2)),
            $board->findPotions());
    }

    public function test_findBlasts()
    {
        $board = new Board("###" . "###" . "##҉");
        $this->assertEquals(array(new Point(2, 0)), $board->findBlasts());
    }

    public function test_findPerks()
    {
        $board = new Board("#cr" . "#i+" . "#TA");
        $this->assertEquals(
            array(new Point(1, 0), new Point(1, 1), new Point(1, 2),
                new Point(2, 0), new Point(2, 1), new Point(2, 2)),
            $board->findPerks());

    }

    public function test_report()
    {
        $board = new Board("board=" .
            "☼☼☼☼☼☼☼☼☼" .
            "☼1 ♣   ♠☼" .
            "☼#2  &  ☼" .
            "☼# 3 ♣ ♠☼" .
            "☼☺  4   ☼" .
            "☼   ö H☻☼" .
            "☼x H ҉҉҉☼" .
            "☼& &    ☼" .
            "☼☼☼☼☼☼☼☼☼");
        $this->assertEquals("" .
            /*8*/ "☼☼☼☼☼☼☼☼☼\n" .
            /*7*/ "☼1 ♣   ♠☼\n" .
            /*6*/ "☼#2  &  ☼\n" .
            /*5*/ "☼# 3 ♣ ♠☼\n" .
            /*4*/ "☼☺  4   ☼\n" .
            /*3*/ "☼   ö H☻☼\n" .
            /*2*/ "☼x H ҉҉҉☼\n" .
            /*1*/ "☼& &    ☼\n" .
            /*0*/ "☼☼☼☼☼☼☼☼☼\n" .
                /*012345678*/
            "\n" .
            "Hero at: [1,4]\n" .
            "Other heroes at: [3,7][5,5][7,5][7,7]\n" .
            "Enemy heroes at: [4,3]\n" .
            "Ghosts at: [1,1][3,1][5,6]\n" .
            "Potions at: [1,7][2,6][3,5][4,4][7,3][7,5][7,7]\n" .
            "Blasts at: [5,2][6,2][7,2]\n" .
            "Expected blasts at: [2,7]", $board->__toString());
    }
}
