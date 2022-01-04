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

require_once('../../engine/WebSocketRunner.php');

class WebSocketRunnerTest extends PHPUnit\Framework\TestCase
{

    public function testUrlToWsToken_validHttpUrl()
    {
        $this->assertEquals("ws://127.0.0.1:8080/codenjoy-contest/ws?user=793wdxskw521spo4mn1y&code=531459153668826800",
            WebSocketRunner::urlToWsToken("http://127.0.0.1:8080/codenjoy-contest/board/player/793wdxskw521spo4mn1y?code=531459153668826800"));
    }

    public function testUrlToWsToken_validHttpsUrl()
    {
        $this->assertEquals("wss://dojorena.io/codenjoy-contest/ws?user=793wdxskw521spo4mn1y&code=531459153668826800",
            WebSocketRunner::urlToWsToken("https://dojorena.io/codenjoy-contest/board/player/793wdxskw521spo4mn1y?code=531459153668826800"));
    }

    public function testUrlToWsToken_unsupportedScheme()
    {
        $this->expectException(InvalidArgumentException::class);
        WebSocketRunner::urlToWsToken("ftp://dojorena.io/codenjoy-contest/board/player/793wdxskw521spo4mn1y?code=531459153668826800");
    }

    public function testUrlToWsToken_invalidHost()
    {
        $this->expectException(InvalidArgumentException::class);
        WebSocketRunner::urlToWsToken("https://codenjoy-contest/board/player/793wdxskw521spo4mn1y?code=531459153668826800");
    }

    public function testUrlToWsToken_playedIdContainsNonWordCharacters()
    {
        $this->expectException(InvalidArgumentException::class);
        WebSocketRunner::urlToWsToken("https://dojorena.io/codenjoy-contest/board/player/7**wdxskw521spo4mn1y?code=531459153668826800");
    }

    public function testUrlToWsToken_codeContainsNonWordCharacters()
    {
        $this->expectException(InvalidArgumentException::class);
        WebSocketRunner::urlToWsToken("https://dojorena.io/codenjoy-contest/board/player/793wdxskw521spo4mn1y?code=AA5459153668826800");
    }
}
