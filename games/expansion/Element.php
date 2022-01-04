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

namespace Expansion;

abstract class Element
{
    static array $elements = array(

        "EMPTY" => '-',

        "FLOOR" => '.',

        "ANGLE_IN_LEFT" => '╔',

        "WALL_FRONT" => '═',

        "ANGLE_IN_RIGHT" => '┐',

        "WALL_RIGHT" => '│',

        "ANGLE_BACK_RIGHT" => '┘',

        "WALL_BACK" => '─',

        "ANGLE_BACK_LEFT" => '└',

        "WALL_LEFT" => '║',

        "WALL_BACK_ANGLE_LEFT" => '┌',

        "WALL_BACK_ANGLE_RIGHT" => '╗',

        "ANGLE_OUT_RIGHT" => '╝',

        "ANGLE_OUT_LEFT" => '╚',

        "SPACE" => ' ',

        "FORCE1" => '♥',

        "FORCE2" => '♦',

        "FORCE3" => '♣',

        "FORCE4" => '♠',

        "EXIT" => 'E',

        "HOLE" => 'O',

        "BREAK" => 'B',

        "GOLD" => '$',

        "BASE1" => '1',

        "BASE2" => '2',

        "BASE3" => '3',

        "BASE4" => '4',

        "FOG" => 'F',

        "BACKGROUND" => 'G'
    );
}
