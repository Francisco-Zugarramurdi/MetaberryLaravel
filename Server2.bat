@echo OFF
MODE con: cols=100 lines=30
@echo OFF
title AppPublic

cd publicApp
php artisan serve --port=8009