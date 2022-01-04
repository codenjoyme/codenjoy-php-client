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