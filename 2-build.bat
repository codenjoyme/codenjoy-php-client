call 0-settings.bat

echo off
call lib :color Building php client...
echo on

call lib :print_color %PHP% -v
call %PHP% composer.phar u

call lib :ask