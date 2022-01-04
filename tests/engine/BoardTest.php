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

require_once('../../engine/GameBoard.php');
require_once('../../engine/Point.php');

class BoardTest extends PHPUnit\Framework\TestCase
{

    public function test_emptyMessage()
    {
        $board = new GameBoard(array("a", "b", "c"), "");
        $this->assertEquals("", $board->__toString());
    }

    public function test_emptySupportedElements()
    {
        $this->expectException(InvalidArgumentException::class);
        new GameBoard(array(), "aaa" . "bbb" . "ccc");
    }

    public function test_validMessageAndSupportedElements()
    {
        $board = new GameBoard(array("a", "b", "c"), "aaa" . "bbb" . "ccc");
        $this->assertEquals("aaa\nbbb\nccc\n", $board->__toString());
    }

    public function test_eraseMessagePrefix()
    {
        $board = new GameBoard(array("a", "b", "c"), "board=" . "aaa" . "bbb" . "ccc");
        $this->assertEquals("aaa\nbbb\nccc\n", $board->__toString());
    }

    public function test_messageWithUnsupportedElements()
    {
        $this->expectException(InvalidArgumentException::class);
        new GameBoard(array("a", "b", "c"), "ab8c");
    }

    public function test_getSize()
    {
        $board = new GameBoard(array("a", "b", "c"), "aaa" . "bbb" . "ccc");
        $this->assertEquals(3, $board->getSize());
    }

    public function test_getAt()
    {
        $board = new GameBoard(array("a", "b", "c"), "aaa" . "bbb" . "ccc");
        $this->assertEquals("c", $board->getAt(new Point(0, 0)));
        $this->assertEquals("c", $board->getAt(new Point(1, 0)));
        $this->assertEquals("c", $board->getAt(new Point(2, 0)));
        $this->assertEquals("b", $board->getAt(new Point(0, 1)));
        $this->assertEquals("b", $board->getAt(new Point(1, 1)));
        $this->assertEquals("b", $board->getAt(new Point(2, 1)));
        $this->assertEquals("a", $board->getAt(new Point(0, 2)));
        $this->assertEquals("a", $board->getAt(new Point(1, 2)));
        $this->assertEquals("a", $board->getAt(new Point(2, 2)));
    }

    public function test_getAt_invalidPoint()
    {
        $this->expectException(InvalidArgumentException::class);
        $board = new GameBoard(array("a", "b", "c"), "aaa" . "bbb" . "ccc");
        $board->getAt(new Point(10, 10));
    }

    public function test_find()
    {
        $board = new GameBoard(array("a", "b", "c"), "aaa" . "bbb" . "ccc");
        $this->assertEquals(
            array(new Point(0, 2), new Point(1, 2), new Point(2, 2)),
            $board->find("a"));
        $this->assertEquals(
            array(new Point(0, 0), new Point(0, 1), new Point(1, 0),
                new Point(1, 1), new Point(2, 0), new Point(2, 1)),
            $board->find("b", "c"));
    }

    public function test_find_notExistedElement()
    {
        $board = new GameBoard(array("a", "b", "c"), "aaa" . "bbb" . "ccc");
        $this->assertEquals(array(), $board->find("d"));
    }

    public function test_findFirst()
    {
        $board = new GameBoard(array("a", "b", "c"), "aaa" . "bbb" . "ccc");
        $this->assertEquals(new Point(0, 0), $board->findFirst("c"));
        $this->assertEquals(new Point(0, 1), $board->findFirst("b", "c"));
        $this->assertEquals(new Point(0, 1), $board->findFirst("c", "b"));
    }

    public function test_findFirst_notExistedElement()
    {
        $board = new GameBoard(array("a", "b", "c"), "aaa" . "bbb" . "ccc");
        $this->assertEquals(null, $board->findFirst("d"));
    }

    public function test_isAt()
    {
        $board = new GameBoard(array("a", "b", "c"), "aaa" . "bbb" . "ccc");
        $this->assertEquals(true, $board->isAt(new Point(1, 2), "a"));
        $this->assertEquals(false, $board->isAt(new Point(1, 2), "b"));
        $this->assertEquals(false, $board->isAt(new Point(1, 2), "c"));
    }

    public function test_isAt_invalidPoint()
    {
        $board = new GameBoard(array("a", "b", "c"), "aaa" . "bbb" . "ccc");
        $this->assertEquals(false, $board->isAt(new Point(10, 10), "b"));
    }

    public function test_findNear()
    {
        $board = new GameBoard(array("a", "b", "c", "d", "e", "f", "g", "h", "i"), "abc" . "def" . "ghi");
        $this->assertEquals(array("f", "d", "b", "h"), $board->findNear(new Point(1, 1)));
    }

    public function test_findNear_invalidPoint()
    {
        $board = new GameBoard(array("a", "b", "c", "d", "e", "f", "g", "h", "i"), "abc" . "def" . "ghi");
        $this->assertEquals(array(), $board->findNear(new Point(-1, -1)));
    }

    public function test_countNear()
    {
        $board = new GameBoard(array("a", "b", "c", "d", "e", "f", "g", "h", "i"), "abc" . "def" . "ghi");
        $this->assertEquals(2, $board->countNear(new Point(1, 1), "a", "b", "c", "d"));
    }

    public function test_countNear_invalidPoint()
    {
        $board = new GameBoard(array("a", "b", "c", "d", "e", "f", "g", "h", "i"), "abc" . "def" . "ghi");
        $this->assertEquals(0, $board->countNear(new Point(-1, -1), "a", "b", "c", "d"));
    }

    public function test_countNear_notExistedElement()
    {
        $board = new GameBoard(array("a", "b", "c", "d", "e", "f", "g", "h", "i"), "abc" . "def" . "ghi");
        $this->assertEquals(0, $board->countNear(new Point(1, 1), "r"));
        $this->assertEquals(0, $board->countNear(new Point(1, 1), "x", "y", "z"));
    }

    public function test_isNear()
    {
        $board = new GameBoard(array("a", "b", "c", "d", "e", "f", "g", "h", "i"), "abc" . "def" . "ghi");
        $this->assertEquals(false, $board->isNear(new Point(1, 1), "a"));
        $this->assertEquals(true, $board->isNear(new Point(1, 1), "b"));
        $this->assertEquals(true, $board->isNear(new Point(1, 1), "c", "d"));
    }

    public function test_isNear_invalidPoint()
    {
        $board = new GameBoard(array("a", "b", "c", "d", "e", "f", "g", "h", "i"), "abc" . "def" . "ghi");
        $this->assertEquals(false, $board->isNear(new Point(-1, -1), "a"));
    }

    public function test_isNear_notExistedElement()
    {
        $board = new GameBoard(array("a", "b", "c", "d", "e", "f", "g", "h", "i"), "abc" . "def" . "ghi");
        $this->assertEquals(false, $board->isNear(new Point(1, 1), "r"));
        $this->assertEquals(false, $board->isNear(new Point(1, 1), "x", "y", "z"));
    }
}
