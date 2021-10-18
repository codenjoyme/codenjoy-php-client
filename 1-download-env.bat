if "%JAVA_CLIENT_HOME%"=="" (
    call 0-settings.bat
)

@echo off
echo [44;93m
echo        +-------------------------------------+
echo        !            Installing PHP           !
echo        +-------------------------------------+
echo [0m
echo on

cd %ROOT%
rd /S /Q %PHP_HOME%
IF EXIST %TOOLS%\php.zip (
    @echo Delete previouse downloaded file.
    del %TOOLS%\php.zip
)
@echo Downloading PHP.zip
powershell -command "& { set-executionpolicy remotesigned -s currentuser; [System.Net.ServicePointManager]::SecurityProtocol = 3072 -bor 768 -bor 192 -bor 48; $client=New-Object System.Net.WebClient; $client.Headers['User-Agent']='PoweShell script';  $client.DownloadFile('%ARCH_PHP%','%TOOLS%\php.zip') }"

%ARCH% x -y %TOOLS%\php.zip -o%PHP_HOME%
xcopy /y %TOOLS%\php.ini %PHP_HOME%\

@echo Downloading composer.phar
powershell -command "& { set-executionpolicy remotesigned -s currentuser; [System.Net.ServicePointManager]::SecurityProtocol = 3072 -bor 768 -bor 192 -bor 48; $client=New-Object System.Net.WebClient; $client.Headers['User-Agent']='PoweShell script';  $client.DownloadFile('%ARCH_PHP_COMPOSER%','%PHP_CLIENT_HOME%\composer.phar') }"
cd %ROOT%

call :ask

goto :eof

:ask
    echo Press any key to continue
    pause >nul
goto :eof
