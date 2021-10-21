if "%GAME_TO_RUN%"=="" ( set GAME_TO_RUN=mollymage)
if "%BOARD_URL%"==""   ( set BOARD_URL=http://127.0.0.1:8080/codenjoy-contest/board/player/0?code=000000000000)

set ROOT=%CD%

if "%SKIP_TESTS%"=="" ( set SKIP_TESTS=true)

set CODE_PAGE=65001
chcp %CODE_PAGE%

set TOOLS=%ROOT%\.tools
set ARCH=%TOOLS%\7z\7za.exe

rem Set to true if you want to ignore php installed on the system
if "%INSTALL_LOCALLY%"=="" ( set INSTALL_LOCALLY=true)

if "%INSTALL_LOCALLY%"=="true" ( set PHP_HOME=)
if "%PHP_HOME%"=="" ( set NO_PHP=true)
if "%NO_PHP%"=="true" ( set PHP_HOME=%ROOT%\.php)
if "%NO_PHP%"=="true" ( set PATH=%PHP_HOME%;%PATH%)
set PHP=%PHP_HOME%\php.exe
set PHPUNIT=%ROOT%\vendor\bin\phpunit.bat

echo off
echo        [44;93mPHP_HOME=%PHP_HOME%[0m
echo on

set ARCH_PHP=https://windows.php.net/downloads/releases/archives/php-8.0.8-nts-Win32-vs16-x64.zip
set ARCH_PHP_FOLDER=
set ARCH_PHP_COMPOSER=https://getcomposer.org/download/latest-2.x/composer.phar

set PHP_CLIENT_HOME=%ROOT%