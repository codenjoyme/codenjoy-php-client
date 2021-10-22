call 0-settings.bat

echo off
call lib :color Installing php...
echo on

if "%SKIP_PHP_INSTALL%"=="true" ( goto :skip )
if "%INSTALL_LOCALLY%"=="false" ( goto :skip )
if "%INSTALL_LOCALLY%"=="" ( goto :skip )

cd %ROOT%

IF EXIST %TOOLS%\..\vendor (
    rd /S /Q %TOOLS%\..\vendor
)

call lib :install php %ARCH_URL% %ARCH_FOLDER%

echo Downloading composer.phar
IF EXIST %TOOLS%\composer.phar (
    del /Q %TOOLS%\composer.phar
)
powershell -command "& { set-executionpolicy remotesigned -s currentuser; [System.Net.ServicePointManager]::SecurityProtocol = 3072 -bor 768 -bor 192 -bor 48; $client=New-Object System.Net.WebClient; $client.Headers['User-Agent']='PoweShell script';  $client.DownloadFile('%ARCH_PHP_COMPOSER%','%TOOLS%\composer.phar') }"
xcopy /y %TOOLS%\composer.phar %PHP_CLIENT_HOME%\composer.phar
cd %ROOT%

xcopy /y %TOOLS%\php.ini %PHP_HOME%\

call lib :print_color %PHP% -v

call lib :ask

goto :eof

:skip
	echo off
	call lib :color Installation skipped
	call lib :color INSTALL_LOCALLY=%INSTALL_LOCALLY%
	call lib :color SKIP_PHP_INSTALL=%SKIP_PHP_INSTALL%
	echo on
	call lib :ask
    goto :eof