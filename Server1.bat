@echo OFF
MODE con: cols=100 lines=30
@echo OFF
title BackOffice

cd backofficeApp
php artisan serve --port=8005
