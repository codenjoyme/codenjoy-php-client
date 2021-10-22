call 0-settings.bat

echo off
echo        [44;93m+--------------------------------------------+[0m
echo        [44;93m!       Now we are starting php tests...     ![0m
echo        [44;93m+--------------------------------------------+[0m
echo on

call :sep

cd tests\engine
call %PHPUNIT% --no-configuration %CD%\
cd %ROOT%

call :sep

cd tests\games\clifford
call %PHPUNIT% --no-configuration %CD%\
cd %ROOT%

call :sep

cd tests\games\mollymage
call %PHPUNIT% --no-configuration %CD%\
cd %ROOT%

call :sep

call :ask

goto :eof

:ask
    echo off
    echo        [44;93m+---------------------------------+[0m
    echo        [44;93m!    Press any key to continue    ![0m
    echo        [44;93m+---------------------------------+[0m
    echo on
    pause >nul
goto :eof

:sep
    echo off
    echo [44;93m---------------------------------------------------------------------------------------[0m
    echo on
goto :eof