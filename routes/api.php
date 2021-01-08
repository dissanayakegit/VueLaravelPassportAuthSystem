<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//Auth Routes
Route::post('/user', 'AuthController@user')->middleware('auth:api');
Route::post('/login', 'AuthController@login');
Route::post('/register', 'AuthController@register');
Route::post('/logout', 'AuthController@logout')->middleware('auth:api');
