<?php

class WebSocketRunner
{
    const URL_REGEX = "/(?<scheme>http|https):\/\/(?<host>.+)\/codenjoy-contest\/board\/player\/(?<player>\w+)\?code=(?<code>\d+)/";

    private WebSocket\Client $client;

    public function __construct(string $url)
    {
        $token = self::urlToWsToken($url);
        $this->client = new WebSocket\Client($token);
    }

    public static function urlToWsToken(string $url): string
    {
        preg_match(self::URL_REGEX, $url, $matches);
        if ($matches == null) {
            throw new InvalidArgumentException("invalid url: " . $url);
        }
        $scheme = $matches['scheme'] == "https" ? "wss" : "ws";
        return sprintf("%s://%s/codenjoy-contest/ws?user=%s&code=%s",
            $scheme,
            $matches['host'],
            $matches['player'],
            $matches['code']);
    }

    public function run(GameSolver $solver)
    {
        while (true) {
            $msgFromServer = $this->client->receive();
            $msgToServer = $solver->answer($msgFromServer);
            $this->client->send($msgToServer);
        }
    }
}