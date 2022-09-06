@ECHO OFF
echo [current working directory]     :     %%cd%%       :      %cd%
start http://127.0.0.1:3000
php local serve
PAUSE