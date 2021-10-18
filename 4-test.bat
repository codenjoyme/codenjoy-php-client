if "%GAME_TO_RUN%"=="" (
    call 0-settings.bat
)

chcp %CODE_PAGE%
SET PATH=%CD%\.php;%CD%\vendor\bin;%PATH%

@echo        +-------------------------------------------------------------------------+
@echo        !                       Now we are starting TESTS...                      !
@echo        +-------------------------------------------------------------------------+

cd tests\engine

call phpunit --no-configuration %CD%\
cd ..\games\%GAME_TO_RUN%
call phpunit --no-configuration %CD%\
  
call :ask

goto :eof

:ask
    echo Press any key to continue
    pause >nul
goto :eof
