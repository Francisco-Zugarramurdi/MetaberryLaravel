@echo OFF
MODE con: cols=100 lines=30
@echo OFF
start Server1.bat
start Server2.bat
start Server3.bat
start Server4.bat
start Server5.bat

timeout /t 5 /nobreak

start chrome.exe "http://127.0.0.1:8005/"
start chrome.exe "http://127.0.0.1:8009/"