<?php

Route::get('/', 'AppController@index');

Route::post('/auth/login', 'AuthController@login');
Route::post('/auth/logout', 'AuthController@logout');
Route::post('/auth/invite', 'AuthController@invite');
Route::post('/auth/register', 'AuthController@register');

Route::post('/events', 'EventController@add');
Route::put('/events/{event}', 'EventController@update');
Route::delete('/events/{event}', 'EventController@delete');
Route::get('/events', 'EventController@list');