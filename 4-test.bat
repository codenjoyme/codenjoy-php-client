call 0-settings.bat

echo off
call lib.bat :color Starting php tests...
echo on

call lib.bat :sep

cd tests\engine
call %PHPUNIT% --no-configuration %CD%\
cd %ROOT%

call lib.bat :sep

cd tests\games\clifford
call %PHPUNIT% --no-configuration %CD%\
cd %ROOT%

call lib.bat :sep

cd tests\games\mollymage
call %PHPUNIT% --no-configuration %CD%\
cd %ROOT%

call lib.bat :sep

call lib.bat :ask