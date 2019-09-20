if not DEFINED IS_MINIMIZED set IS_MINIMIZED=1 && start "" /min "%~dpnx0" %* && exit
set filepath=%cd%
:loop
call lessc ../less/main.less ../css/main.css
timeout /t 5&cls
goto loop
exit
