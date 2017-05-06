<?php

Route::get('/', function () {
    $user = null;

    if (Auth::check()) {
        $user = Auth::user()->toArray();
    }

    return view('layout', compact('user'));
});

Route::post('/auth', 'AuthController@login');

Route::post('/events', 'EventController@add');
Route::put('/events/{event}', 'EventController@update');
Route::delete('/events/{event}', 'EventController@delete');
Route::get('/events', 'EventController@list');