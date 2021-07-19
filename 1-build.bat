if "%PHP_CLIENT_HOME%"=="" (
    call 0-settings.bat
)

echo off
echo [44;93m
echo        +-------------------------------------------------------------------------+
echo        !                   Now we are building php client...                     !
echo        +-------------------------------------------------------------------------+
echo [0m
echo on
SET PATH=%CD%\.php;%PATH%
call php -v
call php composer.phar u

@call :ask

goto :eof

:ask
    @echo off
    echo Press any key to continue
    pause >nul
goto :eof