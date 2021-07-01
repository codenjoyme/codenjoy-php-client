<?php

require __DIR__ . '/vendor/autoload.php';
require_once('engine/classes.php');
require_once('games/classes.php');

$game = "mollymage";
$url = "http://localhost:8080/codenjoy-contest/board/player/0?code=000000000000";
if ($argc == 3) {
    $game = $argv[1];
    $url = $argv[2];
}

$solver = determineGameSolver($game);
$wsRunner = new WebSocketRunner($url);
$wsRunner->run($solver);

function determineGameSolver(string $game): Solver
{
    return match ($game) {
        "mollymage" => new MollyMageSolver(),
        default => throw new InvalidArgumentException("no solver for game: " . $game),
    };
}