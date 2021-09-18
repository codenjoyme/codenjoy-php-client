<?php

require __DIR__ . '/vendor/autoload.php';
require_once "engine/classes.php";
require_once "games/mollymage/classes.php";
require_once "games/clifford/classes.php";

$game = "clifford";
$url = "http://localhost:8080/codenjoy-contest/board/player/0?code=000000000000";
if ($argc == 3) {
    $game = $argv[1];
    $url = $argv[2];
}

$solver = determineGameSolver($game);
$wsRunner = new WebSocketRunner($url);
$wsRunner->run($solver);

function determineGameSolver(string $game): GameSolver
{
    return match ($game) {
        "mollymage" => new MollyMage\Solver(),
        "clifford" => new DetectiveClifford\Solver(),
        default => throw new InvalidArgumentException("no solver for game: " . $game),
    };
}