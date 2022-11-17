@echo OFF
MODE con: cols=100 lines=30
@echo OFF
title adsApi

cd adsApi
php artisan serve --port=8003
