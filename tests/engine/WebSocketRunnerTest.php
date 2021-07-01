<?php

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
