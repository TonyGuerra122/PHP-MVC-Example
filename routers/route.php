<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Routers\Route;
use App\Utils\View;

Route::get('/teste', 'ViewController@index');
Route::get('/auth/login', 'security\\AuthController@loginPage');
Route::get('/auth/register', fn() => View::render('pages/register'));
Route::post('/auth/register', 'security\\AuthController@register');