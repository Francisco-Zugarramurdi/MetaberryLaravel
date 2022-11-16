@echo OFF
MODE con: cols=100 lines=30
@echo OFF
title AuthApi

cd authenticationApi
php artisan serve --port=8000
