@echo off
title Running Commands
color 0A

REM Open two CMD windows
@REM start "CMD Window 1" cmd.exe /K "php artisan serve"
@REM start "CMD Window 2" cmd.exe /K "npm run dev"

REM Run a Laravel command in the current window
php artisan schedule:work
