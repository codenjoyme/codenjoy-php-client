#!/usr/bin/env bash

. lib.sh

color $COLOR1 "Setup variables..."
echo

eval_echo "[[ \"$GAME_TO_RUN\" == \"\" ]] && GAME_TO_RUN=clifford"
eval_echo "[[ \"$BOARD_URL\" == \"\" ]]   && BOARD_URL=https://dojorena.io/codenjoy-contest/board/player/dojorena5?code=953820862434373766"

eval_echo "ROOT=$PWD"

eval_echo "PHP_CLIENT_HOME=$ROOT"