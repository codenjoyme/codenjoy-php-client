@echo off
rem #%L
rem Codenjoy - it's a dojo-like platform from developers to developers.
rem %%
rem Copyright (C) 2012 - 2022 Codenjoy
rem %%
rem This program is free software: you can redistribute it and/or modify
rem it under the terms of the GNU General Public License as
rem published by the Free Software Foundation, either version 3 of the
rem License, or (at your option) any later version.
rem
rem This program is distributed in the hope that it will be useful,
rem but WITHOUT ANY WARRANTY; without even the implied warranty of
rem MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
rem GNU General Public License for more details.
rem
rem You should have received a copy of the GNU General Public
rem License along with this program.  If not, see
rem <http://www.gnu.org/licenses/gpl-3.0.html>.
rem #L%
@echo on

@echo off

if "%RUN%"=="" set RUN=%CD%\run
if "%STUFF%"=="" set STUFF=%CD%\stuff

call %RUN% :init_colors

:check_run_mode
    if "%*"=="" (       
        call :run_executable 
    ) else (
        call :run_library %*
    )
    goto :eof

:run_executable
    rem run stuff.bat as executable script
    call %RUN% :color ‘%CL_INFO%‘ ‘This is not executable script. Please use 'run.bat' only.‘
    call %RUN% :ask   
    goto :eof

:run_library
    rem run stuff.bat as library
    call %*     
    goto :eof          

:settings
    if "%INSTALL_LOCALLY%"=="true" ( set PHP_HOME=)

    if "%PHP_HOME%"==""   ( set NO_PHP=true)
    if "%NO_PHP%"=="true" ( set PHP_HOME=%ROOT%\.php)
    if "%NO_PHP%"=="true" ( set PATH=%PHP_HOME%;%PATH%)

    set PHP=%PHP_HOME%\php.exe
    set PHPUNIT=%ROOT%\vendor\bin\phpunit.bat

    echo Language environment variables
    call %RUN% :color ‘%CL_INFO%‘ ‘PATH=%PATH%‘
    call %RUN% :color ‘%CL_INFO%‘ ‘PHP_HOME=%PHP_HOME%‘

    set ARCH_URL=https://windows.php.net/downloads/releases/archives/php-8.0.8-nts-Win32-vs16-x64.zip
    set ARCH_FOLDER=
    set ARCH_PHP_COMPOSER=https://getcomposer.org/download/latest-2.x/composer.phar
    goto :eof

:install
    if exist %TOOLS%\..\vendor (
        call %RUN% :eval_echo ‘rd /S /Q %TOOLS%\..\vendor‘
    )
    call %RUN% :install php %ARCH_URL% %ARCH_FOLDER%
    if exist %TOOLS%\composer.phar (
        call %RUN% :eval_echo ‘del /Q %TOOLS%\composer.phar‘
    )
    call %RUN% :download_file ‘%ARCH_PHP_COMPOSER%‘ ‘%TOOLS%\..\composer.phar‘
    call %RUN% :eval_echo ‘xcopy /y %TOOLS%\php.ini %PHP_HOME%\‘
    goto :eof

:version
    call %RUN% :eval_echo_color ‘%PHP% -v‘
    goto :eof

:build
    call %RUN% :eval_echo ‘%PHP% .\composer.phar u‘
    goto :eof

:test    
    call %RUN% :color ‘%CL_HEADER%‘ ‘Engine tests...‘
    call %RUN% :eval_echo ‘cd %ROOT%\tests\engine‘
    call %RUN% :eval_echo ‘call %PHPUNIT% --no-configuration %CD%\‘

    call %RUN% :color ‘%CL_HEADER%‘ ‘Clifford tests...‘
    call %RUN% :eval_echo ‘cd ROOT%\tests\games\clifford‘
    call %RUN% :eval_echo ‘call %PHPUNIT% --no-configuration %CD%\‘

    call %RUN% :color ‘%CL_HEADER%‘ ‘Mollymage tests...‘
    call %RUN% :eval_echo ‘cd ROOT%\tests\games\mollymage‘
    call %RUN% :eval_echo ‘call %PHPUNIT% --no-configuration %CD%\‘

    call %RUN% :color ‘%CL_HEADER%‘ ‘Sample tests...‘
    call %RUN% :eval_echo ‘cd ROOT%\tests\games\sample‘
    call %RUN% :eval_echo ‘call %PHPUNIT% --no-configuration %CD%\‘

    call %RUN% :sep
    goto :eof

:run
    call %RUN% :eval_echo ‘%PHP% .\index.php %GAME_TO_RUN% %SERVER_URL%‘
    goto :eof