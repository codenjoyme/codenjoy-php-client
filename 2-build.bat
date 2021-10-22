call 0-settings.bat

echo off
call lib.bat :color Building php client...
echo on

call lib.bat :print_color %PHP% -v
call %PHP% composer.phar u

call lib.bat :ask