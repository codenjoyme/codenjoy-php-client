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

require_once('../../engine/Point.php');

class PointTest extends PHPUnit\Framework\TestCase
{

    public function testValidPoints()
    {
        $this->assertEquals(true, (new Point(0, 0))->isValid(10));
        $this->assertEquals(true, (new Point(5, 5))->isValid(10));
        $this->assertEquals(true, (new Point(9, 9))->isValid(10));
        $this->assertEquals(true, (new Point(0, 9))->isValid(10));
        $this->assertEquals(true, (new Point(9, 0))->isValid(10));
    }

    public function testInvalidPoints()
    {
        $this->assertEquals(false, (new Point(-1, 9))->isValid(10));
        $this->assertEquals(false, (new Point(9, -1))->isValid(10));
        $this->assertEquals(false, (new Point(11, 9))->isValid(10));
        $this->assertEquals(false, (new Point(9, 11))->isValid(10));
    }
}
