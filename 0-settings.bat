if "%GAME_TO_RUN%"=="" ( set GAME_TO_RUN=mollymage)
if "%BOARD_URL%"==""  ( set BOARD_URL=http://127.0.0.1:8080/codenjoy-contest/board/player/0?code=000000000000)

set ROOT=%CD%

set SKIP_TESTS=true
set CODE_PAGE=65001


if "%PHP_CLIENT_HOME%"==""        ( set PHP_CLIENT_HOME=%ROOT%)
if "%PHP_HOME%"==""               ( set PHP_HOME=%PHP_CLIENT_HOME%\.php)
set PHP = %PHP_CLIENT_HOME%\php.exe