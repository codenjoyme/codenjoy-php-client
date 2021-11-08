call 0-settings.bat

echo off
call lib :color Starting php tests...
echo on

echo off
call lib :color Engine tests...
echo on

cd tests\engine
call %PHPUNIT% --no-configuration %CD%\
cd %ROOT%

echo off
call lib :color Clifford tests...
echo on

cd tests\games\clifford
call %PHPUNIT% --no-configuration %CD%\
cd %ROOT%

echo off
call lib :color Mollymage tests...
echo on

cd tests\games\mollymage
call %PHPUNIT% --no-configuration %CD%\
cd %ROOT%

echo off
call lib :color Sample tests...
echo on

cd tests\games\sample
call %PHPUNIT% --no-configuration %CD%\
cd %ROOT%

call lib :sep

call lib :ask