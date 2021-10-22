call 0-settings.bat

echo off
call lib :color Starting php tests...
echo on

call lib :sep

cd tests\engine
call %PHPUNIT% --no-configuration %CD%\
cd %ROOT%

call lib :sep

cd tests\games\clifford
call %PHPUNIT% --no-configuration %CD%\
cd %ROOT%

call lib :sep

cd tests\games\mollymage
call %PHPUNIT% --no-configuration %CD%\
cd %ROOT%

call lib :sep

call lib :ask