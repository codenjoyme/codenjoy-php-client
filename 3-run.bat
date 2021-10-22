call 0-settings.bat

echo off
call lib.bat :color Starting php client...
echo on

call %PHP% index.php %GAME_TO_RUN% %BOARD_URL%

call lib.bat :ask