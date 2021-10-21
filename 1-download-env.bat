call 0-settings.bat

echo off
echo        [44;93m+-------------------------------------+[0m
echo        [44;93m!            Installing PHP           ![0m
echo        [44;93m+-------------------------------------+[0m
echo on

if "%SKIP_PHP_INSTALL%"=="true" ( goto :skip )
if "%INSTALL_LOCALLY%"=="false" ( goto :skip )
if "%INSTALL_LOCALLY%"=="" ( goto :skip )

cd %ROOT%

IF EXIST %TOOLS%\..\vendor (
    rd /S /Q %TOOLS%\..\vendor
)

echo Downloading php.zip
IF EXIST %TOOLS%\php.zip (
    del /Q %TOOLS%\php.zip
)
powershell -command "& { set-executionpolicy remotesigned -s currentuser; [System.Net.ServicePointManager]::SecurityProtocol = 3072 -bor 768 -bor 192 -bor 48; $client=New-Object System.Net.WebClient; $client.Headers['User-Agent']='PoweShell script';  $client.DownloadFile('%ARCH_PHP%','%TOOLS%\php.zip') }"
rd /S /Q %TOOLS%\..\.php
%ARCH% x -y -o%TOOLS%\..\.php %TOOLS%\php.zip
cd %ROOT%

echo Downloading composer.phar
IF EXIST %TOOLS%\composer.phar (
    del /Q %TOOLS%\composer.phar
)
powershell -command "& { set-executionpolicy remotesigned -s currentuser; [System.Net.ServicePointManager]::SecurityProtocol = 3072 -bor 768 -bor 192 -bor 48; $client=New-Object System.Net.WebClient; $client.Headers['User-Agent']='PoweShell script';  $client.DownloadFile('%ARCH_PHP_COMPOSER%','%TOOLS%\composer.phar') }"
xcopy /y %TOOLS%\composer.phar %PHP_CLIENT_HOME%\composer.phar
cd %ROOT%

xcopy /y %TOOLS%\php.ini %PHP_HOME%\

call :ask

goto :eof

:skip
	echo off
	echo        [44;93m  Installation skipped:         [0m
	echo        [44;93m      INSTALL_LOCALLY=%INSTALL_LOCALLY%       [0m
	echo        [44;93m      SKIP_PHP_INSTALL=%SKIP_PHP_INSTALL%        [0m
	echo on
	goto :ask
goto :eof

:ask
    echo off
    echo        [44;93m+---------------------------------+[0m
    echo        [44;93m!    Press any key to continue    ![0m
    echo        [44;93m+---------------------------------+[0m
    echo on
    pause >nul
goto :eof