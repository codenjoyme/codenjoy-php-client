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

require_once('../../engine/Direction.php');

class DirectionTest extends PHPUnit\Framework\TestCase
{

    public function test_value()
    {
        global $LEFT;
        global $RIGHT;
        global $UP;
        global $DOWN;
        global $ACT;
        global $STOP;
        $this->assertEquals(0, $LEFT->value());
        $this->assertEquals(1, $RIGHT->value());
        $this->assertEquals(2, $UP->value());
        $this->assertEquals(3, $DOWN->value());
        $this->assertEquals(4, $ACT->value());
        $this->assertEquals(5, $STOP->value());
    }

    public function test_changeX()
    {
        global $LEFT;
        global $RIGHT;
        global $UP;
        global $DOWN;
        $this->assertEquals(0, $LEFT->changeX(1));
        $this->assertEquals(2, $RIGHT->changeX(1));
        $this->assertEquals(1, $UP->changeX(1));
        $this->assertEquals(1, $DOWN->changeX(1));
    }

    public function test_changeY()
    {
        global $LEFT;
        global $RIGHT;
        global $UP;
        global $DOWN;
        $this->assertEquals(1, $LEFT->changeY(1));
        $this->assertEquals(1, $RIGHT->changeY(1));
        $this->assertEquals(2, $UP->changeY(1));
        $this->assertEquals(0, $DOWN->changeY(1));
    }

    public function test_inverted()
    {
        global $LEFT;
        global $RIGHT;
        global $UP;
        global $DOWN;
        $this->assertEquals($RIGHT, $LEFT->inverted());
        $this->assertEquals($LEFT, $RIGHT->inverted());
        $this->assertEquals($DOWN, $UP->inverted());
        $this->assertEquals($UP, $DOWN->inverted());
    }

    public function test_invalidInverted()
    {
        global $ACT;
        global $STOP;
        $this->expectException(InvalidArgumentException::class);
        $ACT->inverted();
        $STOP->inverted();
    }
}