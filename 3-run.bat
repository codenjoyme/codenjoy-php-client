call 0-settings.bat

echo off
call lib :color Starting php client...
echo on

call %PHP% index.php %GAME_TO_RUN% %SERVER_URL%

call lib :ask