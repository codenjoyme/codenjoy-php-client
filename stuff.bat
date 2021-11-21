@echo off

call run :init_colors

:check_run_mode
    if "%*"=="" (       
        call :run_executable 
    ) else (
        call :run_library %*
    )
    goto :eof

:run_executable
    rem run stuff.bat as executable script
    call run :color ‘%CL_INFO%‘ ‘This is not executable script. Please use 'run.bat' only.‘
    call run :ask   
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
    call run :color ‘%CL_INFO%‘ ‘PATH=%PATH%‘
    call run :color ‘%CL_INFO%‘ ‘PHP_HOME=%PHP_HOME%‘

    set ARCH_URL=https://windows.php.net/downloads/releases/archives/php-8.0.8-nts-Win32-vs16-x64.zip
    set ARCH_FOLDER=
    set ARCH_PHP_COMPOSER=https://getcomposer.org/download/latest-2.x/composer.phar
    goto :eof

:install
    if exist %TOOLS%\..\vendor (
        call run :eval_echo ‘rd /S /Q %TOOLS%\..\vendor‘
    )
    call run :install php %ARCH_URL% %ARCH_FOLDER%
    if exist %TOOLS%\composer.phar (
        call run :eval_echo ‘del /Q %TOOLS%\composer.phar‘
    )
    call run :download_file ‘%ARCH_PHP_COMPOSER%‘ ‘%TOOLS%\..\composer.phar‘
    call run :eval_echo ‘xcopy /y %TOOLS%\php.ini %PHP_HOME%\‘
    goto :eof

:version
    call run :print_color %PHP% -v
    goto :eof

:build
    call run :eval_echo ‘%PHP% composer.phar u‘
    goto :eof

:test    
    call %ROOT%\run :color ‘%CL_HEADER%‘ ‘Engine tests...‘
    call %ROOT%\run :eval_echo ‘cd tests\engine‘
    call %ROOT%\run :eval_echo ‘call %PHPUNIT% --no-configuration %CD%\‘
    call %ROOT%\run :eval_echo ‘cd %ROOT%‘
    
    call %ROOT%\run :color ‘%CL_HEADER%‘ ‘Clifford tests...‘
    call %ROOT%\run :eval_echo ‘cd tests\games\clifford‘
    call %ROOT%\run :eval_echo ‘call %PHPUNIT% --no-configuration %CD%\‘
    call %ROOT%\run :eval_echo ‘cd %ROOT%‘

    call %ROOT%\run :color ‘%CL_HEADER%‘ ‘Mollymage tests...‘
    call %ROOT%\run :eval_echo ‘cd tests\games\mollymage‘
    call %ROOT%\run :eval_echo ‘call %PHPUNIT% --no-configuration %CD%\‘
    call %ROOT%\run :eval_echo ‘cd %ROOT%‘

    call %ROOT%\run :color ‘%CL_HEADER%‘ ‘Sample tests...‘
    call %ROOT%\run :eval_echo ‘cd tests\games\sample‘
    call %ROOT%\run :eval_echo ‘call %PHPUNIT% --no-configuration %CD%\‘
    call %ROOT%\run :eval_echo ‘cd %ROOT%‘

    call run :sep
    goto :eof

:run
    call run :eval_echo ‘%PHP% index.php %GAME_TO_RUN% %SERVER_URL%‘
    goto :eof