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

namespace Verland;

abstract class Element
{
    static array $elements = array(

            # Мой герой заразился инфекцией.

        "HERO_DEAD" => 'X',

            # Мой герой.

        "HERO" => '♥',

            # Попытка моим героем зачистить инфекцию. Если инфекция была
            # устранена ситуация вокруг обновится. Если герой ошибся и
            # зона была не инфицирована - штраф.

        "HERO_CURE" => '!',

            # На секунду после окончания игры поле открывается и можно
            # увидеть какую инфекцию удалось обеззаразить герою.

        "HERO_HEALING" => 'x',

            # Герой из моей команды заразился инфекцией.

        "OTHER_HERO_DEAD" => 'Y',

            # Герой из моей команды в работе.

        "OTHER_HERO" => '♠',

            # Попытка героем из моей команды зачистить инфекцию. Если
            # инфекция была устранена ситуация вокруг обновится.  Если
            # герой ошибся и зона была не инфицирована - штраф.

        "OTHER_HERO_CURE" => '+',

            # На секунду после окончания игры поле открывается и можно
            # увидеть какую инфекцию удалось обеззаразить герою из моей
            # команды.

        "OTHER_HERO_HEALING" => 'y',

            # Вражеский герой заразился инфекцией.

        "ENEMY_HERO_DEAD" => 'Z',

            # Вражеский герой в работе.

        "ENEMY_HERO" => '♣',

            # На секунду после окончания игры поле открывается и можно
            # увидеть какую инфекцию удалось обеззаразить вражескому
            # герою.

        "ENEMY_HERO_HEALING" => 'z',

            # На секунду после смерти героя поле открывается и можно
            # увидеть где была инфекция.

        "INFECTION" => 'o',

            # Туман - место где еще не бывал герой. Возможно эта зона
            # инфицирована.

        "HIDDEN" => '*',

            # Непроходимые территории - обычно граница поля, но может быть
            # и простое на пути героя.

        "PATHLESS" => '☼',

            # Вокруг этой зоны нет заражений.

        "CLEAR" => ' ',

            # Вокруг этой зоны было зафиксировано одно заражение.

        "CONTAGION_ONE" => '1',

            # Вокруг этой зоны было зафиксировано два заражения.

        "CONTAGION_TWO" => '2',

            # Вокруг этой зоны было зафиксировано три заражения.

        "CONTAGION_THREE" => '3',

            # Вокруг этой зоны было зафиксировано четыре заражения.

        "CONTAGION_FOUR" => '4',

            # Вокруг этой зоны было зафиксировано пять заражений.

        "CONTAGION_FIVE" => '5',

            # Вокруг этой зоны было зафиксировано шесть заражений.

        "CONTAGION_SIX" => '6',

            # Вокруг этой зоны было зафиксировано семь заражений.

        "CONTAGION_SEVEN" => '7',

            # Вокруг этой зоны было зафиксировано восемь заражений.

        "CONTAGION_EIGHT" => '8'
    );
}
